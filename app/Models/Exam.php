<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $table='exams';
    protected $fillable=[
        'name',
        'subject_id',
        'grade_id',
        'teacher_id',
        'class_id',
        'start_time',
        'end_time',
        'status',
        'password',
        'video',
        'time',
        'multiple'
    ];
    public function question(){
        return $this->hasMany('App\Models\Question', 'exam_id', 'id')->where('status',1);
    }
    public function teacher(){
        return $this->belongsTo('App\Models\Admin', 'teacher_id', 'id')->where('status',1);
    }
    public function subject(){
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id')->where('status',1);
    }
}
