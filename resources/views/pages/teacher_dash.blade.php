@extends('layouts.app_dash')

@section('content')

@include('layouts.asideside')

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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

            <!-- Info boxes -->
              <div>
                  
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
                                <b>Form Master</b> <a class="float-right">{{$studentDetails['addteacher'][0]->classnamee}} {{$studentDetails['addteacher'][0]->sectionname}}</a>
                              </li>
                              <li class="list-group-item">
                                <b>System No.</b> <a class="float-right">{{Auth::user()->id}}</a>
                              </li>
                              <li class="list-group-item">
                                <b>School Type</b> <a class="float-right">{{$studentDetails['userschool'][0]->schooltype}}</a>
                              </li>
                            </ul>
            
                            <!--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
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
                              {{$studentDetails['userschool'][0]->schoolname}}
                            </p>
            
                            <hr>
            
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
            
                            <p class="text-muted">{{$studentDetails['addteacher'][0]->residentialaddress}}</p>
            
                            <hr>
            
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Date of Birth</strong>
            
                            <p class="text-muted">
                                {{$studentDetails['addteacher'][0]->dob}}
                            </p>
            
                            <hr>
            
                            <!--<strong><i class="far fa-file-alt mr-1"></i> Notes</strong>-->
            
                            <!--<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>-->
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>
                      <!-- /.col -->
                      <div class="col-md-9">
                        <div class="card">
                          <div class="card-header p-2">
                            <ul class="nav nav-pills">
                              <li class="nav-item"><a class="nav-link active" href="#subjects" data-toggle="tab">Subjects</a></li>
                              <li class="nav-item"><a class="nav-link" href="#attendace" data-toggle="tab">Attendance</a></li>
                              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                          </div><!-- /.card-header -->
                          <div class="card-body">
                            <div class="tab-content">
                              <div class="active tab-pane" id="subjects">

                                <div>
                                    
                                    @if(count($studentDetails['subjects'])>0)
                                        @foreach($studentDetails['subjects'] as $subjects)
                                            <div class="card">
                                                <div style="margin: 10px;">
                                                    <div style="display: flex; flex-direction: column;">
                                                        <i style="font-style: normal; font-size: 12px;">{{$subjects->subjectname}}</i>
                                                        <i style="font-style: normal; font-size: 12px;">{{$subjects->subjectcode}}</i>
                                                        <i style="font-style: normal; font-size: 12px;">{{$subjects->classnamee}}</i>
                                                        <i style="font-style: normal; font-size: 12px;">class count: {{$subjects->studentcount}}</i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    
                                </div>

                              </div>
                              <!-- /.tab-pane -->
                              <div class="tab-pane" id="attendace">
                                  
                                  
    
                              </div>
                              <!-- /.tab-pane -->
            
                              <div class="tab-pane" id="settings">
                                  
                                  
                    
                              </div>
                              <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                          </div><!-- /.card-body -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                      </div>
                      <!-- /.col -->
                    </div>

              </div>
                
          </section>
    <!-- /.content -->
  </div>


  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">Brytosoftgit</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.3-pre
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
    
@endsection