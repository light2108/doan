@extends('layouts.admin.admin_dashboard')
@section('content')
<?php
use Carbon\Carbon;
use App\Models\Result;
?>
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
                                <h3 class="card-title">Toàn Bộ Bài Kiểm Tra</h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="questions-exam" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Bài Kiểm Tra</th>
                                            <th>Ngày Bắt Đầu</th>
                                            <th>Ngày Kết Thúc</th>
                                            <th>TÌnh Trạng</th>
                                            <th style="width:100px">Tùy Chỉnh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" value="{{ $k = 1 }}">
                                        @foreach ($exams as $i => $exam)
                                        @if(in_array($class_id, explode(",",$exam['class_id'])))
                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{ $exam['id'] }}>
                                                </th>
                                                <td>{{ $k++ }}</td>

                                                <td>{{ $exam['name'] }}</td>

                                                <td>
                                                    {{date('Y-m-d H:i:s', strtotime($exam['start_time']))}}
                                                </td>
                                                <td>
                                                    {{date('Y-m-d H:i:s', strtotime($exam['end_time']))}}
                                                </td>
                                                <td>
                                                    @if(!empty(Result::where('exam_id', $exam['id'])->get()->toArray()))
                                                        <span style="color:green">Kết Quả Mới</span>
                                                    @else
                                                        <span style="color:red">Chưa Có Kết Quả</span>
                                                    @endif
                                                </td>
                                                <td style="font-size: 20px">
                                                    @if(!empty(Result::where('exam_id', $exam['id'])->get()->toArray()))
                                                        <a title="View Result of Student" href="{{url('/admin/result/student/exam/'.$exam['id'].'/class/'.$class_id)}}"><i
                                                                class="fas fa-eye"></i></a>
                                                    @else
                                                        <a title="View Result of Student" href="{{url('/admin/see/student/exam/'.$exam['id'].'/class/'.$class_id)}}"><i
                                                            class="fas fa-eye"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
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
