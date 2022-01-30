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
                                      
                                      <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Status:</p>
                                      <p style="margin: 0px; padding-left: 10px; font-size: 13px;">Student name: {{ $item->firstname }} {{ $item->lastname }}</p>
                                    </div>
                                    {{-- <div style="margin: 10px;">
                                      <button type="submit" form="deleteassignment{{ $item->id }}" class="btn btn-sm btn-danger">Delete</button> --}}
                                      {{-- <a href="{{ route('view_submission') }}"><button type="submit" class="btn btn-sm btn-success">View Submissions</button></a> --}}
                                    {{-- </div> --}}
                                    {{-- <form action="{{ route('deleteassignment', $item->id) }}" method="post" id="deleteassignment{{ $item->id }}">
                                      @csrf
                                      @method('delete')
                                    </form> --}}
                                  </div><!-- /.card-body -->
                                </div>
                              </div><!-- /.container-fluid -->
                            </section>
                            <!-- /.content -->
                        
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