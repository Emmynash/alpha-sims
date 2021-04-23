@extends('layouts.app_dash')

@section('content')


{{-- aside menu --}}
  <!-- Main Sidebar Container -->
  @include('layouts.asideside')

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
            <h1 class="m-0 text-dark">Teachers List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- SELECT2 EXAMPLE -->

        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Teachers List</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">


                  <table id="example1" class="table table-bordered table-striped">
                    <thead> 
                    <tr>
                      <th>S/N</th>
                      <th>Name</th>
                      <th>Form Teacher</th>
                      <th>Teach Class</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                      @if ($allTeachers->count() > 0)
                      @php $count = method_exists($allTeachers, 'links') ? 1 : 0; @endphp
                          @foreach ($allTeachers as $item)
                          @php $count = method_exists($allTeachers, 'links') ? ($allTeachers ->currentpage()-1) * $allTeachers ->perpage() + $loop->index + 1 : $count + 1; @endphp
                            <tr>
                              <td>{{ $count }}</td>
                              <td>{{ $item->firstname }} {{ $item->middlename }} {{ $item->lastname }}</td>
                              <td>Win 95+</td>
                              <td> 4</td>
                              <td><button class="btn btn-info btn-sm">view</button></td>
                            </tr>
                          @endforeach
                      @endif
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>S/N</th>
                      <th>Name</th>
                      <th>Form Teacher</th>
                      <th>Teach Class</th>
                      <th>Action</th>
                    </tr>
                    </tfoot>
                  </table>


                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>


        <!-- /.card -->


        <div class="modal fade" id="modal-lg">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Name</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div>
                  <div class="row">
                    <div class="col-md-6">

                    </div>
                    <div class="col-md-6">

                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

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

<!-- ./wrapper -->
    
@endsection

@push('custom-scripts')

<!-- DataTables  & Plugins -->
<script src="{{ asset('../../plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('../../plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('../../plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('../../plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
      function scrollocation(){
        document.getElementById('teachersaside').className = "nav-link active"
        document.getElementById('viewteacheraside').className = "nav-link active"
    }

    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
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
</script>
    
@endpush