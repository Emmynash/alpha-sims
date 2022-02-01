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
            <h1 class="m-0 text-dark">Students Promotion</h1>
            <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Students Promotion"
                data-content="This is where students are promoted. Note: a session change is required to promote students.">Need help?</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Promotion</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        {{-- <div id="alertforpromotion" class="alert alert-danger" role="alert">
          A simple danger alert—check it out!
        </div> --}}

        @include('layouts.message')

          @if ($alldetails['addpost'][0]['schoolsession'] == NULL)
            <div class="alert alert-info" role="alert">
              It seems you haven't sent your school session. Please do as it is a requirement for promoting student. Do it now? <a href="/setupschool_sec">Yes</a>
            </div>
          @endif

          <div id="jss3toss1promo" style="display: none;" class="alert alert-info" role="alert">
            Since classes in secondary schools are grouped into 
            Sciences, Art, Commercial etc, we have ensured you can 
            do that. For that reason, promotion from junior to senior secondary 
            classes will be done one student at a time.
          </div>
        

        <div class="card" style="border-top: 2px solid #0B887C;">



            <div class="row">
                <div class="col-md-6">
                    <form id="fetchstudentforprotionform" action="javascript:console.log('submited')" method="POST">
                        @csrf
                        <div class="row" style="margin: 10px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <i style="font-size: 10px;">Select your Class</i>
                                    <select name="promofromclass" id="promofromclass" class="form-control form-control-sm">
                                        <option value="">Select your Class</option>
                                        @if (count($alldetails['classlist_sec']) > 0)
                                          @foreach ($alldetails['classlist_sec'] as $classes)
                                            <option value="{{$classes->id}}">{{$classes->classname}}</option>
                                          @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <i style="font-size: 10px;">Select a section</i>
                                    <select name="promofromsection" id="" class="form-control form-control-sm">
                                        <option value="">Select a section</option>
                                        @if (count($alldetails['addsection_sec']) > 0)
                                          @foreach ($alldetails['addsection_sec'] as $sections)
                                            <option value="{{$sections->id}}">{{$sections->sectionname}}</option>
                                          @endforeach                                  
                                        @endif
                                    </select>
                                </div>
    
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <i style="font-size: 10px;">Session</i>
                                    @if (count($alldetails['addpost']) > 0)
                                    <input name="promofromsession" type="text" value="{{$oldsessionboth}}" class="form-control form-control-sm" placeholder="Session" readonly>
                                    @endif
                                    
                                </div>
    
                            </div>
                        </div>
                        <div style="margin-left: 20px;  margin-bottom: 10px;">
                          <div id="spinnerfetchstudentpromotion" style="display: none;" class="spinner-border"></div>
                          <button id="fetchstudentforprotionbtn" class="btn btn-info btn-sm" style="">Query</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form id="fullpromotionform" action="/promotion_main_query" method="POST">
                        @csrf
                        <div class="row" style="margin: 10px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <i style="font-size: 10px;">Next Session</i>
                                    <input type="text" id="nextsession" name="nextsession" placeholder="Session" value="{{$alldetails['addpost'][0]['schoolsession']}}" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="form-group">
                                    <i style="font-size: 10px;">Next Class</i>
                                    {{-- <select name="" id="nextClassDisplay" class="form-control form-control-sm">
                                        <option value="">Student Next Class</option>
                                    </select> --}}
                                    <input type="hidden" id="nextClassDisplay" name="nextClassDisplay" class="form-control form-control-sm">
                                    <input type="hidden" id="studentsforpromotion" name="studentsforpromotion">
                                    <input type="text" id="nextClassDisplayname" name="nextClassDisplayname" class="form-control form-control-sm" readonly>
                                </div>
                                <button id="promotebtnall" style="margin:20px; display: none;" class="btn btn-info btn-sm">Promote</button>
                            </div>
                            <div class="col-md-6">
    
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Student List</h3>
          
                          <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                              <input type="text" id="addvalue" name="table_search" class="form-control float-right" placeholder="Search">
          
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
                                <th>Roll No</th>
                                <th>Name</th>
                                <th>Average</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody id="promostudentlist">
                              <tr>
                                <td>NA</td>
                                <td>NA</td>
                                <td>NA</td>
                                <td>NA</td>
                              </tr>
                            </tbody>
                          </table>
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

{{-----------------------------------------------------------------------------------------------------------}}
{{--                                      modal for class allocation for jss3                              --}}
{{-----------------------------------------------------------------------------------------------------------}}

        <!-- The Modal -->
        <div class="modal" id="jssthreetosssone">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <form id="btnjss_sssform" action="javascript:console.log('submited')" method="post">
                  @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <input type="hidden" id="nextpromotoss1jss3" name="nextpromotoss1jss3">
                      <input type="hidden" id="studenttopromoteregno" name="studenttopromoteregno">
                      <input type="hidden" value="{{$alldetails['addpost'][0]['schoolsession']}}" name="newsessionvalue" id="newsessionvalue">
                      <div class="form-group">
                        <div style="display: flex; flex-direction: row;">
                          <button style="border: none; background: transparent; border-top: 1px solid rgb(207, 204, 204); border-bottom: 1px solid rgb(207, 204, 204); border-left: 1px solid rgb(207, 204, 204);" disabled><i class="far fa-arrow-alt-circle-down"></i></button>
                          <input type="text" id="nextclassforjss3" name="nextclassforjss3" class="form-control form-control-sm" style="border-radius: 0px;" readonly style="background-color: #fff">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <div style="display: flex; flex-direction: row;">
                          <button style="border: none; background: transparent; border-top: 1px solid rgb(207, 204, 204); border-bottom: 1px solid rgb(207, 204, 204); border-left: 1px solid rgb(207, 204, 204);" disabled><i class="far fa-arrow-alt-circle-down"></i></button>
                          <select type="text" name="newsection" class="form-control form-control-sm" style="border-radius: 0px;">
                            <option value="">Select Section</option>
                            @if (count($alldetails['addsection_sec']) > 0)
                              @foreach ($alldetails['addsection_sec'] as $sections)
                                <option value="{{$sections->id}}">{{$sections->sectionname}}</option>
                              @endforeach 
                            @endif
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="button" id="btnjss_sssbtn" class="btn btn-success btn-sm" form="btnjss_sssform">Promote</button>
              </div>

            </div>
          </div>
        </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <script>
      function scrollocation(){
        document.getElementById('promotionscroll').className = "nav-link active"

        // var a = [1,2,3];

        document.getElementById('addvalue').value = a;
      }
  </script>
    
@endsection