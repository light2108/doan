<?php

namespace App\Exports;

use App\Models\Result;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Session;
class ResultExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return [
            'Student Code',
            'Student Name',
            'Class',
            'Exam Name',
            'Score'
        ];
    }
    public function collection()
    {
        // return Result::all();
        return collect(Result::getResult(Session::get('exam_id'), Session::get('class_id')));
    }
}
