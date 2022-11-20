<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Session;
use App\Models\Answer;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use App\Models\Result_Answer_Exam;
use App\Models\Result_Merger;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Check_Login_Exam;

class QuestionController extends Controller
{
    public function pagination($items, $perPage = 4, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    // public function each_pagination($items, $perPage = 1, $page = null, $options = [])
    // {
    //     $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    //     $items = $items instanceof Collection ? $items : Collection::make($items);
    //     return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    // }
    public function Index(Request $request, $exam_id, $subject_id, $grade_id, $code)
    {
        Session::put('key', 'question');
        // if(!empty(Session::get('questions_answers'))){
        $questions_answers = Session::get('questions_answers');
        // $result=$request->all();
        // dd($result);
        $xxx = array();
        foreach ($questions_answers as $question_answer) {
            if (in_array($exam_id, explode(',', $question_answer['select_id'])) || $exam_id == $question_answer['exam_id']) {
                $xxx[] = ($question_answer);
            }
        }
        $code=Str::random(32);
        // $ppp=Question::with('answer')->get()->paginate(4);
        // $questions_answers=Question::where('exam_id', $exam_id)->with('answer')->get()->toArray();
        $data = $this->pagination($xxx);
        // // dd($data);
        $data->withPath('/exam/' . $exam_id . '/subject/' . $subject_id . '/grade/' . $grade_id.'/'.$code);
        $exam = Exam::find($exam_id);
        Check_Login_Exam::check_login_exam($exam_id, Auth::guard('student')->user()->id);


        return View('frontend.question.index', compact('questions_answers', 'exam_id', 'subject_id', 'grade_id', 'exam', 'data', 'code'));

    }

    public function ExamListQuestion(Request $request, $exam_id, $subject_id, $grade_id, $code)
    {
        $questions_answers = Session::get('questions_answers');
        $data = array();
        $code=Str::random(32);
        foreach ($questions_answers as $question_answer) {
            if (in_array($exam_id, explode(',', $question_answer['select_id'])) || $exam_id == $question_answer['exam_id']) {
                $data[] = ($question_answer);
            }
        }
        $exam = Exam::find($exam_id);
        // dd($data);
        return View('frontend.question.list', compact('data', 'questions_answers', 'exam_id', 'subject_id', 'grade_id', 'exam', 'code'));
    }
    public function CheckExam(Request $request, $exam_id)
    {
        // $questions_answers=Question::where('exam_id', $exam_id)->with('answer')->get()->toArray();
        if ($request->isMethod('POST')) {
            $data = $request->all();
            // dd($data);

        }
    }

    public function CheckResultAnswer(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // dd($data);
            $count_questions = 0;
            foreach (Session::get('questions_answers') as $question) {
                if ($question['exam_id'] == $data['exam_id'] || in_array($data['exam_id'], explode(",", $question['select_id']))) {
                    $count_questions += 1; //14
                }
            }
            $answers = Answer::whereIn('id', explode(",", $data['answer_ids']))->get()->toArray();
            $arrays = array();
            foreach (explode(",", $data['question_ids']) as $question_id) {
                $answer_same_question_id = array();
                foreach ($answers as $answer) {
                    if ($answer['question_id'] == $question_id) {
                        array_push($answer_same_question_id, $answer['id']);
                    }
                }
                array_push($arrays, $answer_same_question_id);
            }

            $new_arrays = array();
            $j = 0;
            for ($i = 1; $i <= $count_questions; ++$i) {
                if (!in_array($i, explode(",", $data['key']))) {
                    array_push($new_arrays, "");
                } else {
                    array_push($new_arrays, $arrays[$j]);
                    ++$j;
                }
            }
            // dd(($new_arrays[0]));
            $count_correct = 0;
            $score_question_correct = 0;
            $count_answers = 0;
            $score_answers=array();
            foreach ($new_arrays as $new_array) {
                $ok = 1;
                if(!empty($new_array)){
                    if (count($new_array) > 1) {
                        foreach ($new_array as $new) {
                            if (Answer::find($new)->correct_answer == 0) $ok *= 0;
                        }
                    } else if (count($new_array) == 1) {
                        if (Answer::find($new_array[0])->correct_answer == 1) $ok = 1;
                        else $ok = 0;
                    }
                }else{
                    $ok=0;
                }
                if ($ok == 1) {
                    if (!empty($new_array)) {
                        if (count($new_array) > 1) {
                            if (!empty(Question::find(Answer::find($new_array[0])->question_id)->score)) {
                                $score_question_correct += Question::find($new_array[0])->score;
                                $count_correct += 1;
                            }else{
                                $count_answers += 1;
                            }
                        }else if (count($new_array) == 1) {
                            if (!empty(Question::find(Answer::find($new_array[0])->question_id)->score)) {
                                $score_question_correct += Question::find(Answer::find($new_array[0])->question_id)->score;
                                $count_correct += 1;
                            }else{
                                $count_answers += 1;
                            }
                        }
                    }
                }
            }
            // 50 cau 2 cau la no co diem r goi la x, y tinh diem tung cau dung trong 48 cau con lai
            // (10-x-y)/48*
            $score = round(($count_answers) * (10 - $score_question_correct) / ($count_questions - $count_correct), 2) + round($score_question_correct, 2);
            foreach ($new_arrays as $new_array) {
                $ok = 1;
                if(!empty($new_array)){
                    if (count($new_array) > 1) {
                        foreach ($new_array as $new) {
                            if (Answer::find($new)->correct_answer == 0) $ok *= 0;
                        }
                    } else if (count($new_array) == 1) {
                        if (Answer::find($new_array[0])->correct_answer == 1) $ok = 1;
                        else $ok = 0;
                    }
                }else{
                    $ok=0;
                }
                if ($ok == 1) {
                    if (!empty($new_array)) {
                        if (count($new_array) > 1) {
                            if (!empty(Question::find(Answer::find($new_array[0])->question_id)->score)) {
                                array_push($score_answers, Question::find(Answer::find($new_array[0])->question_id)->score);
                            }else{
                                array_push($score_answers,round( (10 - $score_question_correct) / ($count_questions - $count_correct), 2));
                            }
                        }else if (count($new_array) == 1) {
                            if (!empty(Question::find(Answer::find($new_array[0])->question_id)->score)) {

                                array_push($score_answers, Question::find(Answer::find($new_array[0])->question_id)->score);
                            }else{
                                array_push($score_answers,round( (10 - $score_question_correct) / ($count_questions - $count_correct), 2));
                            }
                        }
                    }
                } else {
                    array_push($score_answers, 0);
                }
            }
            if (Result::where('exam_id', $data['exam_id'])->where('student_id', Auth::guard('student')->user()->id)->count() == 0 && date('Y-m-d', strtotime(Exam::find($data['exam_id'])->end_time)) < date('Y-m-d', strtotime(Carbon::now()))) {
                Result::create(['exam_id' => $data['exam_id'], 'student_id' => Auth::guard('student')->user()->id, 'class_id' => Auth::guard('student')->user()->class_id, 'subject_id' => $data['subject_id'], 'score' => 0, 'time' => Carbon::now()->toDateTimeString()]);

                if (Result_Merger::where('exam_id', $data['exam_id'])->where('student_id', Auth::guard('student')->user()->id)->count() == 0) {
                    Result_Merger::create(['exam_id' => $data['exam_id'], 'student_id' => Auth::guard('student')->user()->id, 'class_id' => Auth::guard('student')->user()->class_id, 'subject_id' => $data['subject_id'], 'score' => 0]);
                }
            } else {
                Result::create(['exam_id' => $data['exam_id'], 'student_id' => Auth::guard('student')->user()->id, 'class_id' => Auth::guard('student')->user()->class_id, 'subject_id' => $data['subject_id'], 'score' => $score, 'time' => Carbon::now()->toDateTimeString()]);
                if (Result_Merger::where('exam_id', $data['exam_id'])->where('student_id', Auth::guard('student')->user()->id)->count() > 0) {
                    $result_merger = Result_Merger::where('exam_id', $data['exam_id'])->where('student_id', Auth::guard('student')->user()->id)->first();
                    $result_merger->update(['score' => $result_merger['score'] . ',' . $score]);
                } else {
                    Result_Merger::create(['exam_id' => $data['exam_id'], 'student_id' => Auth::guard('student')->user()->id, 'class_id' => Auth::guard('student')->user()->class_id, 'subject_id' => $data['subject_id'], 'score' => $score]);
                }
            }
            $result_id = Result::where('exam_id', $data['exam_id'])->where('student_id', Auth::guard('student')->user()->id)->orderBy('id', 'desc')->first()->id;
            foreach($score_answers as $score_answer){
                Result_Answer_Exam::create(['result_id' => $result_id, 'score_answer' => $score_answer]);
            }
            return response()->json(['status'=>true]);
        }
    }
    public function VisitToQuestion(Request $request, $exam_id, $subject_id, $grade_id, $question_id, $code)
    {

    }
    public function ResultExam(Request $request, $exam_id, $subject_id)
    {
        // if(Result::where('exam_id', $exam_id)->count()==1){
        $code=Str::random(32);
        if (date('Y-m-d', strtotime(Exam::find($exam_id)->end_time))<date('Y-m-d', strtotime(Carbon::now()))&&Result::where('exam_id', $exam_id)->where('student_id', Auth::guard('student')->user()->id)->count()==0) {
            Result::create(['exam_id' => $exam_id, 'student_id' => Auth::guard('student')->user()->id, 'class_id' => Auth::guard('student')->user()->class_id, 'subject_id' => $subject_id, 'score' => 0, 'time' => date('Y-m-d', strtotime(Exam::find($exam_id)->end_time))]);
            Result_Merger::create(['exam_id' => $exam_id, 'student_id' => Auth::guard('student')->user()->id, 'class_id' => Auth::guard('student')->user()->class_id, 'subject_id' => $subject_id, 'score'=>0]);
            $count_questions=0;
            foreach (Question::get()->toArray() as $question_answer) {
                if (in_array($exam_id, explode(',', $question_answer['select_id'])) || $exam_id == $question_answer['exam_id']) {
                    $count_questions+=1;
                }
            }
            $result_id = Result::where('exam_id', $exam_id)->where('student_id', Auth::guard('student')->user()->id)->orderBy('id', 'desc')->first()->id;
            for($i=1; $i<=$count_questions; ++$i){
                Result_Answer_Exam::create(['result_id'=>$result_id, 'score_answer'=>0]);
            }
            $results = Result::where('exam_id', $exam_id)->where('subject_id', $subject_id)->where('student_id', Auth::guard('student')->user()->id)->get()->toArray();
        // $exam=Exam::find($exam_id);
            $exam = Exam::find($exam_id);
            $subjects = Subject::where('status', 1)->get()->toArray();
            $maxscore = array();
            foreach ($results as $result) {
                array_push($maxscore, $result['score']);
            }
            // }else{
            //     $result=Result::where('exam_id', $exam_id)->get()->toArray();
            // }

            return View('frontend.result.index', compact('results', 'exam', 'subjects', 'maxscore', 'code'));
        }else{
            $results = Result::where('exam_id', $exam_id)->where('subject_id', $subject_id)->where('student_id', Auth::guard('student')->user()->id)->get()->toArray();
        // $exam=Exam::find($exam_id);
            $exam = Exam::find($exam_id);
            $subjects = Subject::where('status', 1)->get()->toArray();
            $maxscore = array();
            foreach ($results as $result) {
                array_push($maxscore, $result['score']);
            }
            // }else{
            //     $result=Result::where('exam_id', $exam_id)->get()->toArray();
            // }

            return View('frontend.result.index', compact('results', 'exam', 'subjects', 'maxscore', 'code'));
        }

    }

    // public function VisitExam(Request $request){
    //     if($request->ajax()){

    //     }
    // }
}
