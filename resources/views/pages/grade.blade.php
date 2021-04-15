@extends('layouts.app_dash')

@section('content')

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
            <h1 class="m-0 text-dark">Add Grades</h1>
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
            
                <form id="addschoolgrade" method="POST" action="/submitgrades" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <label for="gpafor">GPA For</label>
                        <select id="gpafor" name="gpafor" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="School Name">
                            <option value="100">100 Marks</option>
                        </select>
                        </div>
                        <div class="form-group">
                              <label for="grade">Grade (A, B C...)</label>
                            <input id="grade" name="grade" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="A, B,...">
                            </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                    <div id="formdivtwo">
                        <div class="form-group">
                          <label for="point">Point</label>
                            <input id="point" name="point" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" value="" type="number" placeholder="4.00, 3.00...">
                        </div>
                        <div class="form-group">
                          <label for="markfrom">Mark From</label>
                            <input id="markfrom" name="markfrom" style="border: none; background-color:#EEF0F0;" type="number" class="form-control form-control-lg" placeholder="40, 50, 60...">
                        </div>
                        <div class="form-group">
                          <label for="markto">Mark To</label>
                            <input id="markto" name="markto" style="border: none; background-color:#EEF0F0;" type="number" class="form-control form-control-lg" placeholder="40, 50, 60...">
                        </div>
                    </div>
                        
                </form>

              </div>
              <!-- /.col -->
            </div>

            <!-- /.row -->
            <button id="addgrade" type="submit" form="addschoolgrade" class="btn btn-info">Add</button>

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
                  <h3 class="card-title">Grade List <div style="display: none;" id="atprocess" class="spinner-border"></div></h3>
  
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
                        <th>GPA For</th>
                        <th>GPA Name No</th>
                        <th>Point</th>
                        <th>Mark From</th>
                        <th>Mark To</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($studentDetails['addgrades'] as $grades)

                      <tr>
                        <td>{{$grades['gpafor']}}</td>
                        <td>{{$grades['gpaname']}}</td>
                        <td>{{$grades['point']}}</td>
                        <td>{{$grades['marksfrom']}}</td>
                        <td>{{$grades['marksto']}}</td>

                        <form action="/deletegrade" method="post" id="deleteform.{{$grades['id']}}">
                          @csrf
                        <input name="entryId" type="hidden" value="{{$grades['id']}}" >
                        </form>
                        
                        <td>
                          <button class="btn btn-info btn-sm"><i class="far fa-edit"></i></button>  
                          <button type="submit" form="deleteform.{{$grades['id']}}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                        </td>
                      </tr>
                          
                      @endforeach
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

<script>
    function scrollocation(){
        document.getElementById('settingsaside').className = "nav-link active"
        document.getElementById('gradesaside').className = "nav-link active"
    }
</script>

<!-- ./wrapper -->
    
@endsection