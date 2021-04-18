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
            <h1 class="m-0 text-dark">Summary</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Class lists"
                data-content="View all classes in your school and the number of student in each class. You can change a class name incase of any mistake, however you have to be sure of what you are doing. Note: ensure classes are arranged in ascending order">Need help?</button>

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
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
  
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
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">This Term</span>
                  <span class="info-box-number">{{ $schooldetails->getTotalBalTerm == null ? "0":$schooldetails->getTotalBalTerm->total_amount }}</span>
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
                  <span class="info-box-text">This Term Expenditure</span>
                  <span class="info-box-number">2,000</span>
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
                      <th>Status</th>
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
                          <td>{{$item->status}}</td>
                          {{-- <td></td> --}}
                          {{-- <td></button> <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editclassname"><i class="fas fa-eye"></i></button></td> --}}
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
        document.getElementById('summarylistscroll').className = "nav-link active"
      }
  </script>

@endsection