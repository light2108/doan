<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use Illuminate\Support\Facades\Session;

class GradeController extends Controller
{
    public function Index()
    {
        Session::put('page', 'grade');
        $grades = Grade::get()->toArray();
        return View('admin.grades.index', compact('grades'));
    }
    public function AddGrade(Request $request)
    {
        $data = $request->all();
        Grade::create($data);
        return redirect()->back()->with('success_message', 'Created Grade Successfully');
    }
    public function EditGrade(Request $request, $id)
    {
        Grade::find($id)->update($request->all());
        return redirect()->back()->with('success_message', 'Updated Grade Successfully');
    }
    public function DeleteGrade(Request $request, $id)
    {
        Grade::find($id)->delete();
        return redirect()->back()->with('success_message', 'Deleted Grade Successfully');
    }
    public function DeleteAll(Request $request)
    {

        // dd($data);
        if ($request->ajax()) {
            $data = $request->all();
            // dd($data);
            // print_r($data);
            Grade::whereIn('id', explode(",", $data['ids']))->delete();
            return response()->json(['status' => true]);

        }
        return redirect()->back()->with('success_message', 'Deleted Grades Successfully');
    }
    public function StatusGrade(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                Grade::find($data['id'])->update(['status' => 0]);
                return response()->json(['status' => "Active"]);
            } else {
                Grade::find($data['id'])->update(['status' => 1]);
                return response()->json(['status' => "Inactive"]);
            }
            // return response()->json(['status'=>true]);
        }
    }
}
