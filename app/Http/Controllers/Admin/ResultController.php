<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Result;
use App\Models\Classes;
use App\Models\Grade;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ResultExport;
class ResultController extends Controller
{
    public function Index(){
        Session::put('page', 'result');
        // $exams=Exam::where('teacher_id', Auth::guard('admin')->user()->id)->get()->toArray();

        $classes=Classes::where('status', 1)->get()->toArray();
        $grades=Grade::where('status', 1)->get()->toArray();
        // dd($exams);
        return View('admin.result.index_class', compact('classes', 'grades'));
    }
    public function ResultStudentExam(Request $request, $exam_id, $class_id){
        $results=Result::where('exam_id', $exam_id)->where('class_id', $class_id)->orderBy('score', 'Desc')->get()->toArray();
        $students=Student::where('class_id', $class_id)->where('status', 1)->get()->toArray();
        // dd($students);
        $classes=Classes::find($class_id);
        // $result_student
        Session::put('exam_id', $exam_id);
        Session::put('class_id', $class_id);
        // $records=DB::table('results')->join('students', 'results.student_id', '=', 'students.id')->join('exams', 'exams.id', '=','results.exam_id')->join('classes', 'classes.id', '=', 'results.class_id')->select(
        //     'students.student_code as StudentCode', 'students.name as StudentName', 'classes.name as ClassName', 'exams.name as ExamName', 'results.score as Score'
        //   )->where('results.exam_id', $exam_id)->where('results.class_id', $class_id)->get()->toArray();
        // dd($records);
        // dd($results);
        // $records=DB::table('results')->join('students', 'results.student_id', '=', 'students.id')->join('exams', 'exams.id', '=','results.exam_id')->join('classes', 'classes.id', '=', 'results.class_id')->select(
        //     'students.student_code as StudentCode', 'students.name as StudentName', 'classes.name as ClassName', 'exams.name as ExamName', 'results.score as Score',
        //     DB::raw("(max(results.score)")
        //   )->where('results.exam_id', $exam_id)->where('results.class_id', $class_id)->get()->toArray();
        // dd($records);
        return View('admin.result.index_result', compact('results', 'students', 'classes'));
    }

    public function ResultExamClass(Request $request, $class_id){
        $exams=Exam::where('teacher_id', Auth::guard('admin')->user()->id)->where('status', 1)->get()->toArray();
        return View('admin.result.index_exam', compact('exams', 'class_id'));
    }
    public function ExportFileResult(Request $request){
        return Excel::download(new ResultExport, 'results.xlsx');
    }
}
