<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Question extends Model
{
    use HasFactory;
    protected $table='questions';
    protected $fillable=[
        'exam_id',
        'select_id',
        'teacher_id',
        'subject_id',
        'question',
        'status',
        'image',
        'score',
        'grade_id',
        'file_listen',
        'unit_id'
    ];
    public function subject(){
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id')->where('status',1);
    }
    public function answer(){
        return $this->hasMany('App\Models\Answer', 'question_id', 'id')->where('status',1);
    }
    public static function getQuestions($subject_id, $grade_id, $unit_id){
        // return Excel::download(new TeacherExport, 'questions.xlsx');
        $records=Question::with('answer')->where('subject_id', $subject_id)->where('grade_id', $grade_id)->where('unit_id', $unit_id)->get()->toArray();

        $data=array();
        foreach($records as $i=>$record){
            $arr=array();
            array_push($arr, $record['question']);
            foreach($record['answer'] as $key=>$answer){
                $xxx=array();
                if($key==0){
                    array_push($arr, $answer['answer'], number_format((float)$answer['correct_answer'], 0, '', ''), isset($record['score'])?number_format((float)$record['score'], 2, '.', ''):number_format((float)0, 2, '.', ''));
                    array_push($data, $arr);
                }else{
                    array_push($xxx,"", $answer['answer'], number_format((float)$answer['correct_answer'], 0, '', ''));
                    array_push($data, $xxx);

                }
            }
        }
        return $data;
    }
}
