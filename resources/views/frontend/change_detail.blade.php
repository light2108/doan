@extends('layouts.frontend.dashboard')
@section('content')
<div class="breadcrumb-bar">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-12 col-12">
        <nav aria-label="breadcrumb" class="page-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cài đặt thông tin</li>
          </ol>
        </nav>
        <h2 class="breadcrumb-title">Cài đặt thông tin</h2>
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
    </div>
  </div>
</div>


<div class="content">
  <div class="container-fluid">
    <div class="row">

      <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">

        <div class="profile-sidebar">
          <div class="user-widget">
            {{-- <div class="pro-avatar"> --}}
            <img src="{{ $student['image'] }}" id="output" class="pro-avatar">
            {{-- </div> --}}

            <div class="user-info-cont">
              <h4 class="usr-name">{{ $student['name'] }}</h4>
              <p class="mentor-type">
                Mã học sinh: {{ $student['student_code'] }}
              </p>
            </div>
          </div>
          <div class="progress-bar-custom">
            <h6>Hoàn thành thông tin cá nhân ></h6>
            <div class="pro-progress">
              <div class="tooltip-toggle" tabindex="0"></div>
              <div class="tooltip">80%</div>
            </div>
          </div>
          {{-- <div class="custom-sidebar-nav">
                        <ul>
                            <li><a href="dashboard"><i class="fas fa-home"></i>Dashboard <span><i
                                            class="fas fa-chevron-right"></i></span></a></li>
                            <li><a href="bookings"><i class="fas fa-clock"></i>Bookings <span><i
                                            class="fas fa-chevron-right"></i></span></a></li>
                            <li><a href="schedule-timings"><i class="fas fa-hourglass-start"></i>Schedule Timings
                                    <span><i class="fas fa-chevron-right"></i></span></a></li>
                            <li><a href="chat"><i class="fas fa-comments"></i>Messages <span><i
                                            class="fas fa-chevron-right"></i></span></a></li>
                            <li><a href="blog"><i class="fab fa-blogger-b"></i>Blog <span><i
                                            class="fas fa-chevron-right"></i></span></a></li>
                            <li><a href="profile"><i class="fas fa-user-cog"></i>Profile <span><i
                                            class="fas fa-chevron-right"></i></span></a></li>
                            <li><a href="login"><i class="fas fa-sign-out-alt"></i>Logout <span><i
                                            class="fas fa-chevron-right"></i></span></a></li>
                        </ul>
                    </div> --}}
        </div>

      </div>

      <div class="col-md-7 col-lg-8 col-xl-9">
        <div class="card">
          <div class="card-body">

            <form action={{ url('/change-detail') }} method="post" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-6 col-md-6">
                  <div class="form-group">
                    <label>Họ & tên<nav></nav></label>
                    <input type="text" class="form-control" name="name" value="{{ $student['name'] }}" readonly="">
                  </div>
                </div>
                <div class="col-6 col-md-6">
                  <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="number" value="{{ $student['mobile'] }}" class="form-control" name="mobile" required>
                  </div>
                </div>
                <div class="col-6 col-md-6">
                  <div class="form-group">
                    <label>Ảnh </label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image" id="exampleInputFile"
                          onchange="loadfile(event)">
                      </div>

                    </div>
                  </div>
                </div>

                <div class="col-6 col-md-6">
                  <div class="form-group">
                    <label>Mật khẩu hiện tại</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                    <span id="chkpwd"></span>
                  </div>
                </div>
                <div class="col-6 col-md-6">
                  <div class="form-group">
                    <label>Đổi mật khẩu mới</label>
                    <input type="password" class="form-control" name="new_password" required>
                  </div>
                </div>
                <div class="col-6 col-md-6">
                  <div class="form-group">
                    <label>Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" name="confirm_password" required>
                  </div>
                </div>
              </div>
              <div class="submit-section">
                <button type="submit" class="btn btn-primary submit-btn">Lưu thay đổi</button>
              </div>
            </form>
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