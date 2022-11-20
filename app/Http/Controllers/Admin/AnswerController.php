<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Answer;
class AnswerController extends Controller
{
    public function viewAnswer(Request $request, $question_id){
        $answers=Answer::where('question_id', $question_id)->get();
        // dd($answers);
        return View('admin.questions.index_answer', compact('question_id', 'answers'));
    }
    public function addAnswer(Request $request, $question_id){
        if($request->isMethod('post')){
            $data=$request->all();
            $data['question_id']=$question_id;
            Answer::create($data);
            return redirect()->back()->with('success_message', 'Created answer successfully');
        }
    }
    public function editAnswer(Request $request, $answer_id, $question_id){
        $answer=Answer::find($answer_id);
        if($request->isMethod('post')){
            $data=$request->all();
            // $data['question_id']=$question_id;
            $answer->update($data);
            return redirect()->back()->with('success_message', 'Updated answer successfully');
        }
    }
    public function DeleteAll(Request $request){
        if($request->ajax()){
            $data=$request->all();
            Answer::whereIn('id', explode(",",$data['ids']))->delete();
            return response()->json(['status'=>true]);
        }
        return redirect()->back()->with('success_message', 'Deleted Answers Successfully');
    }
}
