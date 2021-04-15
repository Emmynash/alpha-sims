@extends('layouts.app_dash')

@section('content')

  <!-- Main Sidebar Container -->
  @include('layouts.asideside')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div style="width: 90%; margin: 0 auto; padding-top: 10px;">
      {{-- @include('layouts.message') --}}
    </div>
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Profile</h1>
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
            @if ($studentDetails['userschool'][0]['status'] != "Pending" && $studentDetails['userschool'][0]['schooltype'] == "Primary")

            <div class="alert alert-info alert-block">
              {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
              <strong>It is required that you enter correct infomation. Details you enter here will be verified against your documents.</strong>
              <i>Your account will be disabled if false data is found</i>
              
            </div>

            <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">
            <h4 style="padding-top: 10px;"></h4>
            <form id="editteacherprofile" action="/editteachersdata" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6" style="">
                        <div class="form-group">
                            <i style="font-size: 12px;">First Name</i>
                            <input id="firstnameedit" name="firstnameedit" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('firstnameedit') is-invalid @enderror" value="{{ old('firstnameedit' . Auth::user()->firstname, Auth::user()->firstname) }}" type="text" placeholder="First Name">
                            @error('firstnameedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The First Name feild is required</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <i style="font-size: 12px;">Middle Name</i>
                            <input id="middlenameedit" name="middlenameedit" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('middlenameedit') is-invalid @enderror" type="text" value="{{ old('firstnameedit' . Auth::user()->middlename, Auth::user()->middlename) }}" placeholder="Middle Name">
                            @error('middlenameedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The Middle Name feild is required</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <i style="font-size: 12px;">Last Name</i>
                            <input id="lastnameedit" name="lastnameedit" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('lastnameedit') is-invalid @enderror" value="{{ old('firstnameedit' . Auth::user()->lastname, Auth::user()->lastname) }}" type="text" placeholder="Last Name">
                            @error('lastnameedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The last Name feild is required</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <i style="font-size: 12px;">Gender</i>
                            <select name="genderedit" id="genderedit" class="form-control form-control-lg @error('genderedit') is-invalid @enderror" style="border: none; background-color:#EEF0F0;">
                                <option value="">select a value</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @error('genderedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <i style="font-size: 12px;">Religion</i>
                            <select id="religionedit" name="religionedit" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('religionedit') is-invalid @enderror" type="text" placeholder="Religion">
                                <option value="">Choose Religion</option>
                                <option value="Christianity">Christianity</option>
                                <option value="Islam">Islam</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('religionedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <i style="font-size: 12px;">Bloodgroup</i>
                            <select id="bloodgroupedit" name="bloodgroupedit" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('bloodgroupedit') is-invalid @enderror" type="text" placeholder="Blood group">
                                <option value="">Choose blood group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                            @error('bloodgroupedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>
    
                    </div>
                    <div class="col-md-6" style="">
                        <div class="form-group">
                            <i style="font-size: 12px;">Email</i>
                            <input id="emailedit" name="emailedit" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('emailedit') is-invalid @enderror" value="{{ old('emailedit' . Auth::user()->email, Auth::user()->email) }}" type="text" placeholder="Email">
                            @error('emailedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>The email feild is required</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <i style="font-size: 12px;">Course of Study</i>
                            <input id="courseedit" name="courseedit" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('courseedit') is-invalid @enderror" value = "{{ old('courseedit' . $studentDetails['addteachers'][0]['courseedit'], $studentDetails['addteachers'][0]['courseedit']) }}" type="text" placeholder="Course of Study"> 
                            @error('courseedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <i style="font-size: 12px;">Institution (As it appear on your certificate. will be verified)</i>
                            <input id="institutionedit" name="institutionedit" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('institutionedit') is-invalid @enderror" value="{{ old('institutionedit' . $studentDetails['addteachers'][0]['institutionedit'], $studentDetails['addteachers'][0]['institutionedit']) }}" type="text" placeholder="Institution">
                            @error('institutionedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <i style="font-size: 12px;">Class of Degree</i>
                            <input id="degreeedit" name="degreeedit" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('degreeedit') is-invalid @enderror" value="{{ old('degreeedit' . $studentDetails['addteachers'][0]['degreeedit'], $studentDetails['addteachers'][0]['degreeedit']) }}" type="text" placeholder="Class of Degree">
                            @error('degreeedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <i style="font-size: 12px;">Level of Education (BSC, etc...)</i>
                            <input id="educationedit" name="educationedit" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('educationedit') is-invalid @enderror" value="{{ old('educationedit' . $studentDetails['addteachers'][0]['educationedit'], $studentDetails['addteachers'][0]['educationedit']) }}" type="text" placeholder="Level of Education">
                            @error('educationedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <i style="font-size: 12px;">Year of Graduation</i>
                            <input id="graduationedit" name="graduationedit" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('graduationedit') is-invalid @enderror" value="{{ old('graduationedit' . $studentDetails['addteachers'][0]['graduationedit'], $studentDetails['addteachers'][0]['graduationedit']) }}" type="number" placeholder="Year of Graduation">
                            @error('graduationedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>
                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <i style="font-size: 12px;">Date of Birth</i>
                            <input id="birthedit" name="birthedit" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('birthedit') is-invalid @enderror" value="{{ old('birthedit' . $studentDetails['addteachers'][0]['birthedit'], $studentDetails['addteachers'][0]['birthedit']) }}" type="date" placeholder="Date of Birth">
                            @error('birthedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 12px;">Residential Addrress</i>
                            <textarea name="addressedit" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('addressedit') is-invalid @enderror" type="text" placeholder="Residential address">{{ old('addressedit' . $studentDetails['addteachers'][0]['residentialaddress'], $studentDetails['addteachers'][0]['residentialaddress']) }}</textarea>
                            @error('addressedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

            <input type="hidden" name="entryid" value="{{$studentDetails['addteachers'][0]['id']}}">
            <input type="hidden" id="dateofbirth" value="{{$studentDetails['addteachers'][0]['dob']}}">
            <input type="hidden" id="genderdecoy" value="{{$studentDetails['addteachers'][0]['gender']}}">
            <input type="hidden" id="religiondecoy" value="{{$studentDetails['addteachers'][0]['religion']}}">
            <input type="hidden" id="bloodgroupdecoy" value="{{$studentDetails['addteachers'][0]['bloodgroup']}}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 12px;">Passport</i>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" name="passportedit" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text" id="">Upload</span>
                              </div>
                            </div>
                          </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 12px;">Signature</i>
                            <div class="input-group">
                              <div class="custom-file">
                                <input name="signatureedit" type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text" id="">Upload</span>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            </form>
            <i style="font-size: 12px; color:red;">By submiting this form we assume all the information is 
                correct and that any false data will be assumed as frodulent.</i><br>
            <button class="btn btn-info btn-sm" type="submit" form="editteacherprofile">Submit</button>
{{------------------------------------------------------------------------------------}}
{{--                                      secondary school                          --}}
{{------------------------------------------------------------------------------------}}
            @else

            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">
                  <h4 style="padding-top: 10px;">Class Allocation Details</h4>
                  <div class="row">
                    <div class="col-md-6">
                          <form id="addteachersecondary" method="POST" action="/studentreg" enctype="multipart/form-data">
                              @csrf
                                  <div class="form-group">
                                  <select name="studentclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="School Name">
                                          <option value="">choose class</option>
                                      @foreach ($studentDetails['classList'] as $classlist)
                                          <option value="{{$classlist->classnamee}}">{{$classlist->classnamee}}</option>
      
                                      @endforeach
                                  </select>
                                  </div>
                                  <div class="form-group">
                                  <input id="studentRegNoConfirm" name="systemnumber" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Temporary Registration No">
                                  <p>Verify reg no before proceeding</p>
                                  <button type="button" class="btn btn-sm bg-info" onclick="confirmRegNo()" style="margin-top: 2px;">confirm</button>
                                  </div>
                                  <div class="form-group">
                                  <input id="newregnumber" name="studentnewregnum" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="New Reg No" readonly>
                                  <button type="button" data-toggle="collapse" data-target="#classnametip" style="font-size: 10px;">New Registration Number?</button>
                                  <div id="classnametip" class="collapse" style="border-bottom: 10px;">
                                      <p style="margin-left: 10px; font-size: 13px;">
                                      Registration number is alocated automatically to every Teacher 
                                      <i style="color: red;">This field is auto generated.</i>
                                      </p>
                                  </div>
                                  </div>
                              </div>
                              <!-- /.col -->
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <input name="schoolsession" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Session">
                                  </div>
                                  <div class="form-group">
                                      <select name="studentsection" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Student House">
                                          <option value="">Select section</option>
                                          @foreach ($studentDetails['addSection'] as $section)
                                          <option value="{{$section->sectionname}}">{{$section->sectionname}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <select name="studentshift" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Address">
                                          <option value="Choose shift">Choose shift</option>
                                          <option value="Morning">Morning</option>
                                          <option value="Afternoon">Afternoon</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                    <select name="studentshift" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Allocate course">
                                        <option value="Choose shift">Allocate course</option>
                                        <option value="Morning">Morning</option>
                                        <option value="Afternoon">Afternoon</option>
                                    </select>
                                </div>
      
                              </div>
                              <!-- /.col -->
                              </div>
                              <h4 style="padding-top: 30px;">Teacher's Details</h4>
                              <div class="row">
                                  
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input id="firstname" name="firstnamenew" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="First name">
                                      </div>
                                      <div class="form-group">
                                          <input id="middlename" name="middlenamenew" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Middle name">
                                      </div>
                                      <div class="form-group">
                                          <input id="lastname" name="lastnamenew" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Last name">
                                      </div>
                                      <div class="form-group">
                                      <label for="dateofbirth">Date of birth</label>
                                      <input id="dateofbirth" name="dateofbirth" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="date" placeholder="Date of birth">
                                  </div>
      
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <select name="studentgender" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Gender">
                                              <option value="">Choose gender</option>
                                              <option value="Male">Male</option>
                                              <option value="Female">Female</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <select name="sudentreligion" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Religion">
                                              <option value="">Choose Religion</option>
                                              <option value="Christianity">Christianity</option>
                                              <option value="Islam">Islam</option>
                                              <option value="Other">Other</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <select name="studentbloodgroup" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Blood group">
                                              <option value="">Choose blood group</option>
                                              <option value="A+">A+</option>
                                              <option value="A-">A-</option>
                                              <option value="B+">B+</option>
                                              <option value="B-">B-</option>
                                              <option value="AB+">AB+</option>
                                              <option value="AB-">AB-</option>
                                              <option value="O+">O+</option>
                                              <option value="O-">O-</option>
                                          </select>
                                      </div>
      
                                  </div>
                              </div>
      
                              <h4 style="padding-top: 30px;">Address Detail</h4>
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <textarea name="studentpresenthomeaddress" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Present home address"></textarea>
                                      </div>
                                      <div class="form-group">
                                          <textarea name="studentpermanenthomeaddress" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Permanent home address"></textarea>
                                      </div>
      
                                  </div>
                                  <div class="col md 6">
                                  <div class="form-group">
                                      <label for="exampleInputFile">Passport size photograph (not more than 200KB)</label>
                                      <div class="input-group">
                                      <div class="custom-file">
                                          <input name="studentpassport" style="border: none; background-color:#EEF0F0;" type="file" class="custom-file-input" id="exampleInputFile">
                                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                      </div>
                                      <div class="input-group-append">
                                          <span class="input-group-text" id="">Upload</span>
                                      </div>
                                      </div>
                                  </div>
                                  </div>
                              </div>
                          </form>
                              <!-- /.row -->
                              <button type="submit" class="btn btn-info" form="addteachersecondary">Submit</button>
      
                </div>
            </div>




            @endif
        </div>
    </section>
</div>

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
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

<script>
    function scrollocation(){
        document.getElementById('editteacher').className = "nav-link active"
        document.getElementById('birthedit').value = document.getElementById('dateofbirth').value
        document.getElementById('genderedit').value = document.getElementById('genderdecoy').value
        document.getElementById('bloodgroupedit').value = document.getElementById('bloodgroupdecoy').value
        document.getElementById('religionedit').value = document.getElementById('religiondecoy').value
   
    }
</script>
    
@endsection