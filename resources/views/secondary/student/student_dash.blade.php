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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">




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
  
                <h3 class="profile-username text-center">{{Auth::user()->firstname}} {{Auth::user()->middlename}} {{AUth::user()->lastname}}</h3>
  
                  <p class="text-muted text-center">{{$mainStudentDetails['studentsDetailsMain']['schoolname']}}</p>
  
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                    <b>Class</b> <a class="float-right">{{$mainStudentDetails['studentsDetailsMain']['classname']}}{{$mainStudentDetails['studentsDetailsMain']['sectionname']}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>Reg. No.</b> <a class="float-right">{{$mainStudentDetails['studentsDetailsMain']['id']}}</a>
                    </li>
                    <li class="list-group-item">
                    <b>System No.</b> <a class="float-right">{{Auth::user()->id}}</a>
                    </li>
                    <li class="list-group-item">
                    <b>Role</b> <a class="float-right">{{Auth::user()->role}}</a>
                    </li>
                    <li class="list-group-item">
                    <b>Gender</b> <a class="float-right">{{$mainStudentDetails['studentsDetailsMain']['gender']}}</a>
                    </li>
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
                  <strong><i class="fas fa-book mr-1"></i> school</strong>
  
                  <p class="text-muted">
                    {{$mainStudentDetails['studentsDetailsMain']['schoolname']}}
                  </p>
  
                  <hr>
  
                  <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
  
                  <p class="text-muted">{{$mainStudentDetails['studentsDetailsMain']['studentpermanenthomeaddress']}}</p>
  
                  <hr>
  
                  <strong><i class="fas fa-pencil-alt mr-1"></i> Date of Birth</strong>
  
                <p class="text-muted">{{$mainStudentDetails['studentsDetailsMain']['dateOfBirth']}}</p>
  
                  <hr>
  
                  {{-- <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
  
                  <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p> --}}
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
                    <li class="nav-item"><a class="nav-link" href="#attendance" data-toggle="tab">Attendance</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="subjects">

                        <br>
                        <ul class="list-group" id="myList" style="height: 400px; overflow-y: scroll;">
                            @if (count($mainStudentDetails['addsubjects']) > 0)
                                @foreach ($mainStudentDetails['addsubjects'] as $subject)
                                    <li class="list-group-item" style="display: flex;">
                                        <div style="display: flex; flex-direction: column;">
                                            <i style="font-size: 10px; font-style: normal; font-weight: bold;">Subject</i>
                                            <i style="font-style: normal; font-size: 12px;">{{$subject->subjectname}}</i>
                                        </div>
                                        <div style="flex: 0.2;"></div>
                                        <div style="display: flex; flex-direction: column;">
                                            <i style="font-size: 10px; font-style: normal; font-weight: bold;">Subject Code</i>
                                            <i style="font-style: normal; font-size: 12px;">{{$subject->subjectcode}}</i>
                                        </div>
                                        
                                    </li>
                                @endforeach
                            @endif
                        </ul>  

                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="attendance">
                      <div class="card" style="height: 30px;">
                          <i style="margin-left: 5px;">Todays date is: {{date('Y-m-d')}}</i>
                      </div>
                      <div class="row">
                        @if (count($mainStudentDetails['daysarray']) > 0)
                          @for ($i = 1; $i < $mainStudentDetails['monthcount'] + 1; $i++)
                            @if (in_array($i, $mainStudentDetails['daysarray']))
                              <div class="col-md-1 col-3">
                                <div class="card bg-success" style="height: 50px;">
                                  <i style="font-style: normal; font-weight: bold; padding: 5px;">{{$i}}</i>
                                </div>
                              </div>
                            @else
                              <div class="col-md-1 col-3">
                                <div class="card bg-danger" style="height: 50px;">
                                  <i style="font-style: normal; font-weight: bold; padding: 5px;">{{$i}}</i>
                                </div>
                              </div>
                            @endif
                          @endfor
                        @else
                          <div class="card" style="height: 50px; width: 100%; display: flex; align-items: center; justify-content: center;">
                            <i>No Attendance taken this month</i>
                          </div>
                        @endif
                      </div>
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <script>
      function scrollocation(){
        document.getElementById('dashboard_dash').className = "nav-link active"
      }
  </script>
    
@endsection