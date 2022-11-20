@extends('layouts.admin.admin_dashboard')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dữ Liệu</h1>
                        @if (Session::has('error_message'))
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
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <!-- Main content -->
        <form
            action="{{ url('/admin/edit-question/'.$question_id.'/subject/'.$subject_id.'/grade/'.$grade_id.'/unit/'.$unit_id) }}"
            method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Điều Chỉnh Câu Hỏi</h3>

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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Câu Hỏi</label>
                                            <textarea name="question" id="question" class="form-control"
                                                required>{!! $question['question'] !!}</textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Ảnh</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image"
                                                        id="exampleInputFile" onchange="loadfile(event)">
                                                    <label class="custom-file-label"
                                                        for="exampleInputFile">{{ $question['image'] }}</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>File Nghe</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="file_listen"
                                                        id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile"></label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Điểm</label>
                                            <input type="text" class="form-control" placeholder="Enter score" name="score"
                                                value="{{ $question['score'] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <img id="output" width="250" height="250" src="{{ $question['image'] }}">

                                    </div>
                                </div>

                            </div>
                            <div class="appendnewquestion" count-answer="{{ count($question['answer']) }}">
                                {{-- <input type="hidden" value="{{$key=1}}"> --}}
                                @foreach ($question['answer'] as $key => $answer)
                                    {{-- {{++$key}} --}}
                                    <div class="row @if ($key>= 2) newcreate @endif">
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Câu Trả Lời</label>
                                                    <select class="form-control" name="correct_answer[]">
                                                        @if ($answer['correct_answer'] == 1)
                                                            <option style="color:red" value="0">False</option>
                                                            <option style="color:green" value="1" selected>True</option>
                                                        @else
                                                            <option style="color:red" value="0" selected>False</option>
                                                            <option style="color:green" value="1">True</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="answer[]"
                                                        id="answer-{{ ++$key }}"
                                                        required>{!! $answer['answer'] !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($key == 2)
                                            <div class="col-md-1">
                                                <a href="javascript:void(0)" class="addnewquestion"><i
                                                        class="fas fa-plus-circle fa-3x" style="margin-top:25px"></i></a>
                                            </div>
                                        @elseif($key>2)
                                            <div class="col-md-1">
                                                <a href="javascript:void(0)" class="delete-attr"><i
                                                        class="fas fa-minus-circle fa-3x" style="margin-top:25px"></i></a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                {{-- <div class="row">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Answer</label>
                                                <select class="form-control" name="correct_answer[]">
                                                    <option style="color:red" value="0" checked>False</option>
                                                    <option style="color:green" value="1">True</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <textarea class="form-control" name="answer[]" id="answer-2"
                                                    required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" class="addnewquestion"><i
                                                class="fas fa-plus-circle fa-3x" style="margin-top:25px"></i></a>
                                    </div>

                                </div> --}}
                            </div>
                        </div>
                        @if(Auth::guard('admin')->user()->role == -1)
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Chỉnh Sửa</button>
                        </div>
                        @endif
                        <!-- /.card -->
                    </div>
                </div>
            </section>
        </form>
        <!-- SELECT2 EXAMPLE -->
    </div>

@endsection
@push('script')
    {{-- <script src="//cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script> --}}
    {{-- <script src="//cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script> --}}
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor 4
        // instance, using default configuration.
        // CKEDITOR.replace('question');
        ClassicEditor
            .create(document.querySelector('#question'))
            .catch(error => {
                console.error(error);
            });
        // $('.answer').each(function(e) {
        //     CKEDITOR.replace(this.id);
        // });
        var count_answer = $('.appendnewquestion').attr('count-answer');
        // alert(count_answer);
        for ($i = 1; $i <= (count_answer); ++$i) {
            ClassicEditor
                .create(document.querySelector('#answer-' + $i))
                .catch(error => {
                    console.error(error);
                });
        }
        $(".delete-attr").click(function() {
            $(this).closest(".newcreate").remove();
        });

    </script>
@endpush
