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
          <!-- SELECT2 EXAMPLE -->
        @if ($studentDetails['userschool'][0]['status'] != "Pending")
        <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">

            <div class="row">
              <div class="col-md-6">
            
                <form id="addschool" method="POST" action="/shoolreg" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <div id="classprocess" class="spinner-border" style="position: absolute; left: 50%; top: 10px; display: none;"></div>
                        <select id="selectedClass" onchange="getClassSubjects()" name="studentclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="School Name">
                            <option value="">choose class</option>
                            @foreach ($studentDetails['classList'] as $classlist)
                            <option value="{{$classlist->id}}" {{ count($studentDetails) > 5 ? $studentDetails['addteachers'][0]['classid'] == $classlist->id ? "" : "disabled" : "" }}>{{$classlist->classnamee}}</option>
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
                            <input id="sessionquery" name="sessionquery" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" value="{{$studentDetails['userschool'][0]['schoolsession']}}" type="text" placeholder="Session">
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
                                <option value="{{$section->sectionname}}" {{ count($studentDetails) > 5 ? $studentDetails['addteachers'][0]['section'] == $section->sectionname ? "" : "disabled" : "" }}>{{$section->sectionname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <input type="text" id="classiddecoy" value="{{ count($studentDetails) > 5 ? $studentDetails['addteachers'][0]['shift'] : "" }}">
                        
                </form>

              </div>
              <!-- /.col -->
            </div>

            <!-- /.row -->
            <button id="addschoolent" onclick="fetchUsersByClassforMarks()" type="button" class="btn btn-info">Process</button>

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin. --}}
          </div>
        </div>

        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Student List <div style="display: none;" id="atprocess" class="spinner-border"></div></h3>
  
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
                  <table class="table table-hover text-nowrap" id="studentfromsameclass">
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
                        <th>Grade</th>
                        <th>Attendance</th>
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

        <div class="modal fade" id="modal-lg">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Name</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div>
                  <div class="row">
                    <div class="col-md-6">

                    </div>
                    <div class="col-md-6">

                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        </div><!-- /.container-fluid -->
      </section>
  </div>

  {{-- modal --}}
  <div class="container">
   <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div>
              <div class="row">
                <div class="col-md-6">
                  <i>Class: <p id="classname"></p></i>
                  <i>Reg No<p id="studentId"></p></i>
                </div>
                <div class="col-md-6">
                  <i>Subject: <p id="subjectselected"></p></i>
                  <i>Roll No: <p id="rollnumber"></p></i>
                </div>
              </div>
          </div>
          <form action="">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="examsmarks">Exams</label>
                  <input id="examsmarks" type="text" class="form-control">
                </div>

              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="ca1marks">CA1</label>
                  <input id="ca1marks" type="text" class="form-control">
                </div>

              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="ca2marks">CA2</label>
                  <input id="ca2marks" type="text" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="ca3marks">CA3</label>
                  <input id="ca3marks" type="text" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="attendancemarks">Assignment</label>
                  <input id="attendancemarks" type="text" class="form-control">
                </div>
              </div>
            </div>
          </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" onclick="addstudentMarks()" class="btn btn-success btn-sm">Submit</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
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
                    const element = console.log(result[index]);
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
//                         fetch users by class for to add marks
//------------------------------------------------------------------------------------------

     function fetchUsersByClassforMarks(){

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

      //  alert(studentsectionMain)
      $("#tbodymarks").empty();


      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          $.ajax({
            url:"/viewusersbyclass", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {session:sessionquery, classId: selectedclassidMain, subjectbyclassid:subjectbyclassidMain, schoolterm:schooltermMain, studentshift:studentshiftMain, studentsection:studentsectionMain},
            success:function(result){
              console.log(result)


              for (let index = 0; index < result[0].length; index++) {
                const element = result[0][index];

                // var tablee = document.getElementById('studentfromsameclass').getElementsByTagName('tbody')[index];
                
                // var attendanceCheck = result[1]

                var elementMain = result[0][index]['regno']

                // var n = attendanceCheck.includes(elementMain.toString());


                for (let index1 = 0; index1 < result[1].length; index1++) {
                  const element = result[1][index1];

                  if (result[1][index1]['id'] == elementMain) {

                    // console.log(result[2])

                    $('#studentfromsameclass').find('tbody').append('<tr><td>'+ result[0][index]['regno'] +'</td><td>'+ result[0][index]['rollnumber'] +'</td><td>'+ result[1][index]['firstnamenew'] + ' ' + result[1][index]['middlenamenew'] + ' ' + result[1][index]['lastnamenew'] + '</tb><td>' + result[0][index]['exams'] + '</td><td>'+ result[0][index]['ca1'] +'</td><td>'+ result[0][index]['ca2'] +'</td><td>'+ result[0][index]['ca3'] +'</td><td>'+ result[0][index]['totalmarks'] +'</td><td>'+ result[0][index]['grades'] +'</td><td>att</td><td><button class="btn btn-success btn-sm" type="button" onclick="studentMarksEnter('+ result[0][index]['id']+', '+ result[0][index]['renumberschoolnew'] +')"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-sm" type="button" onclick="deletemark('+ result[0][index]['id'] +')"><i class="far fa-trash-alt"></i></button></td></tr>');
                    
                  }
                  
                }

                    
                    

              }
         
           },
           error:function(){
            alert('failed')
           }
         });

     }

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
              console.log(result)

              alert(result.msg)

                
              // }
         
           },
           error:function(){
            alert('failed')
           }
         });

         }

         function deletemark(studentmarkId){
            //  alert(studentmarkId)
            

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax({
                    url:"/deletestudent", //the page containing php script
                    method: "POST", //request type,
                    cache: false,
                    data: {studentmarkId:studentmarkId},
                    success:function(result){
                    console.log(result)

                    // alert(result.msg)
                    fetchUsersByClassforMarks()
                    toastSuccess('Record deleted.')
                        
                    // }
                
                },
                error:function(){
                    alert('failed')
                }
            });
         }

    function scrollocation(){
        document.getElementById('viewmarks').className = "nav-link active"
        document.getElementById('viewmarkslist').className = "nav-link active"
        // document.getElementById('birthedit').value = document.getElementById('dateofbirth').value
        // document.getElementById('genderedit').value = document.getElementById('genderdecoy').value
        // document.getElementById('bloodgroupedit').value = document.getElementById('bloodgroupdecoy').value
        document.getElementById('studentshift').value = document.getElementById('classiddecoy').value
   
    }

</script>
    
@endsection