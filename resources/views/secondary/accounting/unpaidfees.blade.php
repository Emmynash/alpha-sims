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
            <h1 class="m-0 text-dark">Fee Invoices</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Invoices"
                data-content="View all fee invoices, settled, pending, etc">Need help?</button>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Fee Invoices</li>
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
                <h3 class="card-title">Students yet to pay fees</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Serial No.</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Section</th>
                  </tr>
                  </thead>
                  <tbody>

                    @if (count($unpaidArray) < 1)
                      <tr>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                      </tr>
  
                    @else
                    @php $count = method_exists($unpaidArray, 'links') ? 1 : 0; @endphp
                      @foreach ($unpaidArray as $item)
                      @php $count = method_exists($unpaidArray, 'links') ? ($unpaidArray ->currentpage()-1) * $unpaidArray ->perpage() + $loop->index + 1 : $count + 1; @endphp

                        <tr>
                          <td>{{ $count }}</td>
                          <td>{{ $item->firstname }} {{ $item->middlename }} {{ $item->lastname }}</td>
                          <td>{{ $item->classname }}</td>
                          <td>{{ $item->sectionname }}</td>
                          
                      @endforeach
                        
                    @endif

                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Serial No.</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Section</th>
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