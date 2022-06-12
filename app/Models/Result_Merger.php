<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result_Merger extends Model
{
    use HasFactory;
    protected $table='result_merger';
    protected $fillable=[
        'exam_id',
        'student_id',
        'subject_id',
        'class_id',
        'score'
    ];
}
