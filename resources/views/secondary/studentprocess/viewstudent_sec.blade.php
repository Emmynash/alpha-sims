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
            <h1 class="m-0 text-dark">View Students</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">View Students</li>
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
            <div id="viewstudentsingleclassprogress" style="z-index: 999; position: absolute; top: 0; bottom: 0; right: 0; left: 0; display:none; align-items: center; justify-content: center;">
                <div class="spinner-border" style="width: 100px; height: 100px;"></div>
            </div>

            <form id="viewsingleclassform" action="javascript:console.log('submitted')" method="post">
                @csrf
                <div class="row" style="margin: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" type="text" name="classessingle">
                                <option value="">Select class</option>
                                @if (count($addschool->getClassList($addschool->id)) > 0)
                                    @foreach ($addschool->getClassList($addschool->id) as $classes)
                                        <option value="{{$classes->id}}">{{$classes->classname}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" type="text" name="sectionsingle">
                                <option value="">Select Section</option>
                                @if (count($addschool->getSectionList($addschool->id)) > 0)
                                    @foreach ($addschool->getSectionList($addschool->id) as $addsection_sec)
                                        <option value="{{$addsection_sec->id}}">{{$addsection_sec->sectionname}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                            <input class="form-control" type="text" name="schoolsessionsingle" value="{{$addschool->schoolsession}}" placeholder="Session">
                            </div>
                        </div>
                    </div>
                </div>
                <button id="viewsingleclassbtn" class="btn btn-sm btn-info" style="margin: 0 0 10px 20px">Submit</button>
            </form>
        </div>

        <div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">Subject List</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                            {{-- <input type="text" name="table_search" class="form-control float-right" placeholder="Search"> --}}

                            <div class="input-group-append">
                                {{-- <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button> --}}
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap" id="viewstudentsingleclass">
                            <thead>
                            <tr>
                                <th>Reg No</th>
                                <th>class</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Student Type</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- @if (count($alldetails['classesAll']) > 0)
                                @foreach ($alldetails['classesAll'] as $classesall)
                                <tr>
                                    <td>{{$classesall->id}}</td>
                                    <td>{{$classesall->classname}}</td>
                                    <td>{{$classesall->studentcount}}</td>
                                    <td><button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button></td>
                                </tr>
                                @endforeach
                            @endif --}}
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
      document.getElementById('studentsmain').className = "nav-link active"
      document.getElementById('studentsmainview').className = "nav-link active"
    }
</script>
    
@endsection