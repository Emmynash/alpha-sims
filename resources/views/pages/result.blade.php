@extends('layouts.app_dash')

@section('content')


  <!-- Main Sidebar Container -->
  @include('layouts.asideside')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Generate Result</h1>
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
          <div style="margin: 0 auto; padding-top: 10px;">
            @include('layouts.message')
          </div>
          <!-- SELECT2 EXAMPLE -->
        @if ($studentDetails['userschool'][0]['status'] != "Pending")
        <div class="card card-default">

          <!-- /.card-header -->
          <div class="card-body">

            <div class="row">
              <div class="col-md-6">
            
                <form id="psycomotoquery" method="POST" action="/processresult" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                        <select id="studentclass" name="studentclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="School Name" required>
                            <option value="">choose class</option>
                            @foreach ($studentDetails['classList'] as $classlist)
                            <option value="{{$classlist->id}}">{{$classlist->classnamee}}</option>
    
                          @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                          <select id="schoolterm" name="schoolterm" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Address" required>
                              <option value="">school term</option>
                              <option value="1">First Term</option>
                              <option value="2">Second Term</option>
                              <option value="3">Third Term</option>
                          </select>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                    <div id="formdivtwo" style="">
                        <div class="form-group">
                            <!--<i style="font-size: 12px;">Student Reg No.</i>-->
                            <input id="regno" name="regno" value="{{Auth::user()->role == "Student" ? $studentDetails['addstudent'][0]['id']: ""}}" style="border: none; background-color:#EEF0F0;" {{Auth::user()->role == "Student" ? "readonly": ""}} class="form-control form-control-lg" type="text" placeholder="Reg No">
                        </div>
                    </div>
                    
                    <div id="formdivtwo" style="">
                        <div class="form-group">
                            <!--<i style="font-size: 12px;">Session</i>-->
                            <input id="schoolsession" name="schoolsession" placeholder="Session" class="form-control form-control-lg" style="border: none; background-color:#EEF0F0;">
                        </div>
                    </div>
                        
                </form>

              </div>
              <!-- /.col -->
            </div>

            <!-- /.row -->
            <button id="addschoolente" style="" type="submit" class="btn btn-info" form="psycomotoquery">Query result</button>

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin. --}}
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
            url:"/confirmRegNew", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {regNumber: regNumber},
            success:function(result){
                    console.log(result)

                    for (let index = 0; index < result.length; index++) {
                      const element = index[index];

                      var tablee = document.getElementById('studenttable');
                      var row = tablee.insertRow(1);
                      var cell1 = row.insertCell(0);
                      var cell2 = row.insertCell(1);
                      var cell3 = row.insertCell(2);
                      var cell4 = row.insertCell(3);
                      var cell5 = row.insertCell(4);
                      var cell6 = row.insertCell(5);
                      cell1.innerHTML = result[index]['id'];
                      cell2.innerHTML = result[index]['classid'];
                      cell3.innerHTML = result[index]['firstnamenew'] +" "+ result[index]['middlenamenew'] +" "+ result[index]['lastnamenew'];
                      cell4.innerHTML = result[index]['gender'];
                      cell5.innerHTML = result[index]['studentreligion'];
                      cell6.innerHTML = "<button data-toggle=\"modal\" data-target=\"#modal-lg\" onclick=\"ttt()\" class=\" btn btn-sm bg-success\"><i class=\"far fa-eye\"></i></button class=\" btn btn-sm bg-info\">  <button class=\" btn btn-sm bg-info\"><i class=\"fas fa-user-edit\"></i></button>";

                      
                    }



                    // var tablee = document.getElementById('studenttable');
                    // var row = tablee.insertRow(1);
                    // var cell1 = row.insertCell(0);
                    // var cell2 = row.insertCell(1);
                    // var cell3 = row.insertCell(2);
                    // var cell4 = row.insertCell(3);
                    // var cell5 = row.insertCell(4);
                    // var cell6 = row.insertCell(5);
                    // cell1.innerHTML = result.useridsystem;
                    // cell2.innerHTML = result.classid;
                    // cell3.innerHTML = result.firstname +" "+ result.middlename +" "+ result.lastname;
                    // cell4.innerHTML = "Gender";
                    // cell5.innerHTML = result.studentreligion;
                    // cell6.innerHTML = "<button data-toggle=\"modal\" data-target=\"#modal-lg\" onclick=\"ttt()\" class=\" btn btn-sm bg-success\"><i class=\"far fa-eye\"></i></button class=\" btn btn-sm bg-info\">  <button class=\" btn btn-sm bg-info\"><i class=\"fas fa-user-edit\"></i></button>";


           },
           error:function(){
            alert('failed')
           }
           
         });
     };

     function ttt(){
      //  alert('dfdfdfdfd')
     }
</script>
<script>

    function getstudentList() {

      var studentclass = document.getElementById('studentclass')

      var studentsection = document.getElementById('studentsection')

      var studentshift  = document.getElementById('studentshift')

      var studentclassMain = studentclass.options[studentclass.selectedIndex].value;
      var studentsectionMain = studentsection.options[studentsection.selectedIndex].value;
      var studentshiftMain = studentshift.options[studentshift.selectedIndex].value;
      var studentSession = document.getElementById('sessionquery').value;

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
                  // alert(result)
                  console.log(result)

              for (let index = 0; index < result[0].length; index++) {
                const element = result[0][index];

                console.log(element)

                var tablee = document.getElementById('studenttable');
                  var row = tablee.insertRow(1);
                  var cell1 = row.insertCell(0);
                  var cell2 = row.insertCell(1);
                  var cell3 = row.insertCell(2);
                  var cell4 = row.insertCell(3);
                  var cell5 = row.insertCell(4);
                  var cell6 = row.insertCell(5);
                  cell1.innerHTML = result[0][index]['id'];
                  cell2.innerHTML = result[0][index]['classname'];
                  cell3.innerHTML = result[0][index]['firstnamenew'] +" "+ result[0][index]['middlenamenew'] +" "+ result[0][index]['lastnamenew'];
                  cell4.innerHTML = result[0][index]['gender'];
                  cell5.innerHTML = result[0][index]['studentreligion'];
                  cell6.innerHTML = "<button data-toggle=\"modal\" data-target=\"#modal-lg\" onclick=\"ttt()\" class=\" btn btn-sm bg-success\"><i class=\"far fa-eye\"></i></button class=\" btn btn-sm bg-info\">  <button class=\" btn btn-sm bg-info\"><i class=\"fas fa-user-edit\"></i></button>";
                
              }

                  


         },
         error:function(){
          alert('failed')
         }
         
       });
   };

    function ShowHideDiv() {
        var chkYes = document.getElementById("querywithregnumber");
        var entireclassform = document.getElementById('addschool');
        var entireclassdivtwo = document.getElementById('formdivtwo');
        var withregnoonly = document.getElementById('withregnoonly');
        var addschoolentirebtn = document.getElementById('addschoolentire');

        if (chkYes.checked) {
            entireclassform.style.display = "none"
            entireclassdivtwo.style.display = "none"
            withregnoonly.style.display = "block"  
            addschoolentirebtn.style.display = "none"
        }else{
            entireclassform.style.display = "block"
            entireclassdivtwo.style.display = "block"
            withregnoonly.style.display = "none"
            addschoolentirebtn.style.display = "block"
        }
    }

    function scrollocation(){
        document.getElementById('resultaside').className = "nav-link active"
        document.getElementById('geberateresultaside').className = "nav-link active"
    }
</script>
    
@endsection