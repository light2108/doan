<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class Result extends Model
{
    use HasFactory;
    protected $table='results';
    protected $fillable=[
        'exam_id',
        'student_id',
        'class_id',
        'subject_id',
        'score'
    ];
    public static function checkdate(){
        $exams=Exam::where('teacher_id', Auth::guard('admin')->user()->id)->get()->toArray();
        $count=0;
        foreach($exams as $exam){
            if(date('Y-m-d H:i:s', strtotime($exam['end_time']))<date('Y-m-d H:i:s', strtotime(Carbon::now()))) $count++;
        }
        return $count;
    }
}
