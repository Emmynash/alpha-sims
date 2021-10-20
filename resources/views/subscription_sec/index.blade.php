@extends('layouts.app_dash')

@section('content')

{{-- aside menu --}}
  <!-- Main Sidebar Container -->
  @php
    $schooldata = App\Addpost::where('id', Auth::user()->schoolid)->get();
    $schooltype = $schooldata[0]->schooltype;
  @endphp



  @if ($schooltype == "Primary")
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <div>
          <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin-top: 5px; border-bottom: 1px solid #fff;">
            <img src="{{asset('storage/schimages/'.$schooldata[0]['schoolLogo'])}}" alt="" class="brand-image img-circle elevation-3"
                style="opacity: .8" width="60px" height="60px">
                <span class="brand-text font-weight-light" style="color: #fff;">{{$schooldata[0]['schoolname']}}</span>
          </div>
          <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div id="profileimgdiv" class="image">
                <div id="spinnerimageupload" style="position: absolute; display: none;">
                  <div class="spinner-border" style="width: 20px; height: 20px;"></div>
                </div>
                <div>
                  <button id="button" style="position: absolute; top: 0; bottom: 0; right: 0; left: 0; border: none; background: transparent; outline: none; color: white;"><i class="fas fa-camera"></i></button>
                  <form id="pixupdatelater" action="javascript:console.log('submited')" method="POST">
                    @csrf
                    <input id="profilepix" name="profilepix" type="file" style="visibility: hidden; position: absolute;"/>
                  </form>
                  {{-- <button id="button">trigger file selection</button> --}}
                </div>
                <img id="profileimgmainpix" src="{{asset('storage/schimages/'.Auth::user()->profileimg)}}" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
              <a href="#" class="d-block">{{ Auth::user()->firstname }} {{Auth::user()->middlename}} {{Auth::user()->lastname}}</a>
              </div>
              {{-- <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->role }}</a>
              </div> --}}
            </div>
            <nav class="mt-2 sidebar1">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview menu-open">
                  <a id="dashboardlink" href="/home" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Dashboard
                    </p>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </aside>
  @else
    @include('layouts.aside_sec')
  @endif

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div style="width: 90%; margin: 0 auto; padding-top: 10px;">
          @include('layouts.message')
        </div>
        
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Subscription</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Subscription</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
              <div class="alert {{$difStudentCount > 0 ? 'alert-warning':'alert-info'}}">
                @if ($difStudentCount > 0)
                  <i style="font-style: normal;">Your have an outstanding payment of ₦{{$amountPerStudent * $difStudentCount}}</i>
                @else
                  <i style="font-style: normal;">Yeah!! Your don't have outstanding payments...</i>
                @endif
                
              </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-header">
                                <form action="{{ route('pay') }}" method="post" id="subscriptionForm">
                                    @csrf
                                    <div class="form-group">
                                        <label style="font-size: 12px;" for="">Amount charged per Student</label>
                                        <input type="number" name="amount_per_student" style="background-color: white;" class="form-control" value="500" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size: 12px;" for="">Student Count</label>
                                        <input type="number" name="quantity" style="background-color: white;" class="form-control" value="{{$difStudentCount}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size: 12px;" for="">Total Amount</label>
                                        <input type="number" name="amount_total" style="background-color: white;" class="form-control" value="{{$amountPerStudent * $difStudentCount}}" readonly>
                                    </div>
                                    <input type="hidden" name="session" value="{{$addschool[0]->schoolsession}}">
                                    <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                                    <input type="hidden" name="email" value="{{Auth::user()->email}}">
                                    <input type="hidden" name="currency" value="NGN">
                                    <input type="hidden" name="amount" value="{{$amountPerStudent * 100}}">
                                    <input type="hidden" name="metadata" value="{{ json_encode($array = ['student_count' => $difStudentCount, 'schoolid'=>Auth::user()->schoolid, 'session'=>$addschool[0]->schoolsession]) }}" >
                                </form>
                                <div>
                                  <button class="btn btn-info btn-sm" form="subscriptionForm" type="submit">Pay Using Card</button>
                                  {{-- <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Transfer to Us</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card">
                            <div class="container mt-3">
                              <!-- Nav tabs -->
                              <ul class="nav nav-tabs">
                                <li class="nav-item">
                                  <a class="nav-link active" data-toggle="tab" href="#home">Approved</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" data-toggle="tab" href="#menu1">Transfer</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" data-toggle="tab" href="#menu2">Outstanding</a>
                                </li>
                              </ul>
                            
                              <!-- Tab panes -->
                              <div class="tab-content">
                                <div id="home" class="container tab-pane active"><br>
                                    <div class="card-body" style="padding: 5px;">
                                      {{-- <div class="card" style="margin: 0px;">
                                          <div class="card-body" style="">
                                              <div style="display: flex; flex-direction: column;">
                                                  <i style="color: #000000; font-style: normal; font-size:12px;">Date:</i>
                                                  <i style="color: #000000; font-style: normal; font-size:12px;">Student Count:</i>
                                                  <i style="color: #000000; font-style: normal; font-size:12px;">Status:</i>
                                                  <i style="color: #000000; font-style: normal; font-size:12px;">Total:</i>
                                              </div>
                                              <button class="btn btn-sm btn-info">Report</button>
                                          </div>
                                      </div> --}}

                                    <!-- /.row -->
                                    <div class="row">
                                      <div class="col-12">
                                        {{-- <div class="card"> --}}
                                          {{-- <div class="card-header"> --}}
                                            {{-- <h3 class="card-title">Responsive Hover Table</h3>

                                            <div class="card-tools">
                                              <div class="input-group input-group-sm" style="width: 150px;">
                                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                                <div class="input-group-append">
                                                  <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                                </div>
                                              </div>
                                            </div>
                                          </div> --}}
                                          <!-- /.card-header -->
                                          <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap">
                                              <thead>
                                                <tr>
                                                  <th>#</th>
                                                  <th>Transaction ID</th>
                                                  <th>Session</th>
                                                  <th>Channel</th>
                                                  <th>Amount</th>
                                                  <th>Student Count</th>
                                                  <th>Date</th>
                                                  <th>Status</th>
                                                  <th>Action</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                @if (count($historySub) <1)
                                                    {{-- <tr><td><p>No Record found</p></td></tr> --}}
                                                @else

                                                  @foreach ($historySub as $historySubSingle)
                                                      <tr>
                                                        <td>#</td>
                                                        <td>{{ $historySubSingle->transid }}</td>
                                                        <td>{{ $historySubSingle->session }}</td>
                                                        <td>{{ $historySubSingle->channel }}</td>
                                                        <td>{{ $historySubSingle->amount }}</td>
                                                        <td>{{ $historySubSingle->student_count }}</td>
                                                        <td>{{ $historySubSingle->created_at }}</td>
                                                        <td>{{ $historySubSingle->status }}</td>
                                                        <td>action</td>
                                                      </tr>
                                                  @endforeach
                                                    
                                                @endif
                                                
                                              </tbody>
                                            </table>
                                          </div>
                                          <!-- /.card-body -->
                                        {{-- </div> --}}
                                        <!-- /.card -->
                                      </div>
                                    </div>
                                    <!-- /.row -->

                                  </div>
                                </div>
                                <div id="menu1" class="container tab-pane fade"><br>
                                  {{-- <h3>Menu 1</h3>
                                  <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> --}}
                                </div>
                                <div id="menu2" class="container tab-pane fade"><br>
                                  {{-- <h3>Menu 2</h3>
                                  <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p> --}}
                                </div>
                              </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
    
    
{{-- modal for transfer payment method --}}
    

                <!-- The Modal -->
                <div class="modal" id="myModal">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">Upload Proof of Payment</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <!-- Modal body -->
                      <div class="modal-body">
                        <div>
                          <div class="alert alert-info">
                            <strong>Note!</strong> Upload a proof of payment. Transaction will have to be confirmed before account is approved
                          </div>
                          <div>
                            <p>Transfer the sum of : <i style="font-weight: bold;">&#8358;{{$amountFinal}}</i> to the below account</p>
                            <p>Account No:</p>
                            <p>Account Name:</p>
                          </div>
                          <div>
                            <form action="/pay_sub_transfer" method="post" id="formTransfer">
                              @csrf
                              <div class="form-group">
                                <label for="">Account Name</label>
                                <input type="text" name="accountname" class="form-control form-control-sm">
                              </div>
                              <div class="form-group">
                                <label for="">Amount to Pay</label>
                                <input type="text" name="amounttopay" value="{{$amountFinal}}" class="form-control form-control-sm" readonly>
                              </div>
                              <div class="form-group">
                                <label for="">Upload proof of payment</label>
                                <input type="file" name="proofofpayment" class="form-control form-control-sm">
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                      <!-- Modal footer -->
                      <div class="modal-footer">
                        <button class="btn btn-sm btn-info" form="formTransfer" type="submit">Submit</button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                      </div>

                    </div>
                  </div>
                </div>
    
            </div><!-- /.container-fluid -->
          </section>
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

    
@endsection