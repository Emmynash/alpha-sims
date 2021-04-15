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
            <h1 class="m-0 text-dark">psychomotor</h1>
            <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Psychomotor"
                data-content="On this module, you are required to fill out phychomoto for all students in each class. this is required for result generation">Need help?</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">psychomotor</li>
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
          <div id="spinnermotoprocess" style="position: absolute; top: 0; bottom: 0; right: 0; left: 0; display: none; align-items: center; justify-content: center; z-index: 999;">
            <div class="spinner-border" style="width: 100px; height: 100px;"></div>
          </div>

            <div class="card" style="margin: 10px;">
                <div style="margin: 5px;">
                    <img src="{{ asset('storage/schimages/'.$student->getStudentName->profileimg)}}" class="rounded-circle" alt="" height="100px" width="100px">
                </div>
                <p><i style="font-style: normal; font-weight: bold; margin-left: 10px;">Name</i>: {{ $student->getStudentName->firstname }} {{ $student->getStudentName->middlename }} {{ $student->getStudentName->lastname }}</p>
            </div>


            <div class="text-center">
                <i style="font-size: 20px; font-weight: bold;">Psycomotor Record</i>
            </div>
            <br>
            <form action="{{ route('add_student_moto', $student->id) }}" id="addmotoformmain" method="POST">
                @csrf
            <div class="row" style="margin: 10px;">

                @if ($addmoto->count() < 1)
                    <div class="col-md-4 col-12 card">
                        <p>No record Added</p>
                    </div>
                @else
                    @foreach ($addmoto as $moto)
                        <div class="col-md-4 col-12">
                            <div class="card" style="border-radius: 0px; border-left: 10px solid green;">
                                <p style="padding-left: 10px;">{{ $moto->name }}</p>
                                <div class="form-group" style="margin: 10px;">
                                    <select name="moto{{ $moto->id }}" class="form-control form-control-sm" id="" required>
                                        <option value="">Select an option</option>
                                        <option value="{{ $moto->id }}_moto_1">1</option>
                                        <option value="{{ $moto->id }}_moto_2">2</option>
                                        <option value="{{ $moto->id }}_moto_3">3</option>
                                        <option value="{{ $moto->id }}_moto_4">4</option>
                                        <option value="{{ $moto->id }}_moto_5">5</option>
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </form>

            <div style="margin: 10px;">
                <button type="submit" form="addmotoformmain" class="btn btn-info btn-sm">Proceed</button>
            </div>
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
        document.getElementById('psyhcomoto').className = "nav-link active"
        document.getElementById('psyhcomotosettings').className = "nav-link active"
      }

      function takemoto(regno, userid, firstname, middlename, lastname){
        $('#modalmoto').modal('show');

        document.getElementById('systemnumber').value = userid;
        document.getElementById('regno').value = regno;
        document.getElementById('term').value = document.getElementById('selectedtermmoto').value;

        document.getElementById('modalnamemoto').innerHTML = firstname+" "+middlename+" "+lastname
      }
  </script>
    
@endsection