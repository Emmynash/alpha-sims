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
            <h1 class="m-0 text-dark">Result Checker</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Result Checker"
                data-content="Check Students result">Need help?</button>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Class list</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="container">
      <button class="btn btn-sm btn-warning">View All</button>
    </div>

    <hr>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          
          @include('layouts.message')


        <div class="card" style="height: 200px; border-top: 2px solid #0B887C;">

                  <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Class List </h3>
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
                      <th>Reg no.</th>
                      <th>Name</th>
                      <th>Class</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($entirestudent) > 0)
                      @foreach ($entirestudent as $entirestudentm)

                      @if ($entirestudentm->getStudentName != null)
                      <tr>
                        <td>{{$entirestudentm->admission_no}}</td>
                        <td>{{$entirestudentm->getStudentName->firstname}} {{$entirestudentm->getStudentName->middlename}} {{$entirestudentm->getStudentName->lastname}}</td>
                        <td>{{$entirestudentm->getClassName->classname}} {{ $entirestudentm->getSectionName->sectionname }}</td>
          
                        
                        <td>
                            <form action="{{ route('result_print_single_sec') }}" method="POST" id="formgetsingleresult{{ $entirestudentm->id }}">
                                @csrf
                                <input type="hidden" value="{{ $entirestudentm->id }}" name="student_reg_no">
                                <input type="hidden" value="{{ $session }}" name="session">
                                <input type="hidden" value="{{ $term }}" name="term">
                                <input type="hidden" value="{{ $entirestudentm->classid }}" name="classid">
                            </form>
                            <button type="submit" form="formgetsingleresult{{ $entirestudentm->id }}" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i>
                          </td>
                      </tr>
                      @endif

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
        document.getElementById('classlistscroll').className = "nav-link active"
      }
  </script>
    
@endsection