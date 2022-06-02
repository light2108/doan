<?php

namespace App\Imports;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\UploadedFile;
use App\Models\Subject;
use App\Models\Classes;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
function normalize($string)
{
    $string = preg_replace('!\s+!', ' ', $string);;
    $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
    // $string=preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);
    return $string;
}
class TeacherImport implements ToModel, WithHeadingRow
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
        $file = public_path('/imgs/'.time() . '.'.$info['basename']);
        file_put_contents($file, $contents);
        $uploaded_file = new UploadedFile($file, time() . '.'.$info['basename']);
        $image='imgs/' . time() . '.' . $info['basename'];
        $subject_id=Subject::where('name', $row['subject'])->first()->id;
        $class_id=Classes::whereIn('name', explode(",",$row['class']))->first()->id;
        return new Admin([
            'name'=>normalize($row['name']),
            'email'=>$row['email'],
            'mobile'=>$row['mobile'],
            'password'=>Hash::make(1),
            'image'=>$image,
            'subject_id'=>$subject_id,
            'class_id'=>$class_id,
            'birth_day'=>date('Y-m-d', strtotime(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birth_day'])))),
            'address'=>$row['address'],
            'sex'=>(($row['sex']=='M'?'1':'0')),
        ]);
    }
}
