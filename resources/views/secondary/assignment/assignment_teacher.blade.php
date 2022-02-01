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
            <h1 class="m-0 text-dark">Subjects</h1>
            {{-- <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Addsubjects"
                data-content="On this module, you are required to enter all subjects offered by your school according to the classes you have.">Need help?</button> --}}
                    
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Subjects</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

{{-- dffdfd --}}

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <i style="padding: 10px; font-style: normal;">Subject List</i>
                    </div>
                    @foreach ($getTeacherSubjects as $item)
                        <a href="{{ route('assignment_view', ['id'=>$item->subjectid,'classid'=>$item->classid, 'sectionid'=>$item->sectionid]) }}">
                          <div class="card">
                            <div class="card-header">
                              <i><i class="fas fa-th-list"></i></i>
                            </div>
                            <div class="card-body">
                              <div>
                                <p style="margin: 0px; padding-left: 10px; color: black; font-size: 13px;">Subject: {{ $item->subjectname }}</p>
                                <p style="margin: 0px; padding-left: 10px; color: black; font-size: 13px;">Class/Section: {{ $item->classname }}{{ $item->sectionname }}</p>
                              </div>
                            </div>
                        </div>
                      </a>
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