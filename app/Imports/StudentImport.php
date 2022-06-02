<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use App\Models\Classes;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
function normalize($string)
{
    $string = preg_replace('!\s+!', ' ', $string);;
    $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
    // $string=preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);
    return $string;
}
class StudentImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {

        $info = pathinfo($row['image']);
        $contents = file_get_contents($row['image']);
        $file = public_path('/imgstudent/'.time() . '.'.$info['basename']);
        file_put_contents($file, $contents);
        $uploaded_file = new UploadedFile($file, time() . '.'.$info['basename']);
        $image='imgstudent/' . time() . '.' . $info['basename'];
        $grade_id = Classes::where('name', '=', $row['class'])->first()->grade_id;
        $class_id = Classes::where('name', '=', $row['class'])->first()->id;
        return new Student([
            'name' => normalize($row['name']),
            'password' => Hash::make(1),
            'mobile' => $row['mobile'],
            'grade_id' => $grade_id,
            'student_code' => (date('Y', strtotime(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['year_admission'])))) . str_pad(Student::where('year', date('Y', strtotime(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['year_admission'])))))->count() + 1, 3, '0', STR_PAD_LEFT)),
            'image' => $image,
            'class_id' => $class_id,
            'year_admission' => date('Y-m-d', strtotime(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['year_admission'])))),
            'year' => date('Y', strtotime(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['year_admission'])))),
            'birth_day'=>date('Y-m-d', strtotime(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birth_day'])))),
            'address'=>$row['address'],
            'sex'=>(($row['sex']=='M')?"1":"0")
        ]);
    }
}
