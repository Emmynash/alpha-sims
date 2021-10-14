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
            <h1 class="m-0 text-dark">Summary</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Summary"
                data-content="View the financial runnings of your school at a glance.">Need help?</button>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Summary</li>
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

        <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-wallet"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Available Amount</span>
                  <span class="info-box-number">
                    {{ $schooldetails->getTotalBal == null ? "0":$schooldetails->getTotalBal->total_amount }}
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-wallet"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">This Term</span>
                  <span class="info-box-number">{{ $schooldetails->getTotalBalTerm($schooldetails->id) == null ? "0":$schooldetails->getTotalBalTerm($schooldetails->id)->total_amount }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
  
            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>
  
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Total Expenditure</span>
                  <span class="info-box-number">{{ $sumTotalExpenditure }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">This Term Expenditure</span>
                  <span class="info-box-number">{{ $sumTotalExpenditureTerm }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>


        <div class="card" style="height: 200px; border-top: 2px solid #0B887C;">

                  <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Transactions</h3>

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

                    {{-- $table->integer('system_id');
                    $table->integer('transaction_type');
                    $table->integer('term');
                    $table->string('session');
                    $table->text('purpose');
                    $table->bigInteger('amount');
                    $table->integer('school_id');
                    $table->string('status'); --}}

                    <tr>
                      <th>#</th>
                      <th>Transaction Type</th>
                      <th>Term</th>
                      <th>Session</th>
                      <th>Purpose</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    
                  </thead>
                  <tbody>
                    @if (count($transactionHistory) > 0)
                    @php $count = method_exists($transactionHistory, 'links') ? 1 : 0; @endphp
                    @foreach ($transactionHistory as $item)
                    @php $count = method_exists($transactionHistory, 'links') ? ($transactionHistory ->currentpage()-1) * $transactionHistory ->perpage() + $loop->index + 1 : $count + 1; @endphp
                        <tr>
                          <td>{{$count}}</td>
                          <td>
                            @if ($item->transaction_type == 1)
                              Deposit
                            @else
                              Withdrawal
                            @endif
                          </td>
                          <td>{{$item->term}}</td>
                          <td>{{$item->session}}</td>
                          <td>{{$item->purpose}}</td>
                          <td>{{$item->amount}}</td>
                          <td>{{ $item->created_at }}</td>
                          <td>{{$item->status}}</td>

                          @if ($item->purpose == "Fees Part Payment")

                            <!-- The Modal -->
                            <div class="modal" id="view_transaction_details">
                              <div class="modal-dialog">
                                <div class="modal-content">
  
                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                    <h4 class="modal-title">Transaction Details</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>
  
                                  <!-- Modal body -->
                                  <div class="modal-body">
                                    <p>Transaction Date: {{ $item->created_at }} <i style="color: green;">{{$item->status}}</i></p>
                                    <p>Transaction Type: Fees Payment</p>
                                    <p>Student Name: {{ $item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id) == null ? "N.A":$item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id)->firstname." ".$item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id) == null ? "N.A":$item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id)->firstname }}</p>
                                    <p>Student Class: {{ $item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id) == null ? "N.A":$item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id)->classname }}</p>
                                    <p>Invoice ID: {{ $item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id) == null ? "N.A":$item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id)->invoice_number }}</p>
                                    <p>Amount Paid: ₦{{ $item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id) == null ? "N.A":$item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id)->amount_paid }}</p>
                                    <p>Total Amount: ₦{{ $item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id) == null ? "N.A":$item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id)->amount }}</p>
                                    <p>Transaction Amount: ₦{{$item->amount}}</p>
                                    <p>Balance: ₦{{ $item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id) == null ? "N.A":$item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id)->amount - $item->getTransactionDetails($item->system_id, $item->session, $item->term, $item->school_id)->amount_paid }}</p>
                                    <p>Transaction Completed By:</p>
                                  </div>
  
                                  <!-- Modal footer -->
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                  </div>
  
                                </div>
                              </div>
                            </div>
                              
                          @endif
                          
                          <td></button> <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#view_transaction_details"><i class="fas fa-eye"></i></button></td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                  
                </table>
              </div>
              <div class="text-center">
                <i style="font-style: normal;">Page {{ $transactionHistory->currentPage() }}</i>
                <i style="font-style: normal;">of</i>
                <i style="font-style: normal;">{{ $transactionHistory->lastPage() }}</i>
              </div>
              <div class="text-center" style="margin: 10px;">
                <a href="{{ $transactionHistory->previousPageUrl() }}"><button class="btn btn-sm btn-info">Prev</button></a>
                <a href="{{ $transactionHistory->nextPageUrl() }}"><button class="btn btn-sm btn-info">Next</button></a>
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
        document.getElementById('accountscroll').className = "nav-link active"
        document.getElementById('summarylistscroll').className = "nav-link active"
      }
  </script>

@endsection