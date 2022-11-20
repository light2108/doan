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
                                <h3 class="card-title">Môn Học</h3>
                                <div style="float:right">
                                    <a role="button" class="btn btn-success delete-all" href="{{url('admin/delete-all/subjects')}}" record="subjects">Xóa Môn Học Chọn</a>
                                    <a role="button" data-toggle="modal" data-target="#exampleModal"
                                        class="btn btn-success">Tạo Môn Học</a>
                                </div>



                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">New Subject</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{ url('/admin/add-subject') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Tên Môn Học:</label>
                                                    <input type="text" class="form-control" placeholder="Enter Subject Name"
                                                        required name="name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Khối:</label>
                                                    <select class="form-control select2" name="grade_id[]" multiple required>
                                                        @foreach ($grades as $grade)
                                                            <option value="{{ $grade['id'] }}">{{ $grade['grade'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Tình Trạng:</label>
                                                    <input type="radio" value="1" checked name="status">Active
                                                    <input type="radio" value="0" name="status">Inactive
                                                </div>


                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Tạo</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="subjects" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>

                                            <th>Tên Môn Học</th>
                                            <th>Khối</th>
                                            <th>Tình Trạng</th>


                                            <th style="width:100px">Tùy Chỉnh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}
                                        @foreach ($subjects as $i => $subject)

                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{$subject['id']}}></th>
                                                <td>{{ $subject['id'] }}</td>

                                                <td>
                                                    {{ $subject['name'] }}
                                                </td>
                                                <td>
                                                    @foreach ($grades as $grade)
                                                        @if (in_array($grade['id'], explode(",",$subject['grade_id'])))
                                                            {{$grade['grade']}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                @if ($subject['status'] == 1)
                                                    <a class="status-subject" href="javascript:void(0)" style="color:green" data-id="{{$subject['id']}}" id="subject-{{ $subject['id'] }}">Active</a>
                                                @else
                                                    <a class="status-subject" href="javascript:void(0)" style="color:red" data-id="{{$subject['id']}}" id="subject-{{ $subject['id'] }}">Inactive</a>
                                                @endif
                                                </td>
                                                <td >

                                                    <div class="modal fade" id="exampleModal{{ $subject['id'] }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Điều Chỉnh Môn Học
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post"
                                                                        action="{{ url('/admin/edit-subject', $subject['id']) }}">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Tên Môn Học:</label>
                                                                            <input class="form-control" type="text"
                                                                                value="{{ $subject['name'] }}"
                                                                                placeholder="Enter Subject Name">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Khối:</label>
                                                                            <select class="form-control select2" name="grade_id[]" multiple required>
                                                                                @foreach ($grades as $grade)
                                                                                    @if (in_array($grade['id'],explode(",",$subject['grade_id'])))
                                                                                        <option value="{{ $grade['id'] }}"
                                                                                            selected>{{ $grade['grade'] }}
                                                                                        </option>
                                                                                    @else <option
                                                                                            value="{{ $grade['id'] }}">
                                                                                            {{ $grade['grade'] }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Tình Trạng:</label>

                                                                                @if ($subject['status'] == 1)
                                                                                    <input type="radio" name="status"
                                                                                        value="1" checked>Active
                                                                                    <input type="radio" name="status"
                                                                                        value="0">Inactive
                                                                                @else
                                                                                    <input type="radio" name="status"
                                                                                        value="1">Active
                                                                                    <input type="radio" name="status"
                                                                                        value="0" checked>Inactive
                                                                                @endif

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Cập Nhật</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>


                                                    <a style="font-size: 20px" title="Edit Subject" role="button" type="submit" data-toggle="modal"
                                                        data-target="#exampleModal{{ $subject['id'] }}"><i
                                                            class="fas fa-edit" style="color: green"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a style="font-size: 20px" title="Delete Subject" href="javascript:void(0)" record='subject'
                                                        recordid={{ $subject['id'] }} class="confirmdelete"><i
                                                            class="fa fa-trash-alt" style="color: red"></i></a>
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
