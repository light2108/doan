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
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
class StudentController extends Controller
{
    public function pagination($items, $perPage = 6, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function Index(Request $request){
        Session::put('key', 'student');
        $subjects=Subject::with('teacher')->where('status', 1)->get()->toArray();
        $xxx = array();
        // if($request->has('search')){
        //     $exams=Exam::with('teacher')->with('subject')->where('name', 'like', '%'.$request->search.'%')->where('status', 1)->get()->toArray();
        //     // dd($exams);
        // }else{
        //     $exams=Exam::with('teacher')->with('subject')->where('status', 1)->get()->toArray();
        // }
        // dd($exams);
        $exams=Exam::with('teacher')->with('subject')->where('status', 1)->get()->toArray();
        foreach ($exams as $exam){
            if (in_array(Auth::guard('student')->user()->class_id, explode(',', $exam['class_id']))&&!empty($exam['teacher'])){
                $xxx[]=$exam;
            }
        }
        // dd($xxx);
        // $data = $this->pagination($xxx);
        if($request->has('search')){
            $data=$this->where('name', 'like', '%'.$request->search.'%')->pagination($xxx);
            // dd($exams);
        }else{
            $data=$this->pagination($xxx);
        }

        $data->withPath('/dashboard');



        // $exams=Exam::with('teacher')->with('subject')->paginate(6+$count);
        return View('frontend.index', compact('subjects', 'data'));
    }

    public function Login(Request $request){
        if($request->isMethod('POST')){
            $data=$request->all();
            if(Auth::guard('student')->attempt(['student_code'=>$data['student_code'],'password'=>$data['password'], 'status'=>1])){
                return redirect('/dashboard');
            }else{
                return redirect()->back()->with('error_message', 'Your student code or password is incorrect');
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
        $classes=Classes::where('status', 1)->get()->toArray();
        if($request->isMethod('POST')){
            $data=$request->all();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $reimage = 'imgstudent/' . time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgstudent');
                $image->move($dest, $reimage);
                $data['image'] = $reimage;
                $student->update($data);
                return redirect()->back()->with('success_message', 'Updated Profile Successfully');
            }
            if(Hash::check($data['current_password'], $student['password'])){
                if($data['new_password']==$data['confirm_password']){
                    $data['password']=Hash::make($data['new_password']);
                    $student->update($data);
                    return redirect()->back()->with('success_message', 'Updated Profile Successfully');
                }else{
                    return redirect()->back()->with('error_message', 'Updated Profile Successfully');
                }
            }else{
                return redirect()->back()->with('error_message', 'Somethings Wrong');
            }
        }
        return View('frontend.change_detail', compact('student', 'classes'));
    }
}
