@extends('landlord.layout.app')

@section('content')
<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Schools management</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Management</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

        @include('layouts.message')
        <small class="text-danger">{{ $errors->first('image') }}</small>

        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">School List</h3>
  
                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      {{-- <input type="text" name="table_search" class="form-control float-right" placeholder="Search"> --}}
                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#addschool">Add School</button>
                      <div class="input-group-append">
                        {{-- <button type="submit" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button> --}}
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Domain</th>
                        <th>Database</th>
                        {{-- <th>Status</th> --}}
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($allSchools as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->domain }}</td>
                            <td>{{ $item->database }}</td>
                            {{-- <td><span class="tag tag-success">Approved</span></td> --}}
                            <td></td>
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

    </div><!-- /.container-fluid -->

    <!-- The Modal -->
    <div class="modal" id="addschool">
        <div class="modal-dialog">
        <div class="modal-content">
    
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Onboard new school</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
    
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{ route('onboard') }}" method="post" id="onboard">
                    @csrf
                    <div class="form-group">
                        <input class="form-control" name="name" placeholder="Enter school name" required/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="domain" placeholder="Enter asigned domain" required/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="database" placeholder="Enter database name" required/>
                    </div>
                </form>
            </div>
    
            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info" form="onboard">Submit</button>
            </div>
    
        </div>
        </div>
    </div>
  </section>
  <!-- /.content -->


</div>
<!-- /.content-wrapper -->
</div>
@endsection