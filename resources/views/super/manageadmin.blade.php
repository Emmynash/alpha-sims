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
              <h1 class="m-0 text-dark">Manage Role</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">AdminRole</li>
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

            <div class="card">
                <div class="row" style="margin: 10px;">
                    <div class="col-sm-5">
                        <form id="submitadminrole" action="javascript:console.log('submited')" method="post">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="adminsystemid" id="adminsystemid" class="form-control form-control-sm" placeholder="Enter system number" style="border-radius: 0px">
                            </div>
                        </form>
                        <button type="submit" id="submitadminform" form="submitadminrole" class="btn btn-sm btn-info">Process</button>
                    </div>
                </div>
            </div>

                    <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Super Admins</h3>

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
                      <th>System Id</th>
                      <th>Role</th>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Date Asigned</th>
                      <th>Group</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($alldetails['allAdmins']) > 0)

                    @foreach ($alldetails['allAdmins'] as $admins)

                    <tr>
                      <td>{{$admins->id}}</td>
                      <td>{{$admins->schoolid}}</td>
                      <td>{{$admins->firstname}} {{$admins->middlename}} {{$admins->lastname}}</td>
                      <td>{{$admins->phonenumber}}</td>
                      <td>{{$admins->email}}</td>
                      <td>{{$admins->created_at}}</td>
                      <td>{{$admins->role}}</td>
{{-- 
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
                      </div>--}}

                      <td>
                        <button class="btn btn-info btn-sm" data-toggle="modal" title="View School" data-target="#schools"><i class="far fa-eye"></i></button>
                        <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete School"><i class="far fa-trash-alt"></i></button></td>
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


            <!-- The Modal -->
            <div class="modal fade" id="adminrole">
                <div class="modal-dialog">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h6 class="modal-title" id="fetchedname">Modal Heading</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">

                      <div id="alertschoolfetched" style="display: none" class="alert alert-success">
                        <strong>Success!</strong> <i id="schoolfetched" style="font-style: normal; font-size: 13px;">dff fdfd fdfdf fdfd fdfd<i>
                      </div>

                    <div class="row">
                      <div class="col-3">
                        <div class="image">
                          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" width="100px" height="100px">
                        </div>
                      </div>
                      <div class="col-9">
                        <div class="card">
                          <div style="display: flex; flex-direction: column; margin-left: 10px;">
                            <i id="rolefetched" style="font-style: normal; font-size: 13px;">Current Role: </i>
                            <i id="emailfetched" style="font-style: normal; font-size: 13px;">Email Address: </i>
                            <i id="phonefetched" style="font-style: normal; font-size: 13px;">Phone Number: </i>
                          </div>
                        </div>
                        <form id="asignroleform" action="/alocatefinal" method="post">
                          @csrf
                          <input type="hidden" id="whotoasign" name="whotoasign">
                          <select name="selectedrole" class="form-control form-control-sm" id="selectedrole" style="border-radius: 0px;">
                            <option value="">select a role</option>
                            <option value="SuperAdmin">General</option>
                            <option value="Technical">Technical</option>
                            <option value="Suport">Suport</option>
                            <option value="Account">Account</option>
                          </select>
                        </form>
                      </div>
                    </div>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm">Revoke Role</button>
                    <button type="submit" form="asignroleform" class="btn btn-success btn-sm">Asign Role</button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    </div>
                    
                </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2014-2019 <a href="http://brightosofttechnologies.com">Brightosoft</a>.</strong>
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
        document.getElementById('managerole').className = "nav-link active"
      }
</script>

@endsection