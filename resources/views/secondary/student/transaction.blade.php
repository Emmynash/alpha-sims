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
            <h1 class="m-0 text-dark">Transactions</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Invoices"
                data-content="View all classes in your school and the number of student in each class. You can change a class name incase of any mistake, however you have to be sure of what you are doing. Note: ensure classes are arranged in ascending order">Need help?</button>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Transactions</li>
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

        {{-- <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Available Amount</span>
                  <span class="info-box-number">
                    1,000
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Total Recieved</span>
                  <span class="info-box-number">41,410</span>
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
                  <span class="info-box-number">760</span>
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
                  <span class="info-box-text">Pending Amount</span>
                  <span class="info-box-number">2,000</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div> --}}


        

        <div class="row">
          <div class="col-md-6 col-12">
            <div class="card" style="height: 200px; border-top: 2px solid #0B887C;">

              <!-- /.row -->
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Invoice</h3>

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
                              <th>Invoice Number</th>
                              <th>Amount</th>
                              <th>Term</th>
                              <th>Session</th>
                              <th>Class</th>
                              <th>Status</th>
                              <th>Date</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if (count($feeInvoices) > 0)
                            @php $count = method_exists($feeInvoices, 'links') ? 1 : 0; @endphp
                              @foreach ($feeInvoices as $item)
                              @php $count = method_exists($feeInvoices, 'links') ? ($feeInvoices ->currentpage()-1) * $feeInvoices ->perpage() + $loop->index + 1 : $count + 1; @endphp
                                <tr>
                                  <td>{{$count}}</td>
                                  <td>{{ $item->invoice_number }}</td>
                                  <td>{{ $item->amount }}</td>
                                  <td>{{ $item->term }}</td>
                                  <td>{{ $item->session }}</td>
                                  <td>{{ $item->classname }}</td>
                                  <td>
                                      @if ($item->status == 0)
                                          Pending
                                      @else
                                          Completed
                                      @endif
                                  </td>
                                  <td>{{ $item->created_at }}</td>
                                  <td>

                                    @if ($item->status == 0)

                                    <form action="{{ route('make_payment') }}" id="paymentform{{ $item->id }}" method="post">
                                        @csrf
                                        <input type="hidden" name="amount" value="{{ $item->amount }}" >
                                    </form>

                                        <button class="btn btn-sm btn-info" form="paymentform{{ $item->id }}" data-toggle="modal" data-target="#editclassname">Pay Now</button>
                                    @else
                                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#editclassname"><i class="fas fa-check"></i></button>
                                    @endif
                                </td>
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
          </div>
          <div class="col-md-6 col-12">
            <div class="card" style="height: 200px; border-top: 2px solid #0B887C;">

              <!-- /.row -->
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Payment Record</h3>

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
                              <th>Trans ID</th>
                              <th>Amount</th>
                              <th>AMount Rem</th>
                              <th>Term</th>
                              <th>Session</th>
                              <th>Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if (count($paymentRecord) > 0)
                            @php $count = method_exists($paymentRecord, 'links') ? 1 : 0; @endphp
                              @foreach ($paymentRecord as $item)
                              @php $count = method_exists($paymentRecord, 'links') ? ($paymentRecord ->currentpage()-1) * $paymentRecord ->perpage() + $loop->index + 1 : $count + 1; @endphp
                                <tr>
                                  <td>{{$count}}</td>
                                  <td>{{ $item->id }}</td>
                                  <td>₦{{ $item->amount_paid }}</td>
                                  <td>₦{{ $item->amount_rem }}</td>
                                  <td>{{ $item->term }}</td>
                                  <td>{{ $item->session }}</td>
                                  <td>{{ $item->created_at }}</td>
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
          </div>
        </div>




  
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
        document.getElementById('invoicelistscroll').className = "nav-link active"
      }
  </script>

@endsection