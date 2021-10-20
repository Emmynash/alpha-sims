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
            <h1 class="m-0 text-dark">e-Learning</h1>
                        <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="E-Learning"
                data-content="This module is used for posting Notifications to the elearning environment.">Need help?</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">e-Learning</li>
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
        @include('layouts.message')
        <div class="row">
            <div class="col-sm-6">
                <form action="/add_assignment" method="post">
                  @csrf
                    <div class="card" style="">
                        <div class="row" style="margin: 10px;">
                            <div class="col-sm-6">
                              <i style="font-style: normal">Asignment</i>
                              <div class="form-group">
                                <i style="font-style: normal; font-size: 10px;">Select a class</i>
                                <select name="assignmentforclass" id="" class="form-control form-control-sm" style="border-radius: 0px;">
                                  <option value="">Select a class</option>
                                  <option value="general">General</option>
                                  @if (count($alldetails['classlist_sec']) > 0)
                                      @foreach ($alldetails['classlist_sec'] as $classlist)
                                      <option value="{{$classlist->id}}">{{$classlist->classname}}</option>
                                      @endforeach
                                  @endif
                                </select>
                              </div>

                              <div class="form-group">
                                <i style="font-style: normal; font-size: 10px;">Content</i>
                                <textarea name="mainassignment"class="form-control form-control-sm" style="border-radius: 0px;" id="" cols="30" rows="5"></textarea>
                              </div>
                                
                            </div>
                            <div class="col-sm-6">
                              <i>.</i>
                              <div class="form-group">
                                <i style="font-style: normal; font-size: 10px;">Date from</i>
                                <input name="datefrom" id="" type="date" class="form-control form-control-sm" style="border-radius: 0px;">
                              </div>

                              <div class="form-group">
                                <i style="font-style: normal; font-size: 10px;">Date to</i>
                                <input name="dateto" id="" type="date" class="form-control form-control-sm" style="border-radius: 0px;">
                              </div>

                              <button type="submit" class="btn btn-info btn-sm"><i class="fas fa-plus"></i> Add</button>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="col-sm-6">
              <form action="/add_assignment" method="post">
                @csrf
                <div class="card" style="">
                    <div class="row" style="margin: 10px;">
                        <div class="col-sm-6">
                          <i style="font-style: normal">Info</i>
                          <div class="form-group">
                            <i style="font-style: normal; font-size: 10px;">Content</i>
                            <textarea name="contentnotif" class="form-control form-control-sm" style="border-radius: 0px;" id="" cols="30" rows="5"></textarea>
                          </div>
                            
                        </div>
                        <div class="col-sm-6">
                          <i>.</i>
                          <div class="form-group">
                            <i style="font-style: normal; font-size: 10px;">Date from</i>
                            <input name="datefrominfo" id="" type="date" class="form-control form-control-sm" style="border-radius: 0px;">
                          </div>

                          <div class="form-group">
                            <i style="font-style: normal; font-size: 10px;">Date to</i>
                            <input name="datetoinfo" id="" type="date" class="form-control form-control-sm" style="border-radius: 0px;">
                          </div>

                          <button type="submit" disabled class="btn btn-info btn-sm"><i class="fas fa-plus"></i> Add</button>
                        </div>
                    </div>
                    
                </div>
            </form>
            </div>
        </div>

      <!-- /.row -->
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Notifications</h3>
  
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
                        <th>ID</th>
                        <th>Class</th>
                        <th>Posted By</th>
                        <th>From</th>
                        <th>TO</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if (count($alldetails['assignments']) > 0)

                        @foreach ($alldetails['assignments'] as $assignment)
                          <tr>
                            <td>{{$assignment->id}}</td>
                            <td>
                              @if ($assignment->classname == null)
                                  General
                              @else
                                {{$assignment->classname}}
                              @endif
                            </td>
                            <td>---</td>
                            <td>{{$assignment->datefrom}}</td>
                            <td>{{$assignment->dateto}}</td>
                            <td><button class="btn btn-sm btn-info" data-toggle="modal" data-target="#assignmentmodal{{$assignment->id}}"><i class="far fa-eye"></i></button> <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button></td>
                          </tr>

                            <!-- The Modal -->
                            <div class="modal fade" id="assignmentmodal{{$assignment->id}}">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                
                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                    <h6 class="modal-title">Notification Id <i style="font-size: 20px; font-weight: bold; font-style: normal;">{{$assignment->id}}</i></h6>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>
                                  
                                  <!-- Modal body -->
                                  <div class="modal-body">
                                    <div>
                                      <i style="font-style: normal; font-size: 13px;">Class Name: </i>
                                      <i style="font-style: normal; font-size: 13px;">
                                        @if ($assignment->classname == null)
                                            General
                                        @else
                                            {{$assignment->classname}}
                                        @endif
                                      </i>
                                    </div>
                                    <div>
                                      <i style="font-style: normal; font-size: 13px;">Date From: </i>
                                      <i style="font-style: normal; font-size: 13px;">{{$assignment->datefrom}}</i>
                                    </div>
                                    <div>
                                      <i style="font-style: normal; font-size: 13px;">Date To: </i>
                                      <i style="font-style: normal; font-size: 13px;">{{$assignment->dateto}}</i>
                                    </div>
                                    <div>
                                    <i style="font-style: normal; font-size: 13px;">Content: </i>
                                    <i style="font-style: normal; font-size: 13px;">{{$assignment->content}}</i>
                                  </div>
                                </div>
                                  
                                  <!-- Modal footer -->
                                  <div class="modal-footer">
                                    <form id="deleteassignment{{$assignment->id}}" action="/deletealignment" method="post">
                                      @csrf
                                      <input name="deleteid" type="hidden" value="{{$assignment->id}}">
                                    </form>
                                    <button type="submit" class="btn btn-danger btn-sm" form="deleteassignment{{$assignment->id}}">Delete</button>
                                  </div>
                                  
                                </div>
                              </div>
                            </div>
                        @endforeach
                          
                      @endif
                    </tbody>
                  </table>
                  {{-- <div style="margin: 10px;">
                    {{ $alldetails['assignments']->links() }}
                  </div> --}}
                  <div class="text-center">
                    <i style="font-style: normal;">Page {{ $alldetails['assignments']->currentPage() }}</i>
                    <i style="font-style: normal;">of</i>
                    <i style="font-style: normal;">{{ $alldetails['assignments']->lastPage() }}</i>
                  </div>
                  <div class="text-center" style="margin: 10px;">
                    <a href="{{ $alldetails['assignments']->previousPageUrl() }}"><button class="btn btn-sm btn-info">Prev</button></a>
                    <a href="{{ $alldetails['assignments']->nextPageUrl() }}"><button class="btn btn-sm btn-info">Next</button></a>
                  </div>
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
    
@endsection