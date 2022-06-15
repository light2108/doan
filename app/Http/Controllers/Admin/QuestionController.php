<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Classes;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Session;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
use App\Models\Answer;
use App\Imports\QuestionImport;
use App\Imports\AnswerImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\QuestionExport;
function removeptag($string){
    $string=str_replace("<p>","",$string);
    $string=str_replace("</p>","",$string);

    return $string;
}
class QuestionController extends Controller
{
    public function Index($subject_id, $grade_id, $unit_id)
    {

        $questions = Question::with('subject')->where('subject_id', $subject_id)->where('grade_id', $grade_id)->where('unit_id', $unit_id)->get()->toArray();
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
        return View('admin.questions.index_question', compact('questions', 'subject_id', 'unit_id', 'teachers', 'subjects', 'grade_id', 'classes', 'teacher_exam'));
    }
    public function addQuestion(Request $request, $subject_id, $grade_id, $unit_id)
    {
        // dd(Session::get('grade_id'));
        if ($request->isMethod('post')) {
            $data = $request->all();
            $request->validate([
                'image'=>'mimes:jpeg, png, jpg',
                'file_listen'=>'mimes:mp3'
            ]);
            // $data['exam_id']=0;
            $data['question']=removeptag($data['question']);
            $data['grade_id'] = $grade_id;
            $data['unit_id'] = $unit_id;
            $data['teacher_id'] = Auth::guard('admin')->user()->id;
            $data['subject_id'] = Auth::guard('admin')->user()->subject_id;
            if ($request->hasFile('image') || $request->hasFile('file_listen')) {
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $reimage = 'imgckeditor/' . time() . '.' . $image->getClientOriginalExtension();
                    $dest = public_path('/imgckeditor');
                    $image->move($dest, $reimage);
                    $data['image'] = $reimage;
                }
                if ($request->hasFile('file_listen')) {
                    $listen = $request->file('file_listen');
                    $relisten = 'listen/' . time() . '.' . $listen->getClientOriginalExtension();
                    $destl = public_path('/listen');
                    $listen->move($destl, $relisten);
                    $data['file_listen'] = $relisten;
                }
                Question::create($data);
            } else {
                Question::create($data);
            }
            foreach ($data['answer'] as $key => $answer) {
                Answer::create(['question_id' => Question::where('teacher_id', Auth::guard('admin')->user()->id)->orderBy('id', 'Desc')->first()->id, 'answer' => removeptag($data['answer'][$key]), 'correct_answer' => $data['correct_answer'][$key]]);
            }
            return redirect('/admin/questions/subject/' . $subject_id . '/grade/' . $grade_id . '/unit/' . $unit_id)->with('success_message', 'Created Question Successfully');
        }
        return View('admin.questions.add_question', compact('grade_id', 'subject_id', 'unit_id'));
    }
    public function editQuestion(Request $request, $question_id, $subject_id, $grade_id, $unit_id)
    {
        // dd(Session::get('grade_id'));
        $question = Question::with('answer')->find($question_id);
        // dd($question);
        if ($request->isMethod('post')) {

            $data = $request->all();
            $request->validate([
                'image'=>'mimes:jpeg, png, jpg',
                'file_listen'=>'mimes:mp3'
            ]);
            // $data['exam_id']=0;
            $data['question']=removeptag($data['question']);
            $data['teacher_id'] = Auth::guard('admin')->user()->id;
            $data['subject_id'] = Auth::guard('admin')->user()->subject_id;
            // dd($data);
            // Question::create($data);
            if ($request->hasFile('image') || $request->hasFile('file_listen')) {
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $reimage = 'imgckeditor/' . time() . '.' . $image->getClientOriginalExtension();
                    $dest = public_path('/imgckeditor');
                    $image->move($dest, $reimage);
                    $data['image'] = $reimage;
                }
                if ($request->hasFile('file_listen')) {
                    $listen = $request->file('file_listen');
                    $relisten = 'listen/' . time() . '.' . $listen->getClientOriginalExtension();
                    $destl = public_path('/listen');
                    $listen->move($destl, $relisten);
                    $data['file_listen'] = $relisten;
                }
                $question->update($data);
            } else {
                $question->update($data);
            }
            Answer::where('question_id',$question_id)->delete();
            foreach ($data['answer'] as $key => $answer) {
                Answer::create(['question_id' => $question['id'], 'answer' => removeptag($data['answer'][$key]), 'correct_answer' => $data['correct_answer'][$key]]);
            }
            return redirect('/admin/questions/subject/' . $subject_id . '/grade/' . $grade_id.'/unit/'.$unit_id)->with('success_message', 'Updated Question Successfully');
        }
        return View('admin.questions.edit_question', compact('question_id', 'subject_id', 'grade_id', 'question', 'unit_id'));
    }
    public function ImportFileQuestion(Request $request, $subject_id, $grade_id, $unit_id){
        if($request->isMethod('post')){
            $request->validate([
                'file'=>'required|mimes:xlsx, xls'
            ]);
            $results=Excel::toArray(new QuestionImport,request()->file('file'));
            // dd($results[0][0]['question']);
            // $count=0;
            foreach($results[0] as $result){
                // dd($result);
                // foreach($result as $row){
                    if(!empty($result['question'])){
                        Question::create(['teacher_id'=>Auth::guard('admin')->user()->id, 'subject_id'=>Auth::guard('admin')->user()->subject_id, 'question'=>$result['question'],
                        'grade_id'=>$grade_id, 'unit_id'=>$unit_id, 'score'=>(isset($result['score'])?$result['score']:0)]);
                    }
                    Answer::create(['question_id'=>Question::where('teacher_id', Auth::guard('admin')->user()->id)->orderBy('id', 'Desc')->first()->id, 'answer'=>$result['answer'], 'correct_answer'=>$result['correct_answer']]);
                // }
            }
            // Excel::import(new QuestionImport,request()->file('file'));
            // Excel::import(new AnswerImport, request()->file('file'));
            return redirect('/admin/questions/subject/'. $subject_id . '/grade/' . $grade_id.'/unit/' . $unit_id)->with('success_message', 'Created Students Successfully');
        }
        return View('admin.questions.add_file_question', compact('subject_id', 'grade_id', 'unit_id'));
    }

    public function ExportFileQuestion(Request $request, $subject_id, $grade_id, $unit_id){
        Session::put('subject_id', $subject_id);
        Session::put('grade_id', $grade_id);
        Session::put('unit_id', $unit_id);
        return Excel::download(new QuestionExport, 'questions.xlsx');
        // $records=DB::table('questions')->join('answer', 'questions.id', '=', 'answer.question_id')->join('subjects', 'questions.subject_id', '=', 'subjects.id')->join('grades', 'questions.grade_id', '=', 'grades.id')->join('units', 'questions.unit_id', '=', 'units.id')->select(
        //     'questions.question','answer.answer as answer', 'answer.correct_answer as correct_answer', 'units.name as unit','grades.grade as grade','subjects.name as subject'
        // )->where('questions.subject_id', $subject_id)->where('questions.grade_id', $grade_id)->where('questions.unit_id', $unit_id)->get()->toArray();
        // // dd($records);
        // return $records;
    }
    public function DeleteAll(Request $request)
    {
        $data = $request->all();

        if ($request->ajax()) {

            Question::whereIn('id', explode(",", $data['ids']))->delete();
            return response()->json(['status' => true]);
        }
        return redirect()->back()->with('success_message', 'Deleted Questions Successfully');

    }
    public function StatusQuestion(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                Question::find($data['id'])->update(['status' => 0]);
                return response()->json(['status' => "Active"]);
            } else {
                Question::find($data['id'])->update(['status' => 1]);
                return response()->json(['status' => "Inactive"]);
            }
            // return response()->json(['status'=>true]);
        }
    }
}
