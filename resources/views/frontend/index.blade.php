@extends('layouts.frontend.dashboard')
@section('content')
<div class="breadcrumb-bar">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-12 col-12">
        <nav aria-label="breadcrumb" class="page-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bảng thông tin</li>
          </ol>
        </nav>
        <h2 class="breadcrumb-title">Bảng thông tin</h2>
      </div>
    </div>
  </div>
</div>


<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-8 col-md-12">
        <div class="row blog-grid-row">
          @foreach ($data as $exam)
          @if (!empty($exam['teacher']))
          <div class="col-md-6 col-sm-12">

            <div class="blog grid-blog">
              <div class="blog-image">
                <video width="400px" height="300px" controls>
                  <source src="{{$exam['video']}}" id="video_here">
                </video>
              </div>
              <div class="blog-content">
                <ul class="entry-meta meta-item">
                  <li>
                    <div class="post-author">
                      <a href="profile"><img src="{{ $exam['teacher']['image'] }}" style="width:50px;height:50px"
                          alt="Post Author">
                        <span>{{ $exam['teacher']['name'] }}</span></a>
                    </div>
                  </li>
                  <li><i class="far fa-clock"></i>{{ date('Y-m-d', strtotime($exam['created_at'])) }}
                  </li>
                </ul>
                <h3 class="blog-title"><a href="blog-details">{{ $exam['name'] }} mon
                    {{ $exam['subject']['name'] }}</a></h3>
                <p class="mb-0">Video kiến thức cho bài kiểm tra {{ $exam['name'] }}.</p>
              </div>
            </div>

          </div>
          @endif
          @endforeach
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="blog-pagination">
              <nav>
                <ul class="pagination justify-content-center">


                  {{ $data->links('pagination::simple-tailwind') }}
                </ul>
              </nav>
            </div>
          </div>
        </div>

      </div>

      <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

        <div class="card search-widget">
          <div class="card-body">
            <form action="{{ url('/dashboard') }}" method="GET" class="search-form">
              @csrf
              <div class="input-group">

                <input type="text" name="search" placeholder="Tìm kiếm..." class="form-control">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
              </div>
            </form>
          </div>
        </div>


        <div class="card post-widget">
          <div class="card-header">
            <h4 class="card-title">Môn học của tôi</h4>
          </div>
          <div class="card-body">
            <ul class="latest-posts">
              @foreach ($subjects as $subject)
              @if (in_array(Auth::guard('student')->user()->grade_id, explode(',', $subject['grade_id'])))
              @foreach ($subject['teacher'] as $teacher)
              @if (in_array(Auth::guard('student')->user()->class_id, explode(',', $teacher['class_id'])))
              <li>
                <div class="post-thumb">
                  <a>
                    <img class="img-fluid" src="{{ $teacher['image'] }}" style="height:80px; width:80px" alt="">
                  </a>
                </div>
                <div class="post-info">
                  <h4>
                    <a
                      href="{{ route('exam.subject.grade', ['subject_id' => $teacher['subject_id'], 'grade_id' => Auth::guard('student')->user()->grade_id]) }}">{{ $subject['name'] }}</a>
                  </h4>
                  <p>{{ $teacher['name'] }}</p>
                </div>
              </li>
              @endif
              @endforeach
              @endif
              @endforeach

            </ul>
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