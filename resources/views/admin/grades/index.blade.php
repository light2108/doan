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
                                <h3 class="card-title">Khối</h3>
                                <div style="float:right">
                                    <a role="button" class="btn btn-success delete-all"
                                        href="{{ url('admin/delete-all/grades') }}" record="grades">Xóa Khối Chọn</a>
                                    <a role="button" href="{{ url('admin/add-grade') }}" data-toggle="modal"
                                        data-target="#exampleModal" class="btn btn-success">Tạo Khối</a>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tạo Khối</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{ url('/admin/add-grade') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Khối:</label>
                                                    <input type="number" class="form-control" name="grade" required
                                                        placeholder="Enter grade">
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Tình Trạng:</label>
                                                    <input type="radio" name="status" value="1" checked>Active
                                                    <input type="radio" name="status" value="0">Inactive
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
                                <table id="grades" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Khối</th>
                                            <th>Tình Trạng</th>
                                            <th>Tùy Chỉnh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}
                                        @foreach ($grades as $i => $grade)

                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{ $grade['id'] }}></th>
                                                <td>{{ ++$i }}</td>
                                                <td>
                                                    {{ $grade['grade'] }}
                                                </td>
                                                <td>
                                                    @if ($grade['status'] == 1)
                                                        <a class="status-grade" href="javascript:void(0)"
                                                            style="color:green" data-id="{{ $grade['id'] }}"
                                                            id="grade-{{ $grade['id'] }}">Active</a>
                                                    @else
                                                        <a class="status-grade" href="javascript:void(0)" style="color:red"
                                                            data-id="{{ $grade['id'] }}"
                                                            id="grade-{{ $grade['id'] }}">Inactive</a>
                                                    @endif
                                                </td>
                                                <td>

                                                    <div class="modal fade" id="exampleModal{{ $grade['id'] }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Điều Chỉnh Khối
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post"
                                                                        action="{{ url('/admin/edit-grade', $grade['id']) }}">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Khối:</label>
                                                                            <input type="number" name="grade"
                                                                                class="form-control" required
                                                                                placeholder="Enter Grade"
                                                                                value="{{ $grade['grade'] }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Tình Trạng:</label>
                                                                            @if ($grade['status'] == 1)
                                                                                <input type="radio" name="status" checked
                                                                                    value="1">Active
                                                                                <input type="radio" name="status"
                                                                                    value="0">Inactive
                                                                            @else
                                                                                <input type="radio" name="status"
                                                                                    value="1">Active
                                                                                <input type="radio" name="status" checked
                                                                                    value="0">Inactive
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


                                                    <a title="Edit Grade" role="button" type="submit" data-toggle="modal"
                                                        style="font-size: 20px"
                                                        data-target="#exampleModal{{ $grade['id'] }}"><i
                                                            class="fas fa-edit" style="color: green"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a title="Delete Grade" href="javascript:void(0)" record='grade'
                                                        style="font-size: 20px" recordid={{ $grade['id'] }}
                                                        class="confirmdelete"><i class="fa fa-trash-alt"
                                                            style="color: red"></i></a>
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
