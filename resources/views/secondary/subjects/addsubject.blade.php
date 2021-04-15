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
            <h1 class="m-0 text-dark">Add Subjects</h1>
            <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Addsubjects"
                data-content="On this module, you are required to enter all subjects offered by your school according to the classes you have.">Need help?</button>
                    
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Subjects</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


        <div class="card" style="border-top: 2px solid #0B887C;">

            <div style="margin: 10px;">
                <div id="subjectalertduplicate" class="alert alert-info alert-block">
                    {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
                    <i class="fas fa-exclamation-circle"></i><strong id="subjectadd_sec"> It seem you haven't added a subject. Add using the form below</strong>
                </div>
            </div>

            <div id="subjectaddprocessspinner" style="position: absolute; top: 0; bottom: 0; right: 0; left: 0; background-color: transparent; z-index: 999; display: none; align-items: center; justify-content: center;">
                <div class="spinner-border" style="width: 100px; height: 100px;"></div>
            </div>

            <form id="addsubjectprocess_secform" action="javascript:console.log('submitted');" method="post">
                @csrf
                <div class="row" style="margin: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <input type="text" class="form-control" name="subjectcodesec" id="subjectcodesec" placeholder="Subject Code" style="text-transform:uppercase">
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Name</label> --}}
                            <input type="text" class="form-control" name="subjectnamesec" id="subjectnamesec" placeholder="Subject Name" style="text-transform:uppercase">
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Name</label> --}}
                            <select type="text" class="form-control" name="class_sec" id="class_sec">
                                <option value="">Select a class</option>
                                @if (count($classesAll) > 0)
                                    @foreach ($classesAll as $classes)
                                        <option value="{{$classes->id}}">{{$classes->classname}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Name</label> --}}
                            <select type="text" class="form-control" name="subjecttype_sec" id="subjecttype_sec">
                                <option value="">Select Subject Type</option>
                                <option value="Core">Core</option>
                            </select>
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Name</label> --}}
                            <select type="text" class="form-control" name="gradesystem_sec" id="gradesystem_sec">
                                <option value="">Select grade system</option>
                                <option value="100">100 marks</option>
                            </select>
                        </div>
                    </div>
                </div>

                <i style="padding-left: 20px; font-size: 20px; font-weight: bold;">Mark Details</i>
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Mark entry"
                data-content="On this section, you are required to enter exams and test marks(Fullmark and passmark.">Need help?</button>

                <div class="row" style="margin: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1" style="font-weight: normal;">Fullmark, Passmark (eg. 100, 50)</label>
                            <input type="text" class="form-control" name="fullmarkpassmark_sec" id="fullmarkpassmark_sec" placeholder="Fullmark, Passmark">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" style="font-weight: normal;">Exams fullmark, Exams passmark (eg. 60, 30)</label>
                            <input type="text" class="form-control" name="examsmark_sec" id="examsmark_sec" placeholder="Fullmark, Passmark">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" style="font-weight: normal;">CA1 fullmark, CA1 passmark (eg. 15, 8)</label>
                            <input type="text" class="form-control" name="ca1marks_sec" id="ca1marks_sec" placeholder="Fullmark, Passmark">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" style="font-weight: normal;">CA2 fullmark, CA2 passmark (eg. 10, 5)</label>
                            <input type="text" class="form-control" name="ca2marks_sec" id="ca2marks_sec" placeholder="Fullmark, Passmark">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" style="font-weight: normal;">CA3 fullmark, CA3 passmark (eg. 5, 3)</label>
                            <input type="text" class="form-control" name="ca3marks_sec" id="ca3marks_sec" placeholder="Fullmark, Passmark">
                        </div>
                    </div>
                </div>
                <button id="addsubjectprocess_secbtn" class="btn btn-sm btn-info" style="margin:0 0 10px 20px;">Submit</button>
            </form>

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
        document.getElementById('subjectsmainAdd').className = "nav-link active"
      }
  </script>
    
@endsection