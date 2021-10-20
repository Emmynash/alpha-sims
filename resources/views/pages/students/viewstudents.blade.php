@extends('layouts.app_dash')

@section('content')


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
            <h1 class="m-0 text-dark">Student List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Student list</li>
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
        <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">


            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>S/N</th>
                <th>Admission No.</th>
                <th>Name</th>
                <th>Class</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>

                @if ($studentList->count() > 0)
                @php $count = method_exists($studentList, 'links') ? 1 : 0; @endphp
                  @foreach ($studentList as $item)
                  @php $count = method_exists($studentList, 'links') ? ($studentList ->currentpage()-1) * $studentList ->perpage() + $loop->index + 1 : $count + 1; @endphp
                    <tr>
                      <td>{{ $count }}</td>
                      <td>{{ $item->admission_no }}</td>
                      <td>{{ $item->getStudentName->firstname }} {{ $item->getStudentName->middlename }} {{ $item->getStudentName->lastname }}</td>
                      <td>{{ $item->getClassName->classnamee }}{{ $item->studentsection }}</td>
                      <td><button class="btn btn-sm btn-info">view</button></td>
                    </tr>
                  @endforeach
                @endif

              </tbody>
              <tfoot>
              <tr>
                <th>S/N</th>
                <th>Admission No.</th>
                <th>Name</th>
                <th>Class</th>
                <th>Action</th>
              </tr>
              </tfoot>
            </table>

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin. --}}
          </div>
        </div>



        <!-- The Modal -->
        <div class="modal fade" id="viewstudentmodal">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
            
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              
              <!-- Modal body -->
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-4 bg-danger" style="height:150px;">

                    <div class="card" style="color: #000;">
                      <div class="card-header">
                        <h4 style="">Card Header</h4>
                      </div>
                      <div class="card-body">Content</div>
                    </div>

                  </div>
                  <div class="col-md-4 bg-success" style="height: 150px;">

                  </div>
                  <div class="col-md-4 bg-warning" style="height: 150px;">

                  </div>
                </div>
              </div>
              
              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

    function scrollocation(){
      document.getElementById('studentaside').className = "nav-link active"
      document.getElementById('viewstudentaside').className = "nav-link active"
    }
</script>
    
@endpush