<?php
use Carbon\Carbon;
?>
@extends('layouts.frontend.dashboard')
@section('content')
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Result</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Result</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content success-page-cont">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">

                    <div class="card success-card">
                        <div class="card-body">
                            <div class="success-cont">
                                <i class="fas fa-check"></i>
                                <h3>Result of Exam!</h3>
                                <h1>{{$result['score']}}</h1>
                                @if($exam['multiple']==1&&date('Y-m-d H:i:s', strtotime($exam['end_time']))>date('Y-m-d H:i:s', strtotime(Carbon::now())))
                                <a  href="{{ url('/exam/' . $exam['id'] . '/subject/' . $result['subject_id'] . '/grade/' . $exam['grade_id']) }}"  class="btn btn-primary view-inv-btn">Back Exam</a>
                                @else <a  href="{{ url('/dashboard') }}"  class="btn btn-primary view-inv-btn">Back dashboard</a>
                                 @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

