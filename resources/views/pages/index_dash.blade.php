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
        <!-- Small boxes (Stat box) -->
        @if (count($studentDetails['userschool']) >0)
            @if ($studentDetails['userschool'][0]['status'] == "Approved")
            @if (Auth::user()->role == "Admin")

            @if (count($studentDetails['classList']) < 1 || count($studentDetails['addHouses']) < 1 || count($studentDetails['addSection']) < 1 || count($studentDetails['addClub']) < 1)
                <div class="alert alert-info alert-block">
                  {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
                  <strong>To proceed with using Alpha-sim, we will work you through some compulsory steps.</strong>
                  <div>
                    <i data-toggle="collapse" data-target="#setupschool"><i class="fas fa-hand-point-right"></i> School setup module. More? </i><a href="/setupschool"><button class="btn btn-sm">Proceed</button></a>
                    <div id="setupschool" class="collapse">
                      In this module, you will be required to enter 
                      details such as classlist, clubs and socielties,
                      school houses, School session, etc...
                    </div>
                  </div>
                </div>
            @endif

            @if (count($studentDetails['addgrades']) < 5)
                <div class="alert alert-info alert-block">
                  {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
                  <strong>To proceed with using Alpha-sim, we will work you through some compulsory steps.</strong>
                  <div>
                    <i data-toggle="collapse" data-target="#setupgrades"><i class="fas fa-hand-point-right"></i> Setup grading system now </i><a href="/grades"><button class="btn btn-sm">Proceed</button></a>
                    <div id="setupgrades" class="collapse">
                      In this module, you will be required to fill in your school grading system
                    </div>
                  </div>
                </div>
            @endif
            

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
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
            </div>
            @endif
          @endif
        @endif

        <!-- /.row -->
        <!-- Main row -->
        @if(Auth::user()->schoolid == null)
        <div class="" >
        <h5>System Number: <b id="tempreg" style="color: red;">{{Auth::user()->id}}</b></h5>
          <h6>Alpha-sim guideline</h6>
          <p>1. Upload a passport photograph</p>
          <p>2. Print your registration slip below and take it to your school administrator</p>
          <p>3. Please, don't add a school if you are not an administrator</p>
          @if (Auth::user()->profileimg == null)
          <p style="font-size: 12px; color: red;">You must first upload your passport</p>
            <button class="btn btn-sm btn-info">Print Slip</button>
          @else
        <button class="btn btn-sm btn-info" onclick="PrintImage('storage/schimages/{{Auth::user()->profileimg}}')">Print Slip</button>
          @endif
          

          <form style="width: 100%;" method="POST" action="/uploadProfilePix" enctype="multipart/form-data">
            @csrf

            <div class="alert alert-warning alert-block" style="margin-top:10px;">
              {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
              <strong>Upload a passport photograph.</strong>
              <i>passport dimension: 180px x 180px, max-Size: 200kb</i>
            </div>

            <div style="width: 100%; margin: 0 auto; padding-top: 10px;">
              @include('layouts.message')
            </div>

            <div class="form-group">
              {{-- <label for="exampleInputFile">Passport size photograph (not more than 200KB)</label> --}}
              <div class="input-group">
              <div class="custom-file">
                  <input name="profilepix" style="border: none; background-color:#EEF0F0;" type="file" class="custom-file-input @error('profilepix') is-invalid @enderror" id="profilepix" required>
                  <label class="custom-file-label" for="profilepix">Choose file</label>
              </div>
              <div class="input-group-append">
                  <span class="input-group-text" id="">Upload</span>
              </div>
              </div>
              @error('profilepix')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          <button class="btn btn-sm btn-info">Upload</button>
          </form>

          <div id="GFG">
            <div style="border: 1px solid red; margin-top: 20px; display: flex; flex-direction: row; justify-content: center; align-items: center;">
              @if (Auth::user()->profileimg == null)
              <img src="storage/schimages/profile.png" alt="" width="100px" height="100px">
              @else
              <img src="{{asset('storage/schimages/'.Auth::user()->profileimg)}}" alt="" width="100px" height="100px">
              @endif
              
              <div style="margin-left: 15px;">
                <p>Account Status: <b style="color: red;">Pending</b></p>
                <p id="firstnameprint">Firstname: <b>{{Auth::user()->firstname}}</b></p>
                <p id="middlenameprint">Middlename: <b>{{Auth::user()->middlename}}</b></p>
                <p id="lastnameprint">Lastname: <b>{{Auth::user()->lastname}}</b></p>
              </div>
            </div>
          </div>


        </div>
        @endif
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>


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

            {{-- <div class="card card-default">
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">

                  </div>
                  <div class="col-md-12">
                    <img src="{{asset('storage/schimages/'.Auth::user()->profileimg)}}" class="img-circle elevation-2" alt="Cinque Terre" width="100px" height="100px">
                    
                    <p style="margin-top: 10px;">Name: {{ Auth::user()->firstname }} {{Auth::user()->middlename}} {{Auth::user()->lastname}}</p>
                    <p>Email: {{Auth::user()->email}}</p>
                  </div>
                </div>
                <h5>Accademic Details</h5>
                <div class="row">
                  <div class="col-md-6">
                    <p><b>Class/Section:</b> {{$studentDetails['addStudent']['classid']}}{{$studentDetails['addStudent']['studentsection']}}</p>
                    <hr>
                    <p><b>Session:</b> {{$studentDetails['addStudent']['schoolsession']}}</p>
                    <hr>
                    <p><b>RegNumber:</b> {{$studentDetails['addStudent']['id']}}</p>
                    <hr>
                    <p><b>SystemNumber:</b> {{$studentDetails['addStudent']['usernamesystem']}}</p>
                    <hr>
                    <p><b>House:</b> {{$studentDetails['addStudent']['housename']}}</p>
                    <hr>
                    <p><b>Shift:</b> {{$studentDetails['addStudent']['studentshift']}}</p>
                    


                  </div>
                  <div class="col-md-6">
                    <p><b>Club:</b> {{$studentDetails['addStudent']['studentclub']}}</p>
                    <hr>
                    <p><b>Firstname:</b> {{$studentDetails['addStudent']['firstname']}}</p>
                    <hr>
                    <p><b>Middlename:</b> {{$studentDetails['addStudent']['middlename']}}</p>
                    <hr>
                    <p><b>Lastname:</b> {{$studentDetails['addStudent']['lastname']}}</p>
                    <hr>
                    <p><b>Gender:</b> {{$studentDetails['addStudent']['gender']}}</p>
                    <hr>
                    <p><b>Date of birth:</b> {{$studentDetails['addStudent']['dateOfBirth']}}</p>

                  </div>
                </div>
              </div>
            </div> --}}
            @endif

{{-------------------------------------------------------------------------------------}}
{{--                                      teachers                                   --}}
{{-------------------------------------------------------------------------------------}}

            @if (Auth::user()->role == "Teacher")

            <!-- Info boxes -->
              <div>
                  
                    <div class="row">
                      <div class="col-md-3">
            
                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                          <div class="card-body box-profile">
                            <div class="text-center">
                              <img class="profile-user-img img-fluid img-circle"
                                   src="../../dist/img/user4-128x128.jpg"
                                   alt="User profile picture">
                            </div>
            
                            <h3 class="profile-username text-center">Nina Mcintire</h3>
            
                            <p class="text-muted text-center">Software Engineer</p>
            
                            <ul class="list-group list-group-unbordered mb-3">
                              <li class="list-group-item">
                                <b>Followers</b> <a class="float-right">1,322</a>
                              </li>
                              <li class="list-group-item">
                                <b>Following</b> <a class="float-right">543</a>
                              </li>
                              <li class="list-group-item">
                                <b>Friends</b> <a class="float-right">13,287</a>
                              </li>
                            </ul>
            
                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
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
                            <strong><i class="fas fa-book mr-1"></i> Education</strong>
            
                            <p class="text-muted">
                              B.S. in Computer Science from the University of Tennessee at Knoxville
                            </p>
            
                            <hr>
            
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
            
                            <p class="text-muted">Malibu, California</p>
            
                            <hr>
            
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
            
                            <p class="text-muted">
                              <span class="tag tag-danger">UI Design</span>
                              <span class="tag tag-success">Coding</span>
                              <span class="tag tag-info">Javascript</span>
                              <span class="tag tag-warning">PHP</span>
                              <span class="tag tag-primary">Node.js</span>
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
                              <li class="nav-item"><a class="nav-link active" href="#subjects" data-toggle="tab">Subjects</a></li>
                              <li class="nav-item"><a class="nav-link" href="#attendace" data-toggle="tab">Attendance</a></li>
                              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                          </div><!-- /.card-header -->
                          <div class="card-body">
                            <div class="tab-content">
                              <div class="active tab-pane" id="subjects">

                                <div>
                                    
                                    <div class="card">
                                        <div style="margin: 10px;">
                                            <div style="display: flex; flex-direction: column;">
                                                <i style="font-style: normal; font-size: 12px;">subject name</i>
                                                <i style="font-style: normal; font-size: 12px;">subject code</i>
                                                <i style="font-style: normal; font-size: 12px;">class</i>
                                                <i style="font-style: normal; font-size: 12px;">class count</i>
                                            </div>
                                        </div>
                                    </div>
                                    
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
                
            @endif
            <!-- /.row -->
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