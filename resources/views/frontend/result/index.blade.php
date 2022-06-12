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
                            <li class="breadcrumb-item active" aria-current="page">My Results</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">My Results</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <h3 class="pb-3">All Results</h3>

                    <div class="tab-pane show active" id="mentee-list">
                        <div class="card card-table">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>EXAM</th>
                                                <th>SUBJECT</th>
                                                <th>TIME</th>
                                                <th>SCORE</th>
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
                                    <h4>Highest Result of Exam: {{max($maxscore)}}</h4>
                                    @if($exam['multiple']==0)
                                        @if (date('Y-m-d', strtotime($exam['end_time']))<date('Y-m-d H:i:s', strtotime(Carbon::now())))
                                            <a href="{{url('/dashboard')}}" class="btn btn-primary view-inv-btn">Back Dashboard</a>
                                        @else
                                            <a href="{{url('/exam/'.$exam['id'].'/subject/'.$exam['subject_id'].'/grade/'.$exam['grade_id'].'/'.$code)}}" class="btn btn-primary view-inv-btn" {{Session::put('questions_answers', Question::with(['answer'=>function($q){
                                                $q->inRandomOrder();
                                            }])->where('status',1)->inRandomOrder()->get())}}>Continue Exam</a>
                                        @endif
                                    @elseif (date('Y-m-d', strtotime($exam['end_time']))<date('Y-m-d H:i:s', strtotime(Carbon::now()))||$exam['multiple']<=count(explode(",",$result['score'])))
                                        <a href="{{url('/dashboard')}}" class="btn btn-primary view-inv-btn">Back Dashboard</a>

                                    @else
                                    <a href="{{url('/exam/'.$exam['id'].'/subject/'.$exam['subject_id'].'/grade/'.$exam['grade_id'].'/'.$code)}}" class="btn btn-primary view-inv-btn" {{Session::put('questions_answers', Question::with(['answer'=>function($q){
                                        $q->inRandomOrder();
                                    }])->where('status',1)->inRandomOrder()->get())}}>Continue Exam</a>
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
