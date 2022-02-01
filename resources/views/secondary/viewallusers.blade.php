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
            <h1 class="m-0 text-dark">Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


        <div class="card" style="height: 200px; border-top: 2px solid #0B887C;">

        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users</h3>

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
                    @if (count($allusers) > 0)
                      @foreach ($allusers as $users)
                        <tr>
                          <td><img src="{{asset('storage/schimages/'.$users->profileimg)}}" class="rounded-circle" alt="" height="40px" width="40px"></td>
                          <td>{{$users->id}}</td>
                          <td>{{$users->firstname}} {{$users->middlename}} {{$users->lastname}}</td>
                          <td>{{$users->role}}</td>
                          <td>{{$users->phonenumber}}</td>
                          <td>{{$users->email}}</td>
                          <td>

                            <div class="dropdown dropleft float-right">
                              <button type="button" class="btn btn-primary" data-toggle="dropdown" style="display: flex; align-items: center;">
                                <i class="fas fa-ellipsis-h"></i></i>
                              </button>
                              <div class="dropdown-menu">
                                <i class="dropdown-item" style="font-size: 10px; position: absolute; top: 0; right: 0; width: 10px;">{{$users->id}}</i>
                                <a class="dropdown-item" href="#" onclick="ViewStudentDetails('{{$users->firstname}}', '{{$users->middlename}}', '{{$users->lastname}}', '{{$users->profileimg}}', '{{$users->id}}', '{{$users->role}}')"><i class="fas fa-eye"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-trash"></i> Delete</a>
                                {{-- <a class="dropdown-item" href="#">Link 3</a> --}}
                              </div>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            @if (count($allusers) > 0)
            {{ $allusers->links() }}
            @endif
          </div>
        </div>
        <!-- /.row -->
        </div>

          <!-- The Modal -->
          <div class="modal" id="viewuserdetailsmodal">
            <div class="modal-dialog">
              <div class="modal-content">
              
                <!-- Modal Header -->
                <div class="modal-header">
                  <h6 class="modal-title" id="viewstudentnamemodal">Modal Heading</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                  <div id="viewusersmodal" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                    <div class="spinner-border"></div>
                    <i>Loading...</i>
                  </div>

                  <div id="viewusermaincontentmodal" style="display: none;">
                    <div class="row" style="">
                      <div class="col-md-6" style="">
                        <div class="card" style="border: 2px solid green;">
                          <div style="">
                            <div style="height: 100px; display: flex; align-items: center; justify-content: center;">
                              <img id="viewuserdetailspix" src="" class="rounded-circle" alt="" width="70px" height="70px">
                            </div>
                            <div style="display: flex; flex-direction: column; align-items:center; justify-content: center;">
                              <i id="viewstudentnamemodalmain" style="font-size: 12px;">User Name Here</i>
                              <!--<i style="font-size: 12px;">User Name Here</i>-->
                            </div>
                            <div>
                              <hr style="width: 90%;">
                                <div style="width: 90%; margin: 0 auto; display: flex;">
                                  <i style="font-size: 12px;">Class</i>
                                  <div style="flex: 1;"></div>
                                  <i id="classsection" style="font-size: 12px;"></i>
                                </div>
                                <hr style="width: 90%;">
                                <div style="width: 90%; margin: 0 auto; display: flex;">
                                  <i style="font-size: 12px;">Reg. No</i>
                                  <div style="flex: 1;"></div>
                                  <i id="studentregno" style="font-size: 12px;"></i>
                                </div>
                                <hr style="width: 90%;">
                                <div style="width: 90%; margin: 0 auto; display: flex;">
                                  <i style="font-size: 12px;">System.No</i>
                                  <div style="flex: 1;"></div>
                                  <i id="systemnomodal" style="font-size: 12px;"></i>
                                </div>
                                <hr style="width: 90%;">
                                <div style="width: 90%; margin: 0 auto; display: flex;">
                                  <i style="font-size: 12px;">Role</i>
                                  <div style="flex: 1;"></div>
                                  <i id="userrole" style="font-size: 12px;"></i>
                                </div>
                                <hr style="width: 90%;">
                                <div style="width: 90%; margin: 0 auto; display: flex;">
                                  <i style="font-size: 12px;">Gender</i>
                                  <div style="flex: 1;"></div>
                                  <i id="usergender" style="font-size: 12px;"></i>
                                </div>
                                <hr style="width: 90%;">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6" style="">
                        <div class="card" style="border: 2px solid red;">
                          <div style="height: 400px;">
                            <hr style="width: 90%;">
                                <div style="width: 90%; margin: 0 auto; display: flex;">
                                  <i style="font-size: 12px;">Address</i>
                                  <div style="flex: 1;"></div>
                                  <i id="studentpresenthomeaddress" style="font-size: 12px;"></i>
                                </div>
                            <hr style="width: 90%;">
                                <div style="width: 90%; margin: 0 auto; display: flex;">
                                  <i style="font-size: 12px;">BloodGroup</i>
                                  <div style="flex: 1;"></div>
                                  <i id="bloodgroup" style="font-size: 12px;"></i>
                                </div>
                            <hr style="width: 90%;">

                          </div>

                        </div>

                      </div>
                    </div>

                  </div>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <script>
      function scrollocation(){
        document.getElementById('setupmain').className = "nav-link active"
        document.getElementById('usersscroll').className = "nav-link active"
      }

      function ViewStudentDetails(firstname, middlename, lastname, profileimg, userid, role){

        // alert('good')
        $('#viewuserdetailsmodal').modal('show');
        var fullname = firstname+" "+" "+middlename+" "+lastname;
        document.getElementById('viewstudentnamemodal').innerHTML = fullname;
        document.getElementById('viewstudentnamemodalmain').innerHTML = fullname;
        document.getElementById('viewuserdetailspix').src = "storage/schimages/"+profileimg;
        document.getElementById('systemnomodal').innerHTML = userid
        document.getElementById('userrole').innerHTML = role;
        
        document.getElementById('viewusermaincontentmodal').style.display = "none"
        document.getElementById('viewusersmodal').style.display = "flex"

        $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                  });
                  $.ajax({
                      url:"{{ route('allusers_sec_fetch') }}", //the page containing php script
                      method: "POST", //request type,
                      cache: false,
                      data: {systemno:userid, role:role},
                      success:function(result){

                     console.log(result.data)
                     document.getElementById('viewusermaincontentmodal').style.display = "block"
                     document.getElementById('viewusersmodal').style.display = "none"
                     if (result.data) {
                       
                       for (let index = 0; index < result.data.length; index++) {
                         const element = result.data[index];
                         document.getElementById('classsection').innerHTML = element.classname+element.sectionname
                         document.getElementById('studentregno').innerHTML = element.id
                         document.getElementById('usergender').innerHTML = element.gender;
                         document.getElementById('studentpresenthomeaddress').innerHTML = element.studentpresenthomeaddress
                         document.getElementById('bloodgroup').innerHTML = element.bloodgroup
                         
                       }
                       
                     }else{
                         $('#viewuserdetailsmodal').modal('hide');
                     }
                                   
                    },
                    error:function(){
                      alert('failed')
                      document.getElementById('viewusermaincontentmodal').style.display = "block"
                      document.getElementById('viewusersmodal').style.display = "none"
                      
                      
                    }
                  });
      }
  </script>
    
@endsection