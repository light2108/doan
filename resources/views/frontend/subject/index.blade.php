
@extends('layouts.frontend.dashboard')
@section('content')
<?php
use Carbon\Carbon;
use App\Models\Result;
?>
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Exams</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">My Exams</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <h3 class="pb-3">All Exams</h3>

                    <div class="tab-pane show active" id="mentee-list">
                        <div class="card card-table">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>TEACHER</th>
                                                <th>NAME</th>
                                                <th>TIME</th>
                                                <th>START DATE</th>
                                                <th>END DATE</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subject_exams as $subject_exam)
                                                @if (in_array(Auth::guard('student')->user()->class_id, explode(',', $subject_exam['class_id'])))
                                                    <tr>
                                                        <td>
                                                            <h2 class="table-avatar">
                                                                <a href="profile" class="avatar avatar-sm me-2"><img
                                                                        class="avatar-img rounded-circle"
                                                                        src="{{ $subject_exam['teacher']['image'] }}"
                                                                        alt="User Image"></a>
                                                                <a href="profile">{{ $subject_exam['teacher']['name'] }}<span><span
                                                                            class="__cf_email__"></span>{{ $subject_exam['teacher']['email'] }}</span></a>
                                                            </h2>
                                                        </td>
                                                        <td>{{ $subject_exam['name'] }}</td>
                                                        <td>{{$subject_exam['time']}}</td>
                                                        <td><span class="pending">{{ $subject_exam['start_time'] }}</span>
                                                        </td>
                                                        <td><span class="pending">{{ $subject_exam['end_time'] }}</span>
                                                        </td>
                                                        <td>
                                                            @if (!empty($subject_exam['password']))
                                                                <a href="javascript:void(0)"
                                                                    data-exam={{ $subject_exam['id'] }}
                                                                    data-subject={{ $subject_exam['subject_id'] }}
                                                                    data-grade={{ $subject_exam['grade_id'] }}
                                                                    class="btn btn-sm bg-info-light visit-exam-password"><i
                                                                        class="far fa-eye"></i>
                                                                    Enter Exam</a>

                                                            @else
                                                            <a @if(date('Y-m-d H:i:s', strtotime($subject_exam['end_time']))<date('Y-m-d H:i:s', strtotime(Carbon::now()))) href="{{url('/result/exam/'.$subject_exam['id'].'/subject/'.$subject_exam['subject_id'])}}" @endif
                                                                @if(!empty(Result::where('exam_id', $subject_exam['id'])->where('student_id', Auth::guard('student')->user()->id)->first()->score))
                                                                    @if($subject_exam['multiple']!=0&&$subject_exam['multiple']<count(explode(",",Result::where('exam_id', $subject_exam['id'])->where('student_id', Auth::guard('student')->user()->id)->first()->score))) href="{{url('/result/exam/'.$subject_exam['id'].'/subject/'.$subject_exam['subject_id'])}}"
                                                                    @else href="{{ url('/exam/' . $subject_exam['id'] . '/subject/' . $subject_exam['subject_id'] . '/grade/' . $subject_exam['grade_id']) }}" @endif

                                                             @else href="{{ url('/exam/' . $subject_exam['id'] . '/subject/' . $subject_exam['subject_id'] . '/grade/' . $subject_exam['grade_id']) }}"
                                                            @endif data-exam={{ $subject_exam['id'] }}
                                                                data-subject={{ $subject_exam['subject_id'] }}
                                                                data-grade={{ $subject_exam['grade_id'] }}
                                                                class="btn btn-sm bg-info-light visit-exam"><i class="far fa-eye"></i>
                                                                Enter Exam</a>
                                                            @endif
                                                        </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
