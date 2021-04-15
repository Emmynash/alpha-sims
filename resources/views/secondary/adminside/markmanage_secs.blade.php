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
            <h1 class="m-0 text-dark">Mark Manage</h1>
            <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Mark Manage"
                data-content="On this module, you are required to enter subject scores for each class.">Need help?</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Mark Manage</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


        <div class="card" style="border-top: 2px solid #0B887C;">
          <div id="processgetstudentsspinner" style="position: absolute; top: 0; bottom: 0; right: 0; left: 0; display: none; align-items: center; justify-content: center; z-index: 999;">
            <div class="spinner-border" style="height: 100px; width: 100px;"></div>
          </div>
            <form id="fetchstudentforresultform" action="javascript:console.log('submitted');" method="POST">
                @csrf
                <div class="row" style="margin: 10px;">
                    <div class="col-md-6">
                      <div id="fetchsubjects_sec_process" style="position: absolute; top:0; bottom:0; right:0; left:0; display: none; align-items: center; justify-content: center;">
                        <div class="spinner-border"></div>
                      </div>
                        <div class="form-group">
                            <i style="font-size: 10px; font-style: normal;">Select class</i>
                            <select name="selected_class" id="classselect" class="form-control form-control-sm">
                                <option value="">Select class</option>
                                @if (count($addpost->getClassList($addpost->id)) > 0)
                                    @foreach ($addpost->getClassList($addpost->id) as $classes)
                                      <option value="{{$classes->id}}">{{$classes->classname}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px; font-style: normal;">Select a subject</i>
                            <select name="selected_subject" id="subjectlistfetched" class="form-control form-control-sm">
                                <option value="">Select a subject</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px; font-style: normal;">Select a term</i>
                            <select name="selected_term" id="selected_term" class="form-control form-control-sm">
                                <option value="">Select a term</option>
                                <option value="1">First term</option>
                                <option value="2">Second term</option>
                                <option value="3">Third term</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 10px; font-style: normal;">Session</i>
                            <input name="currentsession" id="currentsession" value="{{$addpost->schoolsession}}" type="text" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px; font-style: normal;">Select section</i>
                            <select name="selected_section" id="selected_section" class="form-control form-control-sm">
                                <option value="">Select a session</option>
                                @if (count($addpost->getSectionList($addpost->id)) > 0)
                                    @foreach ($addpost->getSectionList($addpost->id) as $section)
                                      <option value="{{$section->id}}">{{$section->sectionname}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <button id="fetchstudentforresultbtn" type="button" class="btn btn-info btn-sm">Query</button>
                </div>
            </form>
        </div>


                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 id="selectedsubject" class="card-title">Students List</h3>
          
                          <div class="card-tools">
                            {{-- <div class="input-group input-group-sm" style="width: 150px;">
                              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
          
                              <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                              </div>
                            </div> --}}
                          </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover text-nowrap">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Exams</th>
                                <th>CA1</th>
                                <th>CA2</th>
                                <th>CA3</th>
                                <th>Total</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>FullMark</td>
                                <td id="exams_sec_f">0</td>
                                <td id="ca1_sec_f">0</td>
                                <td id="ca2_sec_f">0</td>
                                <td id="ca3_sec_f">0</td>
                                <td id="total_sec_f">0</td>
                              </tr>
                              <tr>
                                <td>PassMarks</td>
                                <td id="exams_sec_p">0</td>
                                <td id="ca1_sec_p">0</td>
                                <td id="ca2_sec_p">0</td>
                                <td id="ca3_sec_p">0</td>
                                <td id="total_sec_p">0</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                  </div>
                  <!-- /.row -->

















                  

                @if(Auth::user()->role != "Teacher")
                  <div id="notificationalertmarks" style="display: none;" class="alert alert-info">
                    <strong>Note</strong> Click on the process button only when you are done inputing all student marks for all subject.<br>
                    <strong>Important</strong> To ensure results are generated with accuracy, all student results schould be imputed
                    and for students with no marks in certain subjects, zero should be recorded.
                  </div>
                @else
                    <div id="notificationalertmarks" style="display: none;" class="alert alert-info"></div>
                @endif
        

                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Students List</h3>






          
                          <div class="card-tools">
                            {{-- <div class="input-group input-group-sm" style="width: 150px;">
                              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
          
                              <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                              </div>
                            </div> --}}
                            @if(Auth::user()->role != "Teacher")
                                <button id="processresultpositionmarks" style="display: none;" class="btn btn-info btn-sm" data-toggle="modal" data-target="#resultprocessmodat">Process</button>
                            
                            @else

                                
                                <button id="processresultpositionmarks" style="display: none;" class="btn btn-info btn-sm" data-toggle="modal" disabled data-target="#resultprocessmodat">Process</button>
                            @endif
                            

                            <!-- The Modal -->
                            <div class="modal fade" id="resultprocessmodat">
                              <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                
                                  <!-- Modal Header -->
                                  <div class="modal-header processheatfooter">
                                    <h4 class="modal-title">Important Note</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>
                                  
                                  <!-- Modal body -->
                                  <div class="modal-body" style="height: 100px;">
                                    <div id="spinnerprocess" style="position: absolute; top: 0; bottom: 0; right: 0; left: 0; height: 50px; display: none; align-items: center; justify-content: center;">
                                      <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                        <div class="spinner-border"></div>
                                        <i font-style: normal; font-size:12px;>Processing...</i>
                                      </div>
                                    </div>

                                    <div id="spinnerprocesssuccessfailure" style="position: absolute; top: 0; bottom: 0; right: 0; left: 0; height: 50px; display: none; align-items: center; justify-content: center;">
                                      <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                        <i id="successfailureicon" style="font-size: 25px;" class="fas fa-check-circle"></i>
                                        <i id="successfailuretext" style="font-style: normal; font-size:12px;">Success...</i>
                                      </div>
                                    </div>


                                    
                                    <div id="processnotice">
                                      <i>Accept only after inputing all student marks. Are you sure you want to proceed?</i>
                                      <br>
                                      <i style="font-style: normal; color: red;"><strong>Note:</strong> This process is irreversible</i>
                                      <form id="processformmarksform" action="javascript:console.log('submited')" method="post">
                                        @csrf
                                        <input type="hidden" name="classidmarks" id="classidmarks">
                                        <input type="hidden" name="sessionprocessmark" id="sessionprocessmark">
                                        <input type="hidden" name="processterm" id="processterm">
                                      </form>
                                    </div>
                                  </div>
                                  
                                  <!-- Modal footer -->
                                  <div class="modal-footer processheatfooter">
                                    <button id="processformmarksbtn" form="processformmarksform" type="button" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover text-nowrap">
                            <thead>
                              <tr>
                                <th>Reg No</th>
                                <th>Roll No</th>
                                <th>Name</th>
                                <th>Exams</th>
                                <th>CA1</th>
                                <th>CA2</th>
                                <th>CA3</th>
                                <th>Total</th>
                                <th>Position</th>
                                <th>Grade</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody id="studentmarkslist">
                              {{-- <tr>
                                <td>183</td>
                                <td>John Doe</td>
                                <td>11-7-2014</td>
                                <td>Approved</td>
                                <td>Bacon ipsum.</td>
                                <td>Bacon ipsum.</td>
                                <td>Bacon ipsum.</td>
                                <td>Bacon ipsum.</td>
                                <td>Bacon ipsum.</td>
                                <td>Bacon ipsum.</td>
                              </tr> --}}
                              
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                  </div>
                  <!-- /.row -->

                    <!-- The Modal -->
                    <div class="modal fade" id="myModal">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                        
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h6 id="modalstudentname" class="modal-title">Modal Heading</h6>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          
                          <!-- Modal body -->
                          <div class="modal-body">
                            <i style="font-size: 10px" id="messagedisplay"></i>

                            <form id="submitmarksmainform" action="javascript:console.log('submitted')" method="post">
                              @csrf
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <i style="font-size: 10px;">Exams</i>
                                    <input type="text" name="examsmarksentered" id="examsmarksentered" class="form-control form-control-sm">
                                  </div>
                                  <div class="form-group">
                                    <i style="font-size: 10px;">CA1</i>
                                    <input type="text" name="ca1marksentered" id="ca1marksentered" class="form-control form-control-sm">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <i style="font-size: 10px;">CA2</i>
                                    <input type="text" name="ca2marksentered" id="ca2marksentered" class="form-control form-control-sm">
                                  </div>
                                  <div class="form-group">
                                    <i style="font-size: 10px;">CA3</i>
                                    <input type="text" name="ca3marksentered" id="ca3marksentered" class="form-control form-control-sm">
                                  </div>
                                </div>
                              </div>
                              <input type="hidden" name="studentregno" id="studentregno">
                              <input type="hidden" name="studentsection" id="studentsection">
                              <input type="hidden" name="classidmain" id="classidmain">
                              <input type="hidden" name="subjectid" id="subjectid">
                              <input type="hidden" name="currentterm" id="currentterm">
                              <input type="hidden" name="currentsessionform" id="currentsessionform">
                              <input type="hidden" name="markidstudent" id="markidstudent">
                              <button id="submitmarksmainbtn" class="btn btn-sm btn-info">Submit</button>
                              <button id="addmarkprogress" style="display: none;" class="btn btn-primary" disabled>
                                <span class="spinner-border spinner-border-sm"></span>
                                Please wait..
                              </button>
                            </form>
                          </div>
                          
                          <!-- Modal footer -->
                          <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button> --}}
                          </div>
                          
                        </div>
                      </div>
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
        document.getElementById('managemarkscroll').className = "nav-link active"
      }

      function addmarksmodaltrigger(nameid, middlename, lastname, exams, ca1, ca2, ca3, id, classid, markid){
        $('#myModal').modal('show');
        document.getElementById('modalstudentname').innerHTML = nameid+" "+middlename+" "+lastname;
        if (exams == "null") {
          document.getElementById('examsmarksentered').value = "";
        }else{
          document.getElementById('examsmarksentered').value = exams;
        }
        if (ca1 == "null") {
          document.getElementById('ca1marksentered').value = "";
        } else {
          document.getElementById('ca1marksentered').value = ca1;
        }
        if (ca2 == "null") {
          document.getElementById('ca2marksentered').value = "";
        } else {
          document.getElementById('ca2marksentered').value = ca2;
        }

        if (ca3 == "null") {
          document.getElementById('ca3marksentered').value = "";
        } else {
          document.getElementById('ca3marksentered').value = ca3;
        }

        if (markid == "null") {
          document.getElementById('markidstudent').value = "NA";
        } else {
          document.getElementById('markidstudent').value = markid;
        }
        
        document.getElementById('studentregno').value = id;
        document.getElementById('classidmain').value = classid;
        document.getElementById('subjectid').value = document.getElementById('subjectlistfetched').value;
        document.getElementById('currentterm').value = document.getElementById('selected_term').value;
        document.getElementById('currentsessionform').value = document.getElementById('currentsession').value;
        document.getElementById('studentsection').value = document.getElementById('selected_section').value;
        
      }
  </script>
    
@endsection