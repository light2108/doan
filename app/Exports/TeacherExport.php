<?php

namespace App\Exports;

use App\Models\Admin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class TeacherExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return [
            'ID',
            'Name',
            'Email',
            'Mobile',
            'Subject',
            'Class',
            'Birth Day',
            'Address',
            'Sex'
        ];
    }
    public function collection()
    {
        // return Admin::all();
        return collect(Admin::getTeacher());
    }
}
// id name   email
// 1   long  long@com