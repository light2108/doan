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

class QuestionController extends Controller
{
    public function pagination($items, $perPage = 4, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function Index(Request $request, $exam_id, $subject_id, $grade_id)
    {
        Session::put('key', 'question');
        // if(!empty(Session::get('questions_answers'))){
        if(isset($_COOKIE['questions_answers'])){
            $questions_answers = $_COOKIE['questions_answers'];
            dd($questions_answers);
            $xxx=array();
            foreach ($questions_answers as $question_answer){
                if (in_array($exam_id, explode(',', $question_answer['select_id'])) || $exam_id == $question_answer['exam_id']){
                    $xxx[]=($question_answer);
                }
            }
            // $ppp=Question::with('answer')->get()->paginate(4);
            // $questions_answers=Question::where('exam_id', $exam_id)->with('answer')->get()->toArray();
            $data=$this->pagination($xxx);
            // // dd($data);
            $data->withPath('/exam/'.$exam_id.'/subject/'.$subject_id.'/grade/'.$grade_id);
            $exam = Exam::find($exam_id);
            return View('frontend.question.index', compact('questions_answers', 'exam_id', 'subject_id', 'grade_id','exam', 'data'));
        }else{
        // $xxx=Question::with('answer')->get()->toArray();
            $questions_answers = Question::with('answer')->where('status',1)->inRandomOrder()->get();
            $xxx=array();
            foreach ($questions_answers as $question_answer){
                if (in_array($exam_id, explode(',', $question_answer['select_id'])) || $exam_id == $question_answer['exam_id']){
                    $xxx[]=($question_answer);
                }
            }
            // $ppp=Question::with('answer')->get()->paginate(4);
            // $questions_answers=Question::where('exam_id', $exam_id)->with('answer')->get()->toArray();
            $data=$this->pagination($xxx);
            // // dd($data);
            $data->withPath('/exam/'.$exam_id.'/subject/'.$subject_id.'/grade/'.$grade_id);
            $exam = Exam::find($exam_id);
        // dd($exam);


            return View('frontend.question.index', compact('questions_answers', 'exam_id', 'subject_id', 'grade_id','exam', 'data'));
        }
        // }

        // Session::put('questions_answers', $questions_answers);

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
            // $count_questions=Question::where('exam_id', $data['exam_id'])->with('answer')->count();
            foreach (Question::get()->toArray() as $question) {
                if ($question['exam_id'] == $data['exam_id'] || in_array($data['exam_id'], explode(",", $question['select_id']))) {
                    $count_questions += 1;
                }
            }
            $answers = Answer::whereIn('id', explode(",", $data['answer_ids']))->get()->toArray();
            $count_answers = 0;
            $score_question=0;
            $count_correct=0;
            foreach ($answers as $answer) {
                if ($answer['correct_answer'] == 1){
                    if(!empty(Question::find($answer['question_id'])->score)){
                        $score_question+=Question::find($answer['question_id'])->score;
                        $count_correct+=1;
                    }else{
                        $count_answers+=1;
                    }
                }
            }
            // dd($count_questions);
            $score = round($count_answers*($count_questions-$count_correct)/(10-$score_question), 2)+round($score_question, 2);
            // Session::put('score',$score);
            if(Result::where('exam_id', $data['exam_id'])->where('student_id', Auth::guard('student')->user()->id)->count()>0){
               $result= Result::where('exam_id', $data['exam_id'])->where('student_id', Auth::guard('student')->user()->id);
               $result->update(['score'=>$result->first()->score.",".$score, 'time'=>($result->first()->time."|".Carbon::now()->toDateTimeString())]);
            }else if(date('Y-m-d', strtotime(Exam::find($data['exam_id'])->end_time))<date('Y-m-d', strtotime(Carbon::now()))){
                Result::create(['exam_id' => $data['exam_id'], 'student_id' => Auth::guard('student')->user()->id, 'class_id' => Auth::guard('student')->user()->class_id, 'subject_id' => $data['subject_id'], 'score' => 0, 'time'=>Carbon::now()->toDateTimeString()]);
            }else{
                Result::create(['exam_id' => $data['exam_id'], 'student_id' => Auth::guard('student')->user()->id, 'class_id' => Auth::guard('student')->user()->class_id, 'subject_id' => $data['subject_id'], 'score' => $score, 'time'=>Carbon::now()->toDateTimeString()]);
            }
            // foreach(Result::where('exam_id', $data['exam_id'])->where('student_id', Auth::guard('admin')))
            return response()->json(['status' => true]);
        }
    }
    public function VisitToQuestion(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $question = Question::find($data['question_id'])->with('answer');
            return response()->json(['status' => true]);
            // dd($question);
        }
    }
    public function ResultExam(Request $request, $exam_id, $subject_id)
    {
        // if(Result::where('exam_id', $exam_id)->count()==1){

        if(empty(Result::where('exam_id', $exam_id)->where('subject_id', $subject_id)->where('student_id', Auth::guard('student')->user()->id)->first())){
            Result::create(['exam_id'=>$exam_id, 'student_id'=>Auth::guard('student')->user()->id, 'class_id' => Auth::guard('student')->user()->class_id, 'subject_id' => $subject_id, 'score' => 0, 'time'=>date('Y-m-d', strtotime(Exam::find($exam_id)->end_time))]);
        }
        $result = Result::where('exam_id', $exam_id)->where('subject_id', $subject_id)->where('student_id', Auth::guard('student')->user()->id)->first()->toArray();
        // $exam=Exam::find($exam_id);
        $exam = Exam::find($exam_id);
        $subjects = subject::get()->toArray();
        // $maxscore=array();
        // foreach($results as $result){
        //     array_push($maxscore, $result['score']);
        // }
        // }else{
        //     $result=Result::where('exam_id', $exam_id)->get()->toArray();
        // }

        return View('frontend.result.index', compact('result', 'exam', 'subjects'));
    }
    // public function ExamListQuestion(Request $request, $exam_id, $subject_id, $grade_id){
    //     $questions_answers = Question::with('answer')->where('status',1)->get();
    //     $data=array();
    //     foreach ($questions_answers as $question_answer){
    //         if (in_array($exam_id, explode(',', $question_answer['select_id'])) || $exam_id == $question_answer['exam_id']){
    //             $data[]=($question_answer);
    //         }
    //     }
    //     // dd($data);
    //     return View('frontend.question.list', compact('data', 'exam_id', 'subject_id', 'grade_id'));
    // }
}
