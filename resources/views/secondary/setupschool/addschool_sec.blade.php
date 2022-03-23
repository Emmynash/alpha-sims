@extends($userschool->schooltype == "Primary" ? 'layouts.app_dash' : 'layouts.app_sec')

@section('content')

@if ($userschool->schooltype == "Primary")
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
            <h1 class="m-0 text-dark">Add institution</h1>
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

          @include('layouts.message')

        <!-- /.row -->
        <div class="row">
          <div class="col-12">

            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Status</h3>

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
                      <th>School Id</th>
                      <th>Email</th>
                      <th>Phone Number</th>
                      <th>Active From</th>
                      <th>End On</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    

                      <tr>
                        <td>AS-{{$userschool->id}}</td>
                        <td>{{$userschool->schoolemail}}</td>
                        <td>{{$userschool->mobilenumber}}</td>
                        <td>{{$userschool->periodfrom}}</td>
                        <td>{{$userschool->periodto}}</td>
                        <td><span class="tag tag-success">{{$userschool->status}}</span></td>
                        <td>
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#updateschooldata"><i class="fa-solid fa-images"></i></button>
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#updateschooldataText"><i class="far fa-edit"></i></button>
                        </td>
                      </tr>

                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="modal" id="updateschooldataText">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Update School Record</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <p style="font-weight: bold;">{{$userschool->schoolname}}</p>
                <div class="row">
                  <div class="col-12 col-6">
                    
                    <form action="{{ route('updateschooldetails', $userschool->id) }}" method="post" enctype="multipart/form-data"> 
                     @csrf                     
                      <div class="form-group">
                        <label for="">School Name</label>
                        <input type="text" name="schoolname" class="form-control" value="{{ $userschool->schoolname }}">
                        <small class="text-danger">{{ $errors->first('schoolname') }}</small>
                      </div>
                      <div class="form-group">
                        <label for="">School Mobile Number</label>
                        <input type="text" name="mobilenumber" class="form-control" value="{{ $userschool->mobilenumber }}">
                        <small class="text-danger">{{ $errors->first('mobilenumber') }}</small>
                      </div>
                      <div class="form-group">
                        <label for="">School Website</label>
                        <input type="text" name="schoolwebsite" class="form-control" value="{{ $userschool->schoolwebsite }}">
                        <small class="text-danger">{{ $errors->first('schoolwebsite') }}</small>
                      </div>
                      <div class="form-group">
                        <label for="">Date established</label>
                        <input type="text" name="dateestablished" class="form-control" value="{{ $userschool->dateestablished }}">
                        <small class="text-danger">{{ $errors->first('dateestablished') }}</small>
                      </div>
                      <div class="form-group">
                        <label for="">School address</label>
                        <input type="text" name="schooladdress" class="form-control" value="{{ $userschool->schooladdress }}">
                        <small class="text-danger">{{ $errors->first('schooladdress') }}</small>
                      </div>
                      <div class="form-group">
                        <label for="">School email</label>
                        <input type="text" name="schoolemail" class="form-control" value="{{ $userschool->schoolemail }}">
                        <small class="text-danger">{{ $errors->first('schoolemail') }}</small>
                      </div>
                      <div class="form-group">
                        {{-- <input type="text" name="mobilenumber" class="form-control @error('mobilenumber') is-invalid @enderror" value="{{old('mobilenumber')}}" placeholder="School Location"> --}}
                        <select name="schoolstate" id="schoolstate" class="form-control" value="{{ $userschool->schoolstate }}">
                            <option value="">Select State</option>
                            <option value="Abia">Abuja FCT</option>
                            <option value="Abia">Abia</option>
                            <option value="Adamawa">Adamawa</option>
                            <option value="AkwaIbom">AkwaIbom</option>
                            <option value="Anambra">Anambra</option>
                            <option value="Bauchi">Bauchi</option>
                            <option value="Bayelsa">Bayelsa</option>
                            <option value="Benue">Benue</option>
                            <option value="Borno">Borno</option>
                            <option value="Cross River">Cross River</option>
                            <option value="Delta">Delta</option>
                            <option value="Ebonyi">Ebonyi</option>
                            <option value="Edo">Edo</option>
                            <option value="Ekiti">Ekiti</option>
                            <option value="Enugu">Enugu</option>
                            <option value="FCT">FCT</option>
                            <option value="Gombe">Gombe</option>
                            <option value="Imo">Imo</option>
                            <option value="Jigawa">Jigawa</option>
                            <option value="Kaduna">Kaduna</option>
                            <option value="Kano">Kano</option>
                            <option value="Katsina">Katsina</option>
                            <option value="Kebbi">Kebbi</option>
                            <option value="Kogi">Kogi</option>
                            <option value="Kwara">Kwara</option>
                            <option value="Lagos">Lagos</option>
                            <option value="Nasarawa">Nasarawa</option>
                            <option value="Niger">Niger</option>
                            <option value="Ogun">Ogun</option>
                            <option value="Ondo">Ondo</option>
                            <option value="Osun">Osun</option>
                            <option value="Oyo">Oyo</option>
                            <option value="Plateau">Plateau</option>
                            <option value="Rivers">Rivers</option>
                            <option value="Sokoto">Sokoto</option>
                            <option value="Taraba">Taraba</option>
                            <option value="Yobe">Yobe</option>
                            <option value="Zamfara">Zamafara</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('schoolstate') }}</small>
                    </div>
                      
                      <button type="submit" class="btn btn-sm btn-info">Save</button>
                    </form>

                  </div>
                  <div class="col-12 col-6">

                  </div>
                </div>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
              </div>

            </div>
          </div>
        </div>
        
        
                <!-- The Modal -->
        <div class="modal" id="updateschooldata">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Update Record</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <p style="font-weight: bold;">{{$userschool->schoolname}}</p>
                <div class="row">
                  <div class="col-12 col-6">
                    
                    <form action="/updatelogosig" method="post" enctype="multipart/form-data"> 
                     @csrf                     
                      <div class="form-group">
                        <label for="">School Logo</label>
                        <input type="file" name="image" class="form-control">
                      </div>
                      <input type="hidden" name="key" value="logo" id="">
                      <button type="submit" class="btn btn-sm btn-info">Save</button>
                    </form>

                    <form action="/updatelogosig" method="post" enctype="multipart/form-data"> 
                      @csrf                      
                      <div class="form-group">
                        <label for="">Principal's Signature</label>
                        <input type="file" name="image" class="form-control">
                      </div>
                      <input type="hidden" name="key" value="signature" id="">
                      <button type="submit" class="btn btn-sm btn-info">Save</button>
                    </form>
                  </div>
                  <div class="col-12 col-6">

                  </div>
                </div>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
              </div>

            </div>
          </div>
        </div>



        </div><!-- /.container-fluid -->
      </section>
  </div>


  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<script>
  function verifyForm(){
    let radioBtn = document.getElementsByName('queryusers');
    let nameinput = document.getElementById('schoolNameInput')
    let schoolEmailInput = document.getElementById('schoolEmailInput')
    let schoolMobileNumber = document.getElementById('schoolMobileNumber')
    let schoolWebsiteInput = document.getElementById('schoolWebsiteInput')
    let schoolDateEstablished = document.getElementById('schoolDateEstablished')
    let schoolAddressInput = document.getElementById('schoolAddressInput')
    let formSubmit = document.getElementById('formSubmit')
    let formVerify = document.getElementById('formVerify')

      if (!radioBtn[0].checked && !radioBtn[1].checked) {
        // alert('fdfdfdfdfdfdf')
      }else if (nameinput.value === "") {
        nameinput.style.border = "0.5px solid red"
      } else if(schoolEmailInput.value === ""){
        schoolEmailInput.style.border = "0.5px solid red"
      }else if(schoolMobileNumber.value === ""){
        schoolMobileNumber.style.border = "0.5px solid red"
      }else if(schoolWebsiteInput.value === ""){
        schoolWebsiteInput.style.border = "0.5px solid red"
      }else if(schoolDateEstablished.value === ""){
        schoolDateEstablished.style.border = "0.5px solid red"
      }else if(schoolAddressInput.value === ""){
        schoolAddressInput.style.border = "0.5px solid red"
      }else{
        formSubmit.style.display = "block"
        formVerify.style.display = "none"
      }
  }

  function scrollocation(){
        document.getElementById('settingsaside').className = "nav-link active"
        document.getElementById('institutionaside').className = "nav-link active"
    }
</script>

<!-- ./wrapper -->

    
@endsection