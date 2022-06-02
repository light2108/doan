<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;

function removeptag($string)
{
    $string = str_replace("<p>", "", $string);
    $string = str_replace("</p>", "", $string);
    // $string=preg_replace("<>","",$string);
    // $string=preg_replace("</>","",$string);
    return $string;
}
class QuestionExamController extends Controller
{
    public function Index(Request $request, $grade_id, $id)
    {
        // Session::put('exam_id', $id);
        // dd(removeptag('<p>long</p>'));
        $questions = Question::where('status', 1)->get()->toArray();
        // dd($questions);
        $units = Unit::where('grade_id', $grade_id)->where('subject_id', Auth::guard('admin')->user()->subject_id)->where('status', 1)->get()->toArray();
        // dd($questions);
        return View('admin.questionexam.index_question', compact('questions', 'units', 'grade_id', 'id'));
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
    public function DeleteAll(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            Question::whereIn('id', explode(",", $data['ids']))->delete();
            return response()->json(['status' => true]);
        }
        return redirect()->back()->with('success_message', 'Deleted Questions Exam Successfully');
    }

    public function addQuestion(Request $request, $grade_id, $id)
    {
        // dd(Question::orderBy('id', 'desc')->first()->id)
        // Session::put('count', $request->count);
        // dd(Exam::find($id)->with('question')->get()->toArray());
        if ($request->isMethod('POST')) {
            $data = $request->all();
            // dd($data);
            $data['question'] = removeptag($data['question']);
            $data['grade_id'] = $grade_id;
            $data['exam_id'] = $id;
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
            return redirect('/admin/questions/grade/' . $grade_id . '/exam/' . $id)->with('success_message', 'Created question successfully');
        }

        return View('admin.questionexam.add_question', compact('id', 'grade_id'));
    }
    public function editQuestion(Request $request, $question_id, $grade_id, $id)
    {
        $question = Question::with('answer')->where('id', $question_id)->first()->toArray();
        $old_question = Question::find($question_id);

        if ($request->isMethod('POST')) {
            $data = $request->all();
            // dd($data);
            $data['question'] = removeptag($data['question']);
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
                $old_question->update($data);
            } else {
                $old_question->update($data);
            }
            Answer::where('question_id', $question_id)->delete();
            foreach ($data['answer'] as $key => $answer) {
                Answer::create(['question_id' => $question['id'], 'answer' => removeptag($data['answer'][$key]), 'correct_answer' => $data['correct_answer'][$key]]);
            }
            return redirect('/admin/questions/grade/' . $grade_id . '/exam/' . $id)->with('success_message', 'Updated question successfully');
        }
        return View('admin.questionexam.edit_question', compact('question', 'question_id', 'id', 'grade_id'));
    }
    public function updateQuestion(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $question = Question::find($data['recordid']);
            $stack = array();
            foreach (explode(",", $question['select_id']) as $select_id) {
                if ($select_id != $data['examid']) array_push($stack, $select_id);
            }

            Question::find($data['recordid'])->update(['exam_id' => 0, 'select_id' => join(",", $stack)]);

            return response()->json(['status' => true]);
        }
    }
    public function randomQuestion(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach ($data['unit_id'] as $key => $unit_id) {
                if (!empty($data['number'][$key])) {
                    if ($data['number'][$key] > count(Question::where('unit_id', $unit_id)->get())) {
                        return redirect()->back()->with('error_message', 'Number questions in stock not enough');
                    } else {
                        $questions = Question::where('unit_id', $data['unit_id'][$key])->inRandomOrder()->limit($data['number'][$key])->get();
                        foreach ($questions as $question) {
                            $question->update(['select_id' => ($question['select_id'] . ',' . $data['exam_id'])]);
                        }
                    }
                }
            }
            return redirect()->back()->with('success_message', 'Added Questions Successfully');
        }
    }
}
