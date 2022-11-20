<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard = 'admin';
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'image',
        'role',
        'status',
        'subject_id',
        'class_id',
        'birth_day',
        'address',
        'sex'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id')->where('status',1);
    }
    public function exam()
    {
        return $this->hasMany('App\Models\Exam', 'teacher_id', 'id')->where('status',1);
    }
    public static function teacher()
    {
        $teachers = Admin::where('role','!=', 1)->where('status', 1)->get()->toArray();
        return $teachers;
    }
    public static function teacher_teacher(){
        $teachers = Admin::where('role','!=', 1)->where('subject_id', Auth::guard('admin')->user()->subject_id)->get()->toArray();
        return $teachers;
    }
    public static function getTeacher()
    {
        if(Auth::guard('admin')->user()->role==-1){
        $records = DB::table('admins')->join('subjects', 'subjects.id', '=', 'admins.subject_id')->join('classes', function ($query) {
            $query->whereRaw(DB::raw("find_in_set(classes.id, admins.class_id)", DB::raw(''), DB::raw('')));
        })->select(
            'admins.id',
            'admins.name as teachername',
            'email',
            'mobile',
            'subjects.name as subjectname',
            'classes.name as classname',
            'birth_day',
            'address',
            DB::raw("(CASE WHEN sex=1 THEN 'M' ELSE 'F' END) as sex")
        )->where('subjects.id', Auth::guard('admin')->user()->subject_id)->get()->toArray();
        }else{
            $records = DB::table('admins')->join('subjects', 'subjects.id', '=', 'admins.subject_id')->join('classes', function ($query) {
                $query->whereRaw(DB::raw("find_in_set(classes.id, admins.class_id)", DB::raw(''), DB::raw('')));
            })->select(
                'admins.id',
                'admins.name as teachername',
                'email',
                'mobile',
                'subjects.name as subjectname',
                'classes.name as classname',
                'birth_day',
                'address',
                DB::raw("(CASE WHEN sex=1 THEN 'M' ELSE 'F' END) as sex")
            )->get()->toArray();
        }
        // dd($records);
        return $records;
    }
}
