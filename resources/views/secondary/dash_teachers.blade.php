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
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <p>{{$teachersDetails['detailsextracted']['schoolname']}}</p>
            <div class="row">
                            <div class="col-md-3">
  
                              <!-- Profile Image -->
                              <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                  <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{asset('storage/schimages/'.Auth::user()->profileimg)}}"
                                         alt="User profile picture">
                                  </div>
                  
                                <h3 class="profile-username text-center">{{Auth::user()->firstname}} {{Auth::user()->middlename}} {{Auth::user()->lastname}}</h3>
                  
                                <p class="text-muted text-center">{{Auth::user()->role}}</p>
                  
                                  <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                 
                                    </li>
                                    <li class="list-group-item">
                                      <b>Role</b> <a class="float-right">{{Auth::user()->role}}</a>
                                    </li>
                                    <li class="list-group-item">
                                      <!--<b>Reg. No.</b> <a class="float-right">{{$teachersDetails['detailsextracted']['id']}}</a>-->
                                    </li>
                                    <li class="list-group-item">
                                      <b>System No.</b> <a class="float-right">{{Auth::user()->id}}</a>
                                    </li>
                                    <li class="list-group-item">
                                      <!--<b>Gender</b> <a class="float-right">{{$teachersDetails['detailsextracted']['gender']}}</a>-->
                                    </li>
                                    <!--<li class="list-group-item">-->
                                    <!--    @if ($teachersDetails['detailsextracted']['formsection'] == "")-->
                                    <!--    <b>Form Master</b> <a class="float-right">No</a>-->
                                    <!--    @else-->
                                    <!--<b>Form Master</b> <a class="float-right">{{$teachersDetails['formTeacher']}}{{$teachersDetails['detailsextracted']['formsection']}}</a>-->
                                    <!--    @endif-->
                                      
                                    <!--</li>-->
                                  </ul>
                                </div>
                                <!-- /.card-body -->
                              </div>
                              <!-- /.card -->
                  
                              <!-- About Me Box -->
                              <div class="card card-primary">
                                <div class="card-header">
                                  <h3 class="card-title">About Me</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                  <strong><i class="fas fa-book mr-1"></i> School</strong>
                  
                                  <p class="text-muted">
                                    <!--{{$teachersDetails['detailsextracted']['schoolname']}}-->
                                  </p>
                  
                                  <hr>
                  
                                  <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
                  
                                <!--<p class="text-muted">{{$teachersDetails['detailsextracted']['residentialaddress']}}</p>-->
                  
                                  <hr>
                  
                                  <strong><i class="fas fa-pencil-alt mr-1"></i> Date of Birth</strong>
                  
                                <!--<p class="text-muted">{{$teachersDetails['detailsextracted']['dob']}}</p>-->
                  
                                  <hr>
                  
                                  {{-- <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                  
                                  <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p> --}}
                                </div>
                                <!-- /.card-body -->
                              </div>
                              <!-- /.card -->
                            </div>
            
            
            
            </div>
        </div>
    </section>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->


@endsection