@extends('layouts.admin.admin_dashboard')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dữ Liệu</h1>
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
                            <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>
                            <li class="breadcrumb-item active">Bảng Dữ Liệu</li>
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
                                <h3 class="card-title">Học Sinh</h3>

                                <div style="float:right">
                                    <a role="button" class="btn btn-success" href="{{url('/admin/import-file-student')}}">Tạo Học Sinh Từ File</a>
                                    <a role="button" class="btn btn-success" href="{{url('/admin/export-file-student')}}">Xuất File Học Sinh</a>

                                    <a role="button" class="btn btn-success delete-all"
                                        href="{{ url('admin/delete-all/students') }}" record="students">Xóa Học Sinh Chọn</a>
                                    <a role="button" href="{{ url('admin/add-student') }}" class="btn btn-success">Tạo Học Sinh</a>

                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="students" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>Mã Học Sinh</th>
                                            <th>Ảnh</th>
                                            <th>Tên</th>
                                            <th>Điện Thoại</th>
                                            <th>Lớp</th>
                                            <th>Khối</th>
                                            <th>Tình Trạng</th>

                                            <th style="width:100px">Tùy Chỉnh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}
                                        @foreach ($students as $student)

                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{ $student['id'] }}></th>
                                                <td>{{ $student['student_code'] }}</td>

                                                <td><img src="{{ $student['image'] }}" width="100px" height="100px"></td>
                                                <td>
                                                    {{ $student['name'] }}
                                                </td>
                                                <td>{{ $student['mobile'] }}</td>
                                                <td>
                                                    @foreach ($classes as $class)
                                                        @if($student['class_id']==$class['id'])
                                                            {{$class['name']}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($grades as $grade)
                                                        @if($student['grade_id']==$grade['id'])
                                                            {{$grade['grade']}}
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td>
                                                    @if ($student['status'] == 1)
                                                        <a class="status-student" href="javascript:void(0)" style="color:green" data-id="{{$student['id']}}" id="student-{{ $student['id'] }}">Active</a>
                                                    @else
                                                        <a class="status-student" href="javascript:void(0)" style="color:red" data-id="{{$student['id']}}" id="student-{{ $student['id'] }}">Inactive</a>
                                                    @endif
                                                </td>
                                                <td style="font-size: 20px">
                                                    <a title="Edit student" role="button"
                                                        href="{{ url('/admin/edit-student', $student['id']) }}"><i
                                                            class="fas fa-edit" style="color: green"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a title="Delete student" href="javascript:void(0)" record='student'
                                                        recordid={{ $student['id'] }} class="confirmdelete"><i
                                                            class="fa fa-trash-alt" style="color: red"></i></a>
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
