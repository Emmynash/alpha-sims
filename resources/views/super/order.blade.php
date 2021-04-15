@extends('layouts.app_dash')

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
              <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
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

        <!-- /.row -->
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Schools</h3>
  
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
                        <th>school Id</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Period From</th>
                        <th>Period To</th>
                        <th>Status</th>
                        <th>Track</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if (count($allschools) > 0)

                      @foreach ($allschools as $schools)

                      <tr>
                        <td>{{$schools->id}}</td>
                        <td>{{$schools->schooltype}}</td>
                        <td>11-7-2014</td>
                        <td>{{$schools->mobilenumber}}</td>
                        <td>{{$schools->schoolemail}}</td>
                        <td>{{$schools->periodfrom}}</td>
                        <td>{{$schools->periodto}}</td>
                        <td>{{$schools->status}}</td>
                        <td>{{$schools->firstname}} {{$schools->middlename}} {{$schools->lastname}}</td>

                        <!-- The Modal -->
                      <div class="modal fade" id="schools{{$schools->id}}">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            
                              <!-- Modal Header -->
                              <div class="modal-header">
                              <h4 class="modal-title">{{$schools->schoolname}}</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              
                              <!-- Modal body -->
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="image">
                                      <img src="{{asset('storage/schimages/'.$schools->schoolLogo)}}" class="img-circle elevation-2" alt="" height="auto" width="50px">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <label for="">Principal's Signature</label>
                                    <div class="image">
                                      <img src="{{asset('storage/schimages/'.$schools->schoolprincipalsignature)}}" class="img-circle elevation-2" alt="" height="auto" width="50px">
                                    </div>
                                  </div>
                                </div>

                                <label for=""><h3>School Details</h3></label>
                                <div class="row">
                                  <div class="col-md-6">
                                    <label for="">School Type: {{$schools->schooltype}}</label>
                                    <label for="">School Type: {{$schools->schoolname}}</label>
                                    <label for="">Year Established: {{$schools->dateestablished}}</label><br>
                                    <label for="">School Website: {{$schools->schoolwebsite}}</label>
                                  </div>
                                  <div class="col-md-6">
                                    <label for="">Status: {{$schools->status}}</label><br>
                                    <label for="">School Address: {{$schools->schooladdress}}</label>
                                    <label for="">Mobile Number: {{$schools->mobilenumber}}</label>
                                    <label for="">School Email: {{$schools->schoolemail}}</label>
                                  </div>
                                </div>

                              <form action="activateschool" method="post" id="activateform{{$schools->id}}">
                                @csrf
                                  <input type="hidden" value="{{$schools->status}}" name="status">
                                  <input type="hidden" value="{{$schools->id}}" name="schoolid" readonly>
                                </form>
                              </div>
                              
                              <!-- Modal footer -->
                              <div class="modal-footer">
                                @if ($schools->status == "Pending")
                                <button type="submit" class="btn btn-success btn-sm" form="activateform{{$schools->id}}"><i class="fas fa-check"></i></button>
                                @else
                                <label for="">You can revoke approved commands</label>
                                <button type="submit" class="btn btn-warning btn-sm" form="activateform{{$schools->id}}"><i class="fab fa-rev"></i></button>
                                @endif
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                        
                        
                        
                        <!--modal for deleting schools-->
                        
                        <!-- Central Modal Small -->
                        <div class="modal fade" id="deleteschool{{$schools->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                          aria-hidden="true">
                        
                          <!-- Change class .modal-sm to change the size of the modal -->
                          <div class="modal-dialog modal-sm" role="document">
                        
                        
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title w-100" id="myModalLabel">{{$schools->id}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                  <center><i style="font-style: normal; font-size: 13px;">Are you sure you want to proceed? Remember this cannot be undone.</i></center>
                                <form id="deleteschoolform{{$schools->id}}" action="/deleteschool" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$schools->id}}" name="schoolid" readonly>
                                </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                <button type="submit" form="deleteschoolform{{$schools->id}}" class="btn btn-danger btn-sm">Proceed</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Central Modal Small -->
                        

                        <td>
                          <button class="btn btn-success btn-sm" data-toggle="modal" title="View School" data-target="#schools{{$schools->id}}"><i class="fas fa-thumbs-up"></i></button>
                          <a href="/view_school_order/{{$schools->id}}"><button class="btn btn-info btn-sm"><i class="far fa-eye"></i></button></a>
                          <button class="btn btn-danger btn-sm" data-toggle="modal" title="Delete School" data-target="#deleteschool{{$schools->id}}"><i class="far fa-trash-alt"></i></button></td>
                      </tr>
                          
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

          <!-- /.row -->
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
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });
  
    function scrollocation(){
        document.getElementById('orderoption').className = "nav-link active"
      }
</script>

@endsection