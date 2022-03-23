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
            <h1 class="m-0 text-dark">Add Comments</h1>
            {{-- <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Addsubjects"
                data-content="On this module, you are required to enter all subjects offered by your school according to the classes you have.">Need help?</button> --}}
                    
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Comments</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid" id="">

        <div class="container">
          <a href="{{ route('admincomment') }}"><button class="btn btn-info btn-sm">Setup Admin Comment</button></a>
        </div>

        <div class="row">
            <div class="col-6 col-md-6">
                <form action="{{ route('setupnewcomment') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Comment(Should be short)</label>
                        <textarea class="form-control form-control-sm" name="comment" id="" cols="30" rows="3" placeholder="type a comment"></textarea>
                        <br>
                        <button class="btn btn-sm btn-info">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <i style="padding: 10px; font-style: normal;">Available Comments</i>
        </div>
        <div class="">
            @foreach ($comments as $item)
                <div class="card">
                    <div class="">
                        <form action="{{ route('deletecomment') }}" method="post" id="deletecomment{{ $item->id }}">
                            @csrf
                            <input type="hidden" name="deleteid" value="{{ $item->id }}">
                        </form>
                        <button form="deletecomment{{ $item->id }}" class="btn btn-sm btn-danger" style="margin: 5px;"><i class="fas fa-trash"></i></button>
                    </div>
                    <div class="" style="padding: 5px;">
                        <i style="font-style: normal; font-size: 10px;">{{ $item->comment }}</i>
                    </div>
                </div>
            @endforeach
        </div>
  
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script src="{{ asset('js/appmarksteachers.js?v=1') }}"></script>

  <script>
        function scrollocation(){
        document.getElementById('setupmain').className = "nav-link active"
        document.getElementById('commentsetup').className = "nav-link active"
        }
    </script>
    
@endsection