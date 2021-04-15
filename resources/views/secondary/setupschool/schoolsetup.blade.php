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
            <h1 class="m-0 text-dark">School Setup</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Setup</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


        <div class="card" style="border-top: 2px solid #0B887C;">

            <div class="row" style="margin: 10px 10px 0 10px;">
                <div class="col-md-6">
                    <form id="addschoolinitialsform" action="javascript:console.log('submitted');" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">School Initials</label>
                            <input type="text" name="schoolinitialsinput" value="{{$alldetails['addschool'][0]['shoolinitial']}}" class="form-control" id="schoolinitialsinput" placeholder="School Initials">
                            <i data-toggle="collapse" data-target="#demo" style="font-size: 13px; font-family: normal; color: blue;">What is school Initials?</i>
                            <div id="demo" class="collapse">
                              <p style="font-size: 12px;">Shool initial is required for Registration number generation. example: school A with Initials 
                                  MSC will have one of its Registration numbers as MSC101010. 
                                  School initial is a compulsory field and cannot be changed.</p>
                            </div>
                        </div>
                        @if ($alldetails['addschool'][0]['shoolinitial'] == null)
                        <button id="addschoolinitialsbtn" class="btn btn-info btn-sm">Add</button>
                        <button id="addschoolinitialsbtnprocess" style="display: none;" class="btn btn-info btn-sm" disabled>
                            <span class="spinner-grow spinner-grow-sm"></span>
                            Loading..
                        </button>
                        @endif
                    </form>

                </div>
                <div class="col-md-6">

                  <style>
                    .mydiv {
                      width:100%;
                      color:black;
                      font-weight:bold;
                      animation: myanimation 15s infinite;
                      border-radius: 5px;
                    }

                    @keyframes myanimation {
                      0% {background-color: red;}
                      25%{background-color:yellow;}
                      50%{background-color:green;}
                      75%{background-color:brown;}
                      100% {background-color: red;}
                    }
                  </style>

                  <div class="mydiv">
                    <p style="padding: 10px;">Current Term: First</p>
                    <button class="btn btn-sm btn-block btn-info" data-toggle="modal" data-target="#updateterm">CLick to Update term</button>
                  </div>

                  <!-- The Modal -->
                  <div class="modal fade" id="updateterm">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                      
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Update term</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                          <form action="{{ route('update_term') }}" method="post" id="updatetermmodal">
                            @csrf
                            <div class="form-group">
                              <label for="">Select a Term</label>
                              <select name="term" class="form-control form-control-sm" id="" required>
                                <option value="">Select Term</option>
                                <option value="1">First</option>
                                <option value="2">Second</option>
                                <option value="3">Third</option>
                              </select>
                            </div>
                          </form>
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                          <button type="submit" form="updatetermmodal" class="btn btn-info btn-sm">Submit</button>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                    
                    {{-- @if(count($alldetails['getStudentCount']) != $alldetails['subHistory'])
                    
                        <div class="alert alert-danger">
                            <p>You cannot change your school session because you are yet to clear your subscription. CLick the button before to proceed.</p>
                            <a href="/sub_index"><button class="btn btn-sm btn-info">Proceed</button></a>
                        </div>
                    
                    @else --}}
                    
                        <form id="schoolsessionform" action="javascript:console.log('submitted');" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Current Session</label>
                            <input type="text" class="form-control" value="{{$alldetails['addschool'][0]['schoolsession']}}" name="schoolsessioninput" id="schoolsessioninput" placeholder="Session">
                                </div>
                            </form>
                            <div>
                                <button id="schoolsessionbtnmodal" class="btn btn-info btn-sm">Next</button>
                                <div id="schoolsessionspinner" class="spinner-border" style="width: 20px; height: 20px; display: none;"></div>
                            </div>
                            
        
                            <!-- The Modal -->
                            <div class="modal fade" id="modalschoolsession">
                                <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                    <h4 class="modal-title">Confirm</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                    <i>Are you sure you want to Add session?</i>
                                    
                                    </div>
                                    
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button id="schoolsessionbtn" type="button" class="btn btn-success btn-sm" data-dismiss="modal">Yes</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
                                    </div>
                                    
                                </div>
                                </div>
                            </div>
                    {{-- @endif --}}
                    
                    
                    

                </div>
            </div>

            <div class="row" style="margin: 10px;">
                <div class="col-md-6">
                    <div class="card" style="">
                        <div class="card-header">
                            <i style="font-style: normal;">Setup Class List</i>
                        </div>
                        <div class="card-body">
                            <form id="addclasses_secform" action="javascript:console.log('submitted');" method="post">
                                @csrf
                                <div class="form-group">
                                    <i style="font-style: normal; color: red;">Note: class list should be entered in accending order.</i>
                                    <textarea name="addclasses_input" id="addclasses_input" class="form-control" rows="3" placeholder="Enter class name e.g Jss1, Jss 2, Jss 3" style="text-transform:uppercase"></textarea>
                                  </div>
                                  <div>
                                    <button id="addclasses_secbtn" class="btn btn-sm btn-info">Submit</button>
                                    <div id="classes_spinner_sec" class="spinner-border" style="width: 20px; height: 20px; display: none;"></div>
                                  </div>
                            </form>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="">
                        <div class="card-header">
                            <i style="font-style: normal;">Setup Houses</i>
                        </div>
                        <div class="card-body">
                            <form id="addhouses_secform" action="javascript:console.log('submitted');" method="post">
                                @csrf
                                <div class="form-group">
                                    {{-- <i style="font-style: normal; color: red;">Note: class list should be entered in accending order.</i> --}}
                                    <textarea id="addhouses_input" name="addhouses_input" class="form-control" rows="3" placeholder="Enter class name e.g Red House, Blue House" style="text-transform:uppercase"></textarea>
                                  </div>
                                  <div>
                                    <button id="addhouses_secbtn" class="btn btn-sm btn-info">Submit</button>
                                    <div id="houses_spinner_sec" class="spinner-border" style="width: 20px; height: 20px; display: none;"></div>
                                  </div>
                                 
                            </form>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>

                </div>
            </div>

            <div class="row" style="margin: 10px;">
                <div class="col-md-6">
                    <div class="card" style="">
                        <div class="card-header">
                            <i style="font-style: normal;">Class section Patterns/Arm</i>
                        </div>
                        <div class="card-body">
                            <form id="addsection_secform" action="javascript:console.log('submitted');" method="post">
                                @csrf
                                <div class="form-group">
                                    {{-- <i style="font-style: normal; color: red;">Note: class list should be entered in accending order.</i> --}}
                                    <textarea id="addsection_input" name="addsection_input" class="form-control" rows="3" placeholder="Enter section/arm e.g A, B, C " style="text-transform:uppercase"></textarea>
                                  </div>
                                  <div>
                                    <button id="addsection_secbtn" class="btn btn-sm btn-info">Submit</button>
                                    <div id="section_spinner_sec" class="spinner-border" style="width: 20px; height: 20px; display: none;"></div>
                                  </div>
                            </form>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="">
                        <div class="card-header">
                            <i style="font-style: normal;">Club/Society</i>
                        </div>
                        <div class="card-body">
                            <form id="addclub_secform" action="javascript:console.log('submitted');" method="post">
                                @csrf
                                <div class="form-group">
                                    {{-- <i style="font-style: normal; color: red;">Note: class list should be entered in accending order.</i> --}}
                                    <textarea id="addclub_input" name="addclub_input" class="form-control" rows="3" placeholder="Enter Club/Society e.g Drama club..." style="text-transform:uppercase"></textarea>
                                  </div>
                                  <div>
                                    <button id="addclub_secbtn" class="btn btn-sm btn-info">Submit</button>
                                    <div id="club_spinner_sec" class="spinner-border" style="width: 20px; height: 20px; display: none;"></div>
                                  </div>
                            </form>
                        </div>
                        <div class="card-footer">

                        </div>
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

  <script>
      function scrollocation(){
        document.getElementById('setupmain').className = "nav-link active"
        document.getElementById('setupmainsetupage').className = "nav-link active"
      }
  </script>
    
@endsection