@extends($schooldetails->schooltype == "Primary" ? 'layouts.app_dash' : 'layouts.app_sec')

@section('content')

@if ($schooldetails->schooltype == "Primary")
@include('layouts.asideside') 
@else
  @include('layouts.aside_sec')
@endif

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
        <!--<p>{{$getTeacherDetails->schoolname}}</p>-->
        <div class="row">
            <div class="col-md-3">
  
              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{Auth::user()->profileimg ?? "https://gravatar.com/avatar/?s=200&d=retro"}}"
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
                      <!--<b>Reg. No.</b> <a class="float-right">{{$getTeacherDetails->id}}</a>-->
                    </li>
                    <li class="list-group-item">
                      <b>System No.</b> <a class="float-right">{{Auth::user()->id}}</a>
                    </li>
                    <li class="list-group-item">
                      <!--<b>Gender</b> <a class="float-right">{{$getTeacherDetails->gender}}</a>-->
                    </li>
                    <!--<li class="list-group-item">-->
                    <!--    @if ($formTeacher == null)-->
                    <!--    <b>Form Master</b> <a class="float-right">No</a>-->
                    <!--    @else-->
                    <!--<b>Form Master</b> <a class="float-right">{{$formTeacher->classname}}{{$getTeacherDetails->formsection}}</a>-->
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
                    {{$getTeacherDetails->schoolname}}
                  </p>
  
                  <hr>
  
                  <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
  
                <p class="text-muted">{{$getTeacherDetails->residentialaddress}}</p>
  
                  <hr>
  
                  <strong><i class="fas fa-pencil-alt mr-1"></i> Date of Birth</strong>
  
                <p class="text-muted">{{$getTeacherDetails->dob}}</p>
  
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
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Subject</a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Attendance</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Students</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        
                        @foreach($subjectTeacherOffer as $teachersubjects)
                        
                            <div class="card">
                                <div style="padding: 5px;">
                                    <div>
                                        <i style="font-size: 12px; font-style: normal;">{{$teachersubjects->getSubjectName->subjectname}}</i>
                                    </div>
                                    <div>
                                        <i style="font-size: 12px; font-style: normal;">{{$teachersubjects->getSubjectName->subjectcode}}</i>
                                    </div>
                                    <div>
                                        <i style="font-size: 12px; font-style: normal;">{{$teachersubjects->getClassName->classname}}{{ $teachersubjects->sectionname }}</i>
                                    </div>
                                    {{-- <div>
                                        <i style="font-size: 12px; font-style: normal;">Class Count: {{$teachersubjects->getClassCount($teachersubjects->classid)}}</i>
                                    </div> --}}
                                </div>
                            </div>
                        
                        @endforeach
                        
                        
                        

                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                      
                        <div class="spinner-border"></div>

                    </div>
                    <!-- /.tab-pane -->
  
                    <div class="tab-pane" id="settings">

                      <div class="spinner-border"></div>

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

        function myFunction() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }


      function scrollocation(){
        document.getElementById('dashboard_dash').className = "nav-link active"
      }
  </script>
    
@endsection