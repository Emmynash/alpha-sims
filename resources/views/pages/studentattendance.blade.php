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
            <h1 class="m-0 text-dark">Student Attendance</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Attendance</li>
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
                        <select id="studentclass" name="studentclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="School Name">
                            <option value="">choose class</option>
                            @foreach ($studentDetails['classList'] as $classlist)
                            <option value="{{$classlist->id}}">{{$classlist->classnamee}}</option>
                          @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                        <select id="studentsection" name="studentsection" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Mobile Number">
                            <option value="">Choose section</option>
                            @foreach ($studentDetails['addSection'] as $section)
                            <option value="{{$section->id}}">{{$section->sectionname}}</option>
                            @endforeach
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
                        <input id="todaysdate" name="todaysdate" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" value="{{$studentDetails['attDate']}}" type="text" placeholder="Date" readonly>
                        </div>
                    </div>
                        
                </form>

              </div>
              <!-- /.col -->
            </div>

            <!-- /.row -->
            <button id="addschoolentiret" type="button" onclick="getstudentList()" class="btn btn-info" form="addschool">Get list</button>
            
            <button id="attendancestudentloading" style="display: none;" class="btn btn-info" disabled>
              <span class="spinner-border spinner-border-sm"></span>
              Loading..
            </button>

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
                  <h3 class="card-title">Teachers List <div style="display: none;" id="atprocess" class="spinner-border"></div></h3>
  
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
                  <table class="table table-hover text-nowrap" id="studenttable">
                    <thead>
                      <tr>
                        <th>Reg No</th>
                        <th>Name</th>
                        <th>Allocated Class</th>
                        <th>Section</th>
                        <th>Gender</th>
                        <th>Is Present?</th>
                      </tr>
                    </thead>
                    <tbody id="tbodyidt">
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
    function getSingleStudent(){
    var regNumber = document.getElementById('regNumberQuery').value
    
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          $.ajax({
            url:"/singleTeacher", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {regNumber: regNumber},
            success:function(result){
                    // alert(result.firstname)

                    var tablee = document.getElementById('studenttable');
                    var row = tablee.insertRow(1);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    var cell5 = row.insertCell(4);
                    var cell6 = row.insertCell(5);
                    cell1.innerHTML = result.useridsystem;
                    cell2.innerHTML = result.firstname +" "+ result.middlename +" "+ result.lastname;
                    cell3.innerHTML = result.classid;
                    cell4.innerHTML = "gender";
                    cell5.innerHTML = result.session;
                    cell6.innerHTML = "<button data-toggle=\"modal\" data-target=\"#modal-lg\" onclick=\"ttt()\" class=\" btn btn-sm bg-success\"><i class=\"far fa-eye\"></i></button class=\" btn btn-sm bg-info\">  <button class=\" btn btn-sm bg-info\"><i class=\"fas fa-user-edit\"></i></button>";

           },
           error:function(){
            alert('failed')
           }
           
         });
     };

     function submitattendance(){
        var myTableArray = [];

        $("table#studenttable tr").each(function() {
            var arrayOfThisRow = [];
            var tableData = $(this).find('td');
            if (tableData.length > 0) {
                tableData.each(function() { arrayOfThisRow.push($(this).text()); });
                myTableArray.push(arrayOfThisRow);
            }
        });

        document.getElementById('arrayofpresent').value = myTableArray

        console.log(myTableArray)

alert(myTableArray);
     }
</script>
<script>

//----------------------------------------------------------------------
//                      get student list for attendance
//----------------------------------------------------------------------
    function getstudentList() {

      var studentclass = document.getElementById('studentclass')

      var studentsection = document.getElementById('studentsection')

      var studentshift  = document.getElementById('studentshift')

      var studentclassMain = studentclass.options[studentclass.selectedIndex].value;
      var studentsectionMain = studentsection.options[studentsection.selectedIndex].value;
      var studentshiftMain = studentshift.options[studentshift.selectedIndex].value;
      var studentSession = document.getElementById('sessionquery').value;
      
      document.getElementById('attendancestudentloading').style.display = "block";
      document.getElementById('addschoolentiret').style.display = "none";

      $("#tbodyidt").empty();

      var letters = /^[0-9/]+$/; 
      if(studentSession.match(letters)) {
        // toastError('Invalid session')
      } else{
        toastError('Invalid session')
      }
    
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
      });
        $.ajax({
          url:"/viewallclass", //the page containing php script
          method: "POST", //request type,
          cache: false,
          data: {studentSession: studentSession, studentclassMain:studentclassMain, studentsectionMain:studentsectionMain, studentshiftMain:studentshiftMain},
          success:function(result){
                  console.log(result)
                  
                  document.getElementById('attendancestudentloading').style.display = "none";
                  document.getElementById('addschoolentiret').style.display = "block";

              for (let index = 0; index < result[0].length; index++) {
                const element = result[0][index];

                var tablee = document.getElementById('studenttable').getElementsByTagName('tbody')[0];
                
                var attendanceCheck = result[1]

                var elementMain = result[0][index]['id']

                var n = attendanceCheck.includes(elementMain.toString());

                console.log(n)

                if (n) {
                    $('#studenttable').find('tbody').append('<tr><td>' + result[0][index]['id'] + '</td><td>' + result[0][index]['firstname'] + ' ' + result[0][index]['middlename'] + ' ' + result[0][index]['lastname'] +'</td><td>'+ result[0][index]['classnamee'] +'</td><td>'+ result[0][index]['sectionname'] +'</td><td>'+ result[0][index]['gender'] +'</td><td><button class="btn"><i style="color: green;" class="fas fa-check"></i></button></td></tr>');
                }else{
                    $('#studenttable').find('tbody').append('<tr><td>'+ result[0][index]['id'] +'</td><td>'+ result[0][index]['firstname'] + ' ' + result[0][index]['middlename'] + ' ' + result[0][index]['lastname'] +'</td><td>'+ result[0][index]['classnamee'] +'</td><td>'+ result[0][index]['sectionname'] +'</td><td>'+ result[0][index]['gender'] +'</td><td><input type="checkbox" onclick="checkStudent(\'' + result[0][index]['id'] + '\')"/></td></tr>');
                }
              }
         },
         error:function(){
          alert('failed')
          document.getElementById('attendancestudentloading').style.display = "none";
          document.getElementById('addschoolentiret').style.display = "block";
         }
         
       });
   };


   function checkStudent(teacherId){
        // document.getElementById('atbtn').style.display = "none"
        document.getElementById('atprocess').style.display = "inline-block"
    
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
      });
        $.ajax({
          url:"{{ route('studentatt') }}", //the page containing php script
          method: "POST", //request type,
          cache: false,
          data: {regNumber: teacherId},
          success:function(result){
                //   alert(result.msg)
                  document.getElementById('atprocess').style.display = "none"
         },
         error:function(){
          alert('failed')
         }
         
       });
   }

   function scrollocation(){
        document.getElementById('studentattendanceaside').className = "nav-link active"
        document.getElementById('addstudentattendanceaside').className = "nav-link active"
    }
</script>
    
@endsection