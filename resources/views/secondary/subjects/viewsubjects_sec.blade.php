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
            <h1 class="m-0 text-dark">Subject List</h1>
            <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Class lists"
                data-content="View all subjecst added to your school and subject mark allocation. You can edit the subject class, subject name and subject code. However, you can only edit and delete if no entry has been added to a subject.">Need help?</button>
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
          
          @include('layouts.message')


        <div class="card" style="border-top: 2px solid #0B887C;">

        <!-- /.row -->
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Subject List</h3>
  
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
                      @if (count($subjectAll) > 0)
                        @foreach ($subjectAll as $subjectlist)
                            <tr>
                              <td>{{$subjectlist->subjectcode}}</td>
                              <td>{{$subjectlist->subjectname}}</td>
                              <td>{{$subjectlist->classname}}</td>
                              <td>{{$subjectlist->gradesystem}}</td>
                              <td><i style="font-style: normal; font-size: 12px;">Total: {{$subjectlist->totalfull}}</i> <i style="font-style: normal; font-size: 12px;">Exam: {{$subjectlist->examfull}}</i> <i style="font-style: normal; font-size: 12px;">CA1: {{$subjectlist->ca1full}}</i> <i style="font-style: normal; font-size: 12px;">CA2: {{$subjectlist->ca2full}}</i> 
                                @if ($schoolDetails->caset == 1)
                                <i style="font-style: normal; font-size: 12px;">CA3: {{$subjectlist->ca3full}}</i>
                                @endif
                                </td>
                              <td><i style="font-style: normal; font-size: 12px;">Total: {{$subjectlist->totalpass}}</i> <i style="font-style: normal; font-size: 12px;">Exam: {{$subjectlist->exampass}}</i> <i style="font-style: normal; font-size: 12px;">CA1: {{$subjectlist->ca1pass}}</i> <i style="font-style: normal; font-size: 12px;">CA2: {{$subjectlist->ca2pass}}</i> 
                                @if ($schoolDetails->caset == 1)
                                <i style="font-style: normal; font-size: 12px;">CA3: {{$subjectlist->ca3pass}}</i>
                                @endif
                                </td>

                              {{-- delete modal --}}
                              <!-- The Modal -->
                                <div class="modal fade" id="deletesub_sec{{$subjectlist->id}}">
                                  <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                    
                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                      
                                      <!-- Modal body -->
                                      <div class="modal-body">
                                        Are you sure you want to delete this subject? <i style="color: red;">Process is irreversible</i>
                                        <form id="deletesubject_sec{{$subjectlist->id}}" action="/deletesubject_sec" method="post">
                                          @csrf
                                         <input name="subjectid_sec" type="hidden" value="{{$subjectlist->id}}" readonly>
                                        </form>
                                      </div>
                                      
                                      <!-- Modal footer -->
                                      <div class="modal-footer">
                                        <button type="submit" class="btn btn-success btn-sm" form="deletesubject_sec{{$subjectlist->id}}"><i class="fas fa-check"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
                                      </div>
                                      
                                    </div>
                                  </div>
                                </div>


                                {{-- modal for editing --}}
                                <!-- The Modal -->
                                  <div class="modal fade" id="editsubject_sec{{$subjectlist->id}}">
                                    <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                      
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                          <h6 class="modal-title">{{$subjectlist->subjectname}}</h6>
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <i style="font-style: normal; font-size: 12px; color:red;">I hope you know what you are doing? Cancel if you don't.</i>
                                          <form id="editsubject_secform{{$subjectlist->id}}" action="/editsubject_sec" method="post">
                                            @csrf
                                            <div class="row">
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <i style="font-style: normal; font-size: 10px;">{{$subjectlist->classname}}</i>
                                                  <select name="newclass_sec" class="form-control form-control-sm" id="">
                                                    <option value="">Select Class</option>
                                                    @if (count($classesAll) > 0)
                                                      @foreach ($classesAll as $classes)
                                                          <option value="{{$classes->id}}">{{$classes->classname}}</option>
                                                      @endforeach
                                                        
                                                    @endif
                                                  </select>
                                                </div>
                                                <div class="form-group">
                                                  <i style="font-style: normal; font-size: 10px;">{{$subjectlist->subjectname}}</i>
                                                  <input type="text" name="newsubjectname_sec" class="form-control form-control-sm" value="{{$subjectlist->subjectname}}" required>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <i style="font-style: normal; font-size: 10px;">{{$subjectlist->subjectcode}}</i>
                                                  <input type="text" name="newsubjectcode_sec" class="form-control form-control-sm" value="{{$subjectlist->subjectcode}}" required>
                                                </div>
                                              </div>
                                            </div>
                                            <input type="hidden" value="{{$subjectlist->id}}" name="subjectid_sec">
                                          </form>
                                        </div>
                                        
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                          <button type="submit" class="btn btn-success btn-sm" form="editsubject_secform{{$subjectlist->id}}"><i class="fas fa-check"></i></button>
                                          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
                                        </div>
                                        
                                      </div>
                                    </div>
                                  </div>
                              <td><button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editsubject_sec{{$subjectlist->id}}"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletesub_sec{{$subjectlist->id}}"><i class="fas fa-trash-alt"></i></button></td>
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
        document.getElementById('subjectsmain').className = "nav-link active"
        document.getElementById('subjectsmainview').className = "nav-link active"
      }
  </script>
    
@endsection