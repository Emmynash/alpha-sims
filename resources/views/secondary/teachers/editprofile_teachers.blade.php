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
            <h1 class="m-0 text-dark">Profile Edit</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profile edit</li>
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
            <form action="/confirm_edited" method="POST">
                @csrf
                <div class="row" style="margin: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 10px;">FirstName</i>
                        <input type="text" id="firstnameedit" name="firstnameedit" class="form-control @error('firstnameedit') is-invalid @enderror" value="{{Auth::user()->firstname}}">
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px;">MiddleName</i>
                            <input type="text" id="middlenameedit" name="middlenameedit" class="form-control @error('middlenameedit') is-invalid @enderror" value="{{Auth::user()->middlename}}">
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px;">LastName</i>
                            <input type="text" id="lastnameedit" name="lastnameedit" class="form-control @error('lastnameedit') is-invalid @enderror" value="{{Auth::user()->lastname}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 10px;">Email</i>
                            <input type="text" id="emailnameedit" name="emailnameedit" class="form-control @error('emailnameedit') is-invalid @enderror" value="{{Auth::user()->email}}">
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px;">Course of Study</i>
                            <input type="text" name="courseedit" id="courseedit" class="form-control @error('courseedit') is-invalid @enderror" value = "{{ old('courseedit' . $teachersDetails->courseedit, $teachersDetails->courseedit) }}">
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px;">Institution (As it appear on your certificate. will be verified)</i>
                            <input type="text" id="institutionedit" name="institutionedit" class="form-control @error('institutionedit') is-invalid @enderror" value="{{ old('institutionedit' . $teachersDetails->institutionedit, $teachersDetails->institutionedit) }}">
                        </div>

                    </div>
                </div>
                <div class="row" style="margin: 10px">
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 10px;">Gender</i>
                            <select class="form-control @error('genderedit') is-invalid @enderror" id="genderedit" name="genderedit">
                                <option value="">Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px;">Religion</i>
                            <select id="religionedit" name="religionedit" class="form-control @error('religionedit') is-invalid @enderror">
                                <option value="">Select your religion</option>
                                <option value="Christianity">Christianity</option>
                                <option value="Islam">Islam</option>
                                <option value="other">other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px;">Bloodgroup</i>
                            <select id="bloodgroupedit" name="bloodgroupedit" class="form-control @error('bloodgroupedit') is-invalid @enderror" type="text" placeholder="Blood group">
                                <option value="">Choose blood group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                            @error('bloodgroupedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 10px;">Class of Degree</i>
                            <input type="text" id="degreeedit" name="degreeedit" class="form-control @error('degreeedit') is-invalid @enderror" value="{{ old('degreeedit' . $teachersDetails->degreeedit, $teachersDetails->degreeedit) }}">
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px;">Level of Education (BSC, etc...)</i>
                            <input id="educationedit" name="educationedit" class="form-control @error('educationedit') is-invalid @enderror" value="{{ old('educationedit' . $teachersDetails->educationedit, $teachersDetails->educationedit) }}" type="text" placeholder="Level of Education">
                            @error('educationedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <i style="font-size: 10px;">Year of Graduation</i>
                            <input id="graduationedit" name="graduationedit" class="form-control @error('graduationedit') is-invalid @enderror" value="{{ old('graduationedit' . $teachersDetails->graduationedit, $teachersDetails->graduationedit) }}" type="number" placeholder="Year of Graduation">
                            @error('graduationedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="row" style="margin: 10px;">
                    <div class="col-md-6">

                        <div class="form-group">
                            <i style="font-size: 10px;">Date of Birth</i>
                            <input id="birthedit" name="birthedit" class="form-control @error('birthedit') is-invalid @enderror" value="{{ old('birthedit' . $teachersDetails->birthedit, $teachersDetails->birthedit) }}" type="date" placeholder="Date of Birth">
                            @error('birthedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 10px;">Residential Addrress</i>
                            <textarea name="addressedit" class="form-control @error('addressedit') is-invalid @enderror" type="text" placeholder="Residential address">{{ old('addressedit' . $teachersDetails->residentialaddress, $teachersDetails->residentialaddress) }}</textarea>
                            @error('addressedit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>feild is required</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <input type="hidden" name="entryid" value="{{$teachersDetails->id}}">
                <input type="hidden" id="dateofbirth" value="{{$teachersDetails->dob}}">
                <input type="hidden" id="genderdecoy" value="{{$teachersDetails->gender}}">
                <input type="hidden" id="religiondecoy" value="{{$teachersDetails->religion}}">
                <input type="hidden" id="bloodgroupdecoy" value="{{$teachersDetails->bloodgroup}}">
              
                <div class="row" style="margin: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 10px;">Passport</i>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" name="passportedit" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text" id="">Upload</span>
                              </div>
                            </div>
                          </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-size: 10px;">Signature</i>
                            <div class="input-group">
                              <div class="custom-file">
                                <input name="signatureedit" type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text" id="">Upload</span>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
                <button class="btn btn-sm btn-info" style="margin: 10px;">Submit</button>
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
        document.getElementById('teacheredit').className = "nav-link active"
        document.getElementById('birthedit').value = document.getElementById('dateofbirth').value
        document.getElementById('genderedit').value = document.getElementById('genderdecoy').value
        document.getElementById('bloodgroupedit').value = document.getElementById('bloodgroupdecoy').value
        document.getElementById('religionedit').value = document.getElementById('religiondecoy').value
   
    }
</script>
    
@endsection