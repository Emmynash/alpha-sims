@extends('layouts.app_dash')

@section('content')
    
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
            <h1 class="m-0 text-dark">Add Subject</h1>
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
        <div class="card card-default">

          <!-- /.card-header -->
          <div class="card-body">
            
            <div class="row">
              <div class="col-md-6">
                    <form id="addschool" method="POST" action="/shoolreg" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                            <input id="schoolNameInput" name="schoolname" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Subject Code" required>
                            </div>
                            <div class="form-group">
                            <input id="schoolEmailInput" name="schoolemail" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Subject Name">
                            </div>
                            <div class="form-group">
                            <select id="schoolMobileNumber" name="mobilenumber" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Mobile Number">
                                <option value="">Select Class</option>
                            </select>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="schoolWebsiteInput" name="schoolwebsite" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Website">
                                    <option value="">choose student group</option>
                                    <option value="">Science</option>
                                    <option value="">Art</option>
                                    <option value="">Commercial</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input id="schoolDateEstablished" name="dateestablished" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Establish">
                            </div>
                            <div class="form-group">
                                <textarea id="schoolAddressInput" name="schooladdress" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Address"></textarea>
                            </div>  
                    </form>
              </div>
              <button id="formSubmit" type="submit" class="btn btn-info" form="addschool">Submit</button>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            {{-- <button id="formVerify" onclick="verifyForm()" class="btn btn-warning">Verify</button> --}}
            

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin. --}}
          </div>
        </div>
        <!-- /.card -->

        @else

        {{-- <div id="promoalert" class="alert alert-danger alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>	
          <i class="fas fa-exclamation-circle"></i><strong id="subjectalertmessage"> An error occured. Ensure all fields are filled correctly</strong>
        </div> --}}

        <div class="card card-default">
            <!-- /.card-header -->
            <div id="subjectform" class="card-body">
              <div id="subjectprocess" style="display:none;">
                <div style="position: absolute; top: 0; bottom: 0; right: 0; left:0; background-color: #fff; z-index: 999; opacity: 0.5; display: flex; align-items: center; justify-content: center;">
                  <div style="width: 100px; height: 100px;" class="spinner-border"></div>
                </div>
              </div>

              <form method="POST" action="javascript:console.log('submitted');" id="fetchresult">
                @csrf
                <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <input id="querysession" name="querysession" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Session Query" required>
                          </div>
                          <div class="form-group">
                            <select id="classid" name="studentclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="School Name">
                                  <option value="">choose class</option>
                                @foreach ($studentDetails['classList'] as $classlist)
                                  <option value="{{$classlist->id}}">{{$classlist->classnamee}}</option>
          
                                @endforeach
                            </select>
                          </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <select id="schoolterm" name="schoolterm" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Address">
                              <option value="">school term</option>
                              <option value="1">First Term</option>
                              <option value="2">Second Term</option>
                              <option value="3">Third Term</option>
                          </select>
                        </div>
                      </div>
                      <!-- /.col -->
                </div>
                <!-- /.row --> 
              </form>
              <button type="submit" class="btn btn-sm btn-info" id="resultstudenttable">Query Result</button>
              
  
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
              the plugin. --}}
            </div>
          </div>
        @endif

        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Exam marks for current session</h3>

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
                <table class="table table-hover text-nowrap" id="studenttable">
                  <thead>
                    <tr>
                      <th>Subject Code</th>
                      <th>Subject Name</th>
                      <th>Exams</th>
                      <th>CA1</th>
                      <th>CA2</th>
                      <th>CA3</th>
                      <th>Total</th>
                      <th>Grade</th>
                      <th>Term</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                      @if (count($studentDetails['addmarks']) > 0)
                      @foreach ($studentDetails['addmarks'] as $addmarks)
                      <tr>
                        <td>{{$addmarks->subjectcode}}</td>
                        <td>{{$addmarks->subjectname}}</td>
                        <td>{{$addmarks->exams}}</td>
                        <td>{{$addmarks->ca1}}</td>
                        <td>{{$addmarks->ca2}}</td>
                        <td>{{$addmarks->ca3}}</td>
                        <td>{{$addmarks->totalmarks}}</td>
                        <td>{{$addmarks->grades}}</td>
                        <td>{{$addmarks->term}}</td>

                        <!-- The Modal -->
                        <div class="modal fade" id="studentresult{{$addmarks->id}}">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                            
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <h4 class="modal-title">{{$addmarks->subjectname}}</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              
                              <!-- Modal body -->
                              <div class="modal-body">

                                <div id="projectalert" class="alert alert-warning alert-block">
                                  <button type="button" class="close" data-dismiss="alert">×</button>	
                                  <i class="fas fa-exclamation-circle"></i><strong id="subjectalertmessage"> Submit only if you have a problem with your scores</strong>
                                </div>

                                <form action="" method="post" id="messageform{{$addmarks->id}}">
                                  @csrf
                                  <div class="form-group">
                                    <textarea name="" id="" class="form-control form-control-sm" cols="15" rows="5"></textarea>
                                  </div>
                                </form>
                              </div>
                              
                              <!-- Modal footer -->
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-sm" form="messageform{{$addmarks->id}}">submit</button>
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                              </div>
                              
                            </div>
                          </div>
                        </div>

                        <td><button class="btn btn-sm btn-info" data-toggle="modal" data-target="#studentresult{{$addmarks->id}}"><i class="fas fa-flag-checkered"></i></button></td>
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
  document.getElementById('studentoptions').className = "nav-link active"
  document.getElementById('examsmarkstudent').className = "nav-link active"
}
</script>

@endsection