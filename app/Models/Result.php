<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Result_Answer_Exam;
use App\Models\Classes;
use App\Models\Student;
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
    public static function getResultFull($exam_id, $class_id){
        /*'Student Code',
            'Student Name',
            'Class',
            'Exam Name',
            'Score'
         */
        $students=Student::where('class_id', $class_id)->where('status', 1)->get()->toArray();
        $data=array();
        $records=DB::table('results')->join('result_answer_exam', 'result_answer_exam.result_id', '=', 'results.id')->join('students', 'results.student_id', '=', 'students.id')->join('exams', 'exams.id', '=','results.exam_id')->join('classes', 'classes.id', '=', 'results.class_id')->select(
            'students.student_code as StudentCode', 'students.name as StudentName', 'classes.name as ClassName', 'exams.name as ExamName', 'results.score as Score',
          )->where('results.exam_id', $exam_id)->where('results.class_id', $class_id)->get()->toArray();
        foreach(Result::with('result_answer_exam')->where('exam_id', $exam_id)->where('class_id', $class_id)->get()->toArray() as $result_answer_exam){
            $arr=array();
            foreach($students as $student){
                if($student['id']==$result_answer_exam['student_id']){
                    array_push($arr, $student['student_code'], $student['name'], Classes::find($class_id)->name, Exam::find($exam_id)->name, $result_answer_exam['score']);
                }
            }
            foreach($result_answer_exam['result_answer_exam'] as $key=>$score_answer){
                if($score_answer['score_answer']==0){
                    array_push($arr, number_format((float)$score_answer['score_answer'], 2, '.', '').'/'.'F');
                }else{
                    array_push($arr, number_format((float)$score_answer['score_answer'], 2, '.', '').'/'.'T');
                }
            }
            array_push($data, $arr);
        }
        return $data;
    }
    public function result_answer_exam(){
        return $this->hasMany('App\Models\Result_Answer_Exam','result_id', 'id');
    }
}
/*

*/
