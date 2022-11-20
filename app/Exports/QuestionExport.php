<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Session;
class QuestionExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return [
            'Question',
            'Answer',
            'Correct Answer',
            'Score'
        ];
    }
    public function collection()
    {
        // return Question::all();
        return collect(Question::getQuestions(Session::get('subject_id'), Session::get('grade_id'), Session::get('unit_id')));
    }
}
