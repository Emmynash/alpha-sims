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
            <h1 class="m-0 text-dark">Teachers Attendance</h1>
            <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Teachers Attendance"
                data-content="On this module, you can add students to your school. You will add them using the system number. However, you can create an account for a student here aswell">Need help?</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Teachers Attendance</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


        <div class="card" style="height: 200px; border-top: 2px solid #0B887C;">

                  <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div style="display: flex; align-items: center;">
                  <h3 class="card-title">Teachers List</h3>
                  <div id="attmainSpinner" style="display: none; margin-left: 5px;" class="spinner-border"></div>
                </div>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" id="myInputattendance" class="form-control float-right" placeholder="Search">

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
                      <th>Reg.No</th>
                      <th>Name</th>
                      <th>class</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="teachersattendancetbl">

                        <tr>
                          <td>NA</td>
                          <td>NA</td>
                          <td>NA</td>
                          <td>NA</td>
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
        document.getElementById('attendancemain').className = "nav-link active"
        document.getElementById('attendancemain_add').className = "nav-link active"
        addteacherattendancefetch();
      }

      function teachersAttendance(regno){

        document.getElementById('attmainSpinner').style.display = "block"

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $.ajax({
            url:"/teachers_att_main", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {regno:regno},
            success:function(result){
              console.log(result)
              document.getElementById('attmainSpinner').style.display = "none"
              // document.getElementById('attendancespinnersp').style.display = "none"
              // document.getElementById('checkboxattendance').setAttribute("enable", "");
              
         
           },
           error:function(){
            alert('failed')
            document.getElementById('attmainSpinner').style.display = "none"
           }
         });
      }
      
    function addteacherattendancefetch(){

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          $.ajax({
            url:"/fetch_teacher_add_attendance", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {rollnumber:1},
            success:function(result){
               console.log(result)

              
              // alert(result.msg)
              
                if (result.success) {

                  var html = "";

                  for (let index = 0; index < result.success.length; index++) {
                    const element = result.success[index];

                    var attendanceCheck = result.a

                    var elementMain = result.success[index]['id']

                    var n = attendanceCheck.includes(elementMain.toString());

                    if (n) {
                      html += "<tr>"+"<td>"+element.id+"</td>"+"<td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td>"+"<td>"+element.classname+"</td>"+"<td>"+"<i style='color: green;' class='fas fa-check'></i>"+"</td>"+"</tr>"
                    }else{
                      html += "<tr>"+"<td>"+element.id+"</td>"+"<td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td>"+"<td>"+element.classname+"</td>"+"<td>"+"<input type='checkbox' onclick='teachersAttendance("+element.id+")' >"+"</td>"+"</tr>"
                    }
                  }
                  $("#teachersattendancetbl").html(html);
                }

                
              // }
         
           },
           error:function(){
            alert('failed')
           }
         });

    }
    
    $(document).ready(function(){
      $("#myInputattendance").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#teachersattendancetbl tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>
    
@endsection