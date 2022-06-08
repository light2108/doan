<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionsExport implements FromCollection,WithHeadings
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return [
            'id',
            'exam',            
            'teacher',
            'subject',
            'question',         
            'image',
        ];
     
    }
    public function collection()
    {
        //return Question::all();
        return collect(Question::getQuestion());
    }
}
