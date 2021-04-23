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
            <h1 class="m-0 text-dark">Student List</h1>
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

        <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">

            <div class="row">
              <div class="col-md-6">
            
                <form id="psycomotoquery" method="POST" action="javascript:console.log('submitted');" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                        <select id="studentclass" name="studentclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="School Name">
                            <option value="">choose class</option>
                            @foreach ($studentDetails['classList'] as $classlist)
                              <option value="{{$classlist->id}}" {{ count($studentDetails) > 5 ? $studentDetails['addteachers'][0]['formteacher'] == $classlist->id ? "" : "disabled" : "" }}>{{$classlist->classnamee}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                        <select id="studentsection" name="studentsection" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Mobile Number">
                            <option value="">Choose section</option>
                            @foreach ($studentDetails['addSection'] as $section)
                            <option value="{{$section->sectionname}}" {{ count($studentDetails) > 5 ? $studentDetails['addteachers'][0]['formsection'] == $section->id ? "" : "disabled" : "" }}>{{$section->sectionname}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                    <div id="formdivtwo" style="">
                        <div class="form-group">
                            <input id="sessionquery" value="{{$studentDetails['userschool'][0]['schoolsession']}}" name="sessionquery" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Session" readonly>
                        </div>
                        <div class="form-group">
                            <select id="studentshift" name="studentshift" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Address">
                                <option value="Choose shift">Choose shift</option>
                                <option value="Morning">Morning</option>
                                <option value="Afternoon">Afternoon</option>
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
                        
                </form>

              </div>
              <!-- /.col -->
            </div>

            <!-- /.row -->
            <button id="psycomotoquerybtn" style="" type="submit" class="btn btn-info">Query class</button>

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
                  <h3 class="card-title">Student List</h3>
  
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
                  <table class="table table-hover text-nowrap" id="psycomotoqueryform">
                    <thead>
                      <tr>
                        <th>Reg No</th>
                        <th>Roll No</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
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

<script>
    function motoprocess(firstname, middlename, lastname, regno, systemid, classidmoto){
      // alert(firstname)

      document.getElementById('modealheadmoto').innerHTML = firstname +" "+ middlename+" "+ lastname;
      document.getElementById('studentregnomoto').value = regno
      document.getElementById('systemidmoto').value = systemid
      document.getElementById('classidmoto').value = classidmoto
    }

    function scrollocation(){
        document.getElementById('pychomotoraside').className = "nav-link active"
        document.getElementById('affectivedomainaside').className = "nav-link active"
    }
 
</script>
    
@endsection