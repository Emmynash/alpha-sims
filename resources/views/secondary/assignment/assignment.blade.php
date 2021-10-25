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
            <h1 class="m-0 text-dark">Assignment</h1>
            {{-- <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Addsubjects"
                data-content="On this module, you are required to enter all subjects offered by your school according to the classes you have.">Need help?</button> --}}
                    
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Assignment</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <i style="padding: 10px; font-style: normal;">Assignment List</i>
                    </div>

                    @foreach ($getAssignments as $item)

                      <div class="card">
                        <p style="margin: 0px; padding-left: 10px;">Start Date: <i style="font-style: normal; font-weight: bold;">{{ $item->startdate }}</i></p>
                        <p style="margin: 0px; padding-left: 10px;">Submission: <i style="font-style: normal; font-weight: bold;">{{ $item->submissiondate }}</i></p>
                        <p style="margin: 0px; padding-left: 10px;">Subject: <i style="font-style: normal; font-weight: bold;">{{ $item->subjectname }}</i></p>
                        <p style="margin: 0px; padding-left: 10px;">Class/Section: <i style="font-style: normal; font-weight: bold;">{{ $item->classname }}</i><i style="font-style: normal; font-weight: bold;">{{ $item->sectionname }}</i></p>
                        <p style="margin: 0px; padding-left: 10px;">Description: <i style="font-style: normal; font-weight: bold;">{{ $item->description }}</i></p>
                        <p style="margin: 0px; padding-left: 10px;">File: <a href="{{ $item->filelink }}" download="assignment"><i class="fas fa-file-download"></i> Download</a></p>
                        <p style="margin: 0px; padding-left: 10px;">Status:</p>
                        <div style="margin: 10px;">
                          <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#submitassignment{{ $item->id }}">Submit Assignment</button>
                        </div>

                    </div>

                            <!-- The Modal -->
                      <div class="modal" id="submitassignment{{ $item->id }}">
                        <div class="modal-dialog">
                          <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">Submit Your Assignment</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                              <form action="{{ route('assignment_submit') }}" method="post" enctype="multipart/form-data" id="submitAssignment{{ $item->id }}">
                                @csrf
                                <div class="form-group">
                                  <label for="">Assignment Text</label>
                                  <textarea name="assignmenttext" id="" cols="30" rows="5" class="form-control form-control-sm"></textarea>
                                </div>
                                <input type="text" name="subjectid" value="{{ $item->subjectid }}">
                                <input type="text" name="sectionid" value="{{ $item->sectionid }}">
                                <input type="text" name="classid" value="{{ $item->classid }}">
                                <div class="form-group">
                                  <label for="">Upload Assignment</label>
                                  <input type="file" name="filelink" class="form-control form-control-sm">
                                </div>
                              </form>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                              <button type="submit" form="submitAssignment{{ $item->id }}" class="btn btn-success btn-sm">Submit</button>
                            </div>

                          </div>
                        </div>
                      </div>


                        
                    @endforeach

                    
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
    
@endsection