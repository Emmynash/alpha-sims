@extends('layouts.app_sec')

@section('content')

@include('layouts.aside_sec')

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

            <div class="row" style="margin: 10px;">
                @if ($school->getClassList($school->id)->count() <1)

                    <div class="col-12 col-md-3">
                        <div class="card" style="border-radius: 0px; border-left: 10px solid green;">
                            <p style="padding: 10px;">No class Added</p>
                        </div>
                    </div>
                    
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
                                            <label for="">Enter session (e.g 2012/2013)</label>
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
            </div>
            <div class="row" style="margin: 10px;">
              <div class="col-12 col-md-6">
                <div class="card" data-toggle="modal" data-target="#getresultentireclass" style="border-radius: 0px; border-left: 10px solid green;">
                  <i style="font-style: normal; padding: 10px;"><i class="fas fa-paste"></i> Click to print entire class report </i>
                </div>
              </div>
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
                          @foreach ($school->getClassList($school->id) as $item)

                            <option value="{{ $item->id }}">{{ $item->classname }}</option>
                              
                          @endforeach
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
                        <label for="">Select Term</label>
                        <select name="term" id="" class="form-control form-control-sm">
                            <option value="">select term</option>
                            <option value="1">first</option>
                            <option value="2">Second</option>
                            <option value="3">Third</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Enter session (e.g 2012/2013)</label>
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
  <footer class="main-footer">
    <strong>Copyright &copy; 2012-2019 <a href="http://adminlte.io">Brightosoft</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 0.0.1
    </div>
  </footer>

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