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
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#postassignment">
                        Post Assignment
                    </button>
                    <hr>
                    @foreach ($getAssignments as $item)

                        <div class="card">
                            <p style="margin: 0px; padding-left: 10px;">Start Date: <i style="font-style: normal; font-weight: bold;">{{ $item->startdate }}</i></p>
                            <p style="margin: 0px; padding-left: 10px;">Submission: <i style="font-style: normal; font-weight: bold;">{{ $item->submissiondate }}</i></p>
                            <p style="margin: 0px; padding-left: 10px;">Subject: <i style="font-style: normal; font-weight: bold;">{{ $item->subjectname }}</i></p>
                            <p style="margin: 0px; padding-left: 10px;">Class/Section: <i style="font-style: normal; font-weight: bold;">{{ $item->classname }}</i><i style="font-style: normal; font-weight: bold;">{{ $item->sectionname }}</i></p>
                            <p style="margin: 0px; padding-left: 10px;">Description: <i style="font-style: normal; font-weight: bold;">{{ $item->description }}</i></p>
                            <p style="margin: 0px; padding-left: 10px;">File: <a href="{{ $item->filelink }}" download="assignment"><i class="fas fa-file-download"></i> Download</a></p>
                            <p style="margin: 0px; padding-left: 10px;">Status:</p>
                            {{-- <div class="row" style="margin-left: 10px;">
                                <div class="col-12 col-md-6">
                                    <form action="" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Upload Your Assignment Here</label>
                                            <input type="file" class="form-control form-control-sm">
                                        </div>
                                    </form>
                                </div>
                            </div> --}}
                        </div>
                        
                    @endforeach
                    
                </div>
            </div>
            
        </div>


            <!-- The Modal -->
            <div class="modal" id="postassignment">
                <div class="modal-dialog">
                <div class="modal-content">
            
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Post a New Assignment</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
            
                    <!-- Modal body -->
                    <div class="modal-body">
                    <form method="post" action="{{ route('post_assignment') }}" enctype="multipart/form-data" id="postassignmentM">
                        @csrf
                        <div class="form-group">
                            <label for="">Start Date</label>
                            <input type="date" name="startdate" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Submission Date</label>
                            <input type="date" name="submissiondate" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Subject Name</label>
                            <input type="Text" value="{{ $subject->subjectname }}" name="" class="form-control form-control-sm">
                            <input type="Text" value="{{ $subject->id }}" name="subjectid" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Select a Class</label>
                            <input type="Text" value="{{ $classid }}" name="classid" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Select a Section</label>
                            <input type="Text" value="{{ $sectionid }}" name="sectionid" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="">Assignment description</label>
                            <textarea name="description" class="form-control form-control-sm" id="" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Upload a file(optional)</label>
                            <input type="file" name="assignmentfile" class="form-control form-control-sm">
                        </div>
                    </form>
                    </div>
            
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button  form="postassignmentM" class="btn btn-success btn-sm">Submit</button>
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
    
@endsection