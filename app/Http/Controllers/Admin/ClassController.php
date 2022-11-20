<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Classes;
use App\Models\Grade;
use Illuminate\Support\Facades\Session;

class ClassController extends Controller
{
    public function Index()
    {
        Session::put('page', 'class');
        $grades = Grade::where('status', 1)->get()->toArray();
        $teachers = Admin::where('role', 0)->orWhere('role', -1)->where('status', 1)->get()->toArray();
        $classes = Classes::get()->toArray();

        // dd($classes);
        // dd($teachers);

        // dd($items);
        return View('admin.classes.index', compact('teachers', 'grades', 'classes'));
    }
    public function AddClass(Request $request)
    {
        $data = $request->all();
        // $data['teacher_id']=implode(",", $data['teacher_id']);
        Classes::create($data);
        return redirect()->back()->with('success_message', 'Created Class Successfully');
    }
    public function EditClass(Request $request, $id)
    {
        $data = $request->all();
        // $data['teacher_id']=implode(",", $data['teacher_id']);
        Classes::find($id)->update($data);
        return redirect()->back()->with('success_message', 'Updated Class Successfully');
    }
    public function DeleteClass(Request $request, $id)
    {
        // if ($request->ajax()) {
        Classes::find($id)->delete();
        return redirect()->back()->with('success_message', 'Deleted Class Successfully');
        // }
    }
    public function DeleteAll(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            Classes::whereIn('id', explode(",", $data['ids']))->delete();
            return response()->json(['status' => true]);
        }
        return redirect()->back()->with('success_message', 'Deleted Classes Successfully');
    }
    public function StatusClass(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                Classes::find($data['id'])->update(['status' => 0]);
                return response()->json(['status' => "Active"]);
            } else {
                Classes::find($data['id'])->update(['status' => 1]);
                return response()->json(['status' => "Inactive"]);
            }
            // return response()->json(['status'=>true]);
        }
    }

}
