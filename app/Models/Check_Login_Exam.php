<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check_Login_Exam extends Model
{
    use HasFactory;
    protected $table='check_login_exam';
    protected $fillable=[
        'exam_id',
        'student_id',
        'status'
    ];
    public static function Check_Login_Exam($exam_id, $student_id){

        $status=Check_Login_Exam::where('exam_id', $exam_id)->where('student_id', $student_id)->first();
        if(!empty($status)){
            $status->update(['status'=>1]);
        }
    }
}
