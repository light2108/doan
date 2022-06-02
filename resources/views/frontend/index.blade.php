@extends('layouts.frontend.dashboard')
@section('content')
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Dashboard</h2>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="row blog-grid-row">
                        @foreach ($exams as $exam)
                            @if (in_array(Auth::guard('student')->user()->class_id, explode(',', $exam['class_id'])))
                                <div class="col-md-6 col-sm-12">

                                    <div class="blog grid-blog">
                                        <div class="blog-image">
                                            <iframe width="400px" src="{{ $exam['video'] }}">
                                            </iframe>
                                        </div>
                                        <div class="blog-content">
                                            <ul class="entry-meta meta-item">
                                                <li>
                                                    <div class="post-author">
                                                        <a href="profile"><img src="{{ $exam['teacher']['image'] }}"
                                                                style="width:50px;height:50px" alt="Post Author">
                                                            <span>{{ $exam['teacher']['name'] }}</span></a>
                                                    </div>
                                                </li>
                                                <li><i
                                                        class="far fa-clock"></i>{{ date('Y-m-d', strtotime($exam['created_at'])) }}
                                                </li>
                                            </ul>
                                            <h3 class="blog-title"><a href="blog-details">{{ $exam['name'] }} mon
                                                    {{ $exam['subject']['name'] }}</a></h3>
                                            <p class="mb-0">Video supported for exam {{ $exam['name'] }}.</p>
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


                                        {{ $exams->links('pagination::simple-tailwind') }}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

                    <div class="card search-widget">
                        <div class="card-body">
                            <form action="{{url('/dashboard')}}" method="GET" class="search-form">
                                @csrf
                                <div class="input-group">

                                    <input type="text" name="search" placeholder="Search..." class="form-control">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="card post-widget">
                        <div class="card-header">
                            <h4 class="card-title">My Subjects</h4>
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
                                                            <img class="img-fluid" src="{{ $teacher['image'] }}"
                                                                style="height:80px; width:80px" alt="">
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
