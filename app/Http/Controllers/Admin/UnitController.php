<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Facades\Session;
use App\Models\Subject;
class UnitController extends Controller
{
    public function UnitSubjectGrade(Request $request, $subject_id, $grade_id)
    {
        Session::put('page', $grade_id);
        $units=Unit::where('subject_id', $subject_id)->where('grade_id', $grade_id)->get()->toArray();
        $subjects = Subject::where('status', 1)->get()->toArray();
        return View('admin.questions.index_unit', compact('units','subject_id', 'grade_id', 'subjects'));
    }
    public function AddUnitSubjectGrade(Request $request, $subject_id, $grade_id){
        if($request->isMethod('post')){
            $data=$request->all();
            $data['subject_id'] = $subject_id;
            $data['grade_id'] = $grade_id;
            Unit::create($data);
            return redirect()->back()->with('success_message', 'Created Unit Successfully');
        }
    }
    public function EditUnitSubjectGrade(Request $request, $unit_id, $subject_id, $grade_id){
        if($request->isMethod('post')){
            $data=$request->all();
            Unit::find($unit_id)->update($data);
            return redirect()->back()->with('success_message', 'Updated Unit Successfully');
        }
    }
    public function DeleteUnitSubjectGrade(Request $request, $unit_id, $subject_id, $grade_id){
        Unit::find($unit_id)->delete();
        return redirect()->back()->with('success_message', 'Deleted Unit Successfully');
    }
    public function DeleteAll(Request $request)
    {

        // dd($data);
        if ($request->ajax()) {
            $data = $request->all();
            // dd($data);
            // print_r($data);
            Unit::whereIn('id', explode(",", $data['ids']))->delete();
            return response()->json(['status' => true]);

        }
        return redirect()->back()->with('success_message', 'Deleted Grades Successfully');
    }
    public function StatusUnit(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                Unit::find($data['id'])->update(['status' => 0]);
                return response()->json(['status' => "Active"]);
            } else {
                Unit::find($data['id'])->update(['status' => 1]);
                return response()->json(['status' => "Inactive"]);
            }
            // return response()->json(['status'=>true]);
        }
    }
}
