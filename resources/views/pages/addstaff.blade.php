@extends('layouts.app_dash')

@section('content')

@include('layouts.asideside')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

      
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Staff</h1>
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

            @include('layouts.message')

            <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">
            {{-- <h4 style="padding-top: 10px;">Class Allocation Details</h4> --}}
            <div class="row">
              <div class="col-md-6">
                    <form id="addstaff" method="POST" action="javascript:console.log('submitted');">
                        @csrf
                            <div class="form-group">
                                <label for="teacherRegNoConfirm">System Number</label>
                                <input id="teacherRegNoConfirm" name="systemnumber" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="number" placeholder="Temporary Registration No">
                            </div>
                            <div id="staffconfirmprocess" style="display: none;" class="spinner-border"></div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            
                    

                        </div>
                        <!-- /.col -->
                        </div>
                        <br>

                        
                    </form>
                        <!-- /.row -->
                        <button type="button" class="btn btn-info" id="addstaffbtn">Submit</button>

                        <!-- The Modal -->
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                <h4 class="modal-title">Account Details</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="staffmodal" style="display: flex; flex-direction: column; align-items: center;">
                                        <div class="card" style="height: 100px; width: 100px; display: flex; align-items: center; justify-content: center;">
                                            {{-- <div id="profilepix" class="spinner-border" style="opacity: 0.5; width: 50px; height: 50px;"></div> --}}
                                            <img id="profileuploaded" style="display: none;" src="" class="img-circle elevation-2" alt="" width="70px" height="70px">
                                        </div>
                                        <br>
                                        <div class="card" style="width: 95%; height: 150px;">
                                            <label for="" style="padding-left: 5px;">FirstName: <i id="firstnamemain"></i></label>
                                            <label for="" style="padding-left: 5px;">MiddleName: <i id="middlenamemain"></i></label>
                                            <label for="" style="padding-left: 5px;">LastName: <i id="lastnamemain"></i></label>
                                            <form action="{{ route('addstaffrecord') }}" method="post" style="width: 95%; margin: 0 auto;" id="rolealocationform">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="Selectrole">Select a role</label>
                                                    <select name="SelectRole" class="form-control" id="Selectrole">
                                                        <option value="">Select Role</option>
                                                        @if ($roles->count() > 0)
                                                            @foreach ($roles as $item)
                                                                @if ($item->name != "Student" && $item->name != "Teacher" && $item->name != "Librarian")
                                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                                @endif
                                                                
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <input name="staffid" type="hidden" id="staffid">
                                            </form>

                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-success" form="rolealocationform">submit</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                                </div>
                                
                            </div>
                            </div>
                        </div>
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
        document.getElementById('managestaffaside').className = "nav-link active"
    }
</script>
    
@endsection