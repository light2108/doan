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
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }
    public function answer(){
        return $this->hasMany('App\Models\Answer', 'question_id', 'id');
    }
    public static function getQuestions($subject_id, $grade_id, $unit_id){
        // return Excel::download(new TeacherExport, 'questions.xlsx');
        $records=DB::table('questions')->join('answer', 'questions.id', '=', 'answer.question_id')->join('subjects', 'questions.subject_id', '=', 'subjects.id')->join('grades', 'questions.grade_id', '=', 'grades.id')->join('units', 'questions.unit_id', '=', 'units.id')->select(
            'questions.question','answer.answer as answer', 'answer.correct_answer as correct_answer', 'units.name as unit','grades.grade as grade','subjects.name as subject'
        )->where('questions.subject_id', $subject_id)->where('questions.grade_id', $grade_id)->where('questions.unit_id', $unit_id)->get()->toArray();
        // dd($records);
        return $records;
    }
}
