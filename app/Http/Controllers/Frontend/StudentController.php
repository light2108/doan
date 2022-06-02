<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classes;
use App\Models\Exam;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
class StudentController extends Controller
{
    public function Index(Request $request){
        Session::put('key', 'student');
        $subjects=Subject::with('teacher')->get()->toArray();
        if($request->has('search')){
            $exams=Exam::with('teacher')->with('subject')->where('name', 'like', '%'.$request->search.'%')->get()->toArray();
            // dd($exams);
        }else{
            $exams=Exam::with('teacher')->with('subject')->get()->toArray();
        }
        $count=0;
        foreach($exams as $exam){
            if(!in_array(Auth::guard('student')->user()->class_id, explode(",", $exam['class_id']))){
                $count++;
            }
        }
        if($request->has('search')){
            $exams=Exam::with('teacher')->with('subject')->where('name', 'like', '%'.$request->search.'%')->paginate(6+$count);
            // dd($exams);
        }else{
            $exams=Exam::with('teacher')->with('subject')->paginate(6+$count);
        }
        // $exams=Exam::with('teacher')->with('subject')->paginate(6+$count);
        return View('frontend.index', compact('subjects', 'exams'));
    }

    public function Login(Request $request){
        if($request->isMethod('POST')){
            $data=$request->all();
            if(Auth::guard('student')->attempt(['student_code'=>$data['student_code'],'password'=>$data['password']])){
                return redirect('/dashboard');
            }else{
                return redirect()->back()->with('error_message', 'Your email or password is incorrect');
            }
        }
        return View('frontend.login');
    }
    public function Logout(){
        Auth::guard('student')->logout();
        return redirect('/');
    }
    public function ChangeDetail(Request $request){
        $student=Student::find(Auth::guard('student')->user()->id);
        $classes=Classes::get()->toArray();
        if($request->isMethod('POST')){
            $data=$request->all();
            if(Hash::check($data['old_password'], $student['password'])){
                $data['password']=Hash::make($data['new_password']);
                $student->update($data);
                return redirect()->back()->with('success_message', 'Updated Profile Successfully');
            }else{
                return redirect()->back()->with('error_message', 'Somethings Wrong');
            }
        }
        return View('frontend.change_detail', compact('student', 'classes'));
    }
}
