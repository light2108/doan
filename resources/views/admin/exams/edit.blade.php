@extends('layouts.admin.admin_dashboard')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dữ Liệu</h1>
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
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <!-- Main content -->
        <form action="{{ url('/admin/edit-exam', $exam['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Điều Chỉnh Kiểm Tra</h3>

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
                                            <input type="text" placeholder="Enter Name" value="{{$exam['name']}}" name="name" class="form-control"
                                                required>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Khối</label>
                                            <select class="form-control" name="grade_id" required id="append_grade_exam">
                                                <option>Select</option>
                                                @foreach ($grades as $grade)
                                                    @if($grade['id']==$exam['grade_id'])
                                                        <option value="{{ $grade['id'] }}" selected>{{ $grade['grade'] }}</option>
                                                    @else
                                                        <option value="{{ $grade['id'] }}">{{ $grade['grade'] }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Lớp</label>
                                            <select class="form-control classes" id="appendclass" name="class_id[]" required multiple="multiple" width="100%">
                                                @foreach ($classes as $class)
                                                    @if (in_array($class['id'], explode(",", $exam['class_id'])))
                                                        <option value="{{$class['id']}}" selected>{{$class['name']}}</option>
                                                    @endif
                                                @endforeach
                                                {{-- @foreach ($classes as $class)
                                                    @if (in_array($class['id'], $teacher_classes)&&!in_array($class['id'], explode(",", $exam['class_id'])))
                                                        <option value="{{$class['id']}}">{{$class['name']}}</option>
                                                    @endif
                                                @endforeach --}}
                                                {{-- {{$view}} --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mật Khẩu Mặc Định</label>
                                            <input type="text" class="form-control" name="password"
                                                placeholder="Enter your password" value="{{$exam['password']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Thời Gian Bắt Đầu</label>
                                            <input type="datetime-local" class="form-control" required value="{{date('Y-m-d\TH:i',strtotime($exam['start_time']))}}" name="start_time">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Thời Gian Kết Thúc</label>
                                            <input type="datetime-local" class="form-control" required value="{{date('Y-m-d\TH:i',strtotime($exam['end_time']))}}" name="end_time">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Video</label>
                                            <input type="file" class="form-control" name="video" value="{{$exam['video']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Thời Gian Kiểm Tra</label>
                                            <input type="number" required placeholder="Enter minutes of exam" value="{{$exam['time']}}" class="form-control" name="time">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Số Lần Làm Bài</label>
                                            <select class="form-control" name="multiple" required>
                                                @if($exam['multiple']==0)
                                                    <option value="0" selected>Unlimited</option>
                                                    @for($i=1; $i<=10; ++$i)
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    @endfor
                                                @else
                                                    @for($i=1; $i<=10; ++$i)
                                                        @if($exam['multiple']==$i)
                                                            <option value="{{$i}}" selected>{{$i}}</option>
                                                        @else
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endif
                                                    @endfor
                                                    <option value="0">Không Giới Hạn</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tình Trạng</label><br>
                                            @if($exam['status'] == 1)
                                            <input type="radio" name="status" value="1" checked>Active
                                            <input type="radio" name="status" value="0">Inactive
                                            @else
                                            <input type="radio" name="status" value="1">Active
                                            <input type="radio" name="status" value="0" checked>Inactive
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary add-data">Chỉnh Sửa</button>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </section>
        </form>
        <!-- SELECT2 EXAMPLE -->
    </div>

@endsection
