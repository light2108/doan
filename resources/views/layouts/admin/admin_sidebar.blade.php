<?php
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Classes;
use App\Models\Result;
$grades=Grade::grade();
$subjects=Subject::subject();
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/admin/dashboard')}}" class="brand-link">
        <img src="backend/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">ONLINE EXAM</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="backend/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a class="d-block">{{ Session::get('name') }}
                @if(Auth::guard('admin')->user()->role==0||Auth::guard('admin')->user()->role == -1)-
                    @foreach ($subjects as $subject)
                        @if (Session::get('subject')==$subject['id'])
                            {{$subject['name']}}
                        @endif
                    @endforeach

                @endif
                {{-- {{var_dump(Auth::guard('admin')->user()->subject_id)}} --}}
            </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item menu-open">
                    <a
                        class="nav-link {{ ((Session::get('page') == 'admin_setting' ? 'active' : '' || Session::get('page') == 'admin_detail') ? 'active' : '' || Session::get('page') == 'admin_password') ? 'active' : '' }}">
                        <i class="fas fa-user-circle fa"></i>
                        <p>
                            Admin Setting
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/admin/change-detail') }}"
                                class="nav-link {{ Session::get('page') == 'admin_detail' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change admin detail</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/change-password') }}"
                                class="nav-link {{ Session::get('page') == 'admin_password' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change admin password</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-header">BASIC</li>
                @if (Auth::guard('admin')->user()->role == -1||Auth::guard('admin')->user()->role == 1)
                    <li class="nav-item">
                        <a href="{{ url('admin/teachers') }}" class="nav-link {{ Session::get('page') == 'teacher' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>
                                Teachers
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ url('/admin/students') }}" class="nav-link {{ Session::get('page') == 'student' ? 'active' : '' }}">
                        <i class="nav-icon fa fa-user-graduate"></i>
                        <p>
                            Students
                        </p>
                    </a>

                </li>
                @if (Auth::guard('admin')->user()->role == 0||Auth::guard('admin')->user()->role == -1)
                    <li class="nav-item">
                        <a href="{{url('/admin/result/exam/class')}}" class="nav-link {{ Session::get('page') == 'result' ? 'active' : '' }}">
                            <i class="nav-icon fa fa-clipboard-check"></i>
                            <p>
                                Results
                                <span class="badge badge-info right">{{Result::checkdate()}}</span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/exams') }}" class="nav-link {{ Session::get('page') == 'exam' ? 'active' : '' }}">
                            <i class="nav-icon fa fa-clipboard-list"></i>
                            <p>
                                Exams
                            </p>

                        </a>

                    </li>
                @endif
                @if(Auth::guard('admin')->user()->role==1)
                <li class="nav-item">
                    <a href="{{ url('admin/grades') }}" class="nav-link {{ Session::get('page') == 'grade' ? 'active' : '' }}">
                        <i class="nav-icon fa fa-graduation-cap"></i>
                        <p>
                            Grades
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/subjects') }}" class="nav-link {{ Session::get('page') == 'subject' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book-reader"></i>
                        <p>
                            Subjects
                        </p>

                    </a>

                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/classes') }}" class="nav-link {{ Session::get('page') == 'class' ? 'active' : '' }}">
                        <i class="nav-icon 	fas fa-school"></i>
                        <p>
                            Classes
                        </p>
                    </a>
                </li>
                @endif
                @if (Auth::guard('admin')->user()->role == 0||Auth::guard('admin')->user()->role == -1)
                    <li class="nav-item">
                        <a class="nav-link
                        @foreach ($grades as $grade)
                        {{ Session::get('page') == $grade['id'] ? 'active' : '' }}
                        @endforeach">
                            <i class="nav-icon fas fa-question"></i>
                            <p>
                                Questions
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @foreach ($grades as $grade)
                                <li class="nav-item">
                                    <a href="{{ url('/admin/units/subject/'.Auth::guard('admin')->user()->subject_id.'/grade', $grade['id']) }}" class="nav-link {{ Session::get('page') == $grade['id'] ? 'active' : '' }}">
                                        &nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                                        <p>Grade {{$grade['grade']}}</p>
                                    </a>
                                </li>
                            @endforeach


                        </ul>
                    </li>
                @endif
            </ul>

        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
