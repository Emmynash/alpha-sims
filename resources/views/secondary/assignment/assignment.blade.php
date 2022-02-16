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
            @include('layouts.message')
        </div>

        <div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <i style="padding: 10px; font-style: normal;">Assignment List</i>
                    </div>

                    @foreach ($getAssignments as $item)


                      <!-- Main content -->
                      <section class="content">
                        <div class="container-fluid">
                          <div class="card card-primary card-outline">
                            <div class="card-header">
                              <h3 class="card-title">Assignment for <i style="font-style: normal;">{{ $item->subjectname }}</h3>
                            </div> <!-- /.card-body -->
                            <div class="card-body">
                              <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Description: <i style="font-style: normal;">{{ $item->description }}</i></p>
                              <br>
                              <strong>TimeLine</strong>
                              <div>
                                <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Start Date: <i style="font-style: normal; font-weight: bold;">{{  date("d M Y", strtotime($item->startdate)) }}</i></p>
                                <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Submission: <i style="font-style: normal; font-weight: bold;">{{  date("d M Y", strtotime($item->submissiondate)) }}</i></p>
                                <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Class/Section: <i style="font-style: normal; font-weight: bold;">{{ $item->classname }}</i><i style="font-style: normal; font-weight: bold;">{{ $item->sectionname }}</i></p>
                                <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Assignment Category: <i style="font-style: normal; font-weight: bold;">{{  strtoupper($item->assessment_cat) }}</i></p>
                                <p style="margin: 0px; padding-left: 10px; font-size: 13px;">File: <a href="{{ $item->filelink }}" download="assignment"><i class="fas fa-file-download"></i> Download</a></p>
                                <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Status:</p>
                              </div>
                              <div style="margin: 10px;">
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#submitassignment{{ $item->id }}">Submit Assignment</button>
                                <a href="{{ route('view_submission_student', ['subjectid'=>$item->subjectid,'classid'=>$item->classid, 'sectionid'=>$item->sectionid]) }}"><button class="btn btn-info btn-sm">View Submissions</button></a>
                              </div>
                            </div><!-- /.card-body -->
                          </div>
                        </div><!-- /.container-fluid -->
                      </section>
                      <!-- /.content -->


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
                                <input type="hidden" name="subjectid" value="{{ $item->subjectid }}">
                                <input type="hidden" name="sectionid" value="{{ $item->sectionid }}">
                                <input type="hidden" name="classid" value="{{ $item->classid }}">
                                <input type="hidden" name="assignment_id" value="{{ $item->id }}">
                                
                                <div class="form-group">
                                  <label for="">Upload Assignment</label>
                                  <i style="color: red; font-style: normal; font-size: 13px;">Note: Max upload size 4mb (doc, docx, pdf, jpeg, jpg, png)</i>
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
  </div>
  <!-- /.content-wrapper -->
    
@endsection