@extends('layouts.app_dash')

@section('content')
{{-- aside menu --}}
  <!-- Main Sidebar Container -->
  @include('layouts.asideside')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div style="width: 90%; margin: 0 auto; padding-top: 10px;">
      @include('layouts.message')
    </div>
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Users</h1>
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
          <!-- SELECT2 EXAMPLE -->
        @if ($studentDetails['userschool'][0]['status'] != "Pending" && $studentDetails['userschool'][0]['schooltype'] != "Primary")
        {{-- <button>Add classes</button> --}}
        <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">

            <p>card body</p>


          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin. --}}
          </div>
        </div>
        <!-- /.card -->

        @else

        <!-- /.row -->
        <div class="row">
            <div class="col-12">
            {{-- <button class="btn btn-info btn-sm" style="margin: 5px;"><a href="/setupschool" style="color: #fff;">Add classes</a></button> --}}
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">User list</h3>
  
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
                        <th></th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                        @if (count($studentDetails['allusers']) > 0)
  
                        @foreach ($studentDetails['allusers'] as $allusers)
                        <tr>
                          <td>
                            <div class="image">
                                <img src="{{asset('storage/schimages/'.$allusers->profileimg)}}" class="img-circle elevation-2" alt="" width="50px" height="auto">
                              </div>
                          </td>
                          <td>{{$allusers->id}}</td>
                          <td>{{$allusers->firstname}} {{$allusers->middlename}} {{$allusers->lastname}}</td>
                          <td>{{$allusers->role}}</td>
                          <td>{{$allusers->phonenumber}}</td>
                          <td>{{$allusers->email}}</td>
                          <td>
                            <div class="dropdown">
                              <button type="button" class="btn btn-outline-info" data-toggle="dropdown">
                                <i class="fas fa-ellipsis-h"></i>
                              </button>
                              <div class="dropdown-menu">
                                {{-- <a class="dropdown-item" href="#"><i class="fas fa-edit"></i> Edit</a> --}}
                                {{-- <a class="dropdown-item" href="#"><i class="fas fa-trash-alt"></i> Delete</a> --}}
                                {{-- <a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View</a> --}}
                                {{-- <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Another link</a> --}}
                              </div>
                            </div>

                          </td>
                          {{-- <td style="display: flex; flex-direction: column;"> <label style="font-size:12px;">total:{{$subject->totalfull}}, exams:{{$subject->examfull}}</label> <label style="font-size:12px;">CA1:{{$subject->ca1full}}, CA2:{{$subject->ca2full}}, CA3:{{$subject->ca3full}}</label></td>
                          <td><label style="font-size: 12px;">total:{{$subject->totalpass}}, exams:{{$subject->exampass}}</label>  <label style="font-size:12px;">CA1:{{$subject->ca1pass}}, CA2:{{$subject->ca2pass}}, CA3:{{$subject->ca3pass}}</label></td>
                          <td><span class="tag tag-success">{{$subject->classname}}</span></td> --}}
                        </tr>
                        @endforeach
                        
                          
                        @endif
                    </tbody>
                    
                  </table>
                  
                </div>
                
                <!-- /.card-body -->
              </div>
              @if (count($studentDetails['allusers']) > 0)
                {{ $studentDetails['allusers']->links() }}
              @endif
              <!-- /.card -->
            </div>
          </div>
        
        @endif

          @if ($studentDetails['userschool'][0]['status'] == "Pending")
                      <!-- /.row -->
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Status</h3>
  
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
                        <th>School Id</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Active From</th>
                        <th>End On</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        {{-- @if (count($userschool) > 0)
  
                        @foreach ($userschool as $schools)
                          <td>{{$userschool[0]['schoolId']}}</td>
                          <td>{{$userschool[0]['schoolemail']}}</td>
                          <td>{{$userschool[0]['mobilenumber']}}</td>
                          <td>{{$userschool[0]['periodfrom']}}</td>
                          <td>{{$userschool[0]['periodto']}}</td>
                          <td><span class="tag tag-success">{{$userschool[0]['status']}}</span></td>
                        @endforeach
                          
                        @endif --}}
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          @endif

        </div><!-- /.container-fluid -->
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

<script>
    function scrollocation(){
        document.getElementById('settingsaside').className = "nav-link active"
        document.getElementById('usersaside').className = "nav-link active"
    }
</script>

@endsection