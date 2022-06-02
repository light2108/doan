@extends('layouts.admin.admin_dashboard')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Students</li>
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
                            <h3 class="card-title">Edit Student</h3>

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
                                            <label for="exampleInputEmail1">Name<span style="color:red">*</span></label>
                                            <input type="text" placeholder="Enter Name" name="name" class="form-control"
                                                required value="{{$student['name']}}">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Address<span style="color:red">*</span></label>
                                            <input type="text" placeholder="Enter Address" name="address"
                                                class="form-control" value="{{$student['address']}}" required>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mobile</label>
                                            <input type="number" placeholder="Enter Mobile" name="mobile"
                                                class="form-control" value="{{$student['mobile']}}">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Birth day</label>
                                            <input type="date" placeholder="" name="birth_day" class="form-control"
                                                required value="{{date('Y-m-d', strtotime($student['birth_day']))}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Year Admission</label>
                                            <input type="date" placeholder="Enter Year Admission" name="year_admission"
                                                class="form-control" required value="{{date('Y-m-d', strtotime($student['year_admission']))}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Password</label>
                                            <input type="text" placeholder="Enter Password" name="password"
                                                class="form-control" value="1" readonly="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image</label>
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
                                            <label for="exampleInputEmail1">Grade</label>
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
                                                <label for="exampleInputEmail1">Classes</label>
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Status</label>
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
                                            <label for="exampleInputEmail1">Sex</label>
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
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </section>
        </form>
        <!-- SELECT2 EXAMPLE -->
    </div>

@endsection
