@extends('layouts.app_sec')

@section('content')

@include('layouts.aside_sec')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">My Profile</h1>
            {{-- <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Addsubjects"
                data-content="On this module, you are required to enter all subjects offered by your school according to the classes you have.">Need help?</button> --}}
                    
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">My profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card">
                  <div class="text-center" style="margin: 5px;">
                    <img id="profileimgmainpix" src="{{asset('storage/schimages/'.Auth::user()->profileimg)}}" class="img-circle elevation-2" alt="User Image" height="150px">
                  </div>
                  <button class="btn btn-sm btn-info badge" style="margin: 10px;">upload pix</button>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card">
                    <form action="">
                        @csrf
                        <div class="row" style="margin: 10px;">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" value="{{ Auth::user()->firstname }}" placeholder="firstname">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" value="{{ Auth::user()->middlename }}" placeholder="middlename">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" value="{{ Auth::user()->lastname }}" placeholder="lastname">
                                </div>
                            </div>
                        </div>
                        <div style="margin: 10px;">
                            <textarea name="" class="form-control form-control-sm" id="" cols="30" rows="5" placeholder="Address"></textarea>
                        </div>
                        <div class="row" style="margin: 10px;">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-sm" placeholder="contact">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input type="date" class="form-control form-control-sm" placeholder="Date of birth">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

  
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2012-2019 <a href="http://adminlte.io">Brightosoft</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 0.0.1
    </div>
  </footer>



  <script>
      function scrollocation(){
        document.getElementById('managestaffscroll').className = "nav-link active"
      }
</script>
    
@endsection