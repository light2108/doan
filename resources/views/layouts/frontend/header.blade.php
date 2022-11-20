<?php

use App\Models\Classes;
use App\Models\Subject;

$subjects = Subject::with('teacher')->where('status', 1)
  ->get()
  ->toArray();
$classes = Classes::classes();
?>
<header class="header">
  <nav class="navbar navbar-expand-lg header-nav">
    <div class="container-fluid">
      <div class="navbar-header">
        <a id="mobile_btn" href="javascript:void(0);">
          <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
          </span>
        </a>
        <a href="{{url('/dashboard')}}" class="navbar-brand logo">
          <img src="frontend/assets/img/logo.png" class="img-fluid" alt="Logo">
        </a>
      </div>
      <div class="main-menu-wrapper">
        <div class="menu-header">
          <a href="{{url('/dashboard')}}" class="menu-logo">
            <img src="frontend/assets/img/logo.png" class="img-fluid" alt="Logo">
          </a>
          <a id="menu_close" class="menu-close" href="javascript:void(0);">
            <i class="fas fa-times"></i>
          </a>
        </div>
        <ul class="main-nav">
          <li class="active">
            <a href="{{ url('/dashboard') }}">Trang chủ</a>
          </li>
          <li class="has-submenu  ">
            <a>Môn học <i class="fas fa-chevron-down"></i></a>
            <ul class="submenu">
              @foreach ($subjects as $subject)
              @if (in_array(Auth::guard('student')->user()->grade_id, explode(',', $subject['grade_id'])))
              @foreach ($subject['teacher'] as $teacher)
              @if (in_array(Auth::guard('student')->user()->class_id, explode(',', $teacher['class_id'])))
              <li class=""><a
                  href="{{ route('exam.subject.grade', ['subject_id' => $subject['id'], 'grade_id' => Auth::guard('student')->user()->grade_id]) }}">{{ $subject['name'] }}</a>
              </li>
              @endif
              @endforeach
              @endif
              @endforeach
            </ul>
          </li>
          {{-- <li class="has-submenu ">
                        <a href="">Mentee <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li class="has-submenu ">
                                <a href="#">Mentors</a>
                                <ul class="submenu">
                                    <li class=""><a href="map-grid">Map Grid</a></li>
                                    <li class=""><a href="map-list">Map List</a></li>
                                </ul>
                            </li>
                            <li class=""><a href="search">Search Mentor</a></li>
                            <li class=""><a href="profile">Mentor Profile</a></li>
                            <li class=""><a href="bookings-mentee">Bookings</a></li>
                            <li class=""><a href="checkout">Checkout</a></li>
                            <li class=""><a href="booking-success">Booking Success</a></li>
                            <li class=""><a href="dashboard-mentee">Mentee Dashboard</a></li>
                            <li class=""><a href="favourites">Favourites</a></li>
                            <li class=""><a href="chat-mentee">Chat</a></li>
                            <li class=""><a href="profile-settings-mentee">Profile Settings</a></li>
                            <li class=""><a href="change-password">Change Password</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu ">
                        <a href="">Pages <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li class=""><a href="voice-call">Voice Call</a></li>
                            <li class=""><a href="video-call">Video Call</a></li>
                            <li class=""><a href="search">Search Mentors</a></li>
                            <li class=""><a href="components">Components</a></li>
                            <li class="has-submenu">
                                <a href="invoices">Invoices</a>
                                <ul class="submenu">
                                    <li><a href="invoices">Invoices</a></li>
                                    <li><a href="invoice-view">Invoice View</a></li>
                                </ul>
                            </li>
                            <li class=""><a href="blank-page">Starter Page</a></li>
                            <li class="{{ url('/login') }}"><a href="login">Login</a></li>
          <li class=""><a href="register">Register</a></li>
          <li class=""><a href="forgot-password">Forgot Password</a></li>
        </ul>
        </li>
        <li class="has-submenu ">
          <a href="">Blog <i class="fas fa-chevron-down"></i></a>
          <ul class="submenu">
            <li class=""><a href="blog-list">Blog List</a></li>
            <li class=""><a href="blog-grid">Blog Grid</a></li>
            <li class=""><a href="blog-details">Blog Details</a></li>
          </ul>
        </li>
        <li>
          <a href="https://mentoring-laravel.dreamguystech.com/template-1/public/admin/index_admin"
            target="_blank">Admin</a>
        </li>
        <li class="login-link">
          <a href="login">Login / Signup</a>
        </li> --}}
        </ul>
      </div>
      <ul class="nav header-navbar-rht">

        <li class="nav-item dropdown has-arrow logged-item">
          <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
            <span class="user-img">
              <img class="rounded-circle me-2" src="{{ Auth::guard('student')->user()->image }}" width="31"
                alt="{{ Auth::guard('student')->user()->name }}">{{ Auth::guard('student')->user()->name }}
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="user-header">
              <div class="avatar avatar-sm">
                <img src="{{ Auth::guard('student')->user()->image }}" alt="User Image"
                  class="avatar-img rounded-circle">
              </div>
              <div class="user-text">
                <h6>{{ Auth::guard('student')->user()->name }}</h6>
                <p class="text-muted mb-0">
                  @foreach ($classes as $class)
                  @if (Auth::guard('student')->user()->class_id == $class['id'])
                  {{ $class['name'] }}
                  @endif
                  @endforeach
                </p>
              </div>
            </div>
            <a class="dropdown-item" href="{{ url('/dashboard') }}">Bảng thông tin</a>
            <a class="dropdown-item" href="{{ url('/change-detail') }}">Cài đặt thông tin</a>
            <a class="dropdown-item" href="{{ url('/logout') }}">Đăng xuất</a>
          </div>
        </li>

      </ul>
    </div>
  </nav>
</header>