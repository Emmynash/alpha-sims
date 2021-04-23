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
            <h1 class="m-0 text-dark">Teachers Attendance</h1>
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

        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Teachers List <div style="display: none;" id="atprocess" class="spinner-border"></div></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">



                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>S/N</th>
                      <th>Reg No.</th>
                      <th>Full name</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>Trident</td>
                      <td>Internet
                        Explorer 4.0
                      </td>
                      <td>Win 95+</td>
                      <td>
                        <form action="" method="post">
                          @csrf
                          <div class="form-group">
                            <input class="form-control form-control-sm" type="checkbox">
                          </div>
                        </form>
                        
                      </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>S/N</th>
                      <th>Reg No.</th>
                      <th>Full name</th>
                      <th>Action</th>
                    </tr>
                    </tfoot>
                  </table>


                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
        <!-- /.card -->

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


    
@endsection

@push('custom-scripts')


<!-- DataTables  & Plugins -->
<script src="{{ asset('../../plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('../../plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('../../plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('../../plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>



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

  function getstudentList() {

    var studentclass = document.getElementById('studentclass')

    var studentsection = document.getElementById('studentsection')

    var studentshift  = document.getElementById('studentshift')

    var studentclassMain = studentclass.options[studentclass.selectedIndex].value;
    var studentsectionMain = studentsection.options[studentsection.selectedIndex].value;
    var studentshiftMain = studentshift.options[studentshift.selectedIndex].value;
    var studentSession = document.getElementById('sessionquery').value;

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
        url:"/getallteacher", //the page containing php script
        method: "POST", //request type,
        cache: false,
        data: {studentSession: studentSession, studentclassMain:studentclassMain, studentsectionMain:studentsectionMain, studentshiftMain:studentshiftMain},
        success:function(result){
                console.log(result)

            for (let index = 0; index < result[0].length; index++) {
              const element = result[0][index];

              var tablee = document.getElementById('studenttable').getElementsByTagName('tbody')[0];
              
              var attendanceCheck = result[1]

              var elementMain = result[0][index]['id']

              var n = attendanceCheck.includes(elementMain.toString());

              console.log(n)

              if (n) {
                  $('#studenttable').find('tbody').append('<tr><td>' + result[0][index]['id'] + '</td><td>' + result[0][index]['firstname'] + ' ' + result[0][index]['middlename'] + ' ' + result[0][index]['lastname'] +'</td><td>'+ result[0][index]['classname'] +'</td><td>'+ result[0][index]['section'] +'</td><td>dsdsdsd</td><td><button class="btn"><i style="color: green;" class="fas fa-check"></i></button></td></tr>');
              }else{
                  $('#studenttable').find('tbody').append('<tr><td>'+ result[0][index]['id'] +'</td><td>'+ result[0][index]['firstname'] + ' ' + result[0][index]['middlename'] + ' ' + result[0][index]['lastname'] +'</td><td>'+ result[0][index]['classname'] +'</td><td>'+ result[0][index]['section'] +'</td><td>dsdsdsd</td><td><input type="checkbox" onclick="checkStudent(\'' + result[0][index]['id'] + '\')"/></td></tr>');
              }
            }
       },
       error:function(){
        alert('failed')
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
        url:"/teachersatt", //the page containing php script
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
      document.getElementById('teachersattendanceaside').className = "nav-link active"
      document.getElementById('addteacherattendanceaside').className = "nav-link active"
  }

  $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });

</script>
@endpush