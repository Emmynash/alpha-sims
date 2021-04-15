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
            <h1 class="m-0 text-dark">Teachers List</h1>
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

            <div>
                <p>Please select Query Method</p>
                    <input onclick="ShowHideDiv()" type="radio" id="querywithregnumber" name="queryusers" value="male">
                    <label for="male">Query with Registration No</label><br>
                    <input onclick="ShowHideDiv()" type="radio" id="queryentireclass" name="queryusers" value="female">
                    <label for="female">Query entire class</label><br>
                </p>
            </div>

            <div class="row">
              <div class="col-md-6">

                <div id="withregnoonly">
                    <div class="form-group">
                        <input id="regNumberQuery" name="firstnamenew" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="School Reg No">
                    </div>

                    <button type="button" onclick="getSingleTeacher()" class="btn btn-info" form="addschool">Query Reg Number</button>
                </div>
            
                <form id="addschool" method="POST" action="/shoolreg" enctype="multipart/form-data" style="display: none;">
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
                            <option value="{{$section->sectionname}}">{{$section->sectionname}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                    <div id="formdivtwo" style="display: none;">
                        <div class="form-group">
                            <input id="sessionquery" name="sessionquery" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Session">
                        </div>
                        <div class="form-group">
                            <select id="studentshift" name="studentshift" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Address">
                                <option value="Choose shift">Choose shift</option>
                                <option value="Morning">Morning</option>
                                <option value="Afternoon">Afternoon</option>
                            </select>
                        </div>
                    </div>
                        
                </form>

              </div>
              <!-- /.col -->
            </div>

            <!-- /.row -->
            <button id="addschoolentirebtnteacher" style="display: none;" type="button" onclick="getstudentList()" class="btn btn-info" form="addschool">Query class</button>

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
                  <h3 class="card-title">Teachers List</h3>
  
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
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="teacherstable">
                      <tr>
                        @if ($studentDetails['userschool'][0]['status'] !="Approved")
  
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
    function getSingleTeacher(){
    var regNumber = document.getElementById('regNumberQuery').value

    // $("#teacherstable").empty();
    $("#studenttable").find("tr:gt(0)").remove();
    
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
                    // console.log(result)

              for (let index = 0; index < result.length; index++) {
                const element = result[index];

                var tablee = document.getElementById('studenttable');
                    var row = tablee.insertRow(1);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    var cell5 = row.insertCell(4);
                    var cell6 = row.insertCell(5);
                    cell1.innerHTML = result[index]['id'];
                    cell2.innerHTML = result[index]['firstname'] +" "+ result[index]['middlename'] +" "+ result[index]['lastname'];
                    cell3.innerHTML = result[index]['classnamee'];
                    // cell4.innerHTML = result.gender;
                    cell4.innerHTML = result[index]['section'];
                    cell5.innerHTML = result[index]['gender'];
                    cell6.innerHTML = "<button data-toggle=\"modal\" data-target=\"#modal-lg\" onclick=\"ttt()\" class=\" btn btn-sm bg-success\"><i class=\"far fa-eye\"></i></button class=\" btn btn-sm bg-info\">  <button class=\" btn btn-sm bg-info\"><i class=\"fas fa-user-edit\"></i></button>";
                
              }


           },
           error:function(){
            alert('failed')
           }
           
         });
     };

     function ttt(){
       alert('dfdfdfdfd')
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

      $("#studenttable").find("tr:gt(0)").remove();

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
          url:"/getallteacherforview", //the page containing php script
          method: "POST", //request type,
          cache: false,
          data: {studentSession: studentSession, studentclassMain:studentclassMain, studentsectionMain:studentsectionMain, studentshiftMain:studentshiftMain},
          success:function(result){
                  // console.log(result)

              for (let index = 0; index < result.length; index++) {
                const element = result[index];

                var tablee = document.getElementById('studenttable');
                  var row = tablee.insertRow(1);
                  var cell1 = row.insertCell(0);
                  var cell2 = row.insertCell(1);
                  var cell3 = row.insertCell(2);
                  var cell4 = row.insertCell(3);
                  var cell5 = row.insertCell(4);
                  var cell6 = row.insertCell(5);
                  cell1.innerHTML = result[index]['id'];
                  cell3.innerHTML = result[index]['classnamee'];
                  cell2.innerHTML = result[index]['firstname'] +" "+ result[index]['middlename'] +" "+ result[index]['lastname'];
                  cell5.innerHTML = result[index]['gender'];
                  cell4.innerHTML = result[index]['section'];
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
        var addschoolentirebtn = document.getElementById('addschoolentirebtnteacher');

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
        document.getElementById('teachersaside').className = "nav-link active"
        document.getElementById('viewteacheraside').className = "nav-link active"
    }
    
</script>
    
@endsection