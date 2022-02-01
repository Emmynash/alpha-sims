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
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#postassignment">
                        Post Assignment
                    </button>
                    <hr>
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
                                      @if ($item->filelink != NULL)
                                          <p style="margin: 0px; padding-left: 10px; font-size: 13px;">File: <a href="{{ $item->filelink }}" download="assignment"><i class="fas fa-file-download"></i> Download</a></p>
                                      @endif
                                      
                                      <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Status:</p>
                                    </div>
                                    <div style="margin: 10px;">
                                      <button type="submit" form="deleteassignment{{ $item->id }}" class="btn btn-sm btn-danger">Delete</button>
                                      <a href="{{ route('view_submission', ['subjectid'=>$item->subjectid,'classid'=>$item->classid, 'sectionid'=>$item->sectionid]) }}"><button type="submit" class="btn btn-sm btn-success">View Submissions</button></a>
                                    </div>
                                    <form action="{{ route('deleteassignment', $item->id) }}" method="post" id="deleteassignment{{ $item->id }}">
                                      @csrf
                                      @method('delete')
                                    </form>
                                  </div><!-- /.card-body -->
                                </div>
                              </div><!-- /.container-fluid -->
                            </section>
                            <!-- /.content -->
                        
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
                          <input type="date" name="startdate" class="form-control form-control-sm" min="<?php echo date("Y-m-d"); ?>">
                      </div>
                      <div class="form-group">
                          <label for="">Submission Date</label>
                          <input type="date" name="submissiondate" class="form-control form-control-sm" min="<?php echo date("Y-m-d"); ?>">
                      </div>
                      <div class="form-group">
                          <label for="">Subject Name</label>
                          <input type="Text" value="{{ $subject->subjectname }}" name="" class="form-control form-control-sm">
                          <input type="hidden" value="{{ $subject->id }}" name="subjectid" class="form-control form-control-sm">
                      </div>
                      <div class="form-group">
                          <select class="form-control form-control-sm" name="sub_assesment_id">
                            <option value="">--Select catetgory--</option>
                            @foreach ($assessments as $item)
                              <option value="{{ $item->id }}">{{ $item->subname }}-{{ $item->name }}</option>
                            @endforeach
                              <option value="0">No Score</option>
                          </select>
                      </div>
                      <div class="form-group">
                          {{-- <label for="">Select a Class</label> --}}
                          <input type="hidden" value="{{ $classid }}" name="classid" class="form-control form-control-sm">
                      </div>
                      <div class="form-group">
                          {{-- <label for="">Select a Section</label> --}}
                          <input type="hidden" value="{{ $sectionid }}" name="sectionid" class="form-control form-control-sm">
                      </div>
                      <div class="form-group">
                          <label for="">Assignment description</label>
                          <textarea name="description" class="form-control form-control-sm" id="" cols="30" rows="5"></textarea>
                      </div>
                      <div class="form-group">
                          <label for="">Upload a file(optional)</label>
                          <i style="color: red; font-style: normal; font-size: 13px;">Note: Max upload size 4mb (doc, docx, pdf, jpeg, jpg, png)</i>
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
    
@endsection