<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Alpha-Sims</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('../../plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class=" navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="../../index3.html" class="nav-link">Home</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
          </li>
        </ul>
    
        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>
    
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fas fa-envelope"></i>
              <span class="badge badge-danger navbar-badge">3</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" role="button">
              <i class="fas fa-th-large"></i>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->


    @yield('content')
    
    
  </div>

 {{-- <!-- jQuery --> --}}
 <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
 {{-- <!-- jQuery UI 1.11.4 --> --}}
 <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
 {{-- <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip --> --}}
 <script>
   $.widget.bridge('uibutton', $.ui.button);
 </script>
 {{-- //  Bootstrap 4 --}}
 <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 {{-- // <!-- ChartJS --> --}}
 <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
 {{-- // <!-- Sparkline --> --}}
 <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
 {{-- // <!-- JQVMap --> --}}
 <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
 <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
 {{-- // <!-- jQuery Knob Chart --> --}}
 <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
 {{-- // <!-- daterangepicker --> --}}
 <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
 <script src="plugins/daterangepicker/daterangepicker.js"></script>
 {{-- // <!-- Tempusdominus Bootstrap 4 --> --}}
 <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
 {{-- // <!-- Summernote --> --}}
 <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
 <!-- overlayScrollbars -->
 <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
 <!-- SweetAlert2 -->
 <script src="{{ asset('../../plugins/sweetalert2/sweetalert2.min.js') }}"></script>
 <!-- Toastr -->
 <script src="{{ asset('../../plugins/toastr/toastr.min.js') }}"></script>
 {{-- // <!-- AdminLTE App --> --}}
 <script src="{{ asset('dist/js/adminlte.js') }}"></script>
 {{-- // <!-- AdminLTE dashboard demo (This is only for demo purposes) --> --}}
 <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
 {{-- // <!-- AdminLTE for demo purposes --> --}}
 <script src="{{ asset('dist/js/demo.js') }}"></script>
 
 <script src="{{ asset('../../plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
 <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
 
 <script type="text/javascript">
 $(document).ready(function () {
   bsCustomFileInput.init();
 });
 
 function toastSuccess(message) {
   var message;
     const Toast = Swal.mixin({
       toast: true,
       position: 'top-end',
       showConfirmButton: false,
       timer: 3000
     });
 
         Toast.fire({
           type: 'success',
           title: message
         })
 
 
 }

 $(function () {
    //Enable check and uncheck all functionality
    $('.checkbox-toggle').click(function () {
      var clicks = $(this).data('clicks')
      if (clicks) {
        //Uncheck all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
        $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
      } else {
        //Check all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
        $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
      }
      $(this).data('clicks', !clicks)
    })

    //Handle starring for glyphicon and font awesome
    $('.mailbox-star').click(function (e) {
      e.preventDefault()
      //detect type
      var $this = $(this).find('a > i')
      var glyph = $this.hasClass('glyphicon')
      var fa    = $this.hasClass('fa')

      //Switch states
      if (glyph) {
        $this.toggleClass('glyphicon-star')
        $this.toggleClass('glyphicon-star-empty')
      }

      if (fa) {
        $this.toggleClass('fa-star')
        $this.toggleClass('fa-star-o')
      }
    })
  })

 $(function () {
    //Add text editor
    $('#compose-textarea').summernote()
  })

 </script>
 @stack('custom-scripts')
</body>
</html>