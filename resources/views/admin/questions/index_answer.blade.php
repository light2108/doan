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
                                <h3 class="card-title">Answers</h3>
                                <div style="float:right">
                                    {{-- <a role="button" class="btn btn-success delete-all"
                                        href="{{ url('admin/delete-all/questions-exam') }}" record="questions-exam">Delete
                                        All</a> --}}
                                    <a role="button" href="javascript:void(0)" class="btn btn-success" data-toggle="modal"
                                        data-target="#exampleModal">Add
                                        Answer</a>

                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">New Answer</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post"
                                                action="{{ url('admin/add-answer/question', $question_id) }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Answer Name:</label>
                                                    <input type="text" class="form-control" name="answer" required
                                                        placeholder="Enter Answer">
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Score:</label>
                                                    <input type="text" class="form-control" name="score"
                                                        placeholder="Enter Score">
                                                </div> --}}

                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">True/False:</label>
                                                    <input type="radio" name="correct_answer" value="1">True
                                                    <input type="radio" name="correct_answer" value="0" checked>False
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
                            </div>
                            {{--  --}}
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="questions-exam" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Answer</th>
                                            {{-- <th>Score</th> --}}
                                            <th>True/False</th>
                                            <th style="width:100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}
                                        @foreach ($answers as $i => $answer)
                                            <div class="modal fade" id="exampleModal{{ $answer['id'] }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">New Answer</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post"
                                                                action="{{ route('admin.edit-answer.question', ['answer_id' => $answer['id'], 'question_id' => $question_id]) }}">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="recipient-name"
                                                                        class="col-form-label">Answer Name:</label>
                                                                    <input type="text" class="form-control" name="answer"
                                                                        required placeholder="Enter Answer" value="{{$answer['answer']}}">
                                                                </div>
                                                                {{-- <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Score:</label>
                                                    <input type="text" class="form-control" name="score"
                                                        placeholder="Enter Score">
                                                </div> --}}

                                                                <div class="form-group">
                                                                    <label for="message-text"
                                                                        class="col-form-label">True/False:</label>
                                                                    @if($answer['correct_answer']==1)
                                                                    <input type="radio" name="correct_answer" value="1" checked>True
                                                                    <input type="radio" name="correct_answer" value="0"
                                                                        >False
                                                                    @else
                                                                    <input type="radio" name="correct_answer" value="1">True
                                                                    <input type="radio" name="correct_answer" value="0" checked
                                                                        >False
                                                                    @endif
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            {{-- @if ($answer['exam_id'] == $id || in_array($id, explode(',', $answer['select_id']))) --}}
                                            <tr>
                                                <th><input type="checkbox" class="sub_ck" data-id={{ $answer['id'] }}>
                                                </th>
                                                <td>{{ ++$i }}</td>

                                                <td>{{ $answer['answer'] }}</td>


                                                <td>
                                                    @if ($answer['correct_answer'] == 1)
                                                        <span class="status-answer" href="javascript:void(0)"
                                                            style="color: green" data-id="{{ $answer['id'] }}"
                                                            id="answer-{{ $answer['id'] }}">True</span>
                                                    @else
                                                        <span class="status-answer" href="javascript:void(0)"
                                                            style="color: red" data-id="{{ $answer['id'] }}"
                                                            id="answer-{{ $answer['id'] }}">False</span>
                                                    @endif
                                                </td>
                                                <td style="font-size: 20px">
                                                    <a title="Edit Answer" role="button" data-toggle="modal"
                                                        data-target="#exampleModal{{ $answer['id'] }}"
                                                        href="javascript:void(0)"><i class="fas fa-edit"
                                                            style="color: green"></i></a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a title="Delete Answer" href="javascript:void(0)" record='answer'
                                                        recordid={{ $answer['id'] }} class="confirmdelete"><i
                                                            class="fa fa-trash-alt" style="color: red"></i></a>
                                                </td>
                                            </tr>
                                            {{-- @endif --}}
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
