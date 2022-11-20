<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $table='classes';
    protected $fillable=[
        'name',
        'grade_id',
        'status'
    ];
    public function teacher(){
        return $this->hasMany('App\Models\Admin', 'class_id', 'id')->where('status',1);
    }
    public function exam(){
        return $this->hasMany('App\Models\Exam', 'class_id', 'id')->where('status',1);
    }
    public static function classes(){
        $classes=Classes::where('status',1)->get()->toArray();
        return $classes;
    }

}
