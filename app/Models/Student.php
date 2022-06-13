<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Models\Classes;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard='students';
    protected $fillable = [
        'name',
        'student_code',
        'password',
        'mobile',
        'image',
        'status',
        'year_admission',
        'class_id',
        'grade_id',
        'year',
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
    public static function student(){
        $students=Student::where('status',1)->get()->toArray();
        return $students;
    }
    public static function teacher_student(){
        $students=Student::whereIn('class_id', explode(",", Auth::guard('admin')->user()->class_id))->where('status',1)->get()->toArray();
        return $students;
    }
    public function class(){
        return $this->belongsTo('App\Models\Classes', 'class_id', 'id')->where('status',1);
    }
    public static function getStudent(){
        if(Auth::guard('admin')->user()->role==-1){
        $records=DB::table('students')->join('classes', 'classes.id','=', 'students.class_id')->join('grades', 'grades.id', '=', 'students.grade_id')->select(
            'student_code', 'students.name as studentname', 'mobile', 'classes.name as classname', 'grades.grade', 'birth_day', 'address', 'sex'
            , 'year_admission', DB::raw("(CASE WHEN sex=1 THEN 'M' ELSE 'F' END) as sex")
        )->whereIn('classes.id', explode(",", Auth::guard('admin')->user()->class_id))->get()->toArray();
        }else{
            $records=DB::table('students')->join('classes', 'classes.id','=', 'students.class_id')->join('grades', 'grades.id', '=', 'students.grade_id')->select(
                'student_code', 'students.name as studentname', 'mobile', 'classes.name as classname', 'grades.grade', 'birth_day', 'address', 'sex'
                , 'year_admission', DB::raw("(CASE WHEN sex=1 THEN 'M' ELSE 'F' END) as sex")
            )->get()->toArray();
        }
        // dd($records);
        return $records;
    }
    public function result(){
        return $this->hasMany('App\Models\Result','student_id', 'id');
    }
}
