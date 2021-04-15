@extends('layouts.app_dash')

@section('content')

<div class="wrapper">
  
    @include('layouts.asideadmin')
  
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Users FeedBack</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">FeedBack</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
  
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->

          <div class="row">
            <div class="col-md-12">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-reply"></i>
                    Feedbacks
                  </h3>
                </div>
                <!-- /.card-header -->

                <div class="container" style="margin-top: 10px;">
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-question-circle"></i> Info!</h5>
                        List of all tickets submited by clients. All tickets should be attended to ASAP...
                    </div>
                </div>

                @if(count($allfeedbackdetails['addfeedback']) > 0)
                
                    @foreach($allfeedbackdetails['addfeedback'] as $feedback)
                    
                        <div class="card-body" style="padding-top: 0px; padding-bottom: 0px;">

                          <div class="callout callout-success">
                            <h5><i style="font-style: normal; font-size: 14px; font-weight: bold;">Feedback No: {{$feedback->id}}</i> {{$feedback->subject}}</h5>
          
                            <p>Account Type: {{$feedback->accounttype}}</p>
                            <button class="btn btn-info btn-sm" data-toggle="collapse" data-target="#feedback{{$feedback->id}}"><i class="far fa-eye"></i></button>
                            <button class="btn btn-success btn-sm"><i class="fas fa-file-download"></i></button>
                              <div id="feedback{{$feedback->id}}" class="collapse">
                                {{$feedback->content}}
                              </div>
                          </div>
                        </div>
                        <!-- /.card-body -->
                    
                    @endforeach
                
                @endif
                
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- END ALERTS AND CALLOUTS -->

          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">
  




              <!-- /.card -->
            </section>
            <!-- right col -->
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.0.3-pre
      </div>
    </footer>
  
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <script>
      function scrollocation(){
        document.getElementById('feed_back').className = "nav-link active"
      }
  </script>


@endsection