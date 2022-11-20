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
                                <h3 class="card-title">Bài Kiểm Tra</h3>
                                <div style="float:right">
                                    <a role="button" class="btn btn-success delete-all"
                                        href="{{ url('admin/delete-all/exams') }}" record="exams">Xóa Bài Kiểm Tra Chọn</a>
                                    <a role="button" href="{{ url('admin/add-exam') }}" class="btn btn-success">Tạo Bài Kiểm Tra</a>
                                </div>
                            </div>
                            {{--  --}}
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="exams" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Tên </th>
                                            <th>Môn Học</th>

                                            <th>Lớp</th>
                                            {{-- <th>Teacher</th> --}}
                                            <th>Ngày Bắt đầu</th>
                                            <th>Ngày Kết Thúc</th>
                                            <th>Tình Trạng</th>
                                            <th>Tùy Chỉnh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}

                                        @foreach ($exams as $i => $exam)
                                            {{-- @if (Auth::guard('admin')->user()->id == $exam['teacher_id']) --}}
                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{ $exam['id'] }}>
                                                </th>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $exam['name'] }}</td>
                                                <td>
                                                    @foreach ($subjects as $subject)
                                                        @if ($subject['id'] == $exam['subject_id'])
                                                            {{ $subject['name'] }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($classes as $class)
                                                        @if (in_array($class['id'], explode(',', $exam['class_id'])))
                                                            {{ $class['name'] }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                {{-- <td>{{ $exam['teacher_id'] }}</td> --}}
                                                <td>{{ $exam['start_time'] }}</td>
                                                <td>{{ $exam['end_time'] }}</td>
                                                <td>
                                                    @if ($exam['status'] == 1)
                                                        <a class="status-exam" href="javascript:void(0)" style="color:green"
                                                            data-id="{{ $exam['id'] }}"
                                                            id="exam-{{ $exam['id'] }}">Active</a>
                                                    @else
                                                        <a class="status-exam" href="javascript:void(0)" style="color:red"
                                                            data-id="{{ $exam['id'] }}"
                                                            id="exam-{{ $exam['id'] }}">Inactive</a>
                                                    @endif
                                                </td>
                                                <td>



                                                    <a title="Index Question Exam" style="font-size: 20px"
                                                        href="{{ route('admin.question.grade.exam', ['grade_id' => $exam['grade_id'], 'id' => $exam['id']]) }}"><i
                                                            class="fas fa-eye"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a title="Edit Exam" role="button" type="submit"
                                                        style="font-size: 20px" href="{{url('/admin/edit-exam', $exam['id'])}}"
                                                        ><i
                                                            class="fas fa-edit" style="color: green"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a title="Delete Exam" href="javascript:void(0)" record='exam'
                                                        style="font-size: 20px" recordid={{ $exam['id'] }}
                                                        class="confirmdelete"><i class="fa fa-trash-alt"
                                                            style="color: red"></i></a>
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
