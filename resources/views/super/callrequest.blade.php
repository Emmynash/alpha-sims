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
            <h1 class="m-0 text-dark">Call Requests</h1>
            {{-- <input type="text" id="callRequestCount" value="{{count($allCallData['callRequestCount'])}}"> --}}
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Call-Request</li>
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
                  <i class="fas fa-headset"></i>
                  Call Lists
                  <i><span id="callRequestCountNotify" class="right badge badge-danger"><i style="font-size: 10px;">Pending</i> {{count($allCallData['callRequestCount'])}}</span></i>
                  <i><span id="callRequestCountNotify" class="right badge badge-warning"> <i style="font-size: 10px;">Call later</i> {{count($allCallData['callRequestCountonCall'])}}</span></i>
                  <span id="callRequestCountNotify" class="right badge badge-info"><i style="font-size: 10px;">Call Done</i> {{count($allCallData['callRequestCountondone'])}}</span>
                </h3>
              </div>
              <!-- /.card-header -->

              <div class="container" style="margin-top: 10px;">
                <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-question-circle"></i> Info!</h5>
                  List of all clients call requests...
                </div>
              </div>

              @if (count($allCallData['callBack']) > 0)

              @foreach ($allCallData['callBack'] as $callrequest)

              <div class="card-body" style="padding-bottom: 0px; padding-top: 0px;">

                <div class="callout callout-success">
                  <h5 style="display: flex; flex-direction: column;">
                    <i style="font-style: normal; font-size: 14px; font-weight: bold;">Call Id: <i>{{$callrequest->id}}</i></i>
                    <i style="font-style: normal; font-size: 14px; font-weight: bold;">Date: <i>{{$callrequest->date}}</i></i>
                    <i style="font-style: normal; font-size: 14px; font-weight: bold;">Status: <i style="color: green;">{{$callrequest->status}}</i></i>
                    <i style="font-style: normal; font-size: 14px; font-weight: bold;">{{$callrequest->fullname}}, {{$callrequest->phonenumber}}, {{$callrequest->emailadd}}</i>
                  </h5>
                  <div>
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#centralModalSm{{$callrequest->id}}"><i class="fas fa-check"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deletemodal"><i class="fas fa-trash-alt"></i></button>
                    <button class="btn btn-info btn-sm" data-toggle="collapse" data-target="#collapseExample{{$callrequest->id}}" aria-expanded="false" aria-controls="collapseExample{{$callrequest->id}}"><i class="fas fa-eye"></i></button>
                  </div>

                  {{-- <p>This is a green callout.</p> --}}
                  <div class="collapse" id="collapseExample{{$callrequest->id}}">
                    <div class="mt-3">
                      {{$callrequest->message}}
                    </div>
                  </div>

                </div>
              </div>
              <!-- /.card-body -->

              <!-- Central Modal Small -->
              <div class="modal fade" id="centralModalSm{{$callrequest->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                <!-- Change class .modal-sm to change the size of the modal -->
                <div class="modal-dialog modal-sm" role="document">


                  <div class="modal-content">
                    <div class="modal-header">
                      <h6 class="modal-title w-100" id="myModalLabel">Call Request Id: {{$callrequest->id}}</h6>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div>
                        <i style="font-style: normal; font-size: 13px;">To ensure call conflict is removed, you are required to choose the appropriate option.
                          "On Call"-: choose this option before placing a call to a client.
                          "Call Done"-: choose this only after making a successful call to a clent.
                          "Call Later"-: Choose this only when a call to a client didn't connect.
                        </i>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-secondary btn-sm" form="oncalladd{{$callrequest->id}}">On Call</button>
                      <button type="submit" class="btn btn-info btn-sm" form="oncalldone{{$callrequest->id}}">Call Done</button>
                      <button type="submit" class="btn btn-warning btn-sm" form="oncalllater{{$callrequest->id}}">Call Later</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Central Modal Small -->

              {{-- on call --}}
              <form id="oncalladd{{$callrequest->id}}" action="/oncalladd" method="post">
                @csrf
                <input type="hidden" name="callid" value="{{$callrequest->id}}">
                <input type="hidden" name="optionselected" id="" value="OnCall">
              </form>
              {{-- on call later --}}
              <form id="oncalllater{{$callrequest->id}}" action="/oncalladd" method="post">
                @csrf
                <input type="hidden" name="callid" value="{{$callrequest->id}}">
                <input type="hidden" name="optionselected" id="" value="OnCallLater">
              </form>
              {{-- on call done --}}
              <form id="oncalldone{{$callrequest->id}}" action="/oncalladd" method="post">
                @csrf
                <input type="hidden" name="callid" value="{{$callrequest->id}}">
                <input type="hidden" name="optionselected" id="" value="OnCalldone">
              </form>
              {{-- delete entry --}}
              <form id="oncalldelete{{$callrequest->id}}" action="/oncalladd" method="post">
                @csrf
                <input type="hidden" name="callid" value="{{$callrequest->id}}">
                <input type="hidden" name="optionselected" id="" value="Delete">
              </form>

              <!-- Central Modal Small -->
              <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                <!-- Change class .modal-sm to change the size of the modal -->
                <div class="modal-dialog modal-sm" role="document">

                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title w-100" id="myModalLabel">Modal title</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <i>Are you sure to want to delete this entry?</i>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
                      <button type="submit" form="oncalldelete{{$callrequest->id}}" class="btn btn-success btn-sm">Yes</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Central Modal Small -->

              @endforeach

              <div style="display: flex; align-items: center; justify-content: center;">
                {{$allCallData['callBack']->links()}}
              </div>

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
    <strong>Copyright &copy; 2019-2022 <a href="http://bluealgoorithm.com">Blue Algorithm technologies.</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 2.0
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
  function scrollocation() {
    document.getElementById('callrequest').className = "nav-link active"
    // document.getElementById('callRequestCountNotify').innerHTML = document.getElementById('callRequestCount').value;
  }
</script>


@endsection