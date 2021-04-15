@extends('layouts.app_dash')

@section('content')


  <!-- Main Sidebar Container -->
  @include('layouts.asideside')

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
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#updateschooldata"><i class="far fa-eye"></i></button>
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
                        <input type="file" name="schoolLogo" class="form-control">
                      </div>
                      <input type="hidden" name="logo" value="logo" id="">
                      <button type="submit" class="btn btn-sm btn-info">Save</button>
                    </form>

                    <form action="/updatelogosig" method="post" enctype="multipart/form-data"> 
                      @csrf                      
                      <div class="form-group">
                        <label for="">School Logo</label>
                        <input type="file" name="schoolprincipalsignature" class="form-control">
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



        </div><!-- /.container-fluid -->
      </section>
  </div>


  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">Brytosoft</a>.</strong>
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