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
            <h1 class="m-0 text-dark">Add Student</h1>
            <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Add Students"
                data-content="On this module, you can add students to your school. You will add them using the system number. However, you can create an account for a student here aswell">Need help?</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Student</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <!--<div style="margin: 5px;">-->
          <!--    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addstudentmodal">Add Student</button>-->
          <!--</div>-->


        <div class="card" style="border-top: 2px solid #0B887C;">

            <div style="margin: 10px;">
                <div id="subjectalertduplicate" class="alert alert-info alert-block">
                    {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
                    <i class="fas fa-exclamation-circle"></i><strong id="subjectadd_sec"> It seem you haven't added a subject. Add using the form below</strong>
                </div>
                
                    @include('layouts.message')
                
            </div>

            <div class="row" style="margin: 10px;">
                <div class="col-md-6">
                    <form id="studentregconfirmform" action="javascript:console.log('submitted');" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                                    <Select class="form-control form-control-sm" name="allocatedclass" id="allocatedclass" style="text-transform:uppercase">
                                        <option value="">Select a class</option>
                                        @if (count($addschool->getClassList($addschool->id)) > 0)
                                            @foreach ($addschool->getClassList($addschool->id) as $classes)
                                                <option value="{{$classes->id}}">{{$classes->classname}}</option>
                                            @endforeach
                                        @endif
                                    </Select>
                                </div>
                                <div class="form-group">
                                    {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                                    <Select class="form-control form-control-sm" name="allocatedsection" id="allocatedsection" style="text-transform:uppercase">
                                        <option value="">Select section</option>
                                        @if (count($addschool->getSectionList($addschool->id)) > 0)
                                            @foreach ($addschool->getSectionList($addschool->id) as $section)
                                                <option value="{{$section->id}}">{{$section->sectionname}}</option>
                                            @endforeach
                                        @endif
                                    </Select>
                                </div>
                                <div class="form-group">
                                    {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                                    <input class="form-control form-control-sm" name="systemnumber" id="systemnumber" placeholder="system number">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                                    <input class="form-control form-control-sm" name="currentsession" value="{{$addschool->schoolsession}}" id="currentsession" placeholder="session">
                                </div>
                                <div class="form-group">
                                    {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                                    <Select class="form-control form-control-sm" name="allocatedshift" id="allocatedshift">
                                        <option value="">Student type</option>
                                        <option value="Boarding">Boarding</option>
                                        <option value="Day">Day</option>
                                    </Select>
                                </div>
                            </div>
                        </div>
                        <i style="font-style: normal; font-size: 10px;">Please, confirm student before proceeding</i>
                        <button id="studentregconfirmbtn" class="btn btn-sm btn-info">Confirm</button>
                    </form>
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
                        </div>
                    </div>
                </div>
            </div>

            <i style="margin: 0 0 10px 20px; font-size: 20px; font-weight: bold;">Student Details</i>
        
            <form action="student_sec_add" method="POST">
                @csrf
                <input type="hidden" name="studentclassallocated" value="{{ old('studentclassallocated') }}" id="studentclassallocated">
                <input type="hidden" name="schoolsession" value="{{ old('schoolsession') }}" id="schoolsession">
                <input type="hidden" name="studentsectionallocated" value="{{ old('studentsectionallocated') }}" id="studentsectionallocated">
                <input type="hidden" name="studenttype" value="{{ old('studenttype') }}" id="studenttype">
                <input type="hidden" name="studentsystemnumber" value="{{ old('studentsystemnumber') }}" id="studentsystemnumber">
                <div class="row" style="margin: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="admissionname" placeholder="enter admission number" class="form-control @error('admissionname') is-invalid @enderror" value="{{ old('admissionname') }}">
                            @error('admissionname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <Select class="form-control @error('studentgender') is-invalid @enderror" name="studentgender" id="studentgender">
                                <option value="">Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </Select>
                            @error('studentgender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <Select class="form-control @error('studentreligion') is-invalid @enderror" name="studentreligion" id="studentreligion">
                                <option value="">Select religion</option>
                                <option value="Christian">Christian</option>
                                <option value="Islam">Islam</option>
                                <option value="Other">Other</option>
                            </Select>
                            @error('studentreligion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <input type="date" class="form-control @error('dateofbirth') is-invalid @enderror" name="dateofbirth" id="dateofbirth">
                            @error('dateofbirth')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <Select class="form-control @error('bloodgroup') is-invalid @enderror" name="bloodgroup" id="bloodgroup">
                                <option value="">Select blood group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </Select>
                            @error('bloodgroup')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <Select class="form-control @error('studenthouse') is-invalid @enderror" name="studenthouse" id="studenthouse">
                                <option value="">Select house</option>
                                @if (count($addschool->gethouseList($addschool->id)) > 0)
                                    @foreach ($addschool->gethouseList($addschool->id) as $house)
                                        <option value="{{$house->id}}">{{$house->housename}}</option>
                                    @endforeach
                                @endif
                            </Select>
                            @error('studenthouse')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <input type="text" class="form-control @error('nationality') is-invalid @enderror" name="nationality" value="{{ old('nationality') }}" id="nationality" placeholder="Nationality">
                            @error('nationality')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <i style="margin: 0 0 10px 20px; font-size: 20px; font-weight: bold;">Club/Scocielty</i>
                <div class="row" style="margin: 10px">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <select class="form-control @error('studentclub') is-invalid @enderror" name="studentclub" id="studentclub" placeholder="Father's Name">
                                <option value="">Select a club</option>
                                @if (count($addschool->getclubList($addschool->id)) > 0)
                                    @foreach ($addschool->getclubList($addschool->id) as $club)
                                        <option value="{{$club->id}}">{{$club->clubname}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('studentclub')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <i style="margin: 0 0 10px 20px; font-size: 20px; font-weight: bold;">Guadian details</i>
                <div class="row" style="margin: 10px">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <input type="text" class="form-control @error('fathersname') is-invalid @enderror" value="{{ old('fathersname') }}"  name="fathersname" id="fathersname" placeholder="Father's Name">
                            @error('fathersname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <input type="number" class="form-control @error('fathersphonenumber') is-invalid @enderror" name="fathersphonenumber" value="{{ old('fathersphonenumber') }}" id="fathersphonenumber" placeholder="Father's Phonenumber">
                            @error('fathersphonenumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>invalid phone number</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <input type="text" class="form-control @error('mothersname') is-invalid @enderror" name="mothersname" value="{{ old('mothersname') }}" id="mothersname" placeholder="Mother's Name">
                            @error('mothersname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <input type="number" class="form-control @error('mothersphonenumber') is-invalid @enderror" name="mothersphonenumber" value="{{ old('mothersphonenumber') }}" id="mothersphonenumber" placeholder="Mother's Phonenumber">
                            @error('mothersphonenumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>invalid phone number</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <i style="margin: 0 0 10px 20px; font-size: 20px; font-weight: bold;">Address</i>
                <div class="row" style="margin: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="studentaddress_sec" class="form-control @error('studentaddress_sec') is-invalid @enderror" id="studentaddress_sec" cols="30" rows="3">{{ old('studentaddress_sec') }}</textarea>
                            @error('studentaddress_sec')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <button class="btn btn-sm btn-info" style="margin: 0 0 10px 20px;">Submit</button>
            </form>

        </div>
        
        
        <!--admin create account for student-->
        
        <!-- Central Modal Small -->
        <div class="modal fade" id="addstudentmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
        
          <!-- Change class .modal-sm to change the size of the modal -->
          <div class="modal-dialog modal-lg" role="document">
        
        
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title w-100" id="myModalLabel">Modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="addstudent_modal" action="/add_astudent_modal" method="POST">
                    @csrf
                    <div class="row" style="margin: 10px;">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>firstname</label>
                                <input type="text" name="modalfirstname" id="modalfirstname" class="form-control form-control-sm" placeholder="firstname">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>middlename</label>
                                <input type="text" name="modalmiddlename" id="modalmiddlename" class="form-control form-control-sm" placeholder="middlename">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>lastname</label>
                                <input type="text" name="modallastname" id="modallastname" class="form-control form-control-sm" placeholder="lastname">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <Select class="form-control form-control-sm @error('studentgender') is-invalid @enderror" name="studentgendermodal" id="studentgendermodal">
                                <option value="">Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </Select>
                            @error('studentgender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <Select class="form-control form-control-sm @error('studentreligion') is-invalid @enderror" name="studentreligionmodal" id="studentreligionmodal">
                                <option value="">Select religion</option>
                                <option value="Christian">Christian</option>
                                <option value="Islam">Islam</option>
                                <option value="Other">Other</option>
                            </Select>
                            @error('studentreligion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <input type="date" class="form-control form-control-sm @error('dateofbirth') is-invalid @enderror" name="dateofbirthmodal" id="dateofbirthmodal">
                            @error('dateofbirth')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <Select class="form-control form-control-sm @error('bloodgroup') is-invalid @enderror" name="bloodgroupmodal" id="bloodgroupmodal">
                                <option value="">Select blood group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </Select>
                            @error('bloodgroup')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <Select class="form-control form-control-sm @error('studenthouse') is-invalid @enderror" name="studenthousemodal" id="studenthousemodal">
                                <option value="">Select house</option>
                                @if (count($addschool->gethouseList($addschool->id)) > 0)
                                    @foreach ($addschool->gethouseList($addschool->id) as $house)
                                        <option value="{{$house->id}}">{{$house->housename}}</option>
                                    @endforeach
                                @endif
                            </Select>
                            @error('studenthouse')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <input type="text" class="form-control form-control-sm @error('nationality') is-invalid @enderror" name="nationalitymodal" value="{{ old('nationality') }}" id="nationalitymodal" placeholder="Nationality">
                            @error('nationality')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <i style="margin: 0 0 10px 20px; font-size: 20px; font-weight: bold;">Club/Scocielty</i>
                <div class="row" style="margin: 10px">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <select class="form-control form-control-sm @error('studentclub') is-invalid @enderror" name="studentclubmodal" id="studentclubmodal" placeholder="Father's Name">
                                <option value="">Select a club</option>
                                @if (count($addschool->getclubList($addschool)) > 0)
                                    @foreach ($addschool->getclubList($addschool) as $club)
                                        <option value="{{$club->id}}">{{$club->clubname}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('studentclub')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                
                <i style="margin: 0 0 10px 20px; font-size: 20px; font-weight: bold;">Guadian details</i>
                <div class="row" style="margin: 10px">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <input type="text" class="form-control form-control-sm @error('fathersname') is-invalid @enderror" value="{{ old('fathersname') }}"  name="fathersnamemodal" id="fathersnamemodal" placeholder="Father's Name">
                            @error('fathersname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <input type="number" class="form-control form-control-sm @error('fathersphonenumber') is-invalid @enderror" name="fathersphonenumbermodal" value="{{ old('fathersphonenumber') }}" id="fathersphonenumbermodal" placeholder="Father's Phonenumber">
                            @error('fathersphonenumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>invalid phone number</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <input type="text" class="form-control form-control-sm @error('mothersname') is-invalid @enderror" name="mothersnamemodal" value="{{ old('mothersname') }}" id="mothersnamemodal" placeholder="Mother's Name">
                            @error('mothersname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="exampleInputEmail1">Subject Code</label> --}}
                            <input type="number" class="form-control form-control-sm @error('mothersphonenumber') is-invalid @enderror" name="mothersphonenumbermodal" value="{{ old('mothersphonenumber') }}" id="mothersphonenumbermodal" placeholder="Mother's Phonenumber">
                            @error('mothersphonenumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>invalid phone number</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                
                <i style="margin: 0 0 10px 20px; font-size: 20px; font-weight: bold;">Address</i>
                <div class="row" style="margin: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="studentaddress_secmodal" class="form-control form-control-sm @error('studentaddress_sec') is-invalid @enderror" id="studentaddress_secmodal" cols="30" rows="3">{{ old('studentaddress_sec') }}</textarea>
                            @error('studentaddress_sec')
                                <span class="invalid-feedback" role="alert">
                                    <strong>required feild</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                
                    
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="checkForm()">Save changes</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Central Modal Small -->




  
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
        document.getElementById('studentsmain').className = "nav-link active"
        document.getElementById('studentsmainadd').className = "nav-link active"
      }
      
      function checkForm(){
          
          var idarray = ["studentgendermodal", "studentreligionmodal", "dateofbirthmodal", "bloodgroupmodal", "studenthousemodal", "nationalitymodal", "studentaddress_secmodal", "mothersphonenumbermodal", "fathersphonenumbermodal", "mothersnamemodal", "fathersnamemodal", "studentclubmodal", "modalfirstname", "modalmiddlename", "modallastname"];
          
          var errorCheck = 0;
          
        for (let index = 0; index < idarray.length; index++) {
            const element = idarray[index];
            
            var studentGender = document.getElementById(element).value.trim(); //studentreligionmodal
            if(studentGender == ""){
                document.getElementById(element).style.backgroundColor = "#F59C90";
                errorCheck = 1;
            }else{
                 document.getElementById(element).style.backgroundColor = "#EEF0F0";
                 errorCheck =0
            }
        }
        
        if(errorCheck == 0){
            document.getElementById("addstudent_modal").submit();
        }
        
          
          

      }
      
      function submitForm(){
          
      }
  </script>
    
@endsection