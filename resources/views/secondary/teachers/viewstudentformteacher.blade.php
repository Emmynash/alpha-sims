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
            <h1 class="m-0 text-dark">Form Teacher Setting</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Form Teacher"
                data-content="Form teachers can manage there students subject record and ensure all data for each record has been entered before result is generated.">Need help?</button>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Settings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          
          @include('layouts.message')


        <div class="card" style="border-top: 2px solid #0B887C;">

                  <!-- /.row -->
        <div class="row">
          <div class="col-12">

            {{-- <div class="card" style="margin: 10px; border-radius: 0px;">
              <div class="row">
                <div class="col-12 col-md-4">
                  <div class="card" style="margin: 5px;">
                    <div style="display: flex; flex-direction: column; align-items: left;">
                      <i style="padding: 10px 0px 0px 10px; font-style: normal; font-size: 12px;">Classname</i>
                      <i style="padding: 5px 0px 5px 10px; font-style: normal;">{{ $formClass->getClassName->classname }}</i>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-4"> 
                  <div class="card" style="margin: 5px;">
                    <div style="display: flex; flex-direction: column; align-items: left;">
                      <i style="padding: 10px 0px 0px 10px; font-style: normal; font-size: 12px;">Section</i>
                      <i style="padding: 5px 0px 5px 10px; font-style: normal;">{{ $formClass->getSectionName->sectionname }}</i>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-4"> 
                  <div class="card" style="margin: 5px;">
                    <div style="display: flex; flex-direction: column; align-items: left;">
                      <i style="padding: 10px 0px 0px 10px; font-style: normal; font-size: 12px;">Class Count</i>
                      <i style="padding: 5px 0px 5px 10px; font-style: normal;">{{ $formClass->getClassCount($formClass->class_id) }}</i>
                    </div>
                  </div>
                </div> //

              </div>
            </div> --}}


            {{-- <div class="container">
              <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Info!</strong> Click on the notify button below to send a notification the admin that all results in your class has been processed...
              </div>
              <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#notifymodal">Notify</button>
              {{-- <a href="{{ route('view_student_form') }}"><button class="btn btn-success btn-sm">View Student </button></a> --}}
              {{-- <hr>
            </div> --}}


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
                      <th>Name</th>
                      <th>Admission No.</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($getStudentList as $item)

                        <tr>
                            <td>{{ $item->firstname }} {{ $item->middlename }} {{ $item->lastname }}</td>
                            <td>{{ $item->admission_no }}</td>
                            <td>
                                  <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit_Student{{ $item->id }}"><i class="fas fa-user-edit"></i></button>
                                @if (in_array($item->id, $commentRecordedArray))
                                  <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                @else
                                  <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#comment_Student{{ $item->id }}"><i class="fas fa-comments"></i></button>
                                @endif

                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#elective_Student{{ $item->id }}"><i class="fas fa-list"></i></button>
                                
                            </td>
                        </tr>

                        <div class="modal fade" id="edit_Student{{ $item->id }}">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Edit Student Data</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="{{ route('update_student_form') }}" method="post" id="updateStudent{{ $item->id }}">
                                      @csrf
                                      <div class="">
                                        <div class="form-group">
                                            <input type="text" name="firstname" value="{{ $item->firstname }}" class="form-control form-control-sm" placeholder="first name">
                                        </div>
                                        <div class="form-group">
                                          <input type="text" name="middlename" value="{{ $item->middlename }}" class="form-control form-control-sm" placeholder="middlename name">
                                      </div>
                                      <div class="form-group">
                                          <input type="text" name="lastname" value="{{ $item->lastname }}" class="form-control form-control-sm" placeholder="lastname name">
                                      </div>
                                      <div class="form-group">
                                        <input type="text" name="admission_no" value="{{ $item->admission_no }}" class="form-control form-control-sm" placeholder="admission number">
                                    </div>
                                      <input type="hidden" name="user_id" value="{{ $item->userid }}">
                                    </div>
                                  </form>
                                  <form action="{{ route('update_student_form') }}" method="post" id="deleteStudent{{ $item->id }}">
                                      @csrf
                                      <input type="hidden" name="user_id" value="{{ $item->userid }}">
                                      <input type="hidden" name="key" value="1">
                                  </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-danger btn-sm" form="deleteStudent{{ $item->id }}">Delete</button>
                                  <button type="submit" class="btn btn-info btn-sm" form="updateStudent{{ $item->id }}">Save changes</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                          <!-- /.modal -->


                          <div class="modal fade" id="elective_Student{{ $item->id }}">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Students Elective(s)</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  @foreach ($item->getStudentElective($item->id, $item->classid, $item->studentsection) as $itemElect)
                                      <div class="card" style="display: flex; flex-direction: row;">
                                        <i style="font-style: normal; font-size: 12px; padding: 5px;">{{ $itemElect->subjectname }}</i>
                                        <div style="flex: 1;"></div>
                                        <div><button type="submit" class="btn btn-sm btn-danger badge" form="remove_elective_form{{ $item->id }}">Remove</button></div>
                                      </div>

                                      <form action="{{ route('remove_elective') }}" method="post" id="remove_elective_form{{ $item->id }}">
                                        @csrf
                                        <input type="hidden" name="electiveid" value="{{ $itemElect->id }}">
                                        <input type="hidden" name="subjectid" value="{{ $itemElect->subjectid }}">
                                        <input type="hidden" name="regno" value="{{ $item->id }}">
                                      </form>

                                  @endforeach
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                  {{-- <button type="submit" class="btn btn-danger btn-sm" form="deleteStudent{{ $item->id }}">Delete</button> --}}
                                  {{-- <button type="submit" class="btn btn-info btn-sm" form="commentStudent{{ $item->id }}">Add Comment</button> --}}
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->


                          <div class="modal fade" id="comment_Student{{ $item->id }}">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Student Comment</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{ route('add_student_comment') }}" method="post" id="commentStudent{{ $item->id }}">
                                        @csrf
                                        <div class="">
                                          <div>
                                              <p>{{ $item->firstname }} {{ $item->middlename }} {{ $item->lastname }}</p>
                                          </div>

                                        <div class="form-group">
                                            {{-- <input type="text" name="middlename" value="{{ $item->middlename }}" class="form-control form-control-sm" placeholder="middlename name"> --}}
                                            {{-- <textarea name="comment" id="" cols="30" rows="5" class="form-control form-control-sm" placeholder="Add Student Comment"></textarea> --}}
                                            <select name="comment" id="" class="form-control form-control-sm">
                                              <option value="">Select a Comment</option>
                                              @foreach ($comments as $item1)
                                                  <option value="{{ $item1->comment }}">{{ $item1->comment }}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                          <input type="hidden" name="reg_no" value="{{ $item->id }}">
                                          <input type="hidden" name="section_id" value="{{ $item->sectionid }}">
                                          <input type="hidden" name="classid" value="{{ $item->classid }}">
                                        </div>
                                    </form>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                    {{-- <button type="submit" class="btn btn-danger btn-sm" form="deleteStudent{{ $item->id }}">Delete</button> --}}
                                    <button type="submit" class="btn btn-info btn-sm" form="commentStudent{{ $item->id }}">Add Comment</button>
                                  </div>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                          </div>
                          <!-- /.modal -->
                        
                    @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->


        </div>


          <!-- The Modal -->
          <div class="modal fade" id="notifymodal">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
              
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Result Notify</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                  <p>Notify the admin that all marks for each subject has been entered</p>
                  <form action="{{ route('form_teacher_result_confirm') }}" method="post" id="formTeachSubjectEnteredConfirm">
                    @csrf
                    <input type="hidden" name="classid" value="{{ $formClass->getClassName->id }}">
                    <input type="hidden" name="sectionid" value="{{ $formClass->getSectionName->id }}" id="">
                  </form>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="submit" class="btn btn-info btn-sm" form="formTeachSubjectEnteredConfirm">Proceed</button>
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
        document.getElementById('formmasteroption').className = "nav-link active"
      }
  </script>
    
@endsection