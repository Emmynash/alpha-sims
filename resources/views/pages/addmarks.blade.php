@extends('layouts.app_dash')

@section('content')

{{-- aside menu --}}
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
            <h1 class="m-0 text-dark">Add Marks</h1>
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
          <div style="display: none;">
            <div class="" style="position: absolute; top: 0; bottom:0; right: 0; left: 0; z-index: 999; display: flex; justify-content: center; align-items: center; background-color: #fff; opacity: 0.2;">
              <div class="spinner-border" style="width: 100px; height: 100px;"></div>
            </div>
          </div>


          @if (count($studentDetails['gradeCheck']) < 5)
            <div class="alert alert-warning alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>	
              <strong><i class="fas fa-exclamation-circle"></i> First setup School grading system before proceeding. Click <a href="/grade"><button class="btn btn-info btn-sm">Here</button></a> to setUp</strong>
              <small>Eample: A, B, C, D, E, F</small>
            </div>
          @endif

          <!-- SELECT2 EXAMPLE -->
        @if ($studentDetails['userschool'][0]['status'] != "Pending")
        <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">

            <div class="row">
              <div class="col-md-6">
            
                <form id="studentmarksform" method="POST" action="javascript:console.log('submitted');" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <div id="classprocess" class="spinner-border" style="position: absolute; left: 50%; top: 10px; display: none;"></div>
                        <select id="selectedClass" onchange="getClassSubjects()" name="studentclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="School Name">
                            <option value="">choose class</option>
                            @foreach ($studentDetails['classList'] as $classlist)
                            <option value="{{$classlist->id}}">{{$classlist->classnamee}}</option>
                          @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                            {{-- <label for="todaysdate" style="font-weight: normal; font-size: 12px; color: red;">Date in this format (YYYY-MM-DD)</label> --}}
                            <select id="subjectbyclassid" onchange="getstudentList()" name="subjectbyclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="YYYY-MM-DD">
                                <option value="">Select Subject</option>
                            </select>
                            </div>
                        <div class="form-group">
                            <select id="schoolterm" name="schoolterm" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Address">
                                <option value="">school term</option>
                                <option value="1">First Term</option>
                                <option value="2">Second Term</option>
                                <option value="3">Third Term</option>
                            </select>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                    <div id="formdivtwo">
                        <div class="form-group">
                            <input id="sessionquery" name="sessionquery" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" value="{{$studentDetails['userschool'][0]['schoolsession']}}" type="text" placeholder="Session" readonly>
                        </div>
                        <div class="form-group">
                            <select id="studentshift" name="studentshift" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Address">
                                <option value="Choose shift">Choose shift</option>
                                <option value="Morning">Morning</option>
                                <option value="Afternoon">Afternoon</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="studentsection" name="studentsection" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Mobile Number">
                                <option value="">Choose section</option>
                                @foreach ($studentDetails['addSection'] as $section)
                                <option value="{{$section->sectionname}}">{{$section->sectionname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        
                </form>

              </div>
              <!-- /.col -->
            </div>

            <!-- /.row -->
            <button id="studentmarksbtn" type="submit" class="btn btn-info">Process</button>
            <button id="markmanagebtnprocess" class="btn btn-info" disabled style="display: none">
              <span class="spinner-border spinner-border-sm"></span>
              Please Wait..
            </button>

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin. --}}
          </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 id="subjectselectedname">Name of subject</h6>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Marks</th>
                      <th>Exams</th>
                      <th>CA1</th>
                      <th>CA2</th>
                      <th>CA3</th>
                    </tr>
                  </thead>
                  <thead>
                    <tr>
                      <th>Full Marks</th>
                      <th id="fullmark">0</th>
                      <th id="fullmarkexams">0</th>
                      <th id="fullmarkca1">0</th>
                      <th id="fullmarkca2">0</th>
                      <th id="fullmarkca3">0</th>
                    </tr>
                  </thead>
                  <thead>
                    <tr>
                      <th>Pass Mark</th>
                      <th id="passmark">0</th>
                      <th id="passmarkexams">0</th>
                      <th id="passmarkca1">0</th>
                      <th id="passmarkca2">0</th>
                      <th id="passmarkca3">0</th>
                    </tr>
                  </thead>
                </table>
              </div>
        </div>
        
              <div id="notificationalertmarks" style="display: none;" class="alert alert-info">
                    <strong>Note</strong> Click on the process button only when you are done inputing all student marks for all subject.<br>
                    <strong>Important</strong> To ensure results are generated with accuracy, all student results schould be imputed
                    and for students with no marks in certain subjects, zero should be recorded.
              </div>

        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Student List <div style="display: none;" id="atprocess" class="spinner-border"></div></h3>
  
                  <div class="card-tools">
                      <button id="processresultpositionmarks" style="display: none;" class="btn btn-info btn-sm" data-toggle="modal" data-target="#resultprocessmodat">Process</button>
                      
                      
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
                                        <input type="hidden" name="selectedsection" id="selectedsessionmarksin">
                                      </form>
                                    </div>
                                  </div>
                                  
                                  <!-- Modal footer -->
                                  <div class="modal-footer processheatfooter">
                                    <button id="processformmarksbtn" form="processformmarksform" type="submit" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
                                  </div>
                                </div>
                              </div>
                            </div>

                  </div>
                </div>
                <!-- /.card-header -->
                <div id="studentmarksscroll" class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap" id="tableformarks">
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
                    <tbody id="tbodymarks">
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>

        <!-- /.card -->
        @endif
        @if ($studentDetails['userschool'][0]["status"] !="Approved")
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Status</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              
              
              
              
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>School Id</th>
                      <th>Email</th>
                      <th>Phone Number</th>
                      <th>Active From</th>
                      <th>End On</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      @if ($studentDetails['userschool'][0] !="Approved")

                      @foreach ($studentDetails['userschool'] as $schools)
                        <td>{{$studentDetails['userschool'][0]['schoolId']}}</td>
                        <td>{{$studentDetails['userschool'][0]['schoolemail']}}</td>
                        <td>{{$studentDetails['userschool'][0]['mobilenumber']}}</td>
                        <td>{{$studentDetails['userschool'][0]['periodfrom']}}</td>
                        <td>{{$studentDetails['userschool'][0]['periodto']}}</td>
                        <td><span class="tag tag-success">{{$studentDetails['userschool'][0]['status']}}</span></td>
                      @endforeach
                        
                      @endif
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        @endif

        {{-- marks modal begin --}}
        
        <!-- The Modal -->
        <div class="modal fade" id="marsmodalmain">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
            
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 id="modalheadmarks" class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              
              <!-- Modal body -->
              <div class="modal-body">

                <div class="alert alert-info alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>	
                  <strong style="font-size: 12px;"><i class="fas fa-info-circle"></i> Student result can be entered when they are available...</strong>
                </div>

                <form action="javascript:console.log('submitted');" id="marksformmain" method="post">
                  @csrf
                  <div style="display: flex; flex-direction: column;">
                    {{-- <label id="studentregnomarks">StudentRegNo</label> --}}
                    {{-- <label id="termmark">Term</label>
                    <label id="sessionmark">Session</label> --}}
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <i style="font-size: 10px;">Exam Mark</i>
                        <input name="exams" id="exams" type="number" class="form-control form-control-sm" placeholder="exams">
                      </div>
                      <div class="form-group">
                        <i style="font-size: 10px;">CA1 Mark</i>
                        <input name="ca1" id="ca1" type="number" class="form-control form-control-sm" placeholder="ca1">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <i style="font-size: 10px;">CA2 Mark</i>
                        <input name="ca2" id="ca2" type="number" class="form-control form-control-sm" placeholder="ca2">
                      </div>
                      <div class="form-group">
                        <i style="font-size: 10px;">CA3 Mark</i>
                        <input name="ca3" id="ca3" type="number" class="form-control form-control-sm" placeholder="ca3">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <i style="font-size: 10px;">Reg No</i>
                        <input name="studentregnomarks" id="studentregnomarks" type="text" value="" class="form-control form-control-sm" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <i style="font-size: 10px;">Session</i>
                      <input name="schoolsession" type="text" value="{{$studentDetails['userschool'][0]['schoolsession']}}" class="form-control form-control-sm" readonly>
                      </div>
                    </div>
                  </div>
                  <input id="schooltermform" name="schooltermform" type="hidden" readonly>
                  <input type="hidden" id="selectedClassform" name="selectedClassform" readonly>
                  <input type="hidden" id="studentshiftform" name="studentshiftform" readonly>
                  <input type="hidden" id="studentsectionform" name="studentsectionform" readonly>
                  <input type="hidden" id="markidform" name="markidform" readonly>
                  <input type="hidden" id="subjectbyclassidform" name="subjectbyclassidform" readonly>
                </form>
              </div>
              
              <!-- Modal footer -->
              <div class="modal-footer">
                <button id="marksformmainbtn" type="button" class="btn btn-success btn-sm">Submit</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
              </div>
              
            </div>
          </div>
        </div>
        {{-- marks modal ends --}}

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

//---------------------------------------------------------------------------------
//                   fetch subject unique to a selected class
//---------------------------------------------------------------------------------

    function getClassSubjects(){
    var classSelect = document.getElementById('selectedClass')
        classSelect.disabled = true

    var studentclassMain = classSelect.options[classSelect.selectedIndex].value;

    var processIndicator = document.getElementById('classprocess')
    processIndicator.style.display = "inline-block"
    
    document.getElementById('classidmarks').value = document.getElementById('selectedClass').value;
    document.getElementById('sessionprocessmark').value = document.getElementById('sessionquery').value;

    $('#subjectbyclassid')
    .find('option')
    .remove()
    .end()
    .append('<option value="whatever">Select Subject</option>')
    .val('')

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          $.ajax({
            url:"/getclasssubject", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {classid: studentclassMain},
            success:function(result){
                classSelect.disabled = false
                processIndicator.style.display = "none"

                for (let index = 0; index < result.length; index++) {
                    // console.log(result[index]);
                    var subjectselect = document.getElementById('subjectbyclassid')
                    var option = document.createElement("option");
                    option.text = result[index]['subjectname'];
                    option.value = result[index]['id']
                    subjectselect.add(option);
                }
                    // console.log(result)                   
           },
           error:function(){
            alert('failed')
           }
         });
     };

    
//-----------------------------------------------------------------------------------------//
//                      fetch selected subject full and pass marks                         //
// ----------------------------------------------------------------------------------------//

     function getstudentList(){

        var subjectbyclassid = document.getElementById('subjectbyclassid')

        var studentclassMain = subjectbyclassid.options[subjectbyclassid.selectedIndex].value;

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          $.ajax({
            url:"/getsubjectmarks", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {subjectId: studentclassMain},
            success:function(result){
                document.getElementById('fullmark').innerHTML = result[0]['totalfull'];
                document.getElementById('fullmarkexams').innerHTML = result[0]['examfull'];
                document.getElementById('fullmarkca1').innerHTML = result[0]['ca1full'];
                document.getElementById('fullmarkca2').innerHTML = result[0]['ca2full'];
                document.getElementById('fullmarkca3').innerHTML = result[0]['ca3full'];

                document.getElementById('passmark').innerHTML = result[0]['totalpass'];
                document.getElementById('passmarkexams').innerHTML = result[0]['exampass'];
                document.getElementById('passmarkca1').innerHTML = result[0]['ca1pass'];
                document.getElementById('passmarkca2').innerHTML = result[0]['ca2pass'];
                document.getElementById('passmarkca3').innerHTML = result[0]['ca3pass'];

                document.getElementById('subjectselectedname').innerHTML = result[0]['subjectname'];         
           },
           error:function(){
            alert('failed')
           }
         });
     }


//------------------------------------------------------------------------------------------
//                         fetch users by class to add marks
//------------------------------------------------------------------------------------------

    //  function fetchUsersByClassforMarks(){

    //    var selectedclassid = document.getElementById('selectedClass')
    //    var subjectbyclassid = document.getElementById('subjectbyclassid')
    //    var schoolterm = document.getElementById('schoolterm')
    //    var sessionquery = document.getElementById('sessionquery').value
    //    var studentshift = document.getElementById('studentshift')
    //    var studentsection = document.getElementById('studentsection')

    //    var selectedclassidMain = selectedclassid.options[selectedclassid.selectedIndex].value;
    //    var subjectbyclassidMain = subjectbyclassid.options[subjectbyclassid.selectedIndex].value;
    //    var schooltermMain = schoolterm.options[schoolterm.selectedIndex].value;
    //    var studentshiftMain = studentshift.options[studentshift.selectedIndex].value;
    //    var studentsectionMain = studentsection.options[studentsection.selectedIndex].value;

    //   //  alert(studentsectionMain)
    //   $("#tbodymarks").empty();


    //   $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    //     });
    //       $.ajax({
    //         url:"/fetchusersbyclass", //the page containing php script
    //         method: "POST", //request type,
    //         cache: false,
    //         data: {session:sessionquery, classId: selectedclassidMain, subjectbyclassid:subjectbyclassidMain, schoolterm:schooltermMain, studentshift:studentshiftMain, studentsection:studentsectionMain},
    //         success:function(result){
    //           console.log(result)


    //           for (let index = 0; index < result[0].length; index++) {
    //             const element = result[0][index];

    //             // var tablee = document.getElementById('studentfromsameclass').getElementsByTagName('tbody')[index];
                
    //             var attendanceCheck = result[1]

    //             var elementMain = result[0][index]['id']

    //             var n = attendanceCheck.includes(elementMain.toString());



    //             // console.log(result[index])

    //             if (n) {

    //             for (let index2 = 0; index2 < result[2].length; index2++) {
    //               const element = result[2][index2];

    //               if (result[2][index2]['regno'] == elementMain) {

    //                 // console.log(result[2])

    //                 $('#studentfromsameclass').find('tbody').append('<tr><td>'+ result[0][index]['id'] +'</td><td>'+ result[0][index]['renumberschoolnew'] +'</td><td>'+ result[0][index]['firstname'] + ' ' + result[0][index]['middlename'] + ' ' + result[0][index]['lastname'] + '</tb><td>' + result[2][index2]['exams'] + '</td><td>'+ result[2][index2]['ca1'] +'</td><td>'+ result[2][index2]['ca2'] +'</td><td>'+ result[2][index2]['ca3'] +'</td><td></td><td><button class="btn btn-sm" type="button" onclick="studentMarksEnter('+ result[0][index]['id']+', '+ result[0][index]['renumberschoolnew'] +')"><i style="color: green;" class="fas fa-check"></i></button></td></tr>');
                    
    //               }
                  
    //             }

    //             }else{
    //               $('#studentfromsameclass').find('tbody').append('<tr><td>'+ result[0][index]['id'] +'</td><td>'+ result[0][index]['renumberschoolnew'] +'</td><td>'+ result[0][index]['firstname'] + ' ' + result[0][index]['middlename'] + ' ' + result[0][index]['lastname'] + '</tb><td></td><td></td><td></td><td></td><td></td><td><button class="btn btn-success btn-sm" type="button" onclick="studentMarksEnter('+ result[0][index]['id']+', '+ result[0][index]['renumberschoolnew'] +')" data-toggle="modal" data-target="#myModal"><i class="far fa-plus-square"></i></button></td></tr>');
    //             }

                    
                
    //           }
         
    //        },
    //        error:function(){
    //         alert('failed')
    //        }
    //      });

    //  }

     function submitMarks(){
        var tableInfo = Array.prototype.map.call(document.querySelectorAll('#studentfromsameclass tbody tr input'), function(tr){
        return Array.prototype.map.call(tr.querySelectorAll('td'), function(td){
          // return td.innerHTML;
          console.log(td.innerHTML)
          });
        });
     }

     function studentMarksEnter(studentId, rollNumber){


       var selectedclassid = document.getElementById('selectedClass')
       var subjectbyclassid = document.getElementById('subjectbyclassid')
       var schoolterm = document.getElementById('schoolterm')
       var sessionquery = document.getElementById('sessionquery').value
       var studentshift = document.getElementById('studentshift')
       var studentsection = document.getElementById('studentsection')

       var selectedclassidMain = selectedclassid.options[selectedclassid.selectedIndex].innerHTML;
       var subjectbyclassidMain = subjectbyclassid.options[subjectbyclassid.selectedIndex].innerHTML;
       var schooltermMain = schoolterm.options[schoolterm.selectedIndex].value;
       var studentshiftMain = studentshift.options[studentshift.selectedIndex].value;
       var studentsectionMain = studentsection.options[studentsection.selectedIndex].value;

        document.getElementById('classname').innerHTML = selectedclassidMain;
        document.getElementById('subjectselected').innerHTML = subjectbyclassidMain;
        document.getElementById('rollnumber').innerHTML = rollNumber
        document.getElementById('studentId').innerHTML = studentId

      //  alert(selectedclassidMain)
     }

     function addstudentMarks(){
        var examsmarks = document.getElementById('examsmarks').value
        var ca1marks = document.getElementById('ca1marks').value
        var ca2marks = document.getElementById('ca2marks').value
        var ca3marks = document.getElementById('ca3marks').value
        var attendancemarks = document.getElementById('attendancemarks').value

       var selectedclassid = document.getElementById('selectedClass')
       var subjectbyclassid = document.getElementById('subjectbyclassid')
       var schoolterm = document.getElementById('schoolterm')
       var sessionquery = document.getElementById('sessionquery').value
       var studentshift = document.getElementById('studentshift')
       var studentsection = document.getElementById('studentsection')

       var selectedclassidMain = selectedclassid.options[selectedclassid.selectedIndex].value;
       var subjectbyclassidMain = subjectbyclassid.options[subjectbyclassid.selectedIndex].value;
       var schooltermMain = schoolterm.options[schoolterm.selectedIndex].value;
       var studentshiftMain = studentshift.options[studentshift.selectedIndex].value;
       var studentsectionMain = studentsection.options[studentsection.selectedIndex].value;

       var rollnumber = document.getElementById('rollnumber').innerHTML
       var studentId = document.getElementById('studentId').innerHTML


        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          $.ajax({
            url:"/addstudentmarks", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {rollnumber:rollnumber, studentId:studentId, sessionquery:sessionquery, examsmarks:examsmarks, ca1marks: ca1marks, ca2marks:ca2marks, ca3marks:ca3marks, attendancemarks:attendancemarks, selectedclassidMain:selectedclassidMain, subjectbyclassidMain:subjectbyclassidMain, schooltermMain:schooltermMain, studentshiftMain:studentshiftMain, studentsectionMain:studentsectionMain},
            success:function(result){
              // console.log(result)
              if (result.msg == "Failed") {
                toastsuccess("Grading system not set")
              }else{
                fetchUsersByClassforMarks()
              }
              
              // alert(result.msg)

                
              // }
         
           },
           error:function(){
            alert('failed')
           }
         });

         }

         function marksprocess(firstname, middlename, lastname, regno, idmark){
            // alert(marknumber)

            document.getElementById('modalheadmarks').innerHTML = firstname +" "+ middlename+" "+lastname
            document.getElementById('studentregnomarks').value = regno
            document.getElementById('schooltermform').value = document.getElementById('schoolterm').value
            document.getElementById('selectedClassform').value = document.getElementById('selectedClass').value
            document.getElementById('studentshiftform').value = document.getElementById('studentshift').value
            document.getElementById('studentsectionform').value = document.getElementById('studentsection').value
            document.getElementById('markidform').value = idmark
            document.getElementById('subjectbyclassidform').value = document.getElementById('subjectbyclassid').value
            document.getElementById('exams').value = ""
            document.getElementById('ca1').value = ""
            document.getElementById('ca2').value = ""
            document.getElementById('ca3').value = ""
         }

         function marksprocessupdate(firstname, middlename, lastname, regno, idmark, exams, ca1, ca2, ca3){
            // alert(marknumber)

            document.getElementById('modalheadmarks').innerHTML = firstname +" "+ middlename+" "+lastname
            document.getElementById('studentregnomarks').value = regno
            document.getElementById('schooltermform').value = document.getElementById('schoolterm').value
            document.getElementById('selectedClassform').value = document.getElementById('selectedClass').value
            document.getElementById('studentshiftform').value = document.getElementById('studentshift').value
            document.getElementById('studentsectionform').value = document.getElementById('studentsection').value
            document.getElementById('markidform').value = idmark
            document.getElementById('subjectbyclassidform').value = document.getElementById('subjectbyclassid').value
            
            if (exams == "undefined") {
              document.getElementById('exams').value = ""
            } else {
              document.getElementById('exams').value = exams
            }

            if (ca1 == "undefined") {
              document.getElementById('ca1').value = ""
            } else {
              document.getElementById('ca1').value = ca1
            }

            if (ca2 == "undefined") {
              document.getElementById('ca2').value = ""
            } else {
              document.getElementById('ca2').value = ca2
            }

            if (ca3 == "undefined") {
              document.getElementById('ca3').value = ""
            } else {
              document.getElementById('ca3').value = ca3
            }
         }

    function scrollocation(){
        document.getElementById('viewmarks').className = "nav-link active"
        document.getElementById('viewmarksadd').className = "nav-link active"
        // document.getElementById('studentshift').value = document.getElementById('classiddecoy').value
        
        
   
    }
    
    
    function addstudentMarks(){
        var examsmarks = document.getElementById('examsmarks').value
        var ca1marks = document.getElementById('ca1marks').value
        var ca2marks = document.getElementById('ca2marks').value
        var ca3marks = document.getElementById('ca3marks').value
        var attendancemarks = document.getElementById('attendancemarks').value

       var selectedclassid = document.getElementById('selectedClass')
       var subjectbyclassid = document.getElementById('subjectbyclassid')
       var schoolterm = document.getElementById('schoolterm')
       var sessionquery = document.getElementById('sessionquery').value
       var studentshift = document.getElementById('studentshift')
       var studentsection = document.getElementById('studentsection')

       var selectedclassidMain = selectedclassid.options[selectedclassid.selectedIndex].value;
       var subjectbyclassidMain = subjectbyclassid.options[subjectbyclassid.selectedIndex].value;
       var schooltermMain = schoolterm.options[schoolterm.selectedIndex].value;
       var studentshiftMain = studentshift.options[studentshift.selectedIndex].value;
       var studentsectionMain = studentsection.options[studentsection.selectedIndex].value;

       var rollnumber = document.getElementById('rollnumber').innerHTML
       var studentId = document.getElementById('studentId').innerHTML


        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          $.ajax({
            url:"/addstudentmarks", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {rollnumber:rollnumber, studentId:studentId, sessionquery:sessionquery, examsmarks:examsmarks, ca1marks: ca1marks, ca2marks:ca2marks, ca3marks:ca3marks, attendancemarks:attendancemarks, selectedclassidMain:selectedclassidMain, subjectbyclassidMain:subjectbyclassidMain, schooltermMain:schooltermMain, studentshiftMain:studentshiftMain, studentsectionMain:studentsectionMain},
            success:function(result){
              // console.log(result)
              if (result.msg == "Failed") {
                toastsuccess("Grading system not set")
              }else{
                fetchUsersByClassforMarks()
              }
              
              // alert(result.msg)

                
              // }
         
           },
           error:function(){
            alert('failed')
           }
         });

    }

</script>
    
@endsection