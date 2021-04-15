@extends('layouts.app_dash')

@section('content')


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
            <h1 class="m-0 text-dark">Student List</h1>
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
        @if ($studentDetails['userschool'][0]['status'] != "Pending")
        <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">

            <div class="row">
              <div class="col-md-6">
            
                <form id="psycomotoquery" method="POST" action="javascript:console.log('submitted');" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                        <select id="studentclass" name="studentclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="School Name">
                            <option value="">choose class</option>
                            @foreach ($studentDetails['classList'] as $classlist)
                              <option value="{{$classlist->id}}" {{ count($studentDetails) > 5 ? $studentDetails['addteachers'][0]['formteacher'] == $classlist->id ? "" : "disabled" : "" }}>{{$classlist->classnamee}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                        <select id="studentsection" name="studentsection" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Mobile Number">
                            <option value="">Choose section</option>
                            @foreach ($studentDetails['addSection'] as $section)
                            <option value="{{$section->sectionname}}" {{ count($studentDetails) > 5 ? $studentDetails['addteachers'][0]['formsection'] == $section->id ? "" : "disabled" : "" }}>{{$section->sectionname}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                    <div id="formdivtwo" style="">
                        <div class="form-group">
                            <input id="sessionquery" value="{{$studentDetails['userschool'][0]['schoolsession']}}" name="sessionquery" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Session" readonly>
                        </div>
                        <div class="form-group">
                            <select id="studentshift" name="studentshift" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Address">
                                <option value="Choose shift">Choose shift</option>
                                <option value="Morning">Morning</option>
                                <option value="Afternoon">Afternoon</option>
                            </select>
                        </div>
                        <div class="form-group">
                          <select id="schoolterm" name="schoolterm" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Address">
                              <option value="">school term</option>
                              <option value="1">First Term</option>
                              <option value="2">Second Term</option>
                              <option value="3">Third Term</option>
                          </select>
                      </div>
                    </div>
                        
                </form>

              </div>
              <!-- /.col -->
            </div>

            <!-- /.row -->
            <button id="psycomotoquerybtn" style="" type="submit" class="btn btn-info">Query class</button>

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin. --}}
          </div>
        </div>

        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Student List</h3>
  
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
                  <table class="table table-hover text-nowrap" id="psycomotoqueryform">
                    <thead>
                      <tr>
                        <th>Reg No</th>
                        <th>Roll No</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>


          <!-- The Modal -->
            <div class="modal" id="motomodal">
              <div class="modal-dialog">
                <div class="modal-content">
                
                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 id="modealheadmoto" class="modal-title">Modal Heading</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  
                  <!-- Modal body -->
                  <div class="modal-body">

                    <div id="projectalert" class="alert alert-warning alert-block">
                      <button type="button" class="close" data-dismiss="alert">×</button>	
                      <i class="fas fa-exclamation-circle"></i><strong id="subjectalertmessage"> You must first verify user.</strong>
                    </div>

                    <form id="mainformmoto" action="javascript:console.log('submitted');" method="post">
                      @csrf
                      <input type="hidden" name="systemidmoto" id="systemidmoto">
                      <input type="hidden" name="classidmoto" id="classidmoto">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">Reg No</i>
                            <input type="text" id="studentregnomoto" name="studentregnomoto" class="form-control form-control-sm" readonly>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">Session</i>
                          <input type="text" value="{{$studentDetails['userschool'][0]['schoolsession']}}" name="schoolsessionmoto" class="form-control form-control-sm" readonly>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">Select term</i>
                            <select name="schooltermmoto" id="" class="form-control form-control-sm">
                              <option value="">Select a value</option>
                              <option value="1">First term</option>
                              <option value="2">Second term</option>
                              <option value="3">Third term</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      {{-- AFFECTIVE DOMAIN : --}}

                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">NEATNESS</i>
                            <select name="neatness" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">PUNTUALITY</i>
                            <select name="punctuality" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">RELIABILITY</i>
                            <select name="reliability" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">POLITENESS</i>
                            <select name="politeness" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">HONESTY</i>
                            <select name="honesty" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">SELF CONTROL</i>
                            <select name="selfcontrol" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">COOPERATION</i>
                            <select name="cooperation" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">ATTENTIVENESS</i>
                            <select name="attentiveness" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">INITIATIVE</i>
                            <select name="initiative" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">ORGANISATION ABILITY</i>
                            <select name="organisation" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">PERSEVERANCE</i>
                            <select name="perseverance" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">FLEXIBILITY</i>
                            <select name="flexibility" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      {{-- PSYCHOMOTOR DOMAIN : --}}

                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">HANDWRITING</i>
                            <select name="handwriting" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">GAMES/SPORT</i>
                            <select name="gamessport" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">CREATIVITY</i>
                            <select name="creativity" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">HANDLING OF TOOLS</i>
                            <select name="handlingoftools" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">DEXTERITY</i>
                            <select name="dexterity" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <i style="font-size: 12px;">NOTE COPYING</i>
                            <select name="notecopying" class="form-control form-control-sm" id="">
                              <option value="">Select a value</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </form>

                  </div>
                  
                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button id="mainbtnmoto" type="button" class="btn btn-success btn-sm">Submit</button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                  </div>
                  
                </div>
              </div>
            </div>


        <!-- /.card -->
        @endif
        @if ($studentDetails['userschool'][0]["status"] !="Approved")
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
                      @if ($studentDetails['userschool'][0] !="Approved")

                      @foreach ($studentDetails['userschool'] as $schools)
                        <td>{{$studentDetails['userschool'][0]['schoolId']}}</td>
                        <td>{{$studentDetails['userschool'][0]['schoolemail']}}</td>
                        <td>{{$studentDetails['userschool'][0]['mobilenumber']}}</td>
                        <td>{{$studentDetails['userschool'][0]['periodfrom']}}</td>
                        <td>{{$studentDetails['userschool'][0]['periodto']}}</td>
                        <td><span class="tag tag-success">{{$studentDetails['userschool'][0]['status']}}</span></td>
                      @endforeach
                        
                      @endif
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

        <div class="modal fade" id="modal-lg">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Name</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                {{-- <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                  <div class="spinner-border"></div>
                </div> --}}

                <div>
                  <div class="row">
                    <div class="col-md-6">
                      <img src="{{asset('storage/schimages/'.Auth::user()->profileimg)}}" class="img-circle elevation-2" alt="Cinque Terre" width="100px" height="100px">
                      <p>Name:</p>
                      <p>Email:</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <p>Class/Section: </p>
                      <hr>
                      <p>Reg No</p>
                      <hr>
                      <p>House</p>
                      <hr>
                      <p>Shift</p>
                      <hr>
                      <p>Blood Group</p>

                    </div>
                    <div class="col-md-6">
                      <p>Father's's Name</p>
                      <hr>
                      <p>Father's Number</p>
                      <hr>
                      <p>Mother's Name</p>
                      <hr>
                      <p>Mother's Number</p>
                      <hr>
                      <p>Home Address</p>
                      <hr>
                      <p>Permanent Address</p>

                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

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

<!-- ./wrapper -->

<script>
    function motoprocess(firstname, middlename, lastname, regno, systemid, classidmoto){
      // alert(firstname)

      document.getElementById('modealheadmoto').innerHTML = firstname +" "+ middlename+" "+ lastname;
      document.getElementById('studentregnomoto').value = regno
      document.getElementById('systemidmoto').value = systemid
      document.getElementById('classidmoto').value = classidmoto
    }

    function scrollocation(){
        document.getElementById('pychomotoraside').className = "nav-link active"
        document.getElementById('affectivedomainaside').className = "nav-link active"
    }
 
</script>
    
@endsection