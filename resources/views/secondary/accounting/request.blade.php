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
            <h1 class="m-0 text-dark">Order Request</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Order Request"
                data-content="Send a money request to the school head for approval. Untill confirmed no action is required">Need help?</button>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Order Request</li>
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


        <div class="card" style="height: 200px; border-top: 2px solid #0B887C;">

                  <!-- /.row -->
                  <i style="font-style: normal; padding: 5px;">Request Table</i>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><button class="btn btn-sm btn-info" data-toggle="modal" data-target="#addrequest">Send Request</button></h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Amount</th>
                      <th>Seen Status</th>
                      <th>Status</th>
                      <th>date accepted or declined</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($schooldetails->getMoneyRequests->count() > 0)
                    @php $count = method_exists($schooldetails->getMoneyRequests, 'links') ? 1 : 0; @endphp
                      @foreach ($schooldetails->getMoneyRequests as $item)
                      @php $count = method_exists($schooldetails->getMoneyRequests, 'links') ? ($schooldetails->getMoneyRequests ->currentpage()-1) * $schooldetails->getMoneyRequests ->perpage() + $loop->index + 1 : $count + 1; @endphp
                        <tr style="{{ $item->status == "Unattended" ? 'background-color: #E1DCDC;':'' }} {{ $item->status == "accept" ? 'background-color: #56DC83;':'' }} {{ $item->status == "declined" ? 'background-color: #EEA0A8;':'' }} {{ $item->status == "inreview" ? 'background-color: #EEEB87;':'' }}">
                          <td>{{$count}}</td>
                          <td>{{$item->amountrequesting}}</td>
                          <td>{{$item->seeenstatus == 0 ? "Not seen":"Seen"}}</td>
                          <td>{{$item->status}}</td>
                          <td>{{$item->dateaccepted == "" ? "NAN":$item->dateaccepted}}</td>
                          <td>
                            @if (Auth::user()->hasRole('HeadOfSchool'))
                              {{-- <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#requestreminder{{ $item->id }}"><i class="fas fa-thumbs-up"></i></button> --}}
                              <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewrequest{{ $item->id }}"><i class="fas fa-eye"></i></button>
                            @else
                              <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#requestreminder{{ $item->id }}"><i class="fas fa-user-clock"></i></button>
                            @endif
                            </td>

                            {{-- head of school --}}

                              <!-- The Modal -->
                              <div class="modal" id="viewrequest{{ $item->id }}">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                  
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">Request {{ Auth::user()->roles->pluck('name')[0] }}</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                      <div>
                                        {{ $item->reasonforrequest }}

                                        {{-- in review request --}}
                                        <form action="{{ route('request_response') }}" method="post" id="inreview{{ $item->id }}"> 
                                          @csrf
                                          <input type="hidden" name="status" value="{{ $item->id }}" id="">
                                          <input type="hidden" name="key" value="inreview">
                                          <input type="hidden" name="amount" value="{{ $item->amountrequesting }}" id="">
                                        </form>

                                        {{-- approve request --}}
                                        <form action="{{ route('request_response') }}" method="post" id="accept{{ $item->id }}"> 
                                          @csrf
                                          <input type="hidden" name="status" value="{{ $item->id }}" id="">
                                          <input type="hidden" name="key" value="accept">
                                          <input type="hidden" name="amount" value="{{ $item->amountrequesting }}" id="">
                                        </form>

                                        {{-- decline request --}}
                                        <form action="{{ route('request_response') }}" method="post" id="declined{{ $item->id }}"> 
                                          @csrf
                                          <input type="hidden" name="status" value="{{ $item->id }}" id="">
                                          <input type="hidden" name="key" value="declined">
                                          <input type="hidden" name="amount" value="{{ $item->amountrequesting }}" id="">
                                        </form>

                                      </div>
                                    </div>
                                    
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                      <button type="submit" form="inreview{{ $item->id }}" class="btn btn-warning btn-sm">In Review</button>
                                      <button type="submit" form="accept{{ $item->id }}" class="btn btn-success btn-sm">Approve</button>
                                      <button type="submit" form="declined{{ $item->id }}" class="btn btn-danger btn-sm">Decline</button>
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>


                            <!-- The Modal -->
                            <div class="modal fade" id="requestreminder{{ $item->id }}">
                              <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                
                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                    <h4 class="modal-title">Send a reminder</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>
                                  
                                  <!-- Modal body -->
                                  <div class="modal-body">
                                    <p>Send a reminder that your request has not been attended to</p>
                                    <form action="" method="post">
                                      @csrf
                                    </form>
                                  </div>
                                  
                                  <!-- Modal footer -->
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Send</button>
                                  </div>
                                  
                                </div>
                              </div>
                            </div>

                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
        </div>


        {{-- model add request --}}

          <!-- The Modal -->
          <div class="modal" id="addrequest">
            <div class="modal-dialog">
              <div class="modal-content">
              
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Request Form</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                  <form action="{{ route('sendmoneyrequest') }}" method="post" id="sendrequestform">
                    @csrf
                    <div class="form-group">
                      <label for="">Amount requesting</label>
                      <input type="text" name="amountrequesting" class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                      <label for="">Reason for the request(schould be detailed)</label>
                      <textarea name="reasonforrequest" id="" cols="30" rows="10" class="form-control form-control-sm"></textarea>
                    </div>
                  </form>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="submit" form="sendrequestform" class="btn btn-success btn-sm">Send</button>
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
                
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <script>
      function scrollocation(){
        document.getElementById('requestlistscroll').className = "nav-link active"
      }
  </script>

@endsection