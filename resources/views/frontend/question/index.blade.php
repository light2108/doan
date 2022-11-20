@extends('layouts.frontend.dashboard')
@section('content')
<?php

use App\Models\Answer; ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5 col-lg-3 theiaStickySidebar">

        <div class="card booking-card">
          <div class="card-header">
            <h4 class="card-title">Questions</h4>
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
              {{-- {{$each_data->links('pagination::bootstrap-4')}} --}}
            </div>
          </div>
          <div class="card-footer">
            <div class="pagination row">
              <div class="col-6 checktime">
                <p id="countdown" class="timer" exam-id="{{ $exam_id }}" subject-id="{{$subject_id}}"
                  time="{{ (isset($exam['time'])?$exam['time']:( strtotime($exam['end_time'])-strtotime($exam['start_time']))/60) }}">
                </p>
              </div>
              <div class="col-6">
                {{-- <button type="submit" class="btn btn-primary finish-exam"
                                        subject-id={{ $subject_id }} exam-id={{ $exam_id }}>Submit</button> --}}
                <a href="{{ url('/exam-list-question/' . $exam_id . '/subject/' . $subject_id . '/grade/' . $grade_id.'/'.$code) }}"
                  style="color:orange">Nộp bài...</a>
              </div>
            </div>

          </div>
        </div>

      </div>
      <div class="col-md-7 col-lg-9"  id="table_data_xxx">
        <div class="card" >

            <div class="card-body" >
              <input type="hidden" value="{{ $i = ($data->currentpage() - 1) * $data->perpage() + 1 }}" id="example"
                current-page="{{ $data->currentpage() }}" last-page="{{ $data->lastpage() }}">
                @foreach ($data as $key => $question_answer)
                {{-- @if (in_array($exam_id, explode(',', $question_answer['select_id'])) || $exam_id == $question_answer['exam_id']) --}}
                <div class="info-widget">
                  Question {{ $i++ }}
                  <p>{{ $question_answer['question'] }}</p>
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
                  @if (Answer::where('question_id', $question_answer['id'])->where('correct_answer', 1)->count() > 1)
                  <h5><input type="radio" value="{{ $answer['id'] }}" class="sub_answer sub_answer_multiple"
                      name="{{ $answer['id'] }}" id="answer-{{ $answer['id'] }}" question-id="{{ $question_answer['id'] }}"
                      key="{{ $i }}" answer-id="{{ $answer['id'] }}">&nbsp;&nbsp;{{ $answer['answer'] }}
                  </h5>
                  @else
                  <h5><input type="radio" value="{{ $answer['id'] }}" class="sub_answer" name="{{ $question_answer['id'] }}"
                      id="answer-{{ $answer['id'] }}" question-id="{{ $question_answer['id'] }}" key="{{ $i }}"
                      answer-id="{{ $answer['id'] }}">&nbsp;&nbsp;{{ $answer['answer'] }}
                  </h5>
                  @endif
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
// setcookie('questions_answers', $questions_answers, time()+60*60*24*365, '/exam/'+exam_id+'/subject/'+subject_id+'/grade/'+grade_id);
var current_page = $('#example').attr('current-page');
// var number_questions=$('#example').attr('number-questions');
var last_page = $('#example').attr('last-page');
// alert(last_page);
localStorage.setItem('last_page', last_page);
localStorage.setItem('exam_id', $('#countdown').attr('exam-id'));
localStorage.setItem('subject_id', $('#countdown').attr('subject-id'));
// alert(data);
// alert(stt_page);
$(".sub_answer").click(function() {
  //localStorage:
  if ($(this).data('checked') == true) {
    $(this).prop('checked', false).data('checked', false);

  } else {
    $(this).data('checked', true);

  }
  var alleds = [];
  $('.sub_answer:checked').each(function() {
    alleds.push($(this).attr('answer-id'));
    //
  });
  // alert(alleds);
  localStorage.setItem("answer_id-" + current_page, JSON.stringify(alleds));

});
var itemValue = JSON.parse(localStorage.getItem("answer_id-" + current_page));
// alert(itemValue);
if (itemValue !== null) {
  itemValue.forEach((element) => {
    // console.log(element);
    $('#answer-' + element).prop('checked', true);
  })
}
var all_answers = [];
var all_questions = [];
var all_keys = [];
for (var i = 1; i <= last_page; i++) {
  all_answers.push(localStorage.getItem('answer_id-' + i));
  all_questions.push(localStorage.getItem('question_id-' + i));
  all_keys.push(localStorage.getItem('key-' + i));
}

// alert(JSON.parse(all_answers[0]));
var xxx = [];
var yyy = [];
var zzz = [];
for (var i = 0; i < all_answers.length; i++) {
  var t = JSON.parse(all_answers[i]);
  var k = JSON.parse(all_questions[i]);
  var j = JSON.parse(all_keys[i]);
  if (t !== null) {
    t.forEach((element) => {
      xxx.push(element);
    });
  }
  if (k !== null) {
    k.forEach((element) => {
      yyy.push(element);
    });
  }
  if (j !== null) {
    j.forEach((element) => {
      zzz.push(element);
    });
  }
}
// alert(xxx);
//localStorage:
$('.sub_answer').click(function() {
  //
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
  localStorage.setItem('question_id-' + current_page, JSON.stringify(alleds));
  localStorage.setItem('key-' + current_page, JSON.stringify(keys));
  if (localStorage.getItem('question_id-' + current_page).includes(question_id)) {
    $('#check-selected-question-' + question_id).html(
      '<a role="button" class="btn btn-primary visit-to-question" style="width:50px" question-id="' +
      question_id + '" href="javascript:void(0)">' + key + '</a>'
    );
  } else {
    $('#check-selected-question-' + question_id).html(
      '<a role="button" class="btn btn-success visit-to-question" style="width:50px" question-id="' +
      question_id + '" href="javascript:void(0)">' + key + '</a>'
    );
  }

});
var itemQuestion = JSON.parse(localStorage.getItem("question_id-" + current_page));

var itemKey = JSON.parse(localStorage.getItem("key-" + current_page));
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
// $('.sub_answer_multiple').click(function(){

// })
// alert(xxx);
var unique = [];
for (var i = 0; i < yyy.length; i++) {
  if (unique.indexOf(yyy[i]) === -1) {
    unique.push(yyy[i]);
  }

}
var unikey = [];
for (var i = 0; i < zzz.length; i++) {
  if (unikey.indexOf(zzz[i]) === -1) {
    unikey.push(zzz[i]);
  }

}

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

  document.getElementById('countdown').innerHTML = hours + "h " + minutes + "m " +
    remainingSeconds + "s";

  if (seconds == 0) {
    // clearInterval(countdownTimer);
    // localStorage.clear();
    var exam_id = $('#countdown').attr('exam-id');
    var subject_id = $('#countdown').attr('subject-id');
    // allanswers = [];
    // $('.sub_answer:checked').each(function() {
    //     xxx.push($(this).attr('answer-id'));
    // });
    var key = unikey.join(",");
    var ans = xxx.join(",");
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
        '<p id="countdown" class="timer alert alert-danger"></p>'
      );
      seconds--;
      // if (!localStorage.getItem("new_seconds")) {
      localStorage.setItem("seconds", (seconds));
      // }else{
      //     localStorage.setItem("new_seconds", (seconds));
      // }
      setTimeout("timer()", 1000);
      if(seconds==0){
        window.location.href = "/result/exam/" + exam_id + '/subject/' + subject_id;
      }
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
// localStorage.clear();



// window.onbeforeunload = function() {
//     localStorage.clear();
//     return '';
// };

</script>

@endpush
