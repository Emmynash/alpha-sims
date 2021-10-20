@extends('layouts.app_dash')

@section('content')
{{-- aside menu --}}
  <!-- Main Sidebar Container -->
  @include('layouts.asideside')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    {{-- <div style="width: 90%; margin: 0 auto; padding-top: 10px;">
      
    </div> --}}
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Subject List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Subject List</li>
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

        <!-- /.row -->
        @include('layouts.message')
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Subject list</h3>
  
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
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Class</th>
                        <th>Grade System</th>
                        <th>Full marks</th>
                        <th>Pass marks</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                        @if (count($addsubject) > 0)
  
                        @foreach ($addsubject as $subject)
                        <tr>
                          <td>{{strtoupper($subject->subjectcode)}}</td>
                          <td>{{$subject->subjectname}}</td>
                          <td>{{$subject->classnamee}}</td>
                          <td>{{$subject->gradesystem}}</td>
                          <td style="display: flex; flex-direction: column;"> <label style="font-size:12px;">total:{{$subject->totalfull}}, exams:{{$subject->examfull}}</label> <label style="font-size:12px;">CA1:{{$subject->ca1full}}, CA2:{{$subject->ca2full}}, CA3:{{$subject->ca3full}}</label></td>
                          <td><label style="font-size: 12px;">total:{{$subject->totalpass}}, exams:{{$subject->exampass}}</label>  <label style="font-size:12px;">CA1:{{$subject->ca1pass}}, CA2:{{$subject->ca2pass}}, CA3:{{$subject->ca3pass}}</label></td>

                            <form action="/deletesubject" method="post" id="deleteSubject{{$subject->id}}">
                              @csrf
                              <input type="hidden" name="subjectid" value="{{$subject->id}}">
                            </form>

                              <!-- The Modal -->
                              <div class="modal fade" id="editsubject{{$subject->id}}">
                                <div class="modal-dialog modal-sm">
                                  <div class="modal-content">
                                  
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h6 class="modal-title">{{$subject->subjectname}}</h6>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                      <form action="/updatesubject" method="post" id="updatesubjects{{$subject->id}}">
                                        @csrf
                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <i for="" style="font-weight: normal; font-size: 10px;">{{$subject->classnamee}}</i>
                                              <select name="updateclass" class="form-control form-control-sm">
                                                @if (count($classList) > 0)
                                                    @foreach ($classList as $class)
                                                        <option value="{{$class->id}}">{{$class->classnamee}}</option>
                                                    @endforeach
                                                @endif
                                              </select>
                                            </div>

                                            <div class="form-group">
                                              <i for="" style="font-weight: normal; font-size: 10px;">{{$subject->subjectcode}}</i>
                                              <input type="text" name="updatesubjectcode" class="form-control form-control-sm" value="{{$subject->subjectcode}}">
                                            </div>

                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <i for="" style="font-weight: normal; font-size: 10px;">{{$subject->subjectname}}</i>
                                              <input type="text" name="updatesubjectname" class="form-control form-control-sm" value="{{$subject->subjectname}}">
                                            </div>
                                            <input type="hidden" name="subjectid" value="{{$subject->id}}">
  
                                          </div>
                                        </div>
                                      </form>
                                    </div>
                                    
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                      <button form="updatesubjects{{$subject->id}}" type="submit" class="btn btn-sm btn-success">Submit</button>
                                      <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>

                          <td><span class="tag tag-success"><button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editsubject{{$subject->id}}"><i class="far fa-edit"></i></button> <button type="submit" class="btn btn-danger btn-sm" form="deleteSubject{{$subject->id}}"><i class="far fa-trash-alt"></i></button></span></td>
                        </tr>
                        @endforeach
                          
                        @endif
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
              @if (count($addsubject) > 0)
                {{ $addsubject->links() }}
              @endif
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

<script>

    function scrollocation(){
        document.getElementById('subjectpage').className = "nav-link active"
        document.getElementById('viewsubjectside').className = "nav-link active"
        // document.getElementById('studentshift').value = document.getElementById('classiddecoy').value
   
    }
</script>

@endsection