@extends('layouts.admin.admin_dashboard')
@section('content')
    <?php use App\Models\Question; ?>
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
                                <h3 class="card-title">Câu Hỏi</h3>
                                <div style="float:right">
                                    <a role="button" href="javascript:void(0)" data-toggle="modal"
                                        data-target="#exampleModalrandom" class="btn btn-success random-question">Thêm Câu Hỏi Ngẫu Nhiên</a>
                                    <a role="button"
                                        href="{{ url('/admin/units/subject/' . Auth::guard('admin')->user()->subject_id . '/grade/' . $grade_id.'/exam/'.$id) }}"
                                        class="btn btn-success">Chọn Câu Hỏi</a>
                                    <a role="button" class="btn btn-success delete-all"
                                        href="{{ url('admin/delete-all/questions-exam') }}" record="questions-exam">Xóa Câu Hỏi Chọn</a>
                                    <a role="button"
                                        href="{{ route('admin.add-question.grade.exam', ['grade_id' => $grade_id, 'id' => $id]) }}"
                                        class="btn btn-success">Tạo Câu Hỏi</a>

                                </div>
                            </div>
                            <div class="modal fade" id="exampleModalrandom" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Thêm Câu Hỏi Ngẫu Nhiên
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form method="post" action="{{ url('/admin/random-question') }}">
                                                @csrf
                                                <input type="hidden" name="exam_id" value="{{ $id }}">
                                                @foreach ($units as $unit)
                                                    <div class="form-group">
                                                        <label for="message-text"
                                                            class="col-form-label">{{ $unit['name'] }}</label>
                                                        <input type="hidden" name="unit_id[]" value="{{ $unit['id'] }}">
                                                        <input class="form-control"
                                                            placeholder="Total of question {{ count(Question::where('unit_id', $unit['id'])->get()) }}"
                                                            type="number" name="number[]">
                                                    </div>
                                                @endforeach
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
                                <table id="questions-exam" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:20px"><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Câu Hỏi</th>
                                            <th>Ngày Tạo</th>
                                            <th>Tình Trạng</th>

                                            <th style="width:100px">Tùy Chỉnh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" value="{{ $k = 1 }}">

                                        @foreach ($questions as $i => $question)
                                            @if (in_array($id, explode(',', $question['select_id'])) || $id == $question['exam_id'])
                                                <tr>
                                                    <th><input type="checkbox" class="sub_ck"
                                                            data-id={{ $question['id'] }}></th>
                                                    <td>{{ $k++ }}</td>

                                                    <td>{!! $question['question'] !!}</td>
                                                    <td>
                                                        {{ date('Y-m-d', strtotime($question['created_at'])) }}
                                                    </td>

                                                    <td>
                                                        @if ($question['status'] == 1)
                                                            <a class="status-question-exam" href="javascript:void(0)"
                                                                style="color:green" data-id="{{ $question['id'] }}"
                                                                id="question-{{ $question['id'] }}">Active</a>
                                                        @else
                                                            <a class="status-question-exam" href="javascript:void(0)"
                                                                style="color:red" data-id="{{ $question['id'] }}"
                                                                id="question-{{ $question['id'] }}">Inactive</a>
                                                        @endif
                                                    </td>
                                                    <td style="font-size: 20px">

                                                        <a title="Edit Question" role="button"
                                                            href="{{ route('admin.edit-question.grade.exam', ['question_id' => $question['id'], 'grade_id' => $question['grade_id'], 'id' => $id]) }}"><i
                                                                class="fas fa-edit" style="color: green"></i></a>
                                                        &nbsp;
                                                        &nbsp;
                                                        <a title="Delete Question" href="javascript:void(0)"
                                                            record='question' recordid={{ $question['id'] }}
                                                            class="updatequestion" gradeid={{ $question['grade_id'] }}
                                                            examid={{ $id }}><i class="fa fa-trash-alt"
                                                                style="color: red"></i></a>
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
