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
            <h1 class="m-0 text-dark">Student Result</h1>
            <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Student result"
                data-content="On this module, you can view students result. NOTE: only students whose psychomotor has been added can be able to view their results.">Need help?</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Result</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


        <div class="card" style="border-top: 2px solid #0B887C;">
            <form action="/result_print_sec" method="POST">
              @csrf
                <div class="row" style="margin: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                          <i style="font-size: 10px;">Select Class</i>
                            <select name="selectedclassmarks" id="" class="form-control form-control-sm">
                                <option value="">Select a class</option>
                                @if (count($classlist_sec) > 0)
                                  @foreach ($classlist_sec as $classes)
                                    <option value="{{$classes->id}}">{{$classes->classname}}</option>
                                  @endforeach
                                    
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                          <i style="font-size: 10px;">Select term</i>
                            <select name="selectedtermmarks" id="selectedtermmarks" class="form-control form-control-sm">
                                <option value="">Select a term</option>
                                <option value="1">First term</option>
                                <option value="2">Second term</option>
                                <option value="3">Third term</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <i style="font-size: 10px;">Student reg no.</i>
                            <input type="text" name="studentRegnomarks" value="{{ Auth::user()->role == 'Student' ?  $studentdetails->id :''}}" {{ Auth::user()->role == "Student" ? "Readonly" : ""}} class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                          <i style="font-size: 10px;">Session</i>
                            <input type="text" name="schoolsession" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <button style="margin: 0 0 10px 20px; " class="btn btn-info btn-sm">Check result</button>
            </form>
        </div>

        {{-- <div class="card">
            <div class="card-body" style="display: flex; align-items: center; justify-content: center;">
                <div class="spinner-border"></div>
            </div>
        </div> --}}
  
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <script>
      function scrollocation(){
        document.getElementById('resultmainscroll').className = "nav-link active"
        document.getElementById('resultmaingenscroll').className = "nav-link active"
      }
  </script>
    
@endsection