
@extends('layouts.frontend.dashboard')
@section('content')
<?php
use Carbon\Carbon;
use App\Models\Result;
?>
    {{-- <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Exams</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">My Exams</h2>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <h3 class="pb-3">All Checked Questions</h3>

                    <div class="tab-pane show active" id="mentee-list">
                        <div class="card card-table">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>Answer</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $key=>$da)
                                            <tr>

                                                <td>
                                                    Question {{++$key}}
                                                </td>
                                                <td id="check-answer-{{$key}}">Answer not selected</td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table><br>
                                    <div class="pagination justify-content-center">
                                        <a href="{{url('/exam/'.$exam_id.'/subject/'.$subject_id.'/grade/'.$grade_id)}}" class="btn btn-primary">Return Exam</a>
                                        {{-- <button type="submit" class="btn btn-primary finish-exam"
                                        subject-id={{ $subject_id }} exam-id={{ $exam_id }}>Submit</button> --}}
                                    </div><br>
                                    <div class="pagination justify-content-center">
                                        {{-- <a class="btn btn-primary">Return Exam</a> --}}
                                        <button type="submit" class="btn btn-primary finish-exam"
                                        subject-id={{ $subject_id }} exam-id={{ $exam_id }}>Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        var total_page=localStorage.getItem('last_page');
        var total_keys=[];
        var total_answers=[];
        for(var i=1; i<=total_page; i++){
            total_keys.push(localStorage.getItem('key-'+i));
            total_answers.push(localStorage.getItem('answer_id-'+i));
        }
        // alert(total_questions);
        var xxx=[];
        var yyy=[];
        for(var i=0; i<total_keys.length; i++){
            var t=JSON.parse(total_keys[i]);
            var z=JSON.parse(total_answers[i]);
            if (t !== null) {
                t.forEach((element)=>{
                    xxx.push(element);
                });
            }
            if (z !== null) {
                z.forEach((element)=>{
                    yyy.push(element);
                });
            }
        }
        for(var i=0; i<xxx.length; i++){
            document.getElementById("check-answer-"+xxx[i]).innerHTML="Answer Selected";
        }
        $('.finish-exam').click(function(event) {
        // window.location.reload();
        var exam_id = $(this).attr('exam-id');
        var subject_id = $(this).attr('subject-id');
        // allanswers = [];
        // $('.sub_answer:checked').each(function() {
        //     xxx.push($(this).attr('answer-id'));
        // });
        Swal.fire({
            title: "Are you sure submit exam?",
            text: "You won't be able to return this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, submit exam!",
        }).then((result) => {
            if (result.isConfirmed) {

                // delete localStorage.seconds;
                // window.localStorage.removeItem('seconds');
                // localStorage.removeItem('seconds');
                var key = xxx.join(",");
                var all = yyy.join(",");
                $.ajax({
                    url: '/check-result-answer',
                    type: 'POST',
                    data: {
                        answer_ids: all,
                        key:key,
                        exam_id: exam_id,
                        subject_id: subject_id
                    },
                    success: function(resp) {
                        if (resp['status'] == true) {
                            window.location.href = "/result/exam/" + exam_id+'/subject/'+subject_id;
                            // localStorage.clear();

                        }
                    },
                    error: function(err) {
                        alert('ERROR');
                    }
                })
                localStorage.clear();
                localStorage.setItem('check', 1);
            }
        });

    });
    </script>

@endpush
