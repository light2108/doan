@extends('layouts.admin.admin_dashboard')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Cài Đặt</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Trang Chủ</a></li>
                            <li class="breadcrumb-item active">Cài Đặt</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- Main content -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Cập Nhật Mật Khẩu</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            @if (Session::has('error_message'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>{{ Session::get('error_message') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if (Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ Session::get('success_message') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form role="form" method="POST" action="{{ url('/admin/change-password') }}"
                                name="updatepasswordform" id="updatepasswordform">
                                @csrf
                                <div class="card-body">
                                    {{-- <div class="form-group">
                                        <label for="exampleInputPassword1">Admin Name</label>
                                        <input type="text" class="form-control"
                                            placeholder="Enter Name" value="{{$admindetails->name}}" required name="name" id="name">
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" value="{{ $admindetails->email }}"
                                            readonly="">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Mật Khẩu</label>
                                        <input type="password" class="form-control" placeholder="Enter Current Password"
                                            required name="current_password" id="current_password">
                                        <span id="chkpwd"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Mật Khẩu Mới</label>
                                        <input type="password" class="form-control" placeholder="Enter New Password"
                                            required name="new_password" id="new_password">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Nhập Lại Mật Khẩu</label>
                                        <input type="password" class="form-control" placeholder="Enter Confirm Password"
                                            required name="confirm_password" id="confirm_password">
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
