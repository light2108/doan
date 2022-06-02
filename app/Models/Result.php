<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class Result extends Model
{
    use HasFactory;
    protected $table='results';
    protected $fillable=[
        'exam_id',
        'student_id',
        'class_id',
        'subject_id',
        'score',
        'time'
    ];
    public static function checkdate(){
        $exams=Exam::where('teacher_id', Auth::guard('admin')->user()->id)->get()->toArray();
        $count=0;
        foreach($exams as $exam){
            if(date('Y-m-d H:i:s', strtotime($exam['end_time']))<date('Y-m-d H:i:s', strtotime(Carbon::now()))) $count++;
        }
        return $count;
    }
    public static function getResult($exam_id, $class_id){
        /*'Student Code',
            'Student Name',
            'Class',
            'Exam Name',
            'Score'
         */
        $records=DB::table('results')->join('students', 'results.student_id', '=', 'students.id')->join('exams', 'exams.id', '=','results.exam_id')->join('classes', 'classes.id', '=', 'results.class_id')->select(
            'students.student_code as StudentCode', 'students.name as StudentName', 'classes.name as ClassName', 'exams.name as ExamName', 'results.score as Score'
          )->where('results.exam_id', $exam_id)->where('results.class_id', $class_id)->get()->toArray();
        return $records;
    }
}
/*

*/
