<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Support\Facades\Session;

class SubjectController extends Controller
{
    public function Index(){
        Session::put('page', 'subject');
        $subjects=Subject::get()->toArray();
        $grades = Grade::where('status', 1)->get()->toArray();
        return View('admin.subjects.index', compact('subjects', 'grades'));
    }
    public function Add(Request $request){
        $data=$request->all();
        $data['grade_id']=implode(",", $data['grade_id']);
        Subject::create($data);
        return redirect()->back()->with('success_message', 'Created Subject Successfully');
    }
    public function Edit(Request $request, $id){
        $data=$request->all();
        $data['grade_id']=implode(",", $data['grade_id']);
        Subject::find($id)->update($data);
        return redirect()->back()->with('success_message', 'Updated Subject Successfully');
    }
    public function DeleteAll(Request $request){
        $data = $request->all();

            if($request->ajax()){
                $data=$request->all();
                Subject::whereIn('id', explode(",", $data['ids']))->delete();
                return response()->json(['status'=>true]);
            }
            return redirect()->back()->with('success_message', 'Deleted Subject Successfully');

    }
    public function StatusSubject(Request $request){
        if($request->ajax()){
            $data=$request->all();
            if($data['status']=="Active"){
                Subject::find($data['id'])->update(['status'=>0]);
                return response()->json(['status'=>"Active"]);
            }else{
                Subject::find($data['id'])->update(['status'=>1]);
                return response()->json(['status'=>"Inactive"]);
            }
            // return response()->json(['status'=>true]);
        }
    }
    public function Delete($id){
        Subject::find($id)->delete();
        return redirect()->back()->with('success_message', 'Deleted Subject Successfully');
    }
}
