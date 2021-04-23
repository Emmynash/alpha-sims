@extends('layouts.app_dash')

@section('content')


  <!-- Main Sidebar Container -->
  @include('layouts.asideside')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Psycomoto</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Psycomoto</li>
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

            @include('layouts.message')

        <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">

            <div class="row">
                <div class="col-12 col-md-6">
                    <div style="margin: 5px;">
                        <img src="{{ asset('storage/schimages/'.$getStudentDetails->profileimg)}}" class="rounded-circle" alt="" height="100px" width="100px">
                    </div>
                    <p><i style="font-style: normal; font-weight: bold; margin-left: 10px;">Name</i>: {{ $getStudentDetails->firstname }} {{ $getStudentDetails->middlename }} {{ $getStudentDetails->lastname }}</p>
                </div>
            </div>

            <div class="text-center">
                <i style="font-size: 20px; font-weight: bold;">Psycomotor Record</i>
            </div>
            <br>
            <div>
                <form action="{{ route('addmoto_post', $getStudentDetails->id) }}" method="post">
                    @csrf
                    <div class="row">
                        @if ($motosettings->count() > 0)
    
                            @foreach ($motosettings as $item)
                                <div class="col-12 col-md-4">
                                    <div class="card" style="border-radius: 0px; border-left: 5px solid green;">
                                        <i style="font-style: normal; padding: 5px;">{{ $item->name }}</i>
                                        <div style="margin: 5px;">
                                            <select name="moto{{ $item->id }}" class="form-control form-control-sm" id="" required>
                                                <option value="">Select an option</option>
                                                <option value="{{ $item->id }}_moto_1">1</option>
                                                <option value="{{ $item->id }}_moto_2">2</option>
                                                <option value="{{ $item->id }}_moto_3">3</option>
                                                <option value="{{ $item->id }}_moto_4">4</option>
                                                <option value="{{ $item->id }}_moto_5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                        @endif
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-info">Add</button>
                    </div>
                </form>

            </div>


          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin. --}}
          </div>
        </div>

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
        document.getElementById('affectivedomainasidesetting').className = "nav-link active"
    }
 
</script>
    
@endpush