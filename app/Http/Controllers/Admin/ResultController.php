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
use App\Exports\ResultExportFull;
use App\Models\Result_Merger;
use App\Models\Question;
use App\Models\Result_Answer_Exam;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Check_Login_Exam;

class ResultController extends Controller
{
    public function Index()
    {
        Session::put('page', 'result');
        // $exams=Exam::where('teacher_id', Auth::guard('admin')->user()->id)->get()->toArray();
        // dd(empty(Result::where('exam_id', 15)->get()->toArray()));
        $classes = Classes::where('status', 1)->get()->toArray();
        $grades = Grade::where('status', 1)->get()->toArray();
        // dd($exams);

        return View('admin.result.index_class', compact('classes', 'grades'));
    }
    public function SeeStudentExam(Request $request, $exam_id, $class_id){
        $exam = Exam::find($exam_id);
        $students = Student::where('class_id', $class_id)->where('status', 1)->get()->toArray();
        // dd($students);

        $classes = Classes::find($class_id);
        if(empty(Check_Login_Exam::where('exam_id', $exam_id)->get()->toArray())){
            foreach($students as $student){
                Check_Login_Exam::create(['exam_id'=>$exam_id, 'student_id'=>$student['id'], 'status'=>0]);
            }
            $students_login=Check_Login_Exam::where('exam_id', $exam_id)->get()->toArray();
        }else{
            $students_login=Check_Login_Exam::where('exam_id', $exam_id)->get()->toArray();
        }
        return View('admin.result.index_status', compact('students_login', 'students', 'classes'));
    }
    public function ResultStudentExam(Request $request, $exam_id, $class_id)
    {
        $exam = Exam::find($exam_id);
        $students = Student::where('class_id', $class_id)->where('status', 1)->get()->toArray();
        // dd($students);

        $classes = Classes::find($class_id);

        $results = Result_Merger::where('exam_id', $exam_id)->where('class_id', $class_id)->orderBy('score', 'Desc')->get()->toArray();

        // $result_student
        Session::put('exam_id', $exam_id);
        Session::put('class_id', $class_id);

        $count_questions = 0;
        foreach (Question::get()->toArray() as $question_answer) {
            if (in_array($exam_id, explode(',', $question_answer['select_id'])) || $exam_id == $question_answer['exam_id']) {
                $count_questions += 1;
            }
        }
        $student_id_has_result = array();
        foreach ($results as $result) {
            $student_id_has_result[] = $result['student_id'];
        }
        // dd($student_id_has_result);
        $student_id_not_result = array();
        foreach ($students as $student) {
            $student_id_not_result[] = $student['id'];
        }
        // dd($student_id_not_result);
        $diff = array_diff($student_id_not_result, $student_id_has_result);
        // dd($diff);
        if (count($diff) > 0) {
            if (date('Y-m-d H:i:s', strtotime($exam['end_time'])) < date('Y-m-d H:i:s', strtotime(Carbon::now()))) {
                foreach ($diff as $di) {
                    Result::create(['exam_id' => $exam_id, 'student_id' => $di, 'class_id' => $class_id, 'subject_id' => Auth::guard('admin')->user()->subject_id, 'score' => 0, 'time' => date('Y-m-d', strtotime($exam['end_time']))]);
                    Result_Merger::create(['exam_id' => $exam_id, 'student_id' => $di, 'class_id' => $class_id, 'subject_id' => Auth::guard('admin')->user()->subject_id, 'score' => 0]);

                    $result_id = Result::where('exam_id', $exam_id)->where('student_id', $di)->orderBy('id', 'desc')->first()->id;
                    for ($i = 1; $i <= $count_questions; ++$i) {
                        Result_Answer_Exam::create(['result_id' => $result_id, 'student_id'=>$di, 'score_answer' => 0]);
                    }
                }
            }
        }
        Session::put('count_questions', $count_questions);
        return View('admin.result.index_result', compact('results', 'students', 'classes', 'exam'));
    }

    public function ResultExamClass(Request $request, $class_id)
    {
        $exams = Exam::where('teacher_id', Auth::guard('admin')->user()->id)->where('status', 1)->get()->toArray();
        return View('admin.result.index_exam', compact('exams', 'class_id'));
    }
    public function ExportFileResultBriefly(Request $request)
    {
        return Excel::download(new ResultExport, 'briefly_results.xlsx');
    }
    public function ExportFileResultFull(Request $request)
    {
        return Excel::download(new ResultExportFull, 'full_results.xlsx');
    }
}
