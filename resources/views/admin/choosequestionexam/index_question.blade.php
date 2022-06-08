@extends('layouts.admin.admin_dashboard')
@section('content')
<?php
use Illuminate\Support\Facades\Session;
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ Session::get('success_message') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif (Session::has('error_message'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{ Session::get('error_message') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">DataTables</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Questions</h3>
                                <div style="float:right">
                                    {{-- <a role="button" class="btn btn-success delete-all"
                                        href="{{ url('admin/delete-all/questions-exam') }}" record="questions-exam">Delete All</a> --}}
                                    {{-- @if (Auth::guard('admin')->user()->role == -1) --}}

                                        <a role="button" href="javascript:void(0)"
                                            class="btn btn-success submit-question" exam-id={{$exam_id}} grade-id={{$grade_id}}>Add
                                            Choose
                                            Questions</a>
                                        {{-- <a role="button"
                                            href="{{ url('/admin/add-question/subject/' . $subject_id . '/grade/' . $grade_id . '/unit/' . $unit_id) }}"
                                            class="btn btn-success">Add
                                            Question</a>

                                    @endif --}}
                                </div>
                            </div>


                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="questions" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Teacher</th>
                                            <th>Question</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th style="width:100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}
                                        @foreach ($questions as $key => $question)

                                            {{-- @if ($grade_id == $question['grade_id']) --}}
                                            <tr>
                                                <th><input type="checkbox" class="sub_ck sub_ck_question"
                                                        data-id={{ $question['id'] }}>
                                                </th>
                                                <td>{{ ++$key }}</td>
                                                <td>
                                                    @foreach ($teachers as $teacher)
                                                        @if ($teacher['id'] == $question['teacher_id'])
                                                            {{ $teacher['name'] }}
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td>{!! $question['question'] !!}</td>
                                                <td>
                                                    {{ date('Y-m-d', strtotime($question['created_at'])) }}
                                                </td>

                                                <td>
                                                    @if ($question['status'] == 1)
                                                        <a  href="javascript:void(0)" style="color:green"
                                                            data-id="{{ $question['id'] }}"
                                                            id="question-{{ $question['id'] }}">Active</a>
                                                    @else
                                                        <a  href="javascript:void(0)" style="color:red"
                                                            data-id="{{ $question['id'] }}"
                                                            id="question-{{ $question['id'] }}">Inactive</a>
                                                    @endif
                                                </td>
                                                <td style="font-size: 20px">
                                                    <a title="View Answer of Question" role="button"
                                                        href=" {{ url('/admin/edit-question/' . $question['id'] . '/subject/' . $subject_id . '/grade/' . $grade_id . '/unit/' . $unit_id.'/exam/'.$exam_id) }}"><i
                                                            class="fas fa-eye" ></i></a>

                                                </td>
                                            </tr>
                                            {{-- @endif --}}
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
