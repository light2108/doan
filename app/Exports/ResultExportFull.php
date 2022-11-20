<?php

namespace App\Exports;

use App\Models\Result;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResultExportFull implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        $arr=array();
        array_push($arr,'Student Code',
        'Student Name',
        'Class',
        'Exam Name',
        'Score');
        for($i=1; $i<=Session::get('count_questions'); ++$i){
            array_push($arr,'Question '.$i);
        }

        return $arr;
    }
    public function collection()
    {
        // return Result::all();
        return collect(Result::getResultFull(Session::get('exam_id'), Session::get('class_id')));
    }
}
