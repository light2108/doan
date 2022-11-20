<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
  public function Index(Request $request, $subject_id, $grade_id)
  {
    $subject_exams = Exam::where('subject_id', $subject_id)->where('grade_id', $grade_id)->with('teacher')->where('status', 1)->get()->toArray();
    // dd($subject_exams);
    $code = Str::random(32);
    Session::put('key', 'subject');
    if ($request->isMethod('POST')) {
    }
    return View('frontend.subject.index', compact('subject_exams', 'code'));
  }
  public function checkPasswordExam(Request $request)
  {
    if ($request->ajax()) {
      $data = $request->all();
      $exam = Exam::find($data['exam_id']);
      if ($exam['password'] == $data['password']) {
        return response()->json(['status' => true, 'code' => Str::random(32)]);
      } else {
        return response()->json(['status' => false]);
      }
    }
  }
}
