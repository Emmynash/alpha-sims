@extends('layouts.app_dash')

@section('content')

  <!-- Main Sidebar Container -->
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
            <h1 class="m-0 text-dark">Add Teacher</h1>
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

            @if (count($studentDetails['addteachers']) < 1)
                <div class="alert alert-info alert-block">
                    {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
                    <strong>It seems you don't have a teacher in your school. Who will then teach your students?</strong>
                    <i>You can add a teacher using system Id</i>
                </div>
            @endif

            <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">
            <h4 style="padding-top: 10px;">Class Allocation Details</h4>
            <div class="row">
              <div class="col-md-12">
                    <!--<form id="addteacherprimary" method="POST" action="/addteachermain">-->
                    <!--    @csrf-->
                        
                        <div class="card">
                            
                                  <div class="alert alert-info alert-block" style="margin: 10px;">
                                    {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
                                    <strong>Each class should have one form master. Use the form to allocate for each class.</strong>
                                  </div>
                            
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div style="margin: 10px;">
                                                    <form action="javascript:console.log('submited')" method="post">
                                                        @csrf
                                                        <div class="form-group">
                                                            <select name="selectedclassteacher" id="selectedclassteacher" class="form-control form-control-sm">
                                                                <option>Select a class</option>
                                                                @if(count($studentDetails['classList']) > 0)
                                                                
                                                                    @foreach($studentDetails['classList'] as $classlists)
                                                                    
                                                                     <option value="{{$classlists->id}}">{{$classlists->classnamee}}</option>
                                                                    
                                                                    @endforeach
                                                                
                                                                @endif
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <select name="selectedsectionteacher" id="selectedsectionteacher" class="form-control form-control-sm">
                                                                <option>Select a section</option>
                                                                @if(count($studentDetails['addSection']) > 0)
                                                                
                                                                    @foreach($studentDetails['addSection'] as $addSection)
                                                                    
                                                                     <option value="{{$addSection->id}}">{{$addSection->sectionname}}</option>
                                                                    
                                                                    @endforeach
                                                                
                                                                @endif
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <input type="text" id="teacherRegNoConfirm" class="form-control form-control-sm" placeholder="system number">
                                                        </div>
                                                        
                                                        <button id="btnfetchteachersdetails" type="submit" onclick="teacherDetails()" class="btn btn-sm btn-info">Confirm</button>
                                                        
                                                        <button id="btnfetchteachersdetailsloading" style="display: none;" class="btn btn-primary btn-sm" type="button" disabled>
                                                          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                          Loading...
                                                        </button>
                                                        
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div style="margin: 10px;">
                                                    <p><i id="formclassgiven"></i></p>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div style="margin: 10px;">
                                            <div class="row">
                                                  <div class="col-md-4">
                                                      <div style="display: flex; align-items: center; justify-content: center; margin-bottom:5px;">
                                                          <img id="studentprofileimgteacher" style="" src="storage/schimages/profile.png" class="img-circle elevation-2" alt="" width="150px" height="150px">
                                                      </div>
                                                  </div>
                                                  <div class="col-md-8">
                                                      <form id="formteacherallocationform" action="javascript:console.log('submited')" method="POST">
                                                          @csrf
                                                          <div>
                                                             <input type="text" id="firstname" class="form-control form-control-sm" placeholder="firstname">
                                                             <br>
                                                             <input type="text" id="middlename" class="form-control form-control-sm" placeholder="middlename">
                                                             <br>
                                                             <input type="text" id="lastname" class="form-control form-control-sm" placeholder="lastname">
                                                          </div>
                                                          <input type="hidden" id="systemnumberTeacher" name="systemnumberTeacher">
                                                          <input type="hidden" id="formclass" name="formclass">
                                                          <input type="hidden" id="formsection" name="formsection">
                                                          <input type="hidden" id="key" name="key" value="form">
                                                          <br>
                                                          <button id="formteacherallocationbtn" class="btn btn-sm btn-info">Asign</button>
                                                      </form>
                                                  </div>
    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                        
                            <!--<div class="form-group">-->
                            <!--<select name="teacherallocatedclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="School Name">-->
                            <!--        <option value="">choose class</option>-->
                            <!--    @foreach ($studentDetails['classList'] as $classlist)-->
                            <!--        <option value="{{$classlist->id}}">{{$classlist->classnamee}}</option>-->

                            <!--    @endforeach-->
                            <!--</select>-->
                            <!--</div>-->
                            
                            <!--<div class="form-group">-->
                            <!--<input id="teacherRegNoConfirm" name="systemnumber" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Temporary Registration No">-->
                            
                            <!--</div>-->
                            <!--{{-- <div class="form-group">-->
                            <!--<input id="newregnumber" name="teachernewregnum" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="New Reg No" readonly>-->
                            <!--<button type="button" data-toggle="collapse" data-target="#classnametip" style="font-size: 10px;">New Registration Number?</button>-->
                            <!--<div id="classnametip" class="collapse" style="border-bottom: 10px;">-->
                            <!--    <p style="margin-left: 10px; font-size: 13px;">-->
                            <!--    Registration number is alocated automatically to every Teacher -->
                            <!--    <i style="color: red;">This field is auto generated.</i>-->
                            <!--    </p>-->
                            <!--</div>-->
                            <!--</div> --}}-->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-12">
                            
                            <div class="card">
                                
                                  <div class="alert alert-info alert-block" style="margin: 10px;">
                                    {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
                                    <strong>Each subject needs a teacher for each class. Use the form below to asign teachers to subject.</strong>
                                  </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div style="margin: 10px;">
                                                    <form action="javascript:console.log('submited')" method="post">
                                                        @csrf
                                                        <div class="form-group">
                                                            <select id="subjectAllocatedSubjectmain" class="form-control form-control-sm">
                                                                <option>Select a Subject</option>
                                                                @if(count($studentDetails['addsubjects']) > 0)
                                                                
                                                                    @foreach($studentDetails['addsubjects'] as $addsubjects)
                                                                    
                                                                     <option value="{{$addsubjects->id}}">{{$addsubjects->subjectname}}/{{$addsubjects->subjectcode}}/{{$addsubjects->classnamee}}</option>
                                                                    
                                                                    @endforeach
                                                                
                                                                @endif
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <input type="text" id="teacherRegNoConfirmclass" class="form-control form-control-sm" placeholder="system number">
                                                        </div>
                                                        
                                                        <button id="btnfetchteachersdetailsclassbtn" class="btn btn-sm btn-info" onclick="teacherDetailsclass()">Confirm</button>
                                                        
                                                        <button id="btnfetchteachersdetailsclassloading" style="display: none;" class="btn btn-primary btn-sm" type="button" disabled>
                                                          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                          Loading...
                                                        </button>
                                                        
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div style="margin: 10px;">
                                            <div class="row">
                                                  <div class="col-md-4">
                                                      <div style="display: flex; align-items: center; justify-content: center; margin-bottom:5px;">
                                                          <img id="studentprofileimgteacherclass" style="" src="storage/schimages/profile.png" class="img-circle elevation-2" alt="" width="150px" height="150px">
                                                      </div>
                                                  </div>
                                                  <div class="col-md-8">
                                                      <form id="allocatesubjectteacherform" action="javascript:console.log('submited')" method="POST">
                                                          @csrf
                                                          <div>
                                                             <input type="text" id="firstnameclass" class="form-control form-control-sm" placeholder="firstname">
                                                             <br>
                                                             <input type="text" id="middlenameclass" class="form-control form-control-sm" placeholder="firstname">
                                                             <br>
                                                             <input type="text" id="lastnameclass" class="form-control form-control-sm" placeholder="firstname">
                                                          </div>
                                                          
                                                          <input type="hidden" id="systemnumberTeacherSubject" name="systemnumberTeacherSubject">
                                                          <input type="hidden" id="subjectAllocatedSubject" name="subjectAllocatedSubject">
                                                          <input type="hidden" id="key" name="key" value="class">
                                                          
                                                          <br>
                                                          <button id="allocatesubjectteacherbtn" class="btn btn-sm btn-info">Asign</button>
                                                      </form>
                                                  </div>
    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>
                            <!--<div class="form-group">-->
                            <!--    <input name="schoolsession" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" value="{{$studentDetails['userschool'][0]['schoolsession']}}" type="text" placeholder="Session">-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <select name="teachersection" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Student House">-->
                            <!--        <option value="">Select section</option>-->
                            <!--        @foreach ($studentDetails['addSection'] as $section)-->
                            <!--        <option value="{{$section->sectionname}}">{{$section->sectionname}}</option>-->
                            <!--        @endforeach-->
                            <!--    </select>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <select name="teachershift" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Address">-->
                            <!--        <option value="">Choose shift</option>-->
                            <!--        <option value="Morning">Morning</option>-->
                            <!--        <option value="Afternoon">Afternoon</option>-->
                            <!--    </select>-->
                            <!--</div>-->
                            <!--<p>Verify reg no before proceeding</p>-->
                            <!--<button type="button" class="btn btn-sm bg-info" onclick="teacherDetails()" style="margin-top: 2px;">confirm</button>-->

                        </div>
                        <!-- /.col -->
                        </div>
                        <br>
                        <!--<div class="row">-->
                        <!--    <div class="col-md-6">-->
                        <!--        <img id="studentprofileimgteacher" src="storage/schimages/profile.png" alt="" width="100px" height="100px" style="margin-bottom: 10px;">-->

                        <!--    <div class="form-group">-->
                        <!--        <input id="firstname" name="firstnamenew" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="First name">-->
                        <!--    </div>-->
                        <!--    <div class="form-group">-->
                        <!--        <input id="middlename" name="middlenamenew" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Middle name">-->
                        <!--    </div>-->
                        <!--    <div class="form-group">-->
                        <!--        <input id="lastname" name="lastnamenew" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Last name">-->
                        <!--    </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                    <!--</form>-->
                        <!-- /.row -->
                        <!--<button type="submit" class="btn btn-info" form="addteacherprimary">Submit</button>-->

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
        document.getElementById('teachersaside').className = "nav-link active"
        document.getElementById('addteacheraside').className = "nav-link active"
    }
</script>
    
@endsection