@extends('layouts.admin.admin_dashboard')
@section('content')
<?php
use Carbon\Carbon;
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
                                <h3 class="card-title">Kết Quả Bài Kiểm Tra</h3>
                                <div style="float:right">
                                    <a role="button" class="btn btn-success" href="{{url('/admin/export-file-result-briefly')}}">Xuất File Kết Quả Tóm Tắt</a>
                                    <a role="button" class="btn btn-success" href="{{url('/admin/export-file-result-full')}}">Xuất File Kết Quả Đầy Đủ</a>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="questions-exam" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Mã Học Sinh</th>
                                            <th>Tên Học Sinh</th>
                                            <th>Lớp</th>
                                            <th>Điểm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" value="{{ $k = 1 }}">
                                        @foreach ($results as $i => $result)

                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{ $result['id'] }}>
                                                </th>
                                                <td>{{ $k++ }}</td>
                                                <td>
                                                    @foreach ($students as $student)
                                                        @if($result['student_id']==$student['id'])
                                                            {{$student['student_code'] }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($students as $student)
                                                        @if($result['student_id']==$student['id'])
                                                            {{$student['name'] }}
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td>
                                                    {{$classes['name']}}
                                                </td>
                                                <td>
                                                    {{max(explode(",",$result['score']))}}
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
