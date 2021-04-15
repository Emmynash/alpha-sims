@extends('layouts.app_dash')

@section('content')

@include('layouts.asideside')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div style="width: 90%; margin: 0 auto; padding-top: 10px;">
      
    </div>
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Student Promotion</h1>
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
    <section class="content">
        <div class="container-fluid">
            @if ($studentDetails['userschool'][0]['status'] != "Pending" && $studentDetails['userschool'][0]['schooltype'] == "Primary")
            <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">
            {{-- <h4 style="padding-top: 10px;">Class Allocation Details</h4> --}}
                <div class="row">
                    <div class="col-md-6" style="border: 1px solid black; border-radius: 5px;">
                    <form action="javascript:console.log('submitted');" method="post" id="promotionfrom">
                        @csrf
                        <h5>Promotion from</h5>
                        <div>
                            <div id="promoalert" class="alert alert-danger alert-block" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">×</button>	
                                <i class="fas fa-exclamation-circle"></i><strong id="subjectalertmessage"> An error occured. Ensure all fields are filled correctly</strong>
                            </div>

                            <div  style="display: flex; flex-direction: row;">
                                <div class="form-group" style="width: 45%;">
                                    <select id="classid" name="studentclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="School Name">
                                        <option value="">choose class</option>
                                    @foreach ($studentDetails['classList'] as $classlist)
                                        <option value="{{$classlist->id}}">{{$classlist->classnamee}}</option>
                
                                    @endforeach
                                </select>
                                </div>
                                <div style="flex: 1;"></div>

                                <div class="form-group" style="width: 45%;">
                                    <select id="classid" name="studentsection" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="School Name">
                                        <option value="">Select section</option>
                                        @foreach ($studentDetails['addSection'] as $section)
                                        <option value="{{$section->sectionname}}">{{$section->sectionname}}</option>
                                        @endforeach
                                </select>
                                </div>
                            </div>
                        </div>
                        <div  style="display: flex; flex-direction: row;">
                            <div class="form-group" style="width: 45%;">
                                <select id="classid" name="studentshift" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="School Name">
                                    <option value="">Choose shift</option>
                                    <option value="Morning">Morning</option>
                                    <option value="Afternoon">Afternoon</option>
                            </select>
                            </div>
                            <div style="flex: 1;"></div>

                            <div class="form-group" style="width: 45%;">
                                {{-- <label for="newregnumber">Your role number</label> --}}
                                <input id="newregnumber" name="session" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="Session">
                            </div>
                        </div>
                    </form>
                    <button type="button" class="btn btn-sm btn-info" style="margin:5px;" id="promotionfrombtn">Process</button>
                    </div>
                    <div class="col-md-6" style="border: 1px solid black; border-radius: 5px;">
                        <div>
                            <h5>Promotion to</h5>
                            @include('layouts.message')
                            <form method="POST" action="/promotemain" id="promotionmain">
                              @csrf
                            <div  style="display: flex; flex-direction: row;">
                                <div class="form-group" style="width: 45%;">
                                    <select id="classid" name="promotionclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="School Name">
                                        <option value="">choose class</option>
                                    @foreach ($studentDetails['classList'] as $classlist)
                                        <option value="{{$classlist->id}}">{{$classlist->classnamee}}</option>
                
                                    @endforeach
                                </select>
                                </div>
                                <div style="flex: 1;"></div>

                                <div class="form-group" style="width: 45%;">
                                    <select id="classid" name="promotionsection" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="School Name">
                                        <option value="">Select section</option>
                                        @foreach ($studentDetails['addSection'] as $section)
                                        <option value="{{$section->sectionname}}">{{$section->sectionname}}</option>
                                        @endforeach
                                </select>
                                </div>
                            </div>
                        </div>
                        <div  style="display: flex; flex-direction: row;">
                            <div class="form-group" style="width: 45%;">
                                <select id="classid" name="promotionshift" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="School Name">
                                    <option value="">Choose shift</option>
                                    <option value="Morning">Morning</option>
                                    <option value="Afternoon">Afternoon</option>
                            </select>
                            </div>
                            <div style="flex: 1;"></div>

                            <div class="form-group" style="width: 45%;">
                                {{-- <label for="newregnumber">Your role number</label> --}}
                                <input id="newregnumber" name="protionsession" style="border: none; background-color:#EEF0F0;" class="form-control form-control-sm" type="text" placeholder="Session">
                            </div>
                        </div>
                        <textarea type="text" name="promotionid" id="arrayregno" style="display: none;"></textarea>
                        <input type="hidden" id="initialsession" name="initialsession">
                      </form>
                      <button type="submit" class="btn btn-sm btn-success" form="promotionmain">Promote All</button>
                    </div>
                
                </div>
                <!-- /.row -->
                
            @else

            @endif
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Promotion</h3>  <div id="tablepromofetch" style="display: none;" class="spinner-border"></div>
  
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
                  <table class="table table-hover text-nowrap" id="promotiontable">
                    <thead>
                      <tr>
                        <th>Registration No</th>
                        <th>Roll No</th>
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="promotionbody">
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
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
        document.getElementById('promotionaside').className = "nav-link active"
    }
</script>
    
@endsection