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
            <h1 class="m-0 text-dark">Manage Classes</h1>
            {{-- <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Addsubjects"
                data-content="On this module, you are required to enter all subjects offered by your school according to the classes you have.">Need help?</button> --}}
                    
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Manage Classes</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid" id="addteachersroot">

        <div class="card">
            <i style="font-style: normal; font-size: 14px; padding: 10px;">List of Classes/Arms or Sections you manage</i>
        </div>

        <div class="row">
            @foreach ($classSubject as $item)

                <div class="col-12 col-md-3">
                   <a href="{{ route('form_teacher', ['classid' => $item->class_id, 'sectionid'=> $item->form_id]) }}"> <div class="card" style="display: flex; flex-direction: row; align-items: center;">
                        <i class="fas fa-users" style="padding-left: 5px;"></i> <i style="font-style: normal; font-size: 14px; padding: 5px;">{{ $item->classname }}{{ $item->sectionname }}</i>
                    </div></a>
                </div>
                
            @endforeach
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
    function scrollocation(){
      document.getElementById('teachersmain').className = "nav-link active"
      document.getElementById('addteachersmain').className = "nav-link active"
    }
</script>
    
@endsection