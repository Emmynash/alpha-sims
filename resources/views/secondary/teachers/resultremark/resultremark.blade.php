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
            <h1 class="m-0 text-dark">My Subjects</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="My Subjects"
                data-content="Shows the list of all the subjects allocated to you. Ensure you have entered all students record for each subject before updating the status.">Need help?</button>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">My Subjects</li>
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
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Subjects</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    {{-- <input type="text" name="table_search" class="form-control float-right" placeholder="Search"> --}}

                    <div class="input-group-append">
                      {{-- <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button> --}}
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Subject</th>
                      <th>Class</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($teacherSubject) > 0)
                      @foreach ($teacherSubject as $teacherSubjects)
                        <tr>
                          <td>{{$teacherSubjects->getSubjectName->subjectname}} {{$teacherSubjects->getSubjectName->subjectcode}}</td>
                          <td>{{ $teacherSubjects->classname }}{{ $teacherSubjects->sectionname }}</td>
                          @if (in_array($teacherSubjects->subject_id, $arrayOfSubjectId))
                          <td>Done</td>
                          <td><button class="btn btn-sm btn-success" data-toggle="modal" data-target=""><i class="fas fa-check"></i></button> </td>
                          @else
                          <td>Pending</td>
                          <td><button class="btn btn-sm btn-success" disabled data-toggle="modal" data-target="#donemodal{{ $teacherSubjects->id }}"><i class="fas fa-plus"></i></button> </td>
                          @endif
                          

                              <!-- The Modal -->
                            <div class="modal fade" id="donemodal{{ $teacherSubjects->id }}">
                                <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                    <h4 class="modal-title"></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                    <form action="{{ route('resultremarkpost') }}" method="post" id="remarkpost{{ $teacherSubjects->id }}">
                                        @csrf
                                        <p>I am done inputing student marks for this subject</p>
                                        <input type="hidden" name="classid" value="{{ $teacherSubjects->classid }}">
                                        <input type="hidden" name="subject_id" value="{{ $teacherSubjects->subject_id }}">
                                        <input type="hidden" name="section_id" value="{{ $teacherSubjects->sectionid }}">
                                    </form>
                                    </div>
                                    
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="submit" form="remarkpost{{ $teacherSubjects->id }}" class="btn btn-info btn-sm">Proceed</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
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
        document.getElementById('classlistscroll').className = "nav-link active"
      }
  </script>
    
@endsection