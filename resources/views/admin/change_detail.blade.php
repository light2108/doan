@extends('layouts.admin.admin_dashboard')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Cập Nhật</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Trang Chủ</a></li>
                            <li class="breadcrumb-item active">Cập Nhật Quản Trị</li>
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
                                <h3 class="card-title">Cập Nhật Thông Tin Quản Trị</h3>
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
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </div>
                            @endif
                            <form role="form" method="POST" action="{{ url('/admin/change-detail') }}"
                                name="updatepasswordform" id="updatepasswordform" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Tên Quản Trị</label>
                                        <input type="text" class="form-control"
                                            placeholder="Enter Name" value="{{$admindetails->name}}" required name="name" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email Quản Trị</label>
                                        <input type="email" name="email" class="form-control" value="{{ $admindetails->email }}" required
                                            >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Điện Thoại</label>
                                        <input type="number" class="form-control" placeholder="Enter Mobile"
                                            required name="mobile" id="current_password" value="{{$admindetails->mobile}}">
                                        {{-- <span id="chkpwd"></span> --}}
                                    </div>
                                    <div class="form-group">

                                             <label>Ảnh</label>
                                             <div class="input-group">
                                                 <div class="custom-file">
                                                     <input type="file" class="custom-file-input" name="image"
                                                         id="exampleInputFile" onchange="loadfile(event)">
                                                     <label class="custom-file-label" for="exampleInputFile">{{$admindetails->image}}</label>
                                                 </div>
                                                 <div class="input-group-append">
                                                     <span class="input-group-text">Upload</span>
                                                 </div>
                                             </div>
                                        {{-- <a href="{{url('/admin/view-image')}}">View Image</a> --}}

                                    </div>

                                    {{-- <div class="form-group">
                                        <label for="exampleInputPassword1">Status</label>
                                        @if($admindetails->status==1)
                                        <input type="radio"
                                             name="status" value="1" class="active" checked>Active
                                        <input type="radio"
                                             name="status" value="0" class="inactive">Inactive
                                        @else
                                        <input type="radio"
                                             name="status" value="0" class="inactive" checked>Inactive
                                        <input type="radio"
                                             name="status" value="1" class="active">Active
                                        @endif
                                    </div> --}}

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img id="output" width="300" height="400" src="{{$admindetails->image}}">
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
