@extends('secondary.accounting.layouts.app_account')


@section('content')

@include('secondary.accounting.layouts.aside_account')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Invoices</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Invoices"
                data-content="View all classes in your school and the number of student in each class. You can change a class name incase of any mistake, however you have to be sure of what you are doing. Note: ensure classes are arranged in ascending order">Need help?</button>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoices</li>
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
        </div>


        <div class="card" style="border-top: 2px solid #0B887C;">

                  <!-- /.row -->
        <div class="row">
          <div class="col-12">


            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Invoices List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Serial No.</th>
                    <th>Name</th>
                    <th>Invoice Number</th>
                    <th>Amount</th>
                    <th>Term</th>
                    <th>Session</th>
                    <th>Class</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>

                    @if ($feeInvoices->count() < 1)
                      <tr>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>--</td>
                      </tr>
  
                    @else
                    @php $count = method_exists($feeInvoices, 'links') ? 1 : 0; @endphp
                      @foreach ($feeInvoices as $item)
                      @php $count = method_exists($feeInvoices, 'links') ? ($feeInvoices ->currentpage()-1) * $feeInvoices ->perpage() + $loop->index + 1 : $count + 1; @endphp

                        <tr>
                          <td>{{ $count }}</td>
                          <td>{{ $item->firstname }} {{ $item->middlename }} {{ $item->lastname }}</td>
                          <td>{{ $item->invoice_number }}</td>
                          <td>{{ $item->amount }}</td>
                          <td>{{ $item->term }}</td>
                          <td>{{ $item->session }}</td>
                          <td>X</td>
                          <td>
                            @if ($item->status == 0)
                            <button class="btn btn-sm btn-success"><i class="fa fa-cancel"></i></button>
                            @else
                                <button class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>
                            @endif
                          </td>
                        </tr>
                          
                      @endforeach
                        
                    @endif

                  

                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Serial No.</th>
                    <th>Name</th>
                    <th>Invoice Number</th>
                    <th>Amount</th>
                    <th>Term</th>
                    <th>Session</th>
                    <th>Class</th>
                    <th>Status</th>
                  </tr>
                  </tfoot>
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

@endsection

@push('custom-scripts')

<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}"></script>
<script src="{{ asset("plugins/datatables-responsive/js/dataTables.responsive.min.js") }}"></script>

<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
      });
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });

    $(function() {

      var TotalValue = 0;

      $("tr #loop").each(function(index,value){
        currentRow = parseFloat($(this).text());
        TotalValue += currentRow
      });

      document.getElementById('total').innerHTML = "₦"+TotalValue;

    });

    function scrollocation(){
        document.getElementById('invoicelistscroll').className = "nav-link active"
    }

  </script>
    
@endpush