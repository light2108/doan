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
            <li class="breadcrumb-item"><a href="index">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Exams</li>
          </ol>
        </nav>
        <h2 class="breadcrumb-title">My Exams</h2>
      </div>
    </div>
  </div>
</div>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 col-lg-12 col-xl-12">
        <h3 class="pb-3">All Exams</h3>

        <div class="tab-pane show active" id="mentee-list">
          <div class="card card-table">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover table-center mb-0">
                  <thead>
                    <tr>
                      <th>Giáo Viên</th>
                      <th>Tên bài kiểm tra</th>
                      <th>Thời gian làm bài</th>
                      <th>Số lượt làm</th>
                      <th>Thời gian bắt đầu</th>
                      <th>Thời gian kết thúc</th>
                      <th>Trạng thái</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($subject_exams as $subject_exam)
                    @if (in_array(Auth::guard('student')->user()->class_id, explode(',', $subject_exam['class_id'])))
                    <tr>
                      <td>
                        <h2 class="table-avatar">
                          <a href="profile" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle"
                              src="{{ $subject_exam['teacher']['image'] }}" alt="User Image"></a>
                          <a href="profile">{{ $subject_exam['teacher']['name'] }}<span><span
                                class="__cf_email__"></span>{{ $subject_exam['teacher']['email'] }}</span></a>
                        </h2>
                      </td>
                      <td>{{ $subject_exam['name'] }}</td>
                      <td>
                        {{isset($subject_exam['time'])?$subject_exam['time']:(strtotime($subject_exam['end_time'])-strtotime($subject_exam['start_time']))/60}} phút
                      </td>
                      <td>
                          @if($subject_exam['multiple']==0)
                            Vô số
                          @else
                          {{$subject_exam['multiple']}}
                          @endif
                      </td>
                      <td><span class="pending">{{ date('d/m/Y H:i:s', strtotime($subject_exam['start_time'])) }}</span>
                      </td>
                      <td><span class="pending">{{ date('d/m/Y H:i:s', strtotime($subject_exam['end_time'])) }}</span>
                      </td>
                      <td>
                        @if(strtotime($subject_exam['end_time'])<strtotime(Carbon::now()))
                        <a class="btn btn-sm bg-info-light"
                        href="{{url('/result/exam/'.$subject_exam['id'].'/subject/'.$subject_exam['subject_id'])}}"><i
                          class="far fa-eye"></i>
                        Xem kết quả</a>
                        @else
                            @if(strtotime($subject_exam['start_time'])<=strtotime(Carbon::now()))
                                @if($subject_exam['multiple']==0)
                                <a href="javascript:void(0)" data-exam={{ $subject_exam['id'] }}
                                data-subject={{ $subject_exam['subject_id'] }} data-grade={{ $subject_exam['grade_id'] }}
                                {{Session::put('questions_answers', Question::with(['answer'=>function($q){
                                                                                $q->inRandomOrder();
                                                                            }])->where('status',1)->inRandomOrder()->get())}} class=" btn btn-sm
                                bg-info-light visit-exam-password">
                                <i class="far fa-eye"></i>
                                Làm bài</a>
                                @elseif($subject_exam['multiple']!=0&&$subject_exam['multiple']<=count(Result::where('exam_id', $subject_exam['id'])->get()))
                                <a href="javascript:void(0)" data-exam={{ $subject_exam['id'] }}
                                data-subject={{ $subject_exam['subject_id'] }} data-grade={{ $subject_exam['grade_id'] }}
                                {{Session::put('questions_answers', Question::with(['answer'=>function($q){
                                                                                $q->inRandomOrder();
                                                                            }])->where('status',1)->inRandomOrder()->get())}} class=" btn btn-sm
                                bg-info-light visit-exam-password">
                                <i class="far fa-eye"></i>
                                Làm bài</a>
                                @else
                                <a class="btn btn-sm bg-info-light"
                                href="{{url('/result/exam/'.$subject_exam['id'].'/subject/'.$subject_exam['subject_id'])}}"><i
                                  class="far fa-eye"></i>
                                Xem kết quả</a>
                                @endif
                            @else
                            <a class="btn btn-sm bg-info-light"
                            href="{{url('/exam/subject/'.$subject_exam['subject_id'].'/grade/'.Auth::guard('student')->user()->grade_id)}}"><i
                              class="far fa-eye"></i>
                            Chưa đến giờ</a>
                            @endif
                        @endif
                      </td>
                      {{-- <!-- <td>
                        @if(date('Y-m-d H:i:s', strtotime($subject_exam['start_time']))<=date('Y-m-d H:i:s',
                          strtotime(Carbon::now()))) @if (!empty($subject_exam['password'])) @if(date('Y-m-d H:i:s',
                          strtotime($subject_exam['end_time']))>=date('Y-m-d H:i:s',
                          strtotime(Carbon::now()))&&empty(Result::where('exam_id',
                          $subject_exam['id'])->where('student_id', Auth::guard('student')->user()->id)))
                          <a href="javascript:void(0)" data-exam={{ $subject_exam['id'] }}
                            data-subject={{ $subject_exam['subject_id'] }} data-grade={{ $subject_exam['grade_id'] }}
                            {{Session::put('questions_answers', Question::with(['answer'=>function($q){
                                                                            $q->inRandomOrder();
                                                                        }])->where('status',1)->inRandomOrder()->get())}} class=" btn btn-sm
                          bg-info-light visit-exam-password">
                          <i class="far fa-eye"></i>
                          Enter Exam</a>
                        @elseif(date('Y-m-d H:i:s', strtotime($subject_exam['end_time']))>=date('Y-m-d H:i:s',
                        strtotime(Carbon::now()))&&!empty(Result::where('exam_id',
                        $subject_exam['id'])->where('student_id', Auth::guard('student')->user()->id)))
                        <a class="btn btn-sm bg-info-light"
                          href="{{url('/result/exam/'.$subject_exam['id'].'/subject/'.$subject_exam['subject_id'])}}"><i
                            class="far fa-eye"></i>
                          Enter Exam</a>
                        @else
                        <a class="btn btn-sm bg-info-light"
                          href="{{url('/result/exam/'.$subject_exam['id'].'/subject/'.$subject_exam['subject_id'])}}"><i
                            class="far fa-eye"></i>
                          Enter Exam</a>
                        @endif

                        @else
                        <a @if(
                          strtotime(Carbon::now())-strtotime($subject_exam['end_time'])>0||Result::where('exam_id',
                          $subject_exam['id'])->where('student_id', Auth::guard('student')->user()->id)->count()>0)
                          href="{{url('/result/exam/'.$subject_exam['id'].'/subject/'.$subject_exam['subject_id'])}}"
                          @endif
                          @if(!empty(Result::where('exam_id', $subject_exam['id'])->where('student_id',
                          Auth::guard('student')->user()->id)->first()->score))
                          @if($subject_exam['multiple']!=0&&$subject_exam['multiple']
                          <count(explode(",",Result::where('exam_id', $subject_exam['id'])->where('student_id',
                            Auth::guard('student')->user()->id)->first()->score)))
                            href="{{url('/result/exam/'.$subject_exam['id'].'/subject/'.$subject_exam['subject_id'])}}"
                            @else
                            href="{{ url('/exam/' . $subject_exam['id'] . '/subject/' . $subject_exam['subject_id'] . '/grade/' . $subject_exam['grade_id'].'/'.$code) }}"
                            @endif

                            @else
                            href="{{ url('/exam/' . $subject_exam['id'] . '/subject/' . $subject_exam['subject_id'] . '/grade/' . $subject_exam['grade_id'].'/'.$code) }}"
                            @endif data-exam={{ $subject_exam['id'] }}
                            data-subject={{ $subject_exam['subject_id'] }}
                            data-grade={{ $subject_exam['grade_id'] }}
                            {{Session::put('questions_answers', Question::with(['answer'=>function($q){
                                                                        $q->inRandomOrder();
                                                                    }])->where('status',1)->inRandomOrder()->get())}}
                            class="btn btn-sm bg-info-light visit-exam"><i class="far fa-eye"></i>
                            Enter Exam
                        </a>
                        @endif
                        @else
                        <a class="btn btn-sm bg-info-light"
                          href="{{url('/exam/subject/'.$subject_exam['subject_id'].'/grade/'.$subject_exam['grade_id'])}}"><i
                            class="far fa-eye"></i>
                          Enter Exam</a>
                        @endif
                      </td> --> --}}
                    </tr>
                    @endif
                    @endforeach
                  </tbody>
                </table>
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
localStorage.clear();
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
