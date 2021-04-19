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
            <h1 class="m-0 text-dark">Setup Grading System</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Grades</li>
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
          <form action="{{ route('submitgrades_sec') }}" method="POST">
            @csrf
            <div class="row" style="margin: 10px;">
                <div class="col-md-6">
                  <div class="form-group">
                    <i style="font-size: 10px;">Grade Type</i>
                    <select name="type" class="form-control form-control-sm" id="">
                      <option value="">Select a school type</option>
                      <option value="1">Junior Secondary</option>
                      <option value="2">Senior Secondary</option>
                    </select>
                  </div>
                    <div class="form-group">
                        <i style="font-size: 10px;">GPA For</i>
                        <input type="text" class="form-control form-control-sm" id="gpafor" name="gpafor" value="100 Marks">
                    </div>
                    <div class="form-group">
                        <i style="font-size: 10px;">Grade (A, B C...)</i>
                        <input type="text" class="form-control form-control-sm" id="grademain" name="grademain" placeholder="A, B, C">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <i style="font-size: 10px;">Mark From</i>
                        <input type="text" class="form-control form-control-sm" id="marksfrom" name="marksfrom" placeholder="40, 50, 60">
                    </div>
                    <div class="form-group">
                        <i style="font-size: 10px;">Mark To</i>
                        <input type="text" class="form-control form-control-sm" id="marksto" name="marksto" placeholder="40, 50, 60">
                    </div>
                    <div class="form-group">
                      <i style="font-size: 10px;">Points(for senior secondary)</i>
                      <input type="number" class="form-control form-control-sm" id="" name="point" placeholder="e.g 4, 3, 2">
                  </div>
                </div>
                <button class="btn btn-info btn-sm">Add</button>
            </div>
          </form>
        </div>

        <div class="card" style="height: 100px;">
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Grade List</h3>
    
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
                            <th>GPA For</th>
                            <th>GPA Name No</th>
                            <th>Mark From</th>
                            <th>Mark To</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                          @if (count($addgrades) > 0)
                            @foreach ($addgrades as $grades)
                            <tr>
                              <td>{{$grades->gpafor}}</td>
                              <td>{{$grades->gpaname}}</td>
                              <td>{{$grades->marksfrom}}</td>
                              <td>{{$grades->marksto}}</td>
                              <td><button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button></td>
                          </tr>
                            @endforeach
                          @endif
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
        document.getElementById('setupmain').className = "nav-link active"
        document.getElementById('gradesscroll').className = "nav-link active"
      }
  </script>
    
@endsection