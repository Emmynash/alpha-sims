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
            <h1 class="m-0 text-dark">Add Teachers</h1>
            <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Class lists"
                data-content="On this module, you are required to allocate subjects to each teacher and asign form-master to each class. Note: system number is required.">Need help?</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Teachers</li>
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
          <div class="alert alert-info alert-block" style="margin: 10px;">
            {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
            <strong>Each class should have one form master. Use the form to allocate for each class.</strong>
          </div>
          
            <div class="row" style="margin: 10px;">
              <div class="col-md-6">
                <form id="teacherregconfirmform" action="javascript:console.log('submitted')" method="post">
                  @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <select name="masterallocatedclass" id="masterallocatedclass" class="form-control form-control-sm">
                        <option value="">Select a class</option>
                        @if (count($classesAll) > 0)
                            @foreach ($classesAll as $classes)
                                <option value="{{$classes->id}}">{{$classes->classname}}</option>
                            @endforeach
                        @endif
                      </select>
                    </div>

                    <div class="form-group">
                      <select name="masterallocatedsection" id="masterallocatedsection" class="form-control form-control-sm">
                        <option value="">Select a section</option>
                        @if (count($addsection_sec) > 0)
                            @foreach ($addsection_sec as $section)
                                <option value="{{$section->id}}">{{$section->sectionname}}</option>
                            @endforeach
                        @endif
                      </select>
                    </div>

                    <div class="form-group">
                      <input type="text" name="mastersystemnumber" id="mastersystemnumber" class="form-control form-control-sm" placeholder="systemnumber">
                    </div>
                    <button id="teacherregconfirmbtn" class="btn btn-info btn-sm">Confirm/Assign</button>
                  </form>
                  </div>
                  <div class="col-md-6">

                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-4">
                      <div style="display: flex; align-items: center; justify-content: center; margin-bottom:5px;">
                          <img id="passportconfirm_sec" style="" src="storage/schimages/profile.png" class="img-circle elevation-2" alt="" width="150px" height="150px">
                      </div>
                  </div>
                  <div class="col-md-8">
                      <div class="form-group">
                          {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                          <input class="form-control form-control-sm" name="registeredfirstname" id="registeredfirstname" placeholder="First name">
                      </div>
                      <div class="form-group">
                          {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                          <input class="form-control form-control-sm" name="registeredmiddlename" id="registeredmiddlename" placeholder="Middle name">
                      </div>
                      <div class="form-group">
                          {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                          <input class="form-control form-control-sm" name="registeredlastname" id="registeredlastname" placeholder="Last name">
                      </div>
                      <form id="allocatemastermainform" action="javascript:console.log('submitted')" method="post">
                        @csrf
                        <input type="hidden" name="systemidformmaster" id="systemidformmaster">
                        <input type="hidden" name="formsection" id="formsection">
                        <input type="hidden" name="formteacherclass" id="formteacherclass">
                        <button style="margin: 5px;" id="allocatemastermainbtn" class="btn btn-sm btn-info">Asign Class</button>
                      </form>
                  </div>
                </div>
              </div>
            </div>
          
        </div>

        <i style="font-style: normal; font-size: 20px; margin:0 0 10px 20px;">Subjects Teachers</i>

        <div class="card" style="border-top: 2px solid #0B887C;">
          <div class="alert alert-info alert-block" style="margin: 10px;">
            {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
            <strong>Each subject needs a teacher for each class. Use the form below to asign teachers to subject.</strong>
          </div>
          
            <div class="row" style="margin: 10px;">
              <div class="col-md-6">
                <form id="allocatesubjectform" action="javascript:console.log('submitted')" method="post">
                  @csrf
                <div class="row">
                  <div class="col-md-6">
                    <!--<div class="form-group">-->
                    <!--  <select name="allocateclasssubject" id="allocateclasssubject" class="form-control form-control-sm">-->
                    <!--    <option value="">Select a class</option>-->
                    <!--    @if (count($classesAll) > 0)-->
                    <!--        @foreach ($classesAll as $classes)-->
                    <!--            <option value="{{$classes->id}}">{{$classes->classname}}</option>-->
                    <!--        @endforeach-->
                    <!--    @endif-->
                    <!--  </select>-->
                    <!--</div>-->

                    <div class="form-group">
                      <select name="allocationsubject" id="allocationsubject" class="form-control form-control-sm">
                        <option value="">Select a subject</option>
                        @if (count($addsubject_sec) > 0)
                            @foreach ($addsubject_sec as $subject)
                                <option value="{{$subject->id}}">{{$subject->subjectname}}/{{$subject->subjectcode}}/{{$subject->classname}}</option>
                            @endforeach
                        @endif
                      </select>
                    </div>

                    <div class="form-group">
                      <input type="text" name="systemidstudentalloc" id="systemidstudentalloc" class="form-control form-control-sm" placeholder="systemnumber">
                    </div>
                    <button id="allocatesubjectbtn" class="btn btn-info btn-sm">Confirm/Assign</button>
                  </form>
                  </div>
                  <div class="col-md-6">

                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-4">
                      <div style="display: flex; align-items: center; justify-content: center; margin-bottom:5px;">
                          <img id="passportconfirm_sec2" style="" src="storage/schimages/profile.png" class="img-circle elevation-2" alt="" width="150px" height="150px">
                      </div>
                  </div>
                  <div class="col-md-8">
                      <div class="form-group">
                          {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                          <input class="form-control form-control-sm" name="firstnameclass" id="registeredfirstname2" placeholder="First name">
                      </div>
                      <div class="form-group">
                          {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                          <input class="form-control form-control-sm" name="middlenameclass" id="registeredmiddlename2" placeholder="Middle name">
                      </div>
                      <div class="form-group">
                          {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                          <input class="form-control form-control-sm" name="lastnameclass" id="registeredlastname2" placeholder="Last name">
                      </div>
                      <form id="subjectallocationform" action="javascript:console.log('submitted')" method="post">
                        @csrf
                        <input type="hidden" name="subject_id" id="allocatesubject">
                        <input type="hidden" name="allocatedclass" id="allocatedclass">
                        <input type="hidden" name="user_id" id="systemidsubjectalloc">
                        <button id="subjectallocationbtn" class="btn btn-sm btn-info">Asign subject</button>
                      </form>
                  </div>
                </div>
              </div>
            </div>
          



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
        document.getElementById('teachersmain').className = "nav-link active"
        document.getElementById('addteachersmain').className = "nav-link active"
      }
  </script>
    
@endsection