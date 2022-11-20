<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Subject extends Model
{
    use HasFactory;
    protected $table='subjects';
    protected $fillable=[
        'name',
        'grade_id',
        'status',
        // 'teacher_id'
    ];
    public function exam(){
        return $this->hasMany('App\Models\Exam', 'subject_id', 'id')->where('status',1);
    }

    public static function subject(){
        $subjects=Subject::where('status',1)->get()->toArray();
        return $subjects;
    }
    public function teacher(){
        return $this->hasMany('App\Models\Admin', 'subject_id', 'id')->where('status',1);
    }
}
