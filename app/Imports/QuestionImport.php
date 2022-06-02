<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;
use App\Models\Unit;
class QuestionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $grade_id=Grade::where('name', $row['grade'])->first()->id;
        $unit_id=Unit::where('name', $row['unit'])->where('grade_id', $grade_id)->first()->id;
        return new Question([
            'question'=>$row['question'],
            'grade_id'=>$grade_id,
            'unit_id'=>$unit_id,
            'subject_id'=>Auth::guard('admin')->user()->subject_id,
            'teacher_id'=>Auth::guard('admin')->user()->id,
        ]);
    }
}
