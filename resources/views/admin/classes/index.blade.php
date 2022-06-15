@extends('layouts.admin.admin_dashboard')
@section('content')
<?php
use App\Models\Student;
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
                                <h3 class="card-title">Classes</h3>
                                <div style="float:right">
                                    <a role="button" class="btn btn-success delete-all"
                                        href="{{ url('admin/delete-all/classes') }}" record="classes">Delete All</a>
                                    <a role="button" href="{{ url('admin/add-class') }}" data-toggle="modal"
                                        data-target="#exampleModal" class="btn btn-success">Add
                                        Class</a>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">New Class</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{ url('/admin/add-class') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Class Name:</label>
                                                    <input type="text" class="form-control" name="name" required
                                                        placeholder="Enter Class Name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Grade:</label>
                                                    <select class="form-control" name="grade_id" required>
                                                        @foreach ($grades as $grade)
                                                            <option value="{{ $grade['id'] }}">{{ $grade['grade'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Teacher</label>
                                                    <select class="form-control teacher" name="teacher_id[]" multiple required>
                                                        @foreach ($teachers as $teacher)
                                                            <option value="{{ $teacher['id'] }}">{{ $teacher['name'] }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div> --}}

                                                {{-- <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Number of
                                                        Students:</label>
                                                    <input class="form-control" type="number" name='number_of_students'
                                                        required>
                                                </div> --}}
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Status:</label>
                                                    <input type="radio" name="status" value="1" checked>Active
                                                    <input type="radio" name="status" value="0">Inactive
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="classes" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Class Name</th>
                                            <th>Grade</th>

                                            <th>Number of Students</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}

                                        @foreach ($classes as $i => $class)

                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{ $class['id'] }}></th>
                                                <td>{{ $class['id'] }}</td>
                                                <td>
                                                    {{ $class['name'] }}
                                                </td>
                                                <td>
                                                    @foreach ($grades as $grade)
                                                        @if ($grade['id'] == $class['grade_id'])
                                                            {{$grade['grade']}}
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td>{{count(Student::where('class_id', $class['id'])->where('status',1)->get())}}</td>
                                                <td>
                                                    @if ($class['status'] == 1)
                                                        <a class="status-class" href="javascript:void(0)" style="color:green" data-id="{{$class['id']}}" id="class-{{ $class['id'] }}">Active</a>
                                                    @else
                                                        <a class="status-class" href="javascript:void(0)" style="color:red" data-id="{{$class['id']}}" id="class-{{ $class['id'] }}">Inactive</a>
                                                    @endif
                                                </td>
                                                <td>

                                                    <div class="modal fade" id="exampleModal{{ $class['id'] }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Exam
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post"
                                                                        action="{{ url('/admin/edit-class', $class['id']) }}">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Class Name:</label>
                                                                            <input type="text" class="form-control"
                                                                                name="name" required
                                                                                placeholder="Enter Class Name"
                                                                                value="{{ $class['name'] }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Grade:</label>
                                                                            <select class="form-control" name="grade_id"
                                                                                required>
                                                                                @foreach ($grades as $grade)
                                                                                    @if ($class['grade_id'] == $grade['id'])
                                                                                        <option value="{{ $grade['id'] }}"
                                                                                            checked>{{ $grade['grade'] }}
                                                                                        </option>
                                                                                    @else
                                                                                        <option
                                                                                            value="{{ $grade['id'] }}">
                                                                                            {{ $grade['grade'] }}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        {{-- <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Number of
                                                                                Students:</label>
                                                                            <input type="number" class="form-control"
                                                                                name="number_of_students" required
                                                                                placeholder="Enter Number of Students"
                                                                                value="{{ $class['number_of_students'] }}">
                                                                        </div> --}}
                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Status:</label>
                                                                            @if ($class['status'] == 1)
                                                                                <input type="radio" name="status" value="1"
                                                                                    checked>Active
                                                                                <input type="radio" name="status"
                                                                                    value="0">Inactive
                                                                            @else
                                                                                <input type="radio" name="status"
                                                                                    value="1">Active
                                                                                <input type="radio" name="status" value="0"
                                                                                    checked>Inactive
                                                                            @endif
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Edit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- <a title="Index Question Exam"
                                                        href="{{ url('/admin/index-question/exam', $class['id']) }}"><i
                                                            class="fas fa-plus-circle"></i></a>
                                                    &nbsp;
                                                    &nbsp; --}}
                                                    <a title="Edit Class" style="font-size:20px" role="button" type="submit"
                                                        data-toggle="modal"
                                                        data-target="#exampleModal{{ $class['id'] }}"><i
                                                            class="fas fa-edit" style="color: green"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a title="Delete Class" style="font-size:20px" href="javascript:void(0)"
                                                        record='class' recordid={{ $class['id'] }}
                                                        class="confirmdelete"><i class="fa fa-trash-alt"
                                                            style="color: red"></i></a>
                                                </td>
                                            </tr>

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
