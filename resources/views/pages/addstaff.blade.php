@extends('layouts.app_dash')

@section('content')

@include('layouts.asideside')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div style="width: 90%; margin: 0 auto; padding-top: 10px;">
      @include('layouts.message')
    </div>
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Staff</h1>
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
            <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">
            {{-- <h4 style="padding-top: 10px;">Class Allocation Details</h4> --}}
            <div class="row">
              <div class="col-md-6">
                    <form id="addstaff" method="POST" action="javascript:console.log('submitted');">
                        @csrf
                            <div class="form-group">
                                <label for="teacherRegNoConfirm">System Number</label>
                                <input id="teacherRegNoConfirm" name="systemnumber" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="number" placeholder="Temporary Registration No">
                            </div>
                            <div id="staffconfirmprocess" style="display: none;" class="spinner-border"></div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            
                    

                        </div>
                        <!-- /.col -->
                        </div>
                        <br>

                        
                    </form>
                        <!-- /.row -->
                        <button type="button" class="btn btn-info" id="addstaffbtn">Submit</button>

                        <!-- The Modal -->
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                <h4 class="modal-title">Modal Heading</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="staffmodal" style="display: flex; flex-direction: column; align-items: center;">
                                        <div class="card" style="height: 100px; width: 100px; display: flex; align-items: center; justify-content: center;">
                                            <div id="profilepix" class="spinner-border" style="opacity: 0.5; width: 50px; height: 50px;"></div>
                                            <img id="profileuploaded" style="display: none;" src="" class="img-circle elevation-2" alt="" width="70px" height="70px">
                                        </div>
                                        <br>
                                        <div class="card" style="width: 95%; height: 150px;">
                                            <label for="" style="padding-left: 5px;">FirstName: <i id="firstnamemain"></i></label>
                                            <label for="" style="padding-left: 5px;">MiddleName: <i id="middlenamemain"></i></label>
                                            <label for="" style="padding-left: 5px;">LastName: <i id="lastnamemain"></i></label>
                                            <form action="/addstaffrecord" method="post" style="width: 95%; margin: 0 auto;" id="rolealocationform">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="Selectrole">Select a role</label>
                                                    <select name="SelectRole" class="form-control" id="Selectrole">
                                                        <option value="">Select Role</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Supervisor">Supervisor</option>
                                                        <option value="Librarian">Librarian</option>
                                                        <option value="Accountant">Accountant</option>
                                                    </select>
                                                </div>
                                                <input name="staffid" type="hidden" id="staffid">
                                            </form>

                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-success" form="rolealocationform">submit</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                                </div>
                                
                            </div>
                            </div>
                        </div>
          </div>
        </div>
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
        document.getElementById('managestaffaside').className = "nav-link active"
    }
</script>
    
@endsection