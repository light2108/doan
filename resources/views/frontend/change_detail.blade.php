@extends('layouts.frontend.dashboard')
@section('content')
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Profile Settings</h2>
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
                                    Student Code:{{ $student['student_code'] }}
                                </p>
                            </div>
                        </div>
                        <div class="progress-bar-custom">
                            <h6>Complete your profiles ></h6>
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

                            <form action={{ url('/change-detail') }} method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-6 col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $student['name'] }}" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <div class="form-group">
                                            <label>Mobile</label>
                                            <input type="number" value="{{ $student['mobile'] }}" class="form-control"
                                                name="mobile">
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image"
                                                        id="exampleInputFile" onchange="loadfile(event)">
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-6">
                                        <div class="form-group">
                                            <label>Old password</label>
                                            <input type="password" class="form-control" id="current_password" name="old_password">
                                            <span id="chkpwd"></span>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <div class="form-group">
                                            <label>New password</label>
                                            <input type="password" class="form-control" name="new_password">
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
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
