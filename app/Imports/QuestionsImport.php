<?php

namespace App\Models\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\UploadedFile;
use App\Models\Subject;
use App\Models\Classes;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class QuestionsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Question([
        'exam_id'=> $row['exam_id'],
        'select_id'=> $row['select_id'],
        'teacher_id'=> $row['teacher_id'],
        'subject_id'=> $row['subject_id'],
        'question'=> $row['question'],
        'status'=> $row['status'],
        'image'=> $row['image'],
        'score'=> $row['score'],
        'grade_id'=> $row['grade_id'],
        ]);
    }
}
