<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class StudentExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return [
            'Student Code',
            'Name',
            'Mobile',
            'Class',
            'Grade',
            'Birth Day',
            'Address',
            'Sex',
            'Year Admission'
        ];
    }
    public function collection()
    {
        // return Student::all();
        return collect(Student::getStudent());
    }
}
