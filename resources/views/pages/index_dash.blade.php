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


    @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HeadOfSchool'))
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
            
            <div class="row">
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                  <h3>{{count($studentDetails['addStudent'])}}</h3>
                    <p>Student</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-user-graduate"></i>
                  </div>
                  <a href="{{ route('viewstudent') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                  <h3>{{count($studentDetails['addteachers'])}}</h3>

                    <p>Teachers</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                  </div>
                  <a href="{{ route('addteacher') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                  <h3>{{count($studentDetails['addsubject'])}}</h3>

                    <p>Subjects</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-book"></i>
                  </div>
                  <a href="{{ route('addsubject') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                  <h3>{{count($studentDetails['classList'])}}</h3>

                    <p>Class</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-school"></i>
                  </div>
                  <a href="{{ route('viewclasslist') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
            </div>
        <!-- /.row -->
        <!-- Main row -->
      </div><!-- /.container-fluid -->
    </section>
    @endif


        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            @if (count($studentDetails['userschool']) > 0)
                @if ($studentDetails['userschool'][0]['status'] == "Approved")
                  @if (Auth::user()->role == "Admin")
                  <h5 class="mb-2">Other Details</h5>
                  <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
          
                        <div class="info-box-content">
                          <span class="info-box-text">Attendance</span>
                          <span class="info-box-number">0</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-pen-square"></i></span>
          
                        <div class="info-box-content">
                          <span class="info-box-text">Exams</span>
                          <span class="info-box-number">0</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-book-open"></i></span>
          
                        <div class="info-box-content">
                          <span class="info-box-text">Books</span>
                          <span class="info-box-number">0</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
          
                        <div class="info-box-content">
                          <span class="info-box-text">Likes</span>
                          <span class="info-box-number">0</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                  </div>
                  @endif
              
              @else
              <h3>Account Activation Pending CLick <a href="/addschool">Here</a> to see Status.</h3>
              @endif
            @endif

            @if (Auth::user()->role == "Student")
          <h5 class="mb-2">{{$studentDetails['userschool'][0]['schoolname']}}</h5>
            <div class="row">
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                  <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Attendance</span>
                    <span class="info-box-number">0</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                  <span class="info-box-icon bg-success"><i class="fas fa-pen-square"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Exams</span>
                    <span class="info-box-number">0</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                  <span class="info-box-icon bg-warning"><i class="fas fa-book-open"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Books</span>
                    <span class="info-box-number">0</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                  <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Likes</span>
                    <span class="info-box-number">0</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
            </div>

            <div class="row">
              <div class="col-md-3">
    
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                    <div class="text-center">
                      <img class="profile-user-img img-fluid img-circle"
                           src="{{asset('storage/schimages/'.$studentDetails['addStudent']['profileimg'])}}"
                           alt="User profile picture">
                    </div>
    
                    <h3 class="profile-username text-center">{{$studentDetails['addStudent']['firstname']}} {{$studentDetails['addStudent']['middlename']}} {{$studentDetails['addStudent']['lastname']}}</h3>
                    {{-- <input type="text" value=""> --}}
                <p class="text-muted text-center">{{$studentDetails['addStudent']['schoolname']}}</p>
    
                    <ul class="list-group list-group-unbordered mb-3">
                      <li class="list-group-item">
                        <b>Class</b> <a class="float-right">{{$studentDetails['addStudent']['classnamee']}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Reg No.</b> <a class="float-right">{{$studentDetails['addStudent']['id']}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>System No.</b> <a class="float-right">{{$studentDetails['addStudent']['userid']}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Role.</b> <a class="float-right">{{$studentDetails['addStudent']['role']}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Gender.</b> <a class="float-right">{{$studentDetails['addStudent']['gender']}}</a>
                      </li>
                    </ul>
    
                    {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
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
                      {{$studentDetails['addStudent']['schoolname']}}
                    </p>
    
                    <hr>
    
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
    
                    <p class="text-muted">{{$studentDetails['addStudent']['studentpermanenthomeaddress']}}</p>
    
                    <hr>
    
                    <strong><i class="fas fa-calendar-alt"></i> Date of birth</strong>
    
                    <p class="text-muted">
                      {{-- <span class="tag tag-danger">UI Design</span>
                      <span class="tag tag-success">Coding</span>
                      <span class="tag tag-info">Javascript</span>
                      <span class="tag tag-warning">PHP</span>
                      <span class="tag tag-primary">Node.js</span> --}}
                      {{$studentDetails['addStudent']['dateOfBirth']}}
                    </p>
    
                    <hr>
    
                    <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
    
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
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
                      <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Subjects</a></li>
                      <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Attendance</a></li>
                      <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="active tab-pane" id="activity">
                        <div class="card" style="height: 50px; display: flex; flex-direction: row; align-items: center; border-radius: 0px;">
                          <div style="margin-left: 20px; display: flex; flex-direction: column;">
                            <i style="font-style: normal; font-weight: bold;">Subject Code</i>
                          </div>
                        </div>

                        @if (count($studentDetails['addsubject']) > 0)

                          @foreach ($studentDetails['addsubject'] as $subject)
                              <div class="card subjectcard_student" style="height: 50px; display: flex; flex-direction: row; align-items: center; flex: 1;">
                                <div style="margin-left: 20px; display: flex; flex-direction: column;">
                                  <i style="font-style: normal; font-weight: bold; font-size: 10px;">Subject Code</i>
                                  <i style="font-style: normal; font-size: 12px;">{{$subject->subjectcode}}</i>
                                </div>
                                <div style="margin-left: 20px; display: flex; flex-direction: column;">
                                  <i style="font-style: normal; font-weight: bold; font-size: 10px;">Subject Name</i>
                                  <i style="font-style: normal; font-size: 12px;">{{$subject->subjectname}}</i>
                                </div>
                              </div>
                          @endforeach
                            
                        @endif

              
                        

                        <!-- /.post -->
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="timeline">
                        <div class="card" style="">
                            
                            <i id="dtText" style="padding: 5px;">Ddate</i>

                        </div>
                        <!-- The timeline -->
                          <div class="row">
                            @if (count($studentDetails['daysarray']))
                                @for ($i = 1; $i < $studentDetails['monthcount'] + 1; $i++)
                                    @if (in_array($i, $studentDetails['daysarray']))
                                      <div class="col-4 col-md-2">
                                        <div class="card" style="height: 100px; background-color: #8CE645;">
                                          <p style="font-weight: bold; font-size: 20px; padding: 5px;">{{$i}}</p>
                                        </div>
                                      </div>
                                    @else
                                      <div class="col-4 col-md-2">
                                        <div class="card" style="height: 100px; background-color: #EC7063 ;">
                                          <p style="font-weight: bold; font-size: 20px; padding: 5px;">{{$i}}</p>
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
                        <form class="form-horizontal">
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                              <input type="email" class="form-control" id="inputName" placeholder="Name">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                              <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="inputName2" placeholder="Name">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                            <div class="col-sm-10">
                              <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                              <button type="submit" class="btn btn-danger">Submit</button>
                            </div>
                          </div>
                        </form>
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
            <!-- /.row -->

            @endif
          </section>
    <!-- /.content -->
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
    
@endsection