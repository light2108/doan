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
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Trang Chủ</a></li>
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
                                <h3 class="card-title">Giáo Viên</h3>
                                <div style="float:right">
                                    <a role="button" class="btn btn-success" href="{{url('/admin/import-file-teacher')}}">Tạo Giáo Viên Từ File</a>
                                    <a role="button" class="btn btn-success" href="{{url('/admin/export-file-teacher')}}">Xuất File Giáo Viên</a>
                                    <a role="button" class="btn btn-success delete-all"
                                        href="{{ url('admin/delete-all/teachers') }}" record="teachers">Xóa Giáo Viên Chọn</a>
                                    <a role="button" href="{{ url('admin/add-teacher') }}" class="btn btn-success">Tạo Giáo Viên</a>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="teachers" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Ảnh</th>
                                            <th>Tên</th>
                                            <th>Email</th>
                                            <th>Điện Thoại</th>
                                            <th>Lớp</th>
                                            <th>Môn Học</th>
                                            <th>Tình Trạng</th>
                                            <th style="width:80px">Tùy Chỉnh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}
                                        @foreach ($teachers as $key => $teacher)

                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{ $teacher['id'] }}></th>
                                                <td>{{ $teacher['id'] }}</td>

                                                <td><img src="{{ $teacher['image'] }}" width="100px" height="100px"></td>
                                                <td>
                                                    {{ $teacher['name'] }}
                                                </td>
                                                <td>{{ $teacher['email'] }}</td>
                                                <td>{{ $teacher['mobile'] }}</td>
                                                <td>
                                                    @foreach ($classes as $class)
                                                        @if (in_array($class['id'], $class_id[$key]))

                                                            {{ $class['name'] }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>

                                                    @foreach ($subjects as $subject)
                                                        @if ($subject['id'] == $teacher['subject_id'])
                                                            {{ $subject['name'] }} @endif
                                                    @endforeach

                                                </td>
                                                <td>
                                                    @if ($teacher['status'] == 1)
                                                        <a class="status-teacher" href="javascript:void(0)" style="color:green" data-id="{{$teacher['id']}}" id="teacher-{{ $teacher['id'] }}">Active</a>
                                                    @else
                                                        <a class="status-teacher" href="javascript:void(0)" style="color:red" data-id="{{$teacher['id']}}" id="teacher-{{ $teacher['id'] }}">Inactive</a>
                                                    @endif
                                                </td>
                                                <td style="font-size: 20px">
                                                    <a title="Edit Teacher" role="button"
                                                        href="{{ url('/admin/edit-teacher', $teacher['id']) }}"><i
                                                            class="fas fa-edit" style="color: green"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a title="Delete Teacher" href="javascript:void(0)" record='teacher'
                                                        recordid={{ $teacher['id'] }} class="confirmdelete"><i
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
