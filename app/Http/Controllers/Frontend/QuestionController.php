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
class QuestionController extends Controller
{
    public function Index(Request $request, $exam_id, $subject_id, $grade_id){
        Session::put('key', 'question');
        $questions_answers=Question::with('answer')->get()->toArray();
        // $questions_answers=Question::where('exam_id', $exam_id)->with('answer')->get()->toArray();

        // dd($questions_answers);
        $exam=Exam::find($exam_id)->toArray();
        // dd($exam);
        return View('frontend.question.index', compact('questions_answers', 'exam_id', 'subject_id', 'exam'));
    }
    public function CheckExam(Request $request, $exam_id){
        // $questions_answers=Question::where('exam_id', $exam_id)->with('answer')->get()->toArray();
        if($request->isMethod('POST')){
            $data= $request->all();
            // dd($data);

        }
    }
    public function CheckResultAnswer(Request $request){

        if($request->ajax()){
            $data= $request->all();
            $count_questions=0;
            // $count_questions=Question::where('exam_id', $data['exam_id'])->with('answer')->count();
            foreach(Question::get()->toArray() as $question){
                if($question['exam_id']==$data['exam_id']||in_array($data['exam_id'], explode(",",$question['select_id']))){
                    $count_questions+=1;
                }
            }
            $answers=Answer::whereIn('id', explode(",", $data['answer_ids']))->get()->toArray();
            $count_answers=0;
            foreach($answers as $answer){
                if($answer['correct_answer']==1) $count_answers+=1;
            }
            // dd($count_questions);
            $score=round($count_answers/$count_questions*10,2);
            // Session::put('score',$score);
            if(Result::where('exam_id', $data['exam_id'])->count()>0){

                Result::where('exam_id', $data['exam_id'])->update(['score'=>max($score,Result::where('exam_id', $data['exam_id'])->first()->score)]);
            }else{
                Result::create(['exam_id'=>$data['exam_id'], 'student_id'=>Auth::guard('student')->user()->id, 'class_id'=>Auth::guard('student')->user()->class_id, 'subject_id'=>$data['subject_id'], 'score'=>$score]);
            }
            return response()->json(['status' =>true]);
        }
    }
    public function VisitToQuestion(Request $request){
        if($request->ajax()){
            $data= $request->all();
            $question=Question::find($data['question_id'])->with('answer');
            return response()->json(['status' =>true]);
            // dd($question);
        }
    }
    public function ResultExam(Request $request, $exam_id){
        // if(Result::where('exam_id', $exam_id)->count()==1){
            $result=Result::where('exam_id', $exam_id)->first()->toArray();
            $exam=Exam::find($exam_id);
        // }else{
        //     $result=Result::where('exam_id', $exam_id)->get()->toArray();
        // }
        if($request->isMethod('POST')){

        }
        return View('frontend.result.index', compact('result', 'exam'));
    }
}
