@extends('layouts.admin.admin_dashboard')
@section('content')
<?php
use App\Models\Classes;
use App\Models\Grade;
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
                                <h3 class="card-title">Bài Kiểm Tra Lớp</h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="questions-exam" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Tên Lớp</th>
                                            <th>Khối</th>
                                            <th style="width:100px">Tùy Chỉnh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" value="{{ $k = 1 }}">
                                        @foreach (explode(",",Auth::guard('admin')->user()->class_id) as $i => $class_id)
                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{ $class_id }}>
                                                </th>
                                                <td>{{ $k++ }}</td>

                                                <td>
                                                    @foreach ($classes as $class)
                                                        @if($class_id==$class['id'])
                                                            {{$class['name']}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($grades as $grade)
                                                        @if(Classes::find($class_id)->grade_id==$grade['id'])
                                                            {{$grade['grade']}}
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td style="font-size: 20px">

                                                    <a title="View Exams of Class" href="{{url('/admin/result/exam/class', $class_id)}}"><i
                                                            class="fas fa-eye"></i></a>
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
