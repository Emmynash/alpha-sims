<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Alpha-sims LogIn</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
      .login-page{
        background-image: url('images/newbackmm.jpg'); 
        background-repeat: no-repeat; 
        background-size: cover;
        
      }

      input:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 1000px #EEF0F0 inset !important;
      }

      #topmenu{
          position: absolute;
          top: 30px;
          right: 30px;
          display: flex;
          flex-direction: row;
      }

  </style>
   <script src="https://www.google.com/recaptcha/api.js"></script>
   <script>
       function onSubmit(token) {
         document.getElementById("login-form").submit();
       }
  </script>
</head>
<body class="hold-transition login-page" style="">
<div class="float-right" id="topmenu">
    <a href="/register"><button class="btn btn-info btn-sm">Register</button></a>
</div>
<div class="login-box">
  <div class="login-logo">
    {{-- <a href="/"><b>Alpha</b>SIMS</a> --}}
    <p>{{ app('currentTenant')->name }}</p>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body" style="border-radius: 10px;">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="login-form" method="POST" action="{{ route('login') }}" autocomplete="on">
        @csrf

        <div class="form-group">
            <input id="email" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" type="text" placeholder="Email" value="{{ old('email') }}" required autofocus autocomplete="off">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="form-group">
            <input id="password" type="password" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('password') is-invalid @enderror" type="text" placeholder="Password" name="password" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="d-flex justify-content-around">
            <div>
                <!-- Remember me -->
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="defaultLoginFormRemember">
                    <label class="custom-control-label" for="defaultLoginFormRemember">Remember me</label>
                </div>
            </div>
            <div>
                <!-- Forgot password -->
                <a href="{{ route('password.request') }}">Forgot password?</a>
            </div>
        </div>

        <button class="btn btn-info btn-block my-4" type="submit" style="color: #fff;"  
        data-action='submit'>Login</button>
        <div>
          <button type="button" class="btn btn-sm btn-info badge">Admin Login</button>
        </div>


      </form>

      <p class="mb-0">
        <a href="/register" class="text-center">Register a new membership</a>
      </p>
    <span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=zrDtkOQWAjJG8nciJwFAu7svkhRBYOVLTRBG7GZuFV062pkRGu964NFdSPbA"></script></span>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

</body>
</html>
