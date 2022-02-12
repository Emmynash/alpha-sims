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
            <h1 class="m-0 text-dark">Submission</h1>
            {{-- <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Addsubjects"
                data-content="On this module, you are required to enter all subjects offered by your school according to the classes you have.">Need help?</button> --}}
                    
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Submission</li>
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
                    {{-- <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#postassignment">
                        Post Assignment
                    </button> --}}
                    <hr>
                    @foreach ($submissions as $item)

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
                                      <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Submited On: <i style="font-style: normal; font-weight: bold;">{{  date("d M Y", strtotime($item->created_at)) }}</i></p>
                                      {{-- <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Submission: <i style="font-style: normal; font-weight: bold;">{{  date("d M Y", strtotime($item->created_at)) }}</i></p> --}}
                                      <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Class/Section: <i style="font-style: normal; font-weight: bold;">{{ $item->classname }}</i><i style="font-style: normal; font-weight: bold;">{{ $item->sectionname }}</i></p>
                                      @if ($item->filelink != NULL)
                                          <p style="margin: 0px; padding-left: 10px; font-size: 13px;">File: <a href="{{ $item->filelink }}" download="assignment"><i class="fas fa-file-download"></i> Download</a></p>
                                      @endif
                                      
                                      <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Status: {{ $item->status == null || $item->status == 0 ? "Not Assessed":"Assessed" }}</p>
                                      <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Student name: {{ $item->firstname }} {{ $item->lastname }}</p>
<<<<<<< HEAD
                                      <hr>
                                      <p style="margin: 0px; padding-left: 10px; font-size: 13px;"><i style="font-weight: bold; font-style:normal;">Comment: </i> {{ $item->comment }}</p>
                                      <p style="margin: 0px; padding-left: 10px; font-size: 13px;"><i style="font-weight: bold; font-style:normal;">Score: </i>{{ $item->score }}</p>
                                      <hr>

                                      @if(!Auth::user()->hasRole('Student'))
                                          @if ($item->status == 0)
                                          <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#assignmentremark{{ $item->id }}">Remark</button>
                                          @else
                                            
                                          @endif
                                        
=======
                                      @if(!Auth::user()->hasRole('Student'))
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#assignmentremark{{ $item->id }}">Remark</button>
>>>>>>> 7f9bf77ed5080c1ca9fd4feed93ed96160c8a25b
                                      @endif
                                      
                                    </div>
                                    
                                  </div><!-- /.card-body -->
                                </div>
                              </div><!-- /.container-fluid -->
                            </section>
                            <!-- /.content -->

                            <!-- The Modal -->
                            <div class="modal" id="assignmentremark{{ $item->id }}">
                              <div class="modal-dialog">
                                <div class="modal-content">

                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                    <h4 class="modal-title">{{ $item->firstname }} {{ $item->lastname }}</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>

                                  <!-- Modal body -->
                                  <div class="modal-body">
                                    <form action="{{ route('remark_assignment') }}" method="post" id="remarkform{{ $item->id }}">
                                      @csrf
                                      <div class="form-group">
                                          <textarea class="form-control form-control-sm" name="comment" id="" cols="30" rows="5" placeholder="comment"></textarea>
                                      </div>
                                      <div class="form-group">
<<<<<<< HEAD
                                        @if ($item->assessment_cat != "0")
                                            <input type="number" name="score" class="form-control form-control-sm" id="" placeholder="enter score(optional)">
                                        @endif
                                      </div>
                                      <input type="hidden" name="submissionid" id="" value={{ $item->id }}>
                                      <input type="hidden" name="assignment_id" id="" value={{ $item->assignment_id }}>
=======
                                          <input type="number" name="score" class="form-control form-control-sm" id="" placeholder="enter score(optional)">
                                      </div>
                                      <input type="hidden" name="submissionid" id="" value={{ $item->id }}>
>>>>>>> 7f9bf77ed5080c1ca9fd4feed93ed96160c8a25b
                                    </form>
                                  </div>

                                  <!-- Modal footer -->
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-success btn-sm" form="remarkform{{ $item->id }}">Submit</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
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
    
@endsection