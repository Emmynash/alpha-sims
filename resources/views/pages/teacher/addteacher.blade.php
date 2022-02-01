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
            <h1 class="m-0 text-dark">Add Teacher</h1>
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
    <section class="content">
        <div class="container-fluid">
            

            <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">
            <h4 style="padding-top: 10px;">Class Allocation Details</h4>
            <div class="row">
              <div class="col-md-12">
                    <!--<form id="addteacherprimary" method="POST" action="/addteachermain">-->
                    <!--    @csrf-->
                        
                        <div class="card">
                            
                                  <div class="alert alert-info alert-block" style="margin: 10px;">
                                    {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
                                    <strong>Each class should have one form master. Use the form to allocate for each class.</strong>
                                  </div>
                            
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div style="margin: 10px;">
                                                    <form id="btnfetchteachersdetailsformteacherform" action="javascript:console.log('submited')" method="post">
                                                        @csrf
                                                        <div class="form-group">
                                                            <select name="selectedclassteacher" id="selectedclassteacher" class="form-control form-control-sm">
                                                                <option>Select a class</option>
                                                                @if(count($classList) > 0)
                                                                
                                                                    @foreach($classList as $classlists)
                                                                    
                                                                     <option value="{{$classlists->id}}">{{$classlists->classnamee}}</option>
                                                                    
                                                                    @endforeach
                                                                
                                                                @endif
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <select name="selectedsectionteacher" id="selectedsectionteacher" class="form-control form-control-sm">
                                                                <option>Select a section</option>
                                                                @if(count($addSection) > 0)
                                                                
                                                                    @foreach($addSection as $addSection)
                                                                    
                                                                     <option value="{{$addSection->id}}">{{$addSection->sectionname}}</option>
                                                                    
                                                                    @endforeach
                                                                
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <input type="hidden" name="type" value="addteacherform">
                                                        
                                                        <div class="form-group">
                                                            <input type="text" id="teacherRegNoConfirm" name="teacherRegNoConfirm" class="form-control form-control-sm" placeholder="system number">
                                                        </div>
                                                        
                                                        <button id="btnfetchteachersdetailsformteacherbtn" type="submit"  class="btn btn-sm btn-info">Confirm</button>
                                                        
                                                        <button id="btnfetchteachersdetailsloading" style="display: none;" class="btn btn-primary btn-sm" type="button" disabled>
                                                          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                          Loading...
                                                        </button>
                                                        
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div style="margin: 10px;">
                                                    <p><i id="formclassgiven"></i></p>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div style="margin: 10px;">
                                            <div class="row">
                                                  <div class="col-md-4">
                                                      <div style="display: flex; align-items: center; justify-content: center; margin-bottom:5px;">
                                                          <img id="studentprofileimgteacher" style="" src="storage/schimages/profile.png" class="img-circle elevation-2" alt="" width="150px" height="150px">
                                                      </div>
                                                  </div>
                                                  <div class="col-md-8">
                                                      <form id="formteacherallocationform" action="javascript:console.log('submited')" method="POST">
                                                          @csrf
                                                          <div>
                                                             <input type="text" id="firstname" class="form-control form-control-sm" placeholder="firstname">
                                                             <br>
                                                             <input type="text" id="middlename" class="form-control form-control-sm" placeholder="middlename">
                                                             <br>
                                                             <input type="text" id="lastname" class="form-control form-control-sm" placeholder="lastname">
                                                          </div>
                                                          <input type="hidden" id="systemnumberTeacher" name="systemnumberTeacher">
                                                          <input type="hidden" id="formclass" name="formclass">
                                                          <input type="hidden" id="formsection" name="formsection">
                                                          <input type="hidden" id="key" name="key" value="addteacherform">
                                                          <br>
                                                          <button id="formteacherallocationbtn" class="btn btn-sm btn-info">Asign</button>
                                                      </form>
                                                  </div>
    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                        
                        </div>
                        <!-- /.col -->
                        <div class="col-md-12">
                            
                            <div class="card">
                                
                                  <div class="alert alert-info alert-block" style="margin: 10px;">
                                    {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
                                    <strong>Each subject needs a teacher for each class. Use the form below to asign teachers to subject.</strong>
                                  </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div style="margin: 10px;">
                                                    <form id="btnfetchteachersdetailsclassform" action="javascript:console.log('submited')" method="post">
                                                        @csrf
                                                        <div class="form-group">
                                                            <select id="subjectAllocatedSubjectmain" class="form-control form-control-sm">
                                                                <option>Select a Subject</option>
                                                                @if(count($addsubjects) > 0)
                                                                
                                                                    @foreach($addsubjects as $addsubjects)
                                                                    
                                                                     <option value="{{$addsubjects->id}}">{{$addsubjects->subjectname}}/{{$addsubjects->subjectcode}}/{{$addsubjects->classnamee}}</option>
                                                                    
                                                                    @endforeach
                                                                
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <input type="hidden" name="type" value="techersubject">
                                                        
                                                        <div class="form-group">
                                                            <input type="text" name="teacherRegNoConfirmclass" id="teacherRegNoConfirmclass" class="form-control form-control-sm" placeholder="system number">
                                                        </div>
                                                        
                                                        <button id="btnfetchteachersdetailsclassbtn" class="btn btn-sm btn-info"">Confirm</button>
                                                        
                                                        <button id="btnfetchteachersdetailsclassloading" style="display: none;" class="btn btn-primary btn-sm" type="button" disabled>
                                                          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                          Loading...
                                                        </button>
                                                        
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div style="margin: 10px;">
                                            <div class="row">
                                                  <div class="col-md-4">
                                                      <div style="display: flex; align-items: center; justify-content: center; margin-bottom:5px;">
                                                          <img id="studentprofileimgteacherclass" style="" src="storage/schimages/profile.png" class="img-circle elevation-2" alt="" width="150px" height="150px">
                                                      </div>
                                                  </div>
                                                  <div class="col-md-8">
                                                      <form id="allocatesubjectteacherform" action="javascript:console.log('submited')" method="POST">
                                                          @csrf
                                                          <div>
                                                             <input type="text" id="firstnameclass" class="form-control form-control-sm" placeholder="firstname">
                                                             <br>
                                                             <input type="text" id="middlenameclass" class="form-control form-control-sm" placeholder="firstname">
                                                             <br>
                                                             <input type="text" id="lastnameclass" class="form-control form-control-sm" placeholder="firstname">
                                                          </div>
                                                          
                                                          <input type="hidden" id="systemnumberTeacherSubject" name="systemnumberTeacherSubject">
                                                          <input type="hidden" id="subjectAllocatedSubject" name="subjectAllocatedSubject">
                                                          <input type="hidden" id="key" name="key" value="class">
                                                          
                                                          <br>
                                                          <button id="allocatesubjectteacherbtn" class="btn btn-sm btn-info">Asign</button>
                                                      </form>
                                                  </div>
    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>

                        </div>
                        <!-- /.col -->
                        </div>
                        <br>

          </div>
        </div>

        </div>
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
        document.getElementById('teachersaside').className = "nav-link active"
        document.getElementById('addteacheraside').className = "nav-link active"
    }
</script>
    
@endsection

@push('custom-scripts')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
    $(function() {
        $('#btnfetchteachersdetailsclassbtn').click(function(e) {
            e.preventDefault();
            $("#btnfetchteachersdetailsclassform").submit();

            $.ajax({
            url: "{{ route('addteachersverify') }}",
            type: 'post',
            dataType: 'json',
            data: $('form#btnfetchteachersdetailsclassform').serialize(),
            success: function(data) {

                console.log(data)
                if (data != null && data != "error") {
                    document.getElementById('firstnameclass').value = data['firstname']
                    document.getElementById('middlenameclass').value = data['middlename']
                    document.getElementById('lastnameclass').value = data['lastname']
                    document.getElementById('studentprofileimgteacherclass').src = '/storage/schimages/'+data['profileimg']

                    document.getElementById('systemnumberTeacherSubject').value = data['id']
                    document.getElementById('subjectAllocatedSubject').value = document.getElementById('subjectAllocatedSubjectmain').value


                } else{

                    document.getElementById('firstnameclass').value = ""
                    document.getElementById('middlenameclass').value = ""
                    document.getElementById('lastnameclass').value = ""
                    document.getElementById('studentprofileimgteacherclass').src = 'https://cdn.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png'
                    
                }
                },
                error:function(errors){
                console.log(errors)
                }
            });
        });
    });

    $(function() {
        $('#btnfetchteachersdetailsformteacherbtn').click(function(e) {
            e.preventDefault();
            $("#btnfetchteachersdetailsformteacherform").submit();

            $.ajax({
            url: "{{ route('addteachersverify') }}",
            type: 'post',
            dataType: 'json',
            data: $('form#btnfetchteachersdetailsformteacherform').serialize(),
            success: function(data) {

                console.log(data)
                if (data != null && data != "error") {
                    document.getElementById('firstname').value = data['firstname']
                    document.getElementById('middlename').value = data['middlename']
                    document.getElementById('lastname').value = data['lastname']
                    document.getElementById('studentprofileimgteacher').src = '/storage/schimages/'+data['profileimg']

                    document.getElementById('systemnumberTeacherSubject').value = data['id']
                    document.getElementById('subjectAllocatedSubject').value = document.getElementById('subjectAllocatedSubjectmain').value


                } else{

                    document.getElementById('firstname').value = ""
                    document.getElementById('middlename').value = ""
                    document.getElementById('lastname').value = ""
                    document.getElementById('studentprofileimgteacher').src = 'https://cdn.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png'
                    
                }
                },
                error:function(errors){
                console.log(errors)
                }
            });
        });
    });
</script>
    
@endpush