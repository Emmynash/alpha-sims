@extends($schooldetails->schooltype == "Primary" ? 'layouts.app_dash' : 'layouts.app_sec')

@section('content')

@if ($schooldetails->schooltype == "Primary")
@include('layouts.asideside') 
@else
  @include('layouts.aside_sec')
@endif

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Manage Electives</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Manage Electives</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        @include('layouts.message')
        <div class="alert alert-info">
            <i style="font-style:normal; font-size:14px; padding:10px;">You are expected to select x number of electives. Click the button below to proceed.</i>
        </div>
    <!-- /.row -->
    <div class="form-group">
        <button class="btn btn-sm btn-info" data-toggle="modal" disabled data-target="#modal-default">Add Elective</button>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Electives</h3>

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
                    <th>Subject Name</th>
                    <th>Subject Type</th>
                    <th>Action</th>
                    </tr>
                </thead>
                    <tbody>

                        @foreach ($myelectives as $item)
                            <tr>
                                <td>{{ $item->subjectname }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            </div>
            
        </div>
        </div>
        <!-- /.row -->

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Class Electives</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div>
                        <form action="{{ route('add_electives') }}" method="post" id="addelectives">
                            @csrf
                            <div class="form-group">
                                <select name="subjectid" id="" class="form-control form-control-sm">
                                    <option value="">Select an elective</option>
                                    @foreach ($subjects as $item)
                                        <option value="{{ $item->subjectid }}">{{ $item->subjectname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                  <button type="submit" form="addelectives" class="btn btn-info btn-sm">Save changes</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->

    </section>
</div>

@endsection