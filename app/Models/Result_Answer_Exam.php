<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result_Answer_Exam extends Model
{
    use HasFactory;
    protected $table='result_answer_exam';
    protected $fillable=[
        'result_id',
        'student_id',
        'score_answer'
    ];
}
