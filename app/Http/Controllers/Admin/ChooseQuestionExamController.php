<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Classes;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Subject;
use App\Models\Answer;
use App\Models\Unit;
use Illuminate\Support\Facades\Session;

class ChooseQuestionExamController extends Controller
{
    public function Index($subject_id, $grade_id, $unit_id, $exam_id)
    {
        $questions = Question::with('subject')->where('subject_id', $subject_id)->where('grade_id', $grade_id)->where('unit_id', $unit_id)->where('status', 1)->get()->toArray();
        // dd($questions);
        $classes = Classes::where('status', 1)->get()->toArray();
        // dd($classes);
        $teacher_exam = Admin::with('exam')->where('id', Auth::guard('admin')->user()->id)->where('status', 1)->first()->toArray();
        // dd($teacher_exam);
        $teachers = Admin::where('role', 0)->orWhere('role', -1)->where('status', 1)->get()->toArray();
        $subjects = Subject::where('status', 1)->get()->toArray();
        // Session::put('page', $grade_id);
        // $grades=Grade::with('class')->get()->toArray();
        // dd($grades);
        return View('admin.choosequestionexam.index_question', compact('questions', 'subject_id', 'unit_id', 'teachers', 'subjects', 'grade_id', 'classes', 'teacher_exam', 'exam_id'));
    }
    public function UnitSubjectGradeExam(Request $request, $subject_id, $grade_id, $exam_id)
    {
        $units=Unit::where('subject_id', $subject_id)->where('grade_id', $grade_id)->where('status', 1)->get()->toArray();
        $subjects = Subject::where('status', 1)->get()->toArray();
        return View('admin.choosequestionexam.index_unit', compact('units','subject_id', 'grade_id', 'subjects', 'exam_id'));
    }
    public function chooseQuestion(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // $data['exam_id']+=$data['exam_id'].",";
            $questions = Question::whereIn('id', explode(",", $data['allquestion_ids']))->get();
            foreach ($questions as $question) {
                $question->update(['select_id' => ($question['select_id'] . ',' . $data['exam_id'])]);
            }
            return response()->json(['status' =>true]);
        }
    }

    public function editQuestion(Request $request, $question_id, $subject_id, $grade_id, $unit_id, $exam_id)
    {
        // dd(Session::get('grade_id'));
        $question = Question::with('answer')->find($question_id);
        // dd($question);

        return View('admin.choosequestionexam.edit_question', compact('question_id', 'subject_id', 'grade_id', 'question', 'unit_id'));
    }

}
