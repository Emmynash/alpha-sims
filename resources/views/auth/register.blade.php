<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Alpha-sims-Register</title>
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
   {{-- <script src="https://www.google.com/recaptcha/api.js"></script> --}}
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

      /* Extra small devices (phones, 600px and down) */
        @media only screen and (max-width: 600px) {
            .login-box{
                width: 90%
            }
        }

        /* Small devices (portrait tablets and large phones, 600px and up) */
        @media only screen and (min-width: 600px) {
            .login-box{
                width: 90%
            }
        }

        /* Medium devices (landscape tablets, 768px and up) */
        @media only screen and (min-width: 768px) {

        }

        /* Large devices (laptops/desktops, 992px and up) */
        @media only screen and (min-width: 992px) {
            .login-box{
                width: 50%
            }
        }

        /* Extra large devices (large laptops and desktops, 1200px and up) */
        @media only screen and (min-width: 1200px) {
            .login-box{
                width: 50%
            }
        }

  </style>
  
   <script>
       function onSubmit(token) {
         document.getElementById("register-form").submit();
       }
   </script>
</head>
<body class="hold-transition login-page" style="">
<div class="float-right" id="topmenu">
    <a href="/login"><button class="btn btn-info btn-sm">LogIn</button></a>
</div>
<div class="login-box">
  <div class="login-logo">
    {{-- <a href="/"><b>Alpha</b>SIMS</a> --}}
    <p>{{ app('currentTenant')->name }}</p>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body" style="border-radius: 10px;">
      <p class="login-box-msg">Create an account to get started</p>

      <form id="register-form" method="POST" action="{{ route('register') }}" autocomplete="on">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input name="firstname" style="border: none; background-color:#EEF0F0;" class="form-control @error('firstname') is-invalid @enderror" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus type="text" placeholder="Firstname">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input name="middlename" style="border: none; background-color:#EEF0F0;" class="form-control @error('middlename') is-invalid @enderror" value="{{ old('middlename') }}" autocomplete="middlename" autofocus type="text" placeholder="Middlename">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input name="lastname" style="border: none; background-color:#EEF0F0;" class="form-control @error('lastname') is-invalid @enderror" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus type="text" placeholder="Lastname">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <input name="email" style="border: none; background-color:#EEF0F0;" class="form-control @error('email') is-invalid @enderror" type="text" placeholder="Email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
        
                <div class="form-group">
                    <input name="phonenumber" style="border: none; background-color:#EEF0F0;" class="form-control" type="text" placeholder="Phone Number">
                </div>
        
                <div class="form-group">
                    <input type="password" style="border: none; background-color:#EEF0F0;" class="form-control @error('password') is-invalid @enderror" type="text" placeholder="Password" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
        
                <div class="form-group">
                    <input id="password-confirm" style="border: none; background-color:#EEF0F0;" class="form-control" type="password" placeholder="Confirm-Password" name="password_confirmation" required autocomplete="new-password">
                </div>

            </div>
        </div>

        <button class="btn btn-info btn-block my-4 g-recaptcha" type="submit" style="color: #fff;""
        data-callback='onSubmit' 
        data-action='submit'>Register</button>


      </form>

      <p class="mb-0">
        <a href="/login" class="text-center">Already have an Account? Yes.</a>
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
