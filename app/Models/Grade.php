<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $table='grades';
    protected $fillable=[
        'grade',
        'status'
    ];
    public function class(){
        return $this->hasMany('App\Models\Classes', 'grade_id', 'id')->where('status',1);
    }
    public static function grade(){
        $grades=Grade::where('status',1)->get()->toArray();
        return $grades;
    }
}
