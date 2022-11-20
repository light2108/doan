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
                            <li class="breadcrumb-item active">Giáo Viên</li>
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
        <form action="{{ url('/admin/add-teacher') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Tạo Giáo Viên</h3>

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
                                            <label for="exampleInputEmail1">Tên</label>
                                            <input type="text" placeholder="Enter Name" name="name" class="form-control"
                                                required>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input type="email" placeholder="Enter Email" name="email" class="form-control"
                                                required>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Ngày Sinh</label>
                                            <input type="date" placeholder="" name="birth_day" class="form-control"
                                                required>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Địa Chỉ</label>
                                            <input type="text" placeholder="Enter Address" name="address" class="form-control"
                                                required>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Điện Thoại</label>
                                            <input type="number" placeholder="Enter Mobile" name="mobile"
                                                class="form-control" required>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mât Khẩu Mặc Định</label>
                                            <input type="text" placeholder="Enter Password" name="password"
                                                class="form-control" value="1" required readonly="">

                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">

                                    <div class="form-group">


                                        <label>Ảnh</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image"
                                                    id="exampleInputFile" onchange="loadfile(event)">
                                                <label class="custom-file-label" for="exampleInputFile"></label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                        {{-- <a href="{{url('/admin/view-image')}}">View Image</a> --}}



                                    </div>

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tên Môn Học</label>
                                            @if(Auth::guard('admin')->user()->role!=1)
                                                @foreach ($subjects as $subject)
                                                    @if($subject['id']==Auth::guard('admin')->user()->subject_id)
                                                        <input type="hidden" class="form-control" name="subject_id" value="{{$subject['id']}}">
                                                        <input type="text" class="form-control" value="{{$subject['name']}}" readonly="">
                                                    @endif
                                                @endforeach
                                            @else
                                                <select class="form-control" name="subject_id" required>
                                                    @foreach($subjects as $subject)
                                                        <option value="{{ $subject['id'] }}">{{ $subject['name']}}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Grade</label>
                                            <select class="form-control select2" id="exampleInputEmail1" name="grade_id[]" multiple>
                                                @foreach ($grades as $grade)
                                                    <option value="{{$grade['id']}}">{{$grade['grade']}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div> --}}
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tên Lớp</label>
                                            <select class="form-control classes" multiple id="exampleInputEmail1" name="class_id[]">
                                                @foreach ($classes as $class)
                                                    <option value="{{$class['id']}}">{{$class['name']}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    @if(Auth::guard('admin')->user()->role==1)
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Trưởng Bộ Môn</label>
                                            <input type="checkbox" name="role" value="-1">

                                        </div>
                                    </div>
                                    @endif
                                    <!-- /.col -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <img id="output" width="300" height="300">

                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tình Trạng</label>
                                            <input type="radio" name="status" checked value="1">Active
                                            <input type="radio" name="status" value="0">Inactive

                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Giới Tính</label>
                                            <input type="radio" name="sex" checked value="1">Male
                                            <input type="radio" name="sex" value="0">Female

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- /.row -->

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Tạo</button>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </section>
        </form>
        <!-- SELECT2 EXAMPLE -->
    </div>

@endsection
