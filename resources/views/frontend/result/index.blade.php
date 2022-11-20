@extends('layouts.frontend.dashboard')
@section('content')
<?php

use Carbon\Carbon;
use App\Models\Result;
use App\Models\Question;
use Illuminate\Support\Facades\Session;
?>
<div class="breadcrumb-bar">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-12 col-12">
        <nav aria-label="breadcrumb" class="page-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kết quả</li>
          </ol>
        </nav>
        <h2 class="breadcrumb-title">Điểm kiểm tra</h2>
      </div>
    </div>
  </div>
</div>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 col-lg-12 col-xl-12">
        <h3 class="pb-3">Tất cả kết quả kiểm tra</h3>

        <div class="tab-pane show active" id="mentee-list">
          <div class="card card-table">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover table-center mb-0">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Bải kiểm tra</th>
                      <th>Môn học</th>
                      <th>Thời gian</th>
                      <th>Điểm</th>
                    </tr>
                  </thead>
                  <tbody>
                    <input type="hidden" value="{{ $k = 1 }}">
                    @foreach ($results as $key=>$result)

                    <tr>
                      <td>{{ $k++ }}</td>
                      <td>
                        {{ $exam['name'] }}
                      </td>
                      <td>
                        @foreach ($subjects as $subject)
                        @if ($subject['id'] == $result['subject_id'])
                        {{ $subject['name'] }}
                        @endif
                        @endforeach
                      </td>
                      <td>{{ date('Y-m-d', strtotime($result['time'])) }}</td>
                      <td>{{ $result['score'] }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>

              </div>

            </div>
          </div>
          <div class="card success-card">
            <div class="card-body">
              <div class="success-cont">
                <h4>Bài có điểm cao nhất: {{max($maxscore)}}</h4>
                @if($exam['multiple']==0)
                @if (strtotime($exam['end_time'])<strtotime(Carbon::now())) <a
                  href="{{url('/dashboard')}}" class="btn btn-primary view-inv-btn">Quay về trang chủ</a>
                  @else
                  <a href="{{url('/exam/'.$exam['id'].'/subject/'.$exam['subject_id'].'/grade/'.$exam['grade_id'].'/'.$code)}}"
                    class="btn btn-primary view-inv-btn" {{Session::put('questions_answers', Question::with(['answer'=>function($q){
                                                $q->inRandomOrder();
                                            }])->where('status',1)->inRandomOrder()->get())}}>Tiếp tục làm bài</a>
                  @endif
                  @elseif (strtotime($exam['end_time'])<
                    strtotime(Carbon::now())||$exam['multiple']<=count(explode(",",$result['score']))) <a
                    href="{{url('/dashboard')}}" class="btn btn-primary view-inv-btn">Quay về trang chủ</a>

                    @else
                    <a href="{{url('/exam/'.$exam['id'].'/subject/'.$exam['subject_id'].'/grade/'.$exam['grade_id'].'/'.$code)}}"
                      class="btn btn-primary view-inv-btn" {{Session::put('questions_answers', Question::with(['answer'=>function($q){
                                        $q->inRandomOrder();
                                    }])->where('status',1)->inRandomOrder()->get())}}>Tiếp tục làm bài</a>
                    @endif
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
if (localStorage.getItem("check")) {

  localStorage.clear();
  // var seconds = 60 * parseInt($('#countdown').attr('time'));

}
if (localStorage.getItem("seconds")) {
  var seconds = localStorage.getItem("seconds");
}
// } else {

//     var seconds = 60 * parseInt($('#countdown').attr('time'));
//     // localStorage.clear();
// }
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

  // document.getElementById('countdown').innerHTML = hours + "h " + minutes + "m " +
  //     remainingSeconds + "s";

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
      // $('.checktime').html(
      //     '<p id="countdown" class="timer btn btn-danger"></p>'
      // );
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
</script>
@endpush
