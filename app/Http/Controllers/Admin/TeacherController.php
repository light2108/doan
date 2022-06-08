<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TeacherImport;
use App\Exports\TeacherExport;
use Illuminate\Support\Facades\DB;
function normalize($string){
    $string=preg_replace('!\s+!', ' ', $string);
    $string=mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
    // $string=preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);
    return $string;
}
function del($string){
    $string=preg_replace('-','', $string);
    return $string;

}
class TeacherController extends Controller
{
    public function Index()
    {
        // Session::put('subject_id', Auth::guard('admin')->user()->id);
        // dd(Auth::guard('admin')->user()->subject_id);

        // dd($xxx);
        // $records=DB::table('admins')->join('subjects', 'subjects.id', '=', 'admins.subject_id')->join('classes',function($query){
        //     $query->on(DB::raw("find_in_set(classes.id, admins.class_id)"));
        // })->select(
        //     'admins.id', 'admins.name as teachername','email', 'mobile','subjects.name as subjectname', 'classes.name as classname', 'birth_day','address',
        //     DB::raw("(CASE WHEN sex=1 THEN 'M' ELSE 'F' END) as sex")
        // )->where('admins.role','!=', 1);
        // $records=DB::table('admins')->join('subjects', 'subjects.id', '=', 'admins.subject_id')->join('classes',function($query){
        //     $query->whereRaw(DB::raw("find_in_set(classes.id, admins.class_id)", DB::raw(''), DB::raw('')));
        // })->select(
        //     'admins.id', 'admins.name as teachername','email', 'mobile','subjects.name as subjectname', 'classes.name as classname', 'birth_day','address',
        //     DB::raw("(CASE WHEN sex=1 THEN 'M' ELSE 'F' END) as sex")
        // )->get()->toArray();

        // dd($records);
        Session::put('page', 'teacher');
        if(Auth::guard('admin')->user()->role==1){
            $teachers = Admin::where('role', 0)->orWhere('role', -1)->get()->toArray();
        }else{
            $teachers = Admin::where('subject_id', Auth::guard('admin')->user()->subject_id)->where('role', 0)->orWhere('role', -1)->get()->toArray();
        }
        $classes = Classes::where('status', 1)->get()->toArray();
        $subjects = Subject::where('status', 1)->get()->toArray();
        $class_id = [];
        foreach ($teachers as $key => $teacher) {
            $class_id[$key] = explode(",", $teacher['class_id']);
        }
        // dd($class_id);
        return View('admin.teachers.index', compact('teachers', 'classes', 'class_id', 'subjects'));
    }
    public function addTeacher(Request $request)
    {
        $subjects = Subject::where('status', 1)->get()->toArray();
        $classes = Classes::where('status', 1)->get()->toArray();
        // $grades=Grade::get()->toArray();
        // dd($grades);
        if ($request->isMethod('post')) {
            $data = $request->all();
            $data['name']=normalize($data['name']);
            $data['password'] = Hash::make($data['password']);
            $data['class_id'] = implode(',', $data['class_id']);
            $curyear=date('Y');        
            $year=(int)($data['birth_day']);
           // $year=del($year);
           //$year=date('Y',$year1);
         //  $year=(int)$year;
           $temp=($curyear-$year);

            if($temp<22){
               // return Redirect::back()->withErrors(['msg' => ' teacher must be over 22 years old']);
               return redirect()->back()->with('success', 'teacher  must be over 20 year old');
                
            }
            // explode(",", $data['class_id']);
            // $data['grade_id']=implode(',', $data['grade_id']);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $reimage = 'imgs/' . time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgs');
                $image->move($dest, $reimage);
                $data['image'] = $reimage;
                Admin::create($data);
                return redirect('/admin/teachers')->with('success_message', 'add teacher success');
            }else{
                Admin::create($data);
                return redirect('/admin/teachers')->with('success_message', 'add teacher success');
            }
        }
        return View('admin.teachers.add', compact('subjects', 'classes'));
    }
    public function editTeacher(Request $request, $id)
    {
        $teacher = Admin::find($id);
        // dd($teacher);
        $subjects = Subject::where('status', 1)->get()->toArray();
        $classes = Classes::where('status', 1)->get()->toArray();
        // $grades=Grade::get()->toArray();
        $class_id = explode(",", $teacher['class_id']);
        // dd($class_id);
        if ($request->isMethod('post')) {
            $data = $request->all();
            $data['name']=normalize($data['name']);
            $data['password'] = $teacher['password'];
            $data['class_id'] = implode(',', $data['class_id']);
            // $data['grade_id']=implode(',', $data['grade_id']);


            $curyear=date('Y');        
            $year=(int)($data['birth_day']);//=date('Y', strtotime($data['birth_day']));
            $temp=($curyear-$year);
            if($temp<22){
               // return Redirect::back()->withErrors(['msg' => ' teacher must be over 22 years old']);
               return redirect()->back()->with('success', 'teacher  must be over 20 year old');
                
            }


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $reimage = 'imgs/' . time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgs');
                $image->move($dest, $reimage);
                $data['image'] = $reimage;
                $teacher->update($data);
                return redirect('/admin/teachers')->with('success_message', 'Updated Teacher Successfully');
            } else {
                $teacher->update($data);
                return redirect('/admin/teachers')->with('success_message', 'Updated Teacher Successfully');
            }
        }
        return View('admin.teachers.edit', compact('subjects', 'teacher', 'classes', 'class_id'));
    }
    public function DeleteAll(Request $request)
    {
        $data = $request->all();

        if ($request->ajax()) {

            Admin::whereIn('id', explode(",", $data['ids']))->delete();
            return response()->json(['status' => true]);
        }
        return redirect()->back()->with('success_message', 'Deleted Teachers Successfully');

    }
    public function deleteTeacher(Request $request, $id)
    {
        // if ($request->ajax()) {
        Admin::find($id)->delete();
        return redirect()->back()->with('success_message', 'Deleted Teacher Successfully');
        // }
    }
    public function StatusTeacher(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                Admin::find($data['id'])->update(['status' => 0]);
                return response()->json(['status' => "Active"]);
            } else {
                Admin::find($data['id'])->update(['status' => 1]);
                return response()->json(['status' => "Inactive"]);
            }
            // return response()->json(['status'=>true]);
        }
    }
    public function ImportFileTeacher(Request $request){
        if($request->isMethod('post')){
            // $request->validate(
            //     [
            //         'file'=>'required|mimes:xls, xlsx',
            //     ]
            // );

            Excel::import(new TeacherImport,request()->file('file'));
            return redirect('/admin/teachers')->with('success_message', 'Created Teachers Successfully');
        }
        return View('admin.teachers.add_file_teacher');
    }
    public function ExportFileTeacher(Request $request){
        return Excel::download(new TeacherExport, 'teachers.xlsx');
    }
}
