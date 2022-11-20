<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
  <title>Mentoring</title>
  <base href="{{ asset(' ') }}" />
  <link type="image/x-icon" href="frontend/assets/img/favicon.png" rel="icon">

  <link rel="stylesheet" href="frontend/assets/css/bootstrap.min.css">

  <link rel="stylesheet" href="frontend/assets/plugins/fontawesome/css/fontawesome.min.css">
  <link rel="stylesheet" href="frontend/assets/plugins/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="frontend/assets/plugins/select2/css/select2.min.css">

  <link rel="stylesheet" href="frontend/assets/plugins/daterangepicker/daterangepicker.css">

  <link rel="stylesheet" href="frontend/assets/css/bootstrap-datetimepicker.min.css">

  <link rel="stylesheet" href="frontend/assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="frontend/assets/css/owl.theme.default.min.css">

  <link rel="stylesheet" href="frontend/assets/css/style.css">
</head>

<body class="account-page">

  <div class="bg-pattern-style">
    <div class="content">

      <div class="account-content">
        <div class="account-box">
          <div class="login-right">
            <div class="login-header">
              <h3>Đăng nhập <span>Hệ thống</span></h3>
              <p class="text-muted"></p>
              @if (Session::has('error_message'))
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('error_message') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
            </div>
            <form action="{{url('/')}}" method="post">
              @csrf
              <div class="form-group">
                <label class="form-control-label">Mã học sinh</label>
                <input type="text" name="student_code" class="form-control">
              </div>
              <div class="form-group">
                <label class="form-control-label">Mật khẩu</label>
                <div class="pass-group">
                  <input type="password" name="password" class="form-control pass-input">
                  <span class="fas fa-eye toggle-password"></span>
                </div>
              </div>
              {{-- <div class="text-end">
                                <a class="forgot-link" href="{{url('/admin/forgot-password')}}">Forgot Password ?</a>
          </div> --}}
          <button class="btn btn-primary login-btn" type="submit">Đăng nhập</button>

          </form>
        </div>
      </div>
    </div>

  </div>
  </div>


  <script src="frontend/assets/js/jquery-3.6.0.min.js"></script>

  <script src="frontend/assets/js/popper.min.js"></script>
  <script src="frontend/assets/js/bootstrap.bundle.min.js"></script>

  <script src="frontend/assets/plugins/select2/js/select2.min.js"></script>

  <script src="frontend/assets/js/moment.min.js"></script>
  <script src="frontend/assets/js/bootstrap-datetimepicker.min.js"></script>
  <script src="frontend/assets/plugins/daterangepicker/daterangepicker.js"></script>

  <script src="frontend/assets/js/owl.carousel.min.js"></script>

  <script src="frontend/assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
  <script src="frontend/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>



  <script src="frontend/assets/js/script.js"></script>
</body>

</html>