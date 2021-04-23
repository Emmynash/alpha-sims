@extends('layouts.app_dash')

@section('content')

    <!-- Main Sidebar Container -->
    @include('layouts.asideside')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    {{-- <div style="width: 90%; margin: 0 auto; padding-top: 10px;">
      @include('layouts.message')
    </div> --}}
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Student</h1>
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
          <!-- SELECT2 EXAMPLE -->


        @include('layouts.message')

        <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-header">
            <i>Please all students will have to first create an account because only the system number is required for registration. However, you as an admin can create account for the student.</i>
          </div>
          <div class="card-body">
            <h4 style="padding-top: 10px;">Academic Details</h4>
            <div class="row">
              <div class="col-md-6">
          <form id="addstudent" method="POST" action="javascript:console.log('submitted');">
            
            <div id="projectalert" class="alert alert-warning alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>	
              <i class="fas fa-exclamation-circle"></i><strong id="subjectalertmessage"> You must first verify user.</strong>
            </div>

              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <select id="classid" name="studentclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="School Name">
                          <option value="">choose class</option>
                        @foreach ($classList as $classlist)
                          <option value="{{$classlist->id}}">{{$classlist->classnamee}}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <select id="studentsectionvalue" name="studentsection" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="Student House">
                      <option value="">Select section</option>
                      @foreach ($addSection as $section)
                      <option value="{{$section->id}}">{{$section->sectionname}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <input id="studentRegNoConfirm" name="systemnumber" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="Student Registration No">
                  </div>
                </div>
                <div class="col-md-6">

                  {{-- <div class="form-group">
                    <input id="schoolsession" name="schoolsession" style="border: none; background-color:#EEF0F0;" value="{{$studentDetails['userschool'][0]['schoolsession']}}" class="form-control form-control-sm" type="text" placeholder="Session">
                  </div> --}}

                  <div class="form-group">
                    <select id="studentshift" name="studentshift" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="Address">
                      <option value="">Choose shift</option>
                      <option value="Morning">Morning</option>
                      <option value="Afternoon">Afternoon</option>
                    </select>
                  </div>

                  <p>Verify reg no before proceeding</p>
                  <button id="btnuserreg" type="submit" class="btn btn-sm bg-info" style="margin-top: 2px;">confirm</button>

                 
                  </div>
                </div>
              </form>

              </div>
              <!-- /.col -->
              <div class="col-md-6" style="display: flex; flex-direction: column; justify-content: center;">
                <div id="spinnerprocessstd" style="display: none; z-index: 999;">
                  <div style="position: absolute; top: 0; bottom: 0; right: 0; left: 0; display: flex; justify-content: center; align-items: center;">
                    <div class="spinner-border" style="width: 100px; height: 100px;"></div>
                  </div>
                </div>

                <div>

                  <div class="row" style="display: flex; align-items: center;">
                    <div class="col-md-4" style="display: flex; align-items: center; justify-content: center;">
                      <img id="conprofileimg" style="" src="storage/schimages/profile.png" class="img-circle elevation-2" alt="" width="150px" height="150px">
                    </div>
                    <div class="col-md-8" style="">

                      <div class="form-group">
                        <input id="confirstname" name="systemnumber1" value="{{ old('systemnumber1') }}" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="Student Registration No" readonly>
                      </div>

                      <div class="form-group">
                        <input id="conmiddlename" name="systemnumber2" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="Student Registration No" readonly>
                      </div>

                      <div class="form-group">
                        <input id="conlastname" name="systemnumber3" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="Student Registration No" readonly>
                      </div>

                    </div>
                  </div>

                </div>
                
                 
              </div>
              <!-- /.col -->
            </div>
      <div id="formforstudent">
            <h4 style="padding-top: 30px;">Student Details</h4>

          <form id="addstudentstd" method="POST" action="{{ route('studentreg') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div>
                <input type="hidden" id="classidstd" value="{{ old('classidstd') }}" name="classidstd">
                <input type="hidden" id="StudentSectionstd" value="{{ old('StudentSectionstd') }}" name="StudentSectionstd">
                <input type="hidden" id="systemnumberstd" value="{{ old('systemnumberstd') }}" name="systemnumberstd">
                <input type="hidden" id="currentsessionstd" value="{{ old('currentsessionstd') }}" name="currentsessionstd">
                <input type="hidden" id="shiftstd" value="{{ old('shiftstd') }}" name="shiftstd">
              </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                      <select name="studentgender" id="studentgender" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('studentgender') is-invalid @enderror" value="{{ old('studentgender') }}">
                          <option value="">Choose gender</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                      </select>
                      @error('studentgender')
                        <span class="invalid-feedback" role="alert">
                            <strong>Field is required</strong>
                        </span>
                      @enderror
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
                      <input name="dateofbirth" id="dateofbirth"  style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('dateofbirth') is-invalid @enderror" type="date" placeholder="Father's no">
                      @error('dateofbirth')
                        <span class="invalid-feedback" role="alert">
                            <strong>Field is required</strong>
                        </span>
                      @enderror
                    </div>
                    
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <select id="studentbloodgroup" name="studentbloodgroup" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('studentbloodgroup') is-invalid @enderror" type="text" placeholder="Blood group">
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
                        @error('studentbloodgroup')
                        <span class="invalid-feedback" role="alert">
                            <strong>Field is required</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                      <select name="studenthouse" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('studenthouse') is-invalid @enderror" type="text" placeholder="Mobile Number">
                        <option value="">Choose house</option>
                        @foreach ($addHouses as $houses)
                        <option value="{{$houses->id}}">{{$houses->housename}}</option>
                        @endforeach
                      </select>
                      @error('studenthouse')
                      <span class="invalid-feedback" role="alert">
                          <strong>Field is required</strong>
                      </span>
                      @enderror
                    </div>

                </div>
            </div>

            <h4 style="padding-top: 30px;">Clubs and Society</h4>
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <select name="studentclub" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('studentclub') is-invalid @enderror" type="text" placeholder="">
                            <option value="">Choose a club/society</option>
                            @foreach ($addClub as $club)
                            <option value="{{$club->clubname}}">{{$club->clubname}}</option>
                            @endforeach
                        </select>
                        @error('studentclub')
                        <span class="invalid-feedback" role="alert">
                            <strong>Field is required</strong>
                        </span>
                        @enderror
                    </div>

                </div>
                <div class="col-md-6">

                </div>

            </div>

            <h4 style="padding-top: 30px;">Guardian's Detail</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input name="studentfathername" value="{{ old('studentfathername') }}" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('studentfathername') is-invalid @enderror" type="text" placeholder="Father's name">
                        @error('studentfathername')
                        <span class="invalid-feedback" role="alert">
                            <strong>Field is required</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="studentfathernumber" value="{{ old('studentfathernumber') }}" maxlength="11" name="studentfathernumber" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('studentfathernumber') is-invalid @enderror" type="text" placeholder="Father's no">
                        @error('studentfathernumber')
                        <span class="invalid-feedback" role="alert">
                            <strong>Invalid Phone Number</strong>
                        </span>
                        @enderror
                    </div>


                </div>
                <div class="col-md 6">
                    <div class="form-group">
                        <input name="studentmothersname" value="{{ old('studentmothersname') }}" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('studentmothersname') is-invalid @enderror" type="text" placeholder="Mother's name">
                        @error('studentmothersname')
                        <span class="invalid-feedback" role="alert">
                            <strong>Field is required</strong>
                        </span>
                        @enderror
                     </div>
                    <div class="form-group">
                        <input id="studentmothersnumber" value="{{ old('studentmothersnumber') }}" name="studentmothersnumber" maxlength="11" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('studentmothersnumber') is-invalid @enderror" type="text" placeholder="Mothers no">
                        @error('studentmothersnumber')
                        <span class="invalid-feedback" role="alert">
                            <strong>Invalid Phone Number</strong>
                        </span>
                        @enderror
                    </div>

                </div>
            </div>

            <h4 style="padding-top: 30px;">Address Detail</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea name="studentpresenthomeaddress" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('studentpresenthomeaddress') is-invalid @enderror" type="text" placeholder="Present home address">{{ old('studentpresenthomeaddress') }}</textarea>
                        @error('studentpresenthomeaddress')
                        <span class="invalid-feedback" role="alert">
                            <strong>Field is required</strong>
                        </span>
                        @enderror
                    </div>

                </div>
                <div class="col md 6">
                  <div class="form-group">
                    <textarea name="studentpermanenthomeaddress" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('studentpermanenthomeaddress') is-invalid @enderror" type="text" placeholder="Permanent home address">{{ old('studentpermanenthomeaddress') }}</textarea>
                    @error('studentpermanenthomeaddress')
                    <span class="invalid-feedback" role="alert">
                        <strong>Field is required</strong>
                    </span>
                    @enderror
                  </div>
                </div>
            </div>
          </form>
            <!-- /.row -->
            {{-- <button id="verifystudent" onclick="verifyStudentEntry()" type="button" class="btn btn-warning">Verify</button> --}}
            <button id="addstudentbtn" type="submit" class="btn btn-info" form="addstudentstd">Submit</button>
        </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin. --}}
          </div>
        </div>
        <!-- /.card -->


{{---------------------------------------------------------------------------------}}
{{--                        modal for selection                                  --}}
{{---------------------------------------------------------------------------------}}
        <!-- The Modal -->
        <div class="modal fade" id="addstudentmethod">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
            
              <!-- Modal Header -->
              <div class="modal-header">
                <h6 class="modal-title">Choose one Option</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              
              <!-- Modal body -->
              <div class="modal-body">
                <div>
                  <i>Have the student already created an account?</i>
                  <button class="btn btn-success btn-sm" data-dismiss="modal">Yes</button>
                  <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#addnewstudentmodal">No</button>
                </div>
              </div>
              
              <!-- Modal footer -->
              <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
              </div>
              
            </div>
          </div>
        </div>

        </div><!-- /.container-fluid -->
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

<!-- ./wrapper -->

<script>
  document.querySelector("#studentfathernumber").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  document.querySelector("#studentmothersnumber").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  function scrollocation(){
    document.getElementById('studentaside').className = "nav-link active"
    document.getElementById('addstudentaside').className = "nav-link active"
    // $("#addstudentmethod").modal('show');
  }
</script>
    
@endsection