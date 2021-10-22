@extends('layouts.app_supper')

@section('content')

<div class="wrapper">
  
    @include('layouts.asideadmin')
  
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Roles</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Roles list</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
  
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->

          <div class="row">
            <div class="col-md-12">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-reply"></i>
                    Role List
                  </h3>
                </div>
                <!-- /.card-header -->

                <div class="container" style="margin-top: 10px;">

                    <div class="row">
                        @if ($role->count() > 0)

                            @foreach ($role as $item)
                                <div class="col-12 col-md-3">
                                    <div class="card" style="border-radius: 0px; border-left: 4px solid green;">
                                        <i style="font-style: normal; padding: 5px;">{{ $item->name }}</i>
                                    </div>

                                    <div style="height: 200px; overflow-y: scroll;">
                                        @foreach ($item->permissions as $items)
                                            <div class="card" style="border-radius: 0px; border-left: 4px solid yellow;">
                                                <i style="font-style: normal; padding: 5px;">{{ $items->name }}</i>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                            @endforeach
                            
                        @endif
                    </div>

                </div>

              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- END ALERTS AND CALLOUTS -->

          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">
  




              <!-- /.card -->
            </section>
            <!-- right col -->
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
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
      function scrollocation(){
        document.getElementById('feed_back').className = "nav-link active"
      }

  
</script>


@endsection