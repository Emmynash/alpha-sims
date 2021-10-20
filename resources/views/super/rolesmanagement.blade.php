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
              <h1 class="m-0 text-dark">Create Roles & Permissions</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">FeedBack</li>
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
                    Feedbacks
                  </h3>
                </div>
                <!-- /.card-header -->

                <div class="container" style="margin-top: 10px;">







                  <!-- Minimal red style -->
                  <div class="row">
                    <div class="col-sm-6">
                      <p>Give Permission</p>
                      <form action="{{ route('add_roles_and_permission') }}" method="post">
                        @csrf
                        <div class="form-group">
                          <label for="">Role Name</label>
                          <select name="rolename" class="form-control" id="">
                            <option value="">Select a Role</option>
                            @foreach ($role as $item)
                              <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                          </select>
                          {{-- <input type="text" class="form-control" name="rolename" placeholder="enter role name"> --}}
                        </div>
  
                        <div class="form-group">
                          <label>Permissions</label>
                          <select class="select2" name="permissions[]" multiple="multiple" data-placeholder="Select a Permission" style="width: 100%;">
                            @foreach ($permission as $item)
                              <option>{{ $item->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <button class="btn btn-primary">Add</button>
                        </div>
                      </form>

                      <p>Revoke Permission</p>
                      <form action="{{ route('revoke_permission_role') }}" method="post">
                        @csrf
                        <div class="form-group">
                          <label for="">Role Name</label>
                          <select name="rolename" class="form-control" id="">
                            <option value="">Select a Role</option>
                            @foreach ($role as $item)
                              <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                          </select>
                          {{-- <input type="text" class="form-control" name="rolename" placeholder="enter role name"> --}}
                        </div>
  
                        <div class="form-group">
                          <label>Permissions</label>
                          <select class="select2" name="permissions[]" multiple="multiple" data-placeholder="Select a Permission" style="width: 100%;">
                            @foreach ($permission as $item)
                              <option>{{ $item->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <button class="btn btn-primary">Remove</button>
                        </div>
                      </form>

                    </div>

                    <div class="col-sm-6">

                      <p>Add more roles & Permissions</p>
                      <form action="{{ route('add_roles') }}" method="post">
                        @csrf
                        <div class="form-group">
                          <label for="">Role Name</label>
                          <input type="text" name="morerolesname" class="form-control">
                        </div>
                        <div class="form-group">
                          <button class="btn btn-primary btn-sm">Add</button>
                        </div>
                      </form>

                      <form action="{{ route('add_permission') }}" method="post">
                        @csrf
                        <div class="form-group">
                          <label for="">Permission Name</label>
                          <input type="text" name="morepermissionsname" class="form-control">
                        </div>
                        <div class="form-group">
                          <button class="btn btn-primary btn-sm">Add</button>
                        </div>
                      </form>

                    </div>

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