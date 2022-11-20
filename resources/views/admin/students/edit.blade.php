@extends('layouts.admin.admin_dashboard')
@section('content')

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
                        @elseif(Session::has('error_message'))
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
                            <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>
                            <li class="breadcrumb-item active">Học Sinh</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <!-- Main content -->
        <form action="{{ url('/admin/edit-student', $student['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Điều Chỉnh Học Sinh</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tên<span style="color:red">*</span></label>
                                            <input type="text" placeholder="Enter Name" name="name" class="form-control"
                                                required value="{{$student['name']}}">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Địa Chỉ<span style="color:red">*</span></label>
                                            <input type="text" placeholder="Enter Address" name="address"
                                                class="form-control" value="{{$student['address']}}" required>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Điện Thoại</label>
                                            <input type="number" placeholder="Enter Mobile" name="mobile"
                                                class="form-control" value="{{$student['mobile']}}">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Ngày Sinh</label>
                                            <input type="date" placeholder="" name="birth_day" class="form-control"
                                                required value="{{date('Y-m-d', strtotime($student['birth_day']))}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Năm Nhập Học</label>
                                            <input type="date" placeholder="Enter Year Admission" name="year_admission"
                                                class="form-control" required value="{{date('Y-m-d', strtotime($student['year_admission']))}}">
                                        </div>
                                    </div>
                                </div>
                                {{-- @if(Auth::guard('admin')->user()->role==1) --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tình Trạng</label><br>
                                            @if($student['status']==1)
                                            <input type="radio" name="status" checked value="1">Active
                                            <input type="radio" name="status" value="0">Inactive
                                            @else
                                            <input type="radio" name="status" value="1">Active
                                            <input type="radio" name="status" checked value="0">Inactive
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Giới Tính</label><br>
                                            @if($student['sex']==1)
                                            <input type="radio" name="sex" checked value="1">Male
                                            <input type="radio" name="sex" value="0">Female
                                            @else
                                            <input type="radio" name="sex" value="1">Male
                                            <input type="radio" name="sex" checked value="0">Female
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- @endif --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ảnh</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image"
                                                    id="exampleInputFile" onchange="loadfile(event)">
                                                <label class="custom-file-label" for="exampleInputFile">{{$student['image']}}</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Khối</label>
                                            <select name="grade_id" class="form-control" id="appendgradeid" required>
                                                <option>Select</option>
                                                @foreach ($grades as $grade)
                                                    @if($student['grade_id']==$grade['id'])
                                                        <option value="{{$grade['id']}}" selected>{{$grade['grade']}}</option>
                                                    @else
                                                        <option value="{{$grade['id']}}">{{$grade['grade']}}</option>
                                                    @endif
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div id="appendclasseslevel">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Lớp</label>
                                                <select name="class_id" class="form-control select2" required>
                                                    @foreach ($classes as $class)
                                                        @if($student['class_id']==$class['id'])
                                                            <option value="{{$class['id']}}" selected>{{$class['name']}}</option>
                                                        {{-- @else
                                                            <option value="{{$class['id']}}">{{$grade['name']}}</option> --}}
                                                        @endif
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <img id="output" width="250" height="250" src={{$student['image']}}>

                                    </div>
                                </div>
                                @if(Auth::guard('admin')->user()->role==1)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mật Khẩu Mặc Định</label>
                                            <input type="text" placeholder="Enter Password" name="password"
                                                class="form-control" value="1" readonly="" required>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </section>
        </form>
        <!-- SELECT2 EXAMPLE -->
    </div>

@endsection
