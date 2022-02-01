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
            <h1 class="m-0 text-dark">Generate Result</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Generate Result"
                data-content="The admin generates result for each class just by a click of a button">Need help?</button>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Generate</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          
          @include('layouts.message')


        <div class="card" style="border-top: 2px solid #0B887C;">

                  <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Class List</h3>

                {{-- <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div> --}}
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <div class="row">

                        @if ($classlist->count() >0)

                            @foreach ($classlist as $item)
                                <div class="col-12 col-md-12">
                                    <div class="card" style="border-radius: 0px; display: flex; flex-direction: row; align-items: center; border-left: 5px solid green;">
                                        <div style="display: flex; flex-direction: column; margin-left: 10px; padding: 10px;">
                                            <i style="font-style: normal; font-size: 12px; font-weight: bold;">Class: {{ $item->classname }}</i>
                                            @if (in_array ( $item->id, $checkRecord))
                                              <i style="font-style: normal; font-size: 12px; font-weight: bold;">Status: Completed</i>
                                            @else
                                              <i style="font-style: normal; font-size: 12px; font-weight: bold;">Status: Pending</i>
                                            @endif
                                            
                                        </div>
                                        <div style="flex: 1;">
        
                                        </div>
                                        <div style="margin-right: 10px;">
                                          @if (in_array ( $item->id, $checkRecord))
                                            <button class="btn btn-sm btn-info">
                                              Generated
                                            </button>
                                          @else
                                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#generateresult{{ $item->id }}">
                                              Generate
                                            </button>
                                          @endif

                                        </div>
                                    </div>
                                </div>

                                  <!-- The Modal -->
                                  <div class="modal fade" id="generateresult{{ $item->id }}">
                                    <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                      
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                          <h4 class="modal-title">Generate Result</h4>
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                          <p>Click the proceed button to generate result for {{ $item->classname }} students</p>
                                          <form action="{{ route('generate_result_main') }}" method="post" id="processresultform{{ $item->id }}">
                                            @csrf
                                            <input type="hidden" name="classid" value="{{ $item->id }}">
                                          </form>
                                        </div>
                                        
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                          <button type="submit" form="processresultform{{ $item->id }}" class="btn btn-success btn-sm">Proceed</button>
                                          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                        </div>
                                        
                                      </div>
                                    </div>
                                  </div>
                            @endforeach
                            
                        @endif
                    </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->


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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <script>
      function scrollocation(){
        document.getElementById('resultmainscroll').className = "nav-link active"
        document.getElementById('resultmaingenscrollgenerate').className = "nav-link active"
      }
  </script>
    
@endsection