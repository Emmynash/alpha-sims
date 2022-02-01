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
            <h1 class="m-0 text-dark">View Attendance</h1>
                        <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Student Attendance"
                data-content="On this module, you are required to take attendance for students according to class.">Need help?</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">View Attendance</li>
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

            <form id="fetchslass_secbtn_viewform" action="javascript:console.log('submitted');" method="POST">
                @csrf
                <div class="row" style="margin: 10px">
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 10px; font-style: normal;">Select class</i>
                            <select name="classselect" class="form-control form-control-sm">
                                <option value="">Select a class</option>
                                @if (count($addschool->getClassList($addschool->id)) > 0)
                                    @foreach ($addschool->getClassList($addschool->id) as $classlist)
                                    <option value="{{$classlist->id}}">{{$classlist->classname}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px; font-style: normal;">Student section</i>
                            <select name="studentsection" class="form-control form-control-sm" id="">
                                <option value="">Select section</option>
                                @if (count($addschool->getSectionList($addschool->id)) > 0)
                                @foreach ($addschool->getSectionList($addschool->id) as $section)
                                <option value="{{$section->id}}">{{$section->sectionname}}</option>
                                @endforeach
                                    
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <i style="font-size: 10px; font-style: normal;">Current session</i>
                        <div class="form-group">
                            <input name="schoolsession" type="text" value="{{$addschool->schoolsession}}" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px; font-style: normal;">Date</i>
                            <input name="daydate" type="date" value="" class="form-control form-control-sm">
                        </div>
                        
                    </div>
                </div>
                <div class="row" style="margin: 10px;">
                    <button type="button" id="fetchslass_secbtn_view" class="btn btn-info btn-sm">Query</button>

                    <button id="attendanceprocessbtn" style="display: none;" class="btn btn-primary btn-sm" disabled>
                        <span class="spinner-border spinner-border-sm"></span>
                        Loading..
                      </button>
                </div>

            </form>
        </div>

        {{-- table --}}

        <!-- /.row -->
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header" style="display: flex;">
                  <div style="display: flex; flex-direction: row; align-items: center;">
                    <h3 class="card-title">Student list</h3>
                    <div style="margin-left: 5px; display: none;" id='attendancespinnersp' class='spinner-border'></div>
                  </div>
                  <div style="flex: 1;"></div> 
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
                        <th>Reg.No</th>
                        <th>Name</th>
                        <th>class</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="fetcheduserstableattendancesview">
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
        document.getElementById('studentatt_sec').className = "nav-link active"
        document.getElementById('studentatt_sec_view').className = "nav-link active"
      }

      function test(id){

        document.getElementById('attendancespinnersp').style.display = "block";
        // document.getElementById('checkboxattendance').setAttribute("disabled", "");

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $.ajax({
            url:"/student_att_main", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {studentregnum:id},
            success:function(result){
              console.log(result)

              document.getElementById('attendancespinnersp').style.display = "none"
            //   document.getElementById('checkboxattendance').setAttribute("enable", "");
              
         
           },
           error:function(){
            alert('failed')
           }
         });

      }
  </script>
    
@endsection