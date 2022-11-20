<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Admin;
use App\Models\Grade;
use App\Models\Question;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Carbon;
class ExamController extends Controller
{
  public function Index()
  {
    // $teacher=Admin::find(Auth::guard('admin')->user()->id)->with('subject');
    // dd($teacher);
    Session::put('page', 'exam');
    $exams = Exam::where('teacher_id', Auth::guard('admin')->user()->id)->get()->toArray();
    $subjects = Subject::where('status', 1)->get()->toArray();
    $classes = Classes::where('status', 1)->get()->toArray();
    $grades = Grade::where('status', 1)->get()->toArray();
    $teacher = Admin::find(Auth::guard('admin')->user()->id);
    $teacher_classes = explode(",", $teacher['class_id']);

    // Session::put('password', $data['password']);
    // dd($teacher_classes);
    // dd($subjects);
    // $exam_classes=explode(",", $['class_id']);
    return View('admin.exams.index', compact('exams', 'teacher', 'classes', 'subjects', 'teacher_classes', 'grades'));
  }
  public function addExam(Request $request)
  {
    $grades = Grade::where('status', 1)->get()->toArray();
    $teacher = Admin::find(Auth::guard('admin')->user()->id);
    $teacher_classes = explode(",", $teacher['class_id']);
    $classes = Classes::where('status', 1)->get()->toArray();
    if ($request->isMethod('post')) {
      $data = $request->all();
      // dd($data);
      $data['teacher_id'] = Auth::guard('admin')->user()->id;
      // $data['password']=Hash::make($data['password']);
      $data['subject_id'] = Auth::guard('admin')->user()->subject_id;
      $data['class_id'] = implode(",", $data['class_id']);
      // $data['multiple']=(isset($data['multiple'])?1:0);
      if ($request->hasFile('video')) {
        $image = $request->file('video');
        $reimage = 'video/' . time() . '.' . $image->getClientOriginalExtension();
        $dest = public_path('/video');
        $image->move($dest, $reimage);
        $data['video'] = $reimage;
        if (date('Y-m-d H:i:s', strtotime($data['start_time'])) <= date('Y-m-d H:i:s', strtotime($data['end_time']))) {
          Exam::create($data);
        } else {
          return redirect()->back()->with('error_message', 'Thời gian bài kiểm tra không đúng');
        }
      } else {
        if (date('Y-m-d H:i:s', strtotime($data['start_time'])) <= date('Y-m-d H:i:s', strtotime($data['end_time']))) {
          Exam::create($data);
        } else {
          return redirect()->back()->with('error_message', 'Thời gian bài kiểm tra không đúng');
        }
      }
      return redirect('/admin/exams')->with('success_message', 'Tạo bài kiểm tra thành công');
    }
    return View('admin.exams.add', compact('grades', 'teacher_classes', 'classes'));
  }
  public function editExam(Request $request, $id)
  {
    $exam = Exam::find($id);
    $grades = Grade::where('status', 1)->get()->toArray();
    $teacher = Admin::find(Auth::guard('admin')->user()->id);
    $classes = Classes::where('status', 1)->get()->toArray();
    $teacher_classes = explode(",", $teacher['class_id']);
    if ($request->isMethod('post')) {
      $data = $request->all();
      // dd($data);
      // Session::put('password', $data['password']);
      // password_
      // $data['password']=Hash::make($data['password']);
      $data['subject_id'] = Auth::guard('admin')->user()->subject_id;
      $data['class_id'] = implode(",", $data['class_id']);

      // $data['multiple']=(isset($data['multiple'])?1:0);
      if ($request->hasFile('video')) {
        $image = $request->file('video');
        $reimage = 'video/' . time() . '.' . $image->getClientOriginalExtension();
        $dest = public_path('/video');
        $image->move($dest, $reimage);
        $data['video'] = $reimage;
        if (date('Y-m-d H:i:s', strtotime($data['start_time'])) <= date('Y-m-d H:i:s', strtotime($data['end_time']))) {
          $exam->update($data);
        } else {
          return redirect()->back()->with('error_message', 'Đặt thời gian bài kiểm tra không đúng');
        }
      } else {
        if (date('Y-m-d H:i:s', strtotime($data['start_time'])) <= date('Y-m-d H:i:s', strtotime($data['end_time']))) {
          $exam->update($data);
        } else {
          return redirect()->back()->with('error_message', 'Đặt thời gian bài kiểm tra không đúng');
        }
      }

      return redirect('/admin/exams')->with('success_message', 'Chỉnh sửa thành công');
    }

    return View('admin.exams.edit', compact('exam', 'grades', 'teacher_classes', 'classes'));
  }
  public function deleteExam($id)
  {
    Exam::find($id)->delete();
    return redirect()->back()->with('success_message', 'Xóa bài kiểm tra thành công');
  }

  public function StatusExam(Request $request)
  {
    if ($request->ajax()) {
      $data = $request->all();
      if ($data['status'] == "Active") {
        Exam::find($data['id'])->update(['status' => 0]);
        return response()->json(['status' => "Active"]);
      } else {
        Exam::find($data['id'])->update(['status' => 1]);
        return response()->json(['status' => "Inactive"]);
      }
      // return response()->json(['status'=>true]);
    }
  }
  public function DeleteAll(Request $request)
  {
    if ($request->ajax()) {
      $data = $request->all();
      Exam::whereIn('id', explode(",", $data['ids']))->delete();
      return response()->json(['status' => true]);
    }
    return redirect()->back()->with('success_message', 'Xóa các bài kiểm tra thành công');
  }
  public function appendClassExam(Request $request)
  {
    if ($request->ajax()) {
      $data = $request->all();
      $teacher = Admin::find(Auth::guard('admin')->user()->id);
      // print_r(explode(",",$teacher['class_id']));
      $getclasses = Classes::where('grade_id', $data['grade_id'])->whereIn('id', explode(",", $teacher['class_id']))->get()->toArray();
      // dd($getclasses);
      // $view=View('admin.exams.append_classes_exam', ['getclasses'=>$getclasses])->render();
      // return response()->json(['view'=>$view]);
      return View('admin.exams.append_classes_exam', compact('getclasses'));
    }
  }
}