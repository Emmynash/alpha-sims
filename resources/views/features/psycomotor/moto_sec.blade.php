@extends($schooldetails->schooltype == "Primary" ? 'layouts.app_dash' : 'layouts.app_sec')

@section('content')

@if ($schooldetails->schooltype == "Primary")
@include('layouts.asideside') 
@else
  @include('layouts.aside_sec')
@endif

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">psychomotor</h1>
            <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Psychomotor"
                data-content="On this module, you are required to fill out phychomoto for all students in each class. this is required for result generation">Need help?</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">psychomotor</li>
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
          <div id="spinnermotoprocess" style="position: absolute; top: 0; bottom: 0; right: 0; left: 0; display: none; align-items: center; justify-content: center; z-index: 999;">
            <div class="spinner-border" style="width: 100px; height: 100px;"></div>
          </div>

            <form id="motoaddform" action="javascript:console.log('submitted')" method="POST">
              @csrf
                <div class="row" style="margin: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 10px;">Select a class</i>
                            <select name="selectedclassmoto" id="selectedclassmoto" class="form-control form-control-sm">
                                <option value="">Select a Class</option>
                                @if (count($alldetails['class_list']) > 0)
                                    @foreach ($alldetails['class_list'] as $classes)
                                        <option value="{{$classes->id}}">{{$classes->classname}}</option>
                                    @endforeach
                                    
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px;">Select a Section</i>
                            <select name="selectedsectionmoto" id="selectedsectionmoto" class="form-control form-control-sm">
                                <option value="">Select a Section</option>
                                @if (count($alldetails['addsection_sec']) > 0)
                                    @foreach ($alldetails['addsection_sec'] as $section)
                                        <option value="{{$section->id}}">{{$section->sectionname}}</option>
                                    @endforeach
                                    
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 10px;">Session</i>
                            <input type="text" name="sessionmoto" id="sessionmoto" value="{{$alldetails['addpost'][0]['schoolsession']}}" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px;">Select a Term</i>
                            <select name="selectedtermmoto" id="selectedtermmoto" class="form-control form-control-sm">
                                <option value="">Select a Term</option>
                                <option value="1">First term</option>
                                <option value="2">Second term</option>
                                <option value="3">Third term</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button style="margin:0 0 10px 20px;" id="motoaddid" class="btn btn-sm btn-info">Query</button>
            </form>
        </div>
                <!-- /.row -->
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
                          <table class="table table-hover text-nowrap">
                            <thead>
                              <tr>
                                <th>Reg No</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody id="tablemoto">

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
                  <div class="modal" id="modalmoto">
                    <div class="modal-dialog">
                      <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h6 class="modal-title" id="modalnamemoto">Modal Heading</h6>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                          <div id="psycospinner" style="display: none; align-items: center; justify-content: center;">
                            <div class="spinner-border"></div>
                          </div>
                          <form id="modalformform" action="javascript:console.log('submited')" method="post">
                            @csrf
                            <input type="hidden" name="systemnumber" id="systemnumber">
                            <input type="hidden" name="regno" id="regno">
                            <input type="hidden" name="term" id="term">
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <i style="font-size: 10px;">Puntuality</i>
                                  <select name="puntualitymoto" id="puntualitymoto" class="form-control form-control-sm">
                                    <option value="">Select a rate</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <i style="font-size: 10px;">Attendance in Class</i>
                                  <select name="attendancemoto" id="attendancemoto" class="form-control form-control-sm">
                                    <option value="">Select a rate</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <i style="font-size: 10px;">Attentiveness</i>
                                  <select name="attentivenessmoto" id="attentivenessmoto" class="form-control form-control-sm">
                                    <option value="">Select a rate</option>
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
                                  <i style="font-size: 10px;">Carrying out Assignment</i>
                                  <select name="carryingoutassignmentmoto" id="carryingoutassignmentmoto" class="form-control form-control-sm">
                                    <option value="">Select a rate</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <i style="font-size: 10px;">Neatness</i>
                                  <select name="neatnessmoto" id="neatnessmoto" class="form-control form-control-sm">
                                    <option value="">Select a rate</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <i style="font-size: 10px;">Honesty</i>
                                  <select name="honestymoto" id="honestymoto" class="form-control form-control-sm">
                                    <option value="">Select a rate</option>
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
                                  <i style="font-size: 10px;">Self control</i>
                                  <select name="selfcontrolmoto" id="selfcontrolmoto" class="form-control form-control-sm">
                                    <option value="">Select a rate</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <i style="font-size: 10px;">Game-sport</i>
                                  <select name="gamesportmoto" id="gamesportmoto" class="form-control form-control-sm">
                                    <option value="">Select a rate</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <i style="font-size: 10px;">Handling of Tools</i>
                                  <select name="handlingoftoolsmoto" id="handlingoftoolsmoto" class="form-control form-control-sm">
                                    <option value="">Select a rate</option>
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
                          <button id="modalformbtn" class="btn btn-success btn-sm" form="modalformform">Add</button>
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
        document.getElementById('psyhcomoto').className = "nav-link active"
      }

      function takemoto(regno, userid, firstname, middlename, lastname){
        $('#modalmoto').modal('show');

        document.getElementById('systemnumber').value = userid;
        document.getElementById('regno').value = regno;
        document.getElementById('term').value = document.getElementById('selectedtermmoto').value;

        document.getElementById('modalnamemoto').innerHTML = firstname+" "+middlename+" "+lastname
      }
  </script>
    
@endsection