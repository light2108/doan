<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
class SubjectController extends Controller
{
    public function Index(Request $request, $subject_id, $grade_id){
        $subject_exams=Exam::where('subject_id', $subject_id)->where('grade_id', $grade_id)->with('teacher')->where('status',1)->get()->toArray();
        // dd($subject_exams);
        Session::put('key', 'subject');
        if($request->isMethod('POST')){
            $data=$request->all();
        }
        return View('frontend.subject.index', compact('subject_exams'));
    }
    public function checkPasswordExam(Request $request){
        if($request->ajax()){
            $data=$request->all();
            $exam=Exam::find($data['exam_id']);
            if($exam['password']==$data['password']){
                return response()->json(['status' =>true]);
            }else{
                return response()->json(['status' =>false]);
            }
        }
    }

}
