<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerExamController extends Controller
{
    public function Index(Request $request, $question_id, $exam_id){
        $answers=Answer::where('question_id', $question_id)->where('status', 1)->get()->toArray();
        return View('admin.questionexam.index_answer', compact('question_id', 'exam_id', 'answers'));
    }
    public function addAnswer(Request $request, $question_id, $exam_id){
        // $answers=Answer::all();
        if($request->isMethod('post')){
            $data=$request->all();
            $data['question_id']=$question_id;
            Answer::create($data);
            return redirect()->back()->with('success_message', 'Created answer successfully');
        }
        // return View('admin.questionexam.index_answer', compact('answers'));
    }
    public function editAnswer(Request $request,$answer_id, $question_id, $exam_id){
        // $answers=Answer::all();
        $answer=Answer::find($answer_id);
        if($request->isMethod('post')){
            $data=$request->all();
            $data['question_id']=$question_id;
            $answer->update($data);
            return redirect()->back()->with('success_message', 'Updated answer successfully');
        }
        // return View('admin.questionexam.index_answer', compact('answers'));
    }
    public function deleteAnswer(Request $request, $answer_id){
        Answer::find($answer_id)->delete();
        return redirect()->back()->with('success_message', 'Deleted Answer successfully');
    }
    public function statusAnswer(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            if ($data['status'] == "True") {
                Answer::find($data['id'])->update(['correct_answer' => 0]);
                return response()->json(['status' => "True"]);
            } else {
                Answer::find($data['id'])->update(['correct_answer' => 1]);
                return response()->json(['status' => "False"]);
            }
        }
    }
    public function DeleteAll(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            Answer::whereIn('id', explode(",", $data['ids']))->delete();
            return response()->json(['status' => true]);
        }
        return redirect()->back()->with('success_message', 'Deleted Answers Exam Successfully');
    }
}
