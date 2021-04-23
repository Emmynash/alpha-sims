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
                    <form action="{{ route('addmotopri') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="enter psycomoto">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-info">Add</button>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <div class="row">
                    @if ($motosettings->count() > 0)

                        @foreach ($motosettings as $item)
                            <div class="col-12 col-md-4">
                                <div class="card" style="border-radius: 0px; border-left: 5px solid green;">
                                    <i style="font-style: normal; padding: 5px;">{{ $item->name }}</i>
                                </div>
                            </div>
                        @endforeach
                        
                    @endif
                </div>
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