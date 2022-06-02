@extends('layouts.admin.admin_dashboard')
@section('content')
<?php
use App\Models\Question;
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
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
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">DataTables</li>
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
                                <h3 class="card-title">Units</h3>
                                {{-- <div style="float:right">
                                    <a role="button" class="btn btn-success delete-all"
                                        href="{{ url('admin/delete-all/units') }}" record="units">Delete All</a>
                                    <a role="button" data-toggle="modal" data-target="#exampleModal"
                                        class="btn btn-success">Add
                                        Unit</a>
                                </div> --}}
                            </div>
                            {{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
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
                                            <form method="post"
                                                action="{{ url('/admin/add-unit/subject/' . $subject_id . '/grade/' . $grade_id) }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Name:</label>
                                                    <input type="text" class="form-control" placeholder="Enter Unit Name"
                                                        required name="name">
                                                </div>

                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Status:</label>
                                                    <input type="radio" value="1" checked name="status">Active
                                                    <input type="radio" value="0" name="status">Inactive
                                                </div>


                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div> --}}
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="subjects" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>

                                            <th>Name</th>
                                            <th>Subject</th>
                                            <th>Number of Question</th>
                                            <th>Status</th>


                                            <th style="width:100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}
                                        @foreach ($units as $i => $unit)

                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{ $unit['id'] }}></th>
                                                <td>{{ $unit['id'] }}</td>

                                                <td>
                                                    {{ $unit['name'] }}
                                                </td>
                                                <td>
                                                    @foreach ($subjects as $subject)
                                                        @if ($subject['id'] == $unit['subject_id'])
                                                            {{ $subject['name'] }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ count(Question::where('unit_id', $unit['id'])->get()) }}
                                                </td>
                                                <td>
                                                    @if ($unit['status'] == 1)
                                                        <a href="javascript:void(0)" style="color:green"
                                                            data-id="{{ $unit['id'] }}"
                                                            id="unit-{{ $unit['id'] }}">Active</a>
                                                    @else
                                                        <a href="javascript:void(0)" style="color:red"
                                                            data-id="{{ $unit['id'] }}"
                                                            id="unit-{{ $unit['id'] }}">Inactive</a>
                                                    @endif
                                                </td>
                                                <td>

                                                    {{-- <div class="modal fade" id="exampleModal{{ $unit['id'] }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Unit
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post"
                                                                        action="{{ url('/admin/edit-unit/' . $unit['id'] . '/subject/' . $subject_id . '/grade/' . $grade_id) }}">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Name:</label>
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Enter Unit Name" required
                                                                                name="name" value="{{ $unit['name'] }}">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="recipient-name"
                                                                                class="col-form-label">Status:</label>

                                                                            @if ($unit['status'] == 1)
                                                                                <input type="radio" name="status" value="1"
                                                                                    checked>Active
                                                                                <input type="radio" name="status"
                                                                                    value="0">Inactive
                                                                            @else
                                                                                <input type="radio" name="status"
                                                                                    value="1">Active
                                                                                <input type="radio" name="status" value="0"
                                                                                    checked>Inactive
                                                                            @endif

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Edit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div> --}}

                                                    <a title="View Question of Unit" style="font-size: 20px"
                                                        href="{{ url('/admin/questions/subject/'.Auth::guard('admin')->user()->subject_id.'/grade/'.$grade_id.'/unit/'.$unit['id'].'/exam/'.$exam_id) }}"><i
                                                            class="fas fa-eye"></i></a>
                                                    {{-- &nbsp;
                                                    &nbsp;
                                                    <a style="font-size: 20px" title="Edit Unit" role="button"
                                                        data-toggle="modal"
                                                        data-target="#exampleModal{{ $unit['id'] }}"><i
                                                            class="fas fa-edit" style="color: green"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a style="font-size: 20px" title="Delete Unit" href="javascript:void(0)"
                                                        record='unit' recordid={{ $unit['id'] }} class="confirmdelete"><i
                                                            class="fa fa-trash-alt" style="color: red"></i></a> --}}
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
