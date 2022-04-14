@extends($school->schooltype == "Primary" ? 'layouts.app_dash' : 'layouts.app_sec')

@section('content')

@if ($school->schooltype == "Primary")
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
          <h1 class="m-0 text-dark">Student Results</h1>
          <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Student result" data-content="On this module, you can view students result. NOTE: only students whose psychomotor has been added can be able to view their results.">Need help?</button>
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

        <div class="row" style="margin: 10px;">
          @if ($school->getClassList($school->id)->count() <1) <div class="col-12 col-md-3">
            <div class="card" style="border-radius: 0px; border-left: 10px solid green;">
              <p style="padding: 10px;">No class Added</p>
            </div>
        </div>

        @else


        @if (Auth::user()->hasRole('Teacher'))

        @foreach($formTeacherClasses as $classes)
        <div class="col-12 col-md-3" data-toggle="modal" data-target="#selectsession{{ $classes->id }}">
          <div class="card" style="border-radius: 0px; border-left: 10px solid green;">
            <p style="padding: 10px;">{{ $classes->classname }}</p>
          </div>
        </div>
        <!-- The Modal -->
        <div class="modal fade" id="selectsession{{ $classes->id }}">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <form action="{{ route('view_by_class') }}" method="post" id="submitresultform{{ $classes->id }}">
                  @csrf
                  <div class="form-group">
                    <label for="">Select Term</label>
                    <select name="term" id="" class="form-control form-control-sm">
                      <option value="">select term</option>
                      <option value="1">first</option>
                      <option value="2">Second</option>
                      <option value="3">Third</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Select Section</label>
                    <select name="section" id="" class="form-control form-control-sm">
                      <option value="">select Section</option>
                      <option value="{{ $classes->sectionId }}">{{ $classes->sectionname }}</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Enter session (e.g 2021/2022)</label>
                    <input type="text" name="session" class="form-control form-control-sm">
                  </div>
                  <input type="hidden" name="classid" value="{{ $classes->id }}">
                </form>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="submit" form="submitresultform{{ $classes->id }}" class="btn btn-info btn-sm">Proceed <i class="fas fa-chevron-right"></i></button>
              </div>

            </div>
          </div>
        </div>
        @endforeach

        @else

        @foreach ($school->getClassList($school->id) as $schooldata)
        <div class="col-12 col-md-3" data-toggle="modal" data-target="#selectsession{{ $schooldata->id }}">
          <div class="card" style="border-radius: 0px; border-left: 10px solid green;">
            <p style="padding: 10px;">{{ $schooldata->classname }}</p>
          </div>
        </div>
        <!-- The Modal -->
        <div class="modal fade" id="selectsession{{ $schooldata->id }}">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <form action="{{ route('view_by_class') }}" method="post" id="submitresultform{{ $schooldata->id }}">
                  @csrf
                  <div class="form-group">
                    <label for="">Select Term</label>
                    <select name="term" id="" class="form-control form-control-sm">
                      <option value="">select term</option>
                      <option value="1">first</option>
                      <option value="2">Second</option>
                      <option value="3">Third</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Select Section</label>
                    <select name="section" id="" class="form-control form-control-sm">
                      <option value="">select Section</option>
                      @foreach ($school->getSectionList($school->id) as $sec)
                      <option value="{{ $sec->id }}">{{ $sec->sectionname }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Enter session (e.g 2021/2022)</label>
                    <input type="text" name="session" class="form-control form-control-sm">
                  </div>
                  <input type="hidden" name="classid" value="{{ $schooldata->id }}">
                </form>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="submit" form="submitresultform{{ $schooldata->id }}" class="btn btn-info btn-sm">Proceed <i class="fas fa-chevron-right"></i></button>
              </div>

            </div>
          </div>
        </div>
        @endforeach

        @endif

        @endif

      </div>
      <div class="row" style="margin: 10px;">
        <div class="col-12 col-md-6">
          <div class="card" data-toggle="modal" data-target="#getresultentireclass" style="border-radius: 0px; border-left: 10px solid green;">
            <i style="font-style: normal; padding: 10px;"><i class="fas fa-paste"></i> Click to print entire class report </i>
          </div>
        </div>
      </div>
      {{-- <form action="{{ route('result_sheet_settings') }}" method="post">
      @csrf
      <div class="row" style="margin:10px;">
        <div class="col-12 col-md-6">
          <div class="card">
            <div style="margin:10px;">
              <select name="name" id="" class="form-control form-control-sm">
                <option value="">Select a result section</option>
                <option value="headerfontsize">header font size</option>
                <option value="subjectfontsize">subject font size</option>
                <option value="footerfontsize">footer font size</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="card">
            <div style="margin:10px;">
              <input name="fontSize" type="number" id="" class="form-control form-control-sm" placeholder="Enter font" />
            </div>
          </div>
        </div>
      </div>
      <div class="form-group" style="margin: 0px 0px 0px 20px;">
        <button class="btn btn-sm btn-info">
          Save
        </button>
      </div>
      </form> --}}

      <div class="row" style="margin:10px;">
        {{-- @foreach ($resultSettings as $item)
                <div class="col-12 col-md-3">
                  <div class="card" style="border-radius: 0px; border-left: 10px solid green;">
                    <p style="padding: 0px 0px 0px 5px; margin: 0px;">Header font Sized</p>
                    <p style="padding: 0px 0px 0px 5px; margin: 0px;">12px</p>
                  </div>
                </div>
              @endforeach --}}

      </div>

      <div class="modal fade" id="getresultentireclass">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Print result</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ Route('print_entrire_class_result') }}" method="get" id="getentireclassresult">
                @csrf
                <div class="form-group">
                  <label for="">Select Class</label>
                  <select name="classid" id="" class="form-control form-control-sm">
                    <option value="">Select Class</option>
                    @if (Auth::user()->hasRole('Teacher'))
                    @foreach ($formTeacherClasses as $item)

                    <option value="{{ $item->id }}">{{ $item->classname }}</option>

                    @endforeach
                    @else
                    @foreach ($school->getClassList($school->id) as $item)

                    <option value="{{ $item->id }}">{{ $item->classname }}</option>

                    @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Select Section</label>
                  <select name="section" id="" class="form-control form-control-sm">
                    <option value="">select Section</option>
                    @if (Auth::user()->hasRole('Teacher'))
                    @foreach ($formTeacherClasses as $item)

                    <option value="{{ $item->sectionId }}">{{ $item->sectionname }}</option>

                    @endforeach
                    @else
                    @foreach ($school->getSectionList($school->id) as $sec)
                    <option value="{{ $sec->id }}">{{ $sec->sectionname }}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Select Term</label>
                  <select name="term" id="" class="form-control form-control-sm">
                    <option value="">select term</option>
                    <option value="1">first</option>
                    <option value="2">Second</option>
                    <option value="3">Third</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Enter session (e.g 2020/2021)</label>
                  <input type="text" name="session" class="form-control form-control-sm">
                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-info btn-sm" form="getentireclassresult">Proceed</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
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
  function scrollocation() {
    document.getElementById('resultmainscroll').className = "nav-link active"
    document.getElementById('resultmaingenscroll').className = "nav-link active"
  }
</script>

@endsection