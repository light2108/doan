@extends('layouts.admin.admin_dashboard')
@section('content')

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
                                <h3 class="card-title">Subjects</h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="questions-exam" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Subject</th>
                                            <th>Status</th>
                                            <th style="width:100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" value="{{ $k = 1 }}">
                                        @foreach ($subjects as $i => $subject)
                                            @if (in_array($grade_id, explode(',', $subject['grade_id'])))
                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{ $subject['id'] }}>
                                                </th>
                                                <td>{{ $k++ }}</td>

                                                <td>{{ $subject['name'] }}</td>

                                                <td>
                                                    @if ($subject['status'] == 1)
                                                        <a href="javascript:void(0)" style="color:green">Active</a>
                                                    @else
                                                        <a href="javascript:void(0)" style="color:red">Inactive</a>
                                                    @endif
                                                </td>
                                                <td style="font-size: 20px">

                                                    <a title="View Question of Subject" href="{{route('admin.questions.subject.grade', ['subject_id'=>$subject['id'], 'grade_id'=>$grade_id])}}"><i
                                                            class="fas fa-eye"></i></a>
                                                </td>
                                            </tr>
                                            @endif
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
