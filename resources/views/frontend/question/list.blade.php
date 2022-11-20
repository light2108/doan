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
                            <li class="breadcrumb-item"><a href="index">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bài kiểm tra</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Bài kiểm tra</h2>
                </div>
            </div>
        </div>
    </div> --}}
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5 col-lg-3 theiaStickySidebar">

        <div class="card booking-card">
          <div class="card-header">
            <h4 class="card-title">Câu hỏi</h4>
          </div>
          <div class="card-body">
            <div class="row pagination">
              <input type="hidden" value="{{ $i = 1 }}" id="data" grade_id="{{ $grade_id }}" exam_id="{{ $exam_id }}"
                subject_id="{{ $subject_id }}" questions_answers="{{ $questions_answers }}">
              @foreach ($questions_answers as $question_answer)
              @if (in_array($exam_id, explode(',', $question_answer['select_id'])) || $exam_id ==
              $question_answer['exam_id'])
              <div class="col-3">
                <div id="check-selected-question-{{ $question_answer['id'] }}" key-id="{{ $i }}"
                  class="check-selected-question">
                  <a role="button" class="btn btn-success visit-to-question" style="width:50px"
                    question-id="{{ $question_answer['id'] }}" href="javascript:void(0)">{{ $i++ }}</a>
                </div>
              </div>
              @if ($i % 4 == 0)<br><br>@endif
              @endif
              @endforeach
            </div>
          </div>
          <div class="card-footer">
            <div class="pagination row">
              <div class="col-6 checktime">
                <p id="countdown" class="timer" exam-id="{{ $exam_id }}"
                  time="{{ !empty($exam['time'])?$exam['time']:(strtotime($exam['end_time'])-strtotime($exam['start_time'])/3600) }}">
                </p>
              </div>

            </div>

          </div>
        </div>

      </div>
      <div class="col-md-7 col-lg-9">
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
                    @foreach ($data as $key => $da)
                    <tr>

                      <td>
                        Question {{ ++$key }}
                      </td>
                      <td id="check-answer-{{ $key }}">Answer not selected</td>

                    </tr>
                    @endforeach
                  </tbody>
                </table><br>
                <div class="pagination justify-content-center">
                  <a href="{{ url('/exam/' . $exam_id . '/subject/' . $subject_id . '/grade/' . $grade_id.'/'.$code) }}"
                    class="btn btn-primary">Return Exam</a>
                  {{-- <button type="submit" class="btn btn-primary finish-exam"
                                        subject-id={{ $subject_id }} exam-id={{ $exam_id }}>Submit</button> --}}
                </div><br>
                <div class="pagination justify-content-center">
                  {{-- <a class="btn btn-primary">Return Exam</a> --}}
                  <button type="submit" class="btn btn-primary finish-exam" subject-id={{ $subject_id }}
                    exam-id={{ $exam_id }}>Submit</button>
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
var total_page = localStorage.getItem('last_page');
var total_keys = [];
var total_answers = [];
var total_questions = [];
for (var i = 1; i <= total_page; i++) {
  total_keys.push(localStorage.getItem('key-' + i));
  total_answers.push(localStorage.getItem('answer_id-' + i));
  total_questions.push(localStorage.getItem('question_id-' + i));
}
// alert(total_questions);
var xxx = [];
var yyy = [];
var zzz = [];
for (var i = 0; i < total_keys.length; i++) {
  var x = JSON.parse(total_keys[i]);
  var y = JSON.parse(total_answers[i]);
  var z = JSON.parse(total_questions[i]);
  if (x !== null) {
    x.forEach((element) => {
      xxx.push(element);
    });
  }
  if (y !== null) {
    y.forEach((element) => {
      yyy.push(element);
    });
  }
  if (z !== null) {
    z.forEach((element) => {
      zzz.push(element);
    });
  }
}
var unique = [];
for (var i = 0; i < zzz.length; i++) {
  if (unique.indexOf(zzz[i]) === -1) {
    unique.push(zzz[i]);
  }

}
var unikey = [];
for (var i = 0; i < xxx.length; i++) {
  if (unikey.indexOf(xxx[i]) === -1) {
    unikey.push(xxx[i]);
  }

}

for (var i = 0; i < unikey.length; i++) {
  document.getElementById("check-answer-" + unikey[i]).innerHTML = "Answer Selected";
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
      var key = unikey.join(",");
      var ans = yyy.join(",");
      var ques = unique.join(",");
      $.ajax({
        url: '/check-result-answer',
        type: 'POST',
        data: {
          answer_ids: ans,
          question_ids: ques,
          key: key,
          exam_id: exam_id,
          subject_id: subject_id
        },
        success: function(resp) {
          if (resp['status'] == true) {
            window.location.href = "/result/exam/" + exam_id + '/subject/' +
              subject_id;
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
// var exam_id = $('#countdown').attr('exam-id');
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

  document.getElementById('countdown').innerHTML =hours + "h " + minutes + "m " +
    remainingSeconds + "s";

  if (seconds == 0) {
    // clearInterval(countdownTimer);
    // localStorage.clear();
    var exam_id = localStorage.getItem('exam_id');
    var subject_id = localStorage.getItem('subject_id');
    // allanswers = [];
    // $('.sub_answer:checked').each(function() {
    //     xxx.push($(this).attr('answer-id'));
    // });
    var key = unikey.join(",");
    var ans = yyy.join(",");
    var ques = unique.join(",");
    $.ajax({
      url: '/check-result-answer',
      type: 'POST',
      data: {
        answer_ids: ans,
        question_ids: ques,
        key: key,
        exam_id: exam_id,
        subject_id: subject_id
      },
      success: function(resp) {
        if (resp['status'] == true) {
          window.location.href = "/result/exam/" + exam_id + '/subject/' + subject_id;
        }
      },
      error: function(err) {
        alert('ERROR');
      }
    });
    localStorage.clear();
    localStorage.setItem('check', 1);
    // localStorage.clear();
  } else {
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
    } else {
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
if (zzz !== null) {
  zzz.forEach((element, index) => {
    // console.log(element);
    $('#check-selected-question-' + element).html(
      '<a role="button" class="btn btn-primary visit-to-question" style="width:50px" question-id="' +
      element + '" href="javascript:void(0)">' + xxx[index] + '</a>'
    );

  })
}
</script>

@endpush
