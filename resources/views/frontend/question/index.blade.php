@extends('layouts.frontend.dashboard')
@section('content')
<?php

?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-lg-3 theiaStickySidebar">

                    <div class="card booking-card">
                        <div class="card-header">
                            <h4 class="card-title">Questions </h4>
                        </div>
                        <div class="card-body">
                            <div class="row pagination">
                                <input type="hidden" value="{{ $i = 1}}" id="data"
                                     grade_id="{{ $grade_id }}" exam_id="{{ $exam_id }}"
                                    subject_id="{{ $subject_id }}" questions_answers="{{$questions_answers}}">
                                @foreach ($questions_answers as $question_answer)
                                    @if (in_array($exam_id, explode(',', $question_answer['select_id'])) || $exam_id == $question_answer['exam_id'])
                                        <div class="col-3">
                                            <div id="check-selected-question-{{ $question_answer['id'] }}"
                                                key-id="{{ $i }}">
                                                <a role="button" class="btn btn-success visit-to-question"
                                                    style="width:50px" question-id="{{ $question_answer['id'] }}"
                                                    href="javascript:void(0)">{{ $i++ }}</a>
                                            </div>
                                        </div>
                                        @if ($i % 4 == 0)<br><br>@endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="pagination row">
                                <div class="col-8 checktime">
                                    <p id="countdown" class="timer" exam-id="{{ $exam_id }}"
                                        time="{{ $exam['time'] }}"></p>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary finish-exam"
                                        subject-id={{ $subject_id }} exam-id={{ $exam_id }}>Submit</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-md-7 col-lg-9">

                    <div class="card" id="table_data">
                        {{-- <div class="card-body">
                            <input type="hidden" value="{{ $i = ($data->currentpage() - 1) * $data->perpage() + 1 }}" id="data">
                            @foreach ($data as $key => $question_answer)
                                <div class="info-widget">
                                    Question {{ $i++ }} <p>{{ $question_answer['question'] }}</p>
                                    @if (!empty($question_answer['image']))
                                        <img src="{{ $question_answer['image'] }}" width="200px" height="200px"><br><br>
                                    @endif
                                    @if (!empty($question_answer['file_listen']))
                                        <audio controls>
                                            <source src="{{ $question_answer['file_listen'] }}" type="audio/mpeg">
                                        </audio><br><br>
                                    @endif
                                    Select one:
                                    @foreach ($question_answer['answer'] as $answer)
                                        <h5><input type="radio" value="{{ $answer['id'] }}" class="sub_answer"
                                                name="{{ $question_answer['id'] }}" id="answer-{{ $answer['id'] }}"
                                                question-id="{{ $question_answer['id'] }}"
                                                answer-id="{{ $answer['id'] }}">&nbsp;&nbsp;{{ $answer['answer'] }}
                                        </h5>
                                    @endforeach
                                </div>
                            @endforeach
                            <div class="pagination justify-content-center">
                                {{ $data->links('pagination::bootstrap-4') }}
                            </div>
                        </div> --}}
                        <div class="card-body">
                            <input type="hidden" value="{{ $i = ($data->currentpage() - 1) * $data->perpage() + 1 }}" id="example" current-page="{{$data->currentpage()}}" last-page="{{$data->lastpage()}}">
                            @foreach ($data as $key => $question_answer)
                                {{-- @if (in_array($exam_id, explode(',', $question_answer['select_id'])) || $exam_id == $question_answer['exam_id']) --}}
                                <div class="info-widget">
                                    Question {{ $i++ }} <p>{{ $question_answer['question'] }}</p>
                                    @if (!empty($question_answer['image']))
                                        <img src="{{ $question_answer['image'] }}" width="200px" height="200px"><br><br>
                                    @endif
                                    @if (!empty($question_answer['file_listen']))
                                        <audio controls>
                                            <source src="{{ $question_answer['file_listen'] }}" type="audio/mpeg">
                                        </audio><br><br>
                                    @endif
                                    Select one:
                                    @foreach ($question_answer['answer']->shuffle() as $answer)
                                        <h5><input type="radio" value="{{ $answer['id'] }}" class="sub_answer"
                                                name="{{ $question_answer['id'] }}" id="answer-{{ $answer['id'] }}"
                                                question-id="{{ $question_answer['id'] }}"
                                                answer-id="{{ $answer['id'] }}">&nbsp;&nbsp;{{ $answer['answer'] }}
                                        </h5>
                                    @endforeach
                                </div>
                                {{-- @endif --}}
                            @endforeach
                            <div class="pagination justify-content-center">
                                {{ $data->links('pagination::bootstrap-4') }}
                            </div>
                        </div>


                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')

    {{-- <script>
        $('#question_answer').DataTable();
    </script> --}}
    <script>
        var exam_id=$('#data').attr('exam_id');
        var subject_id=$('#data').attr('subject_id');
        var grade_id=$('#data').attr('grade_id');
        if(sessionStorage.getItem('questions_answers')){
            var questions_answers=$('#data').attr('questions_answers');
        }else{
            sessionStorage.setItem('questions_answers', (questions_answers));
            // setCookie('questions_answers', localStorage.getItem('questions_answers'));
        }
        // setcookie('questions_answers', $questions_answers, time()+60*60*24*365, '/exam/'+exam_id+'/subject/'+subject_id+'/grade/'+grade_id);
        var current_page=$('#example').attr('current-page');
        // var number_questions=$('#example').attr('number-questions');
        var last_page=$('#example').attr('last-page');
        // alert(last_page);


        // alert(data);
        // alert(stt_page);
        $("input[type=\"radio\"]").click(function() {
            //localStorage:
            var alleds = [];
            $('.sub_answer:checked').each(function() {
                    alleds.push($(this).attr('answer-id'));
                //
            });
            // alert(alleds);
            localStorage.setItem("option-"+current_page,JSON.stringify(alleds));

        });
        var itemValue = JSON.parse(localStorage.getItem("option-"+current_page));
        // alert(itemValue);
        if (itemValue !== null) {
            itemValue.forEach((element) => {
                // console.log(element);
                $('#answer-' + element).prop('checked', true);
            })
        }
        var all_answers=[];
        var all_questions=[];
        var all_keys=[];
        for (var i = 1; i <=last_page; i++) {
            all_answers.push(localStorage.getItem('option-'+i));
            all_questions.push(localStorage.getItem('question_id-'+i));
            all_keys.push(localStorage.getItem('key-'+i));
        }

    // alert(JSON.parse(all_answers[0]));
        var xxx=[];
        var yyy=[];
        var zzz=[];
        for(var i=0; i<all_answers.length; i++) {
            var t=JSON.parse(all_answers[i]);
            var k=JSON.parse(all_questions[i]);
            var j=JSON.parse(all_keys[i]);
            if (t !== null) {
            t.forEach((element)=>{
                xxx.push(element);
            });
        }
            if (k !== null) {
            k.forEach((element)=>{
                yyy.push(element);
            });
        }
            if (j !== null) {
            j.forEach((element)=>{
                zzz.push(element);
            });
        }
        }
        // alert(xxx);
        //localStorage:
        $('.sub_answer').click(function() {
            var alleds = [];
            var keys = [];
            $('.sub_answer:checked').each(function() {
                alleds.push($(this).attr('question-id'));
                keys.push($('#check-selected-question-' + $(this).attr('question-id')).attr('key-id'));
            });
            var question_id = $(this).attr('question-id');
            // alert(question_id);
            var key = $('#check-selected-question-' + question_id).attr('key-id');
            // alert(key)
            localStorage.setItem('question_id-'+current_page, JSON.stringify(alleds));
            localStorage.setItem('key-'+current_page, JSON.stringify(keys));
            $('#check-selected-question-' + question_id).html(
                '<a role="button" class="btn btn-primary visit-to-question" style="width:50px" question-id="' +
                question_id + '" href="javascript:void(0)">' + key + '</a>'
            );

        });
        var itemQuestion = JSON.parse(localStorage.getItem("question_id-"+current_page));

        var itemKey = JSON.parse(localStorage.getItem("key-"+current_page));
        if (itemQuestion !== null) {
            itemQuestion.forEach((element, index) => {
                // console.log(element);
                $('#check-selected-question-' + element).html(
                    '<a role="button" class="btn btn-primary visit-to-question" style="width:50px" question-id="' +
                    element + '" href="javascript:void(0)">' + itemKey[index] + '</a>'
                );
            })
        }
        if (yyy !== null) {
            yyy.forEach((element, index) => {
                // console.log(element);
                $('#check-selected-question-' + element).html(
                    '<a role="button" class="btn btn-primary visit-to-question" style="width:50px" question-id="' +
                    element + '" href="javascript:void(0)">' + zzz[index] + '</a>'
                );
            })
        }
        // alert(xxx);
        if (localStorage.getItem("check")) {

            localStorage.clear();
            var seconds = 60 * parseInt($('#countdown').attr('time'));

        }
        if (localStorage.getItem("seconds")) {
            var seconds = localStorage.getItem("seconds");
        } else {

            var seconds = 60 * parseInt($('#countdown').attr('time'));
            // localStorage.clear();
        }
        var exam_id = $('#countdown').attr('exam-id');
        // var seconds = initialTime;

        function timer() {
            var days = Math.floor(seconds / 24 / 60 / 60);
            var hoursLeft = Math.floor((seconds) - (days * 86400));
            var hours = Math.floor(hoursLeft / 3600);
            var minutesLeft = Math.floor((hoursLeft) - (hours * 3600));
            var minutes = Math.floor(minutesLeft / 60);
            var remainingSeconds = seconds % 60;
            if (remainingSeconds < 10) {

                remainingSeconds = "0" + remainingSeconds;
            }

            document.getElementById('countdown').innerHTML = hours + "h " + minutes + "m " +
                remainingSeconds + "s";

            if (seconds == 0) {
                // clearInterval(countdownTimer);
                // localStorage.clear();
                var exam_id = $(this).attr('exam-id');
                var subject_id = $('.finish-exam').attr('subject-id');
                // allanswers = [];
                $('.sub_answer:checked').each(function() {
                    xxx.push($(this).attr('answer-id'));
                });

                var all = xxx.join(",");
                $.ajax({
                    url: '/check-result-answer',
                    type: 'POST',
                    data: {
                        answer_ids: all,
                        exam_id: exam_id,
                        subject_id: subject_id
                    },
                    success: function(resp) {
                        if (resp['status'] == true) {
                            window.location.href = "/result/exam/" + exam_id+'/subject/'+subject_id;
                        }
                    },
                    error: function(err) {
                        alert('ERROR');
                    }
                });
                localStorage.clear();
                localStorage.setItem('check', 1);
                // localStorage.clear();
            }  else {
                if (seconds <= 10) {
                $('.checktime').html(
                    '<p id="countdown" class="timer btn btn-danger"></p>'
                );
                seconds--;
                // if (!localStorage.getItem("new_seconds")) {
                localStorage.setItem("seconds", (seconds));
                // }else{
                //     localStorage.setItem("new_seconds", (seconds));
                // }
                setTimeout("timer()", 1000);
            }else{
                // localStorage.removeItem('seconds');
                // localStorage.removeItem('seconds');
                seconds--;
                // if (!localStorage.getItem("new_seconds")) {
                localStorage.setItem("seconds", (seconds));
                // }else{
                //     localStorage.setItem("new_seconds", (seconds));
                // }
                setTimeout("timer()", 1000);
            }
                // clearInterval(seconds);

            }
        }
        setTimeout("timer()", 1000);
        // localStorage.clear();


        $('.finish-exam').click(function(event) {
            // window.location.reload();
            var exam_id = $(this).attr('exam-id');
            var subject_id = $(this).attr('subject-id');
            // allanswers = [];
            $('.sub_answer:checked').each(function() {
                xxx.push($(this).attr('answer-id'));
            });
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
                    sessionStorage.removeItem('questions_answers');
                    var all = xxx.join(",");
                    $.ajax({
                        url: '/check-result-answer',
                        type: 'POST',
                        data: {
                            answer_ids: all,
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
        // window.onbeforeunload = function() {
        //     localStorage.clear();
        //     return '';
        // };

    </script>

@endpush
