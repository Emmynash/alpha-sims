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
            <h1 class="m-0 text-dark">Manage Staff</h1>
            <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Manage Staff"
                data-content="On this module, you are required to allocate roles to different Staff in your school.">Need help?</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Manage staff</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="card" style="height: 200px; border-top: 2px solid #0B887C;">
            <div class="row" style="margin: 10px;">
                <div class="col-md-4">
                    <i style="font-size: 13px; font-style: normal;">Enter staff regno for role allocation</i>
                    <form id="addroleform" action="javascript:console.log('submited')" method="post">
                        @csrf
                        <div class="form-group" style="display: flex; flex-dirextion: row;">
                            <button style="border: none; background: transparent; border-top: 1px solid rgb(206, 201, 201); border-bottom: 1px solid rgb(206, 201, 201); border-left: 1px solid rgb(206, 201, 201);" disabled><i class="fas fa-users"></i></button>
                            <input name="staffregnorole" style="border-radius: 0px;" placeholder="Enter staff system no." type="text" step="border-radius: 0px;" class="form-control form-control-sm">
                        </div>
                        <div>
                        
                        </div>
                        <button id="addrolebtn" class="btn btn-sm btn-info">Query</button>
                        <div id="spinnerroleallocation" style="display: none;">
                            <div class="spinner-border"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Button trigger modal -->
        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addrolequery">
            Launch demo modal
        </button> --}}
        
        <!-- Central Modal Small -->
        <div class="modal fade" id="addrolequery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
        
            <!-- Change class .modal-sm to change the size of the modal -->
            <div class="modal-dialog modal-sm" role="document">
        
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title w-100" id="myModalLabel">Allocate Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div style="display: flex; align-items: center; justify-content: center;">
                        <img id="allocateroleimg" src="https://cdn.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png" class="rounded-circle" alt="Cinque Terre" width="70px" height="auto">
                    </div>
                    <div style="display: none;" id="spinnerallocaterolemain" class="spinner-border"></div>
                    <br>
                    <div class="text-center">
                        <i style="font-style: normal; font-size: 14px;" id="fullnamerole"></i>
                    </div>
                    <br>
                    <div>
            
                        <form id="allocateroleform" action="javascript:console.log('submitted')" method="post">
                            @csrf
                            <input type="hidden" id="systemnumberrole" name="systemnumberrole">
                            <div class="form-group" style="display: flex; flex-dirextion: row;">
                                <button style="border: none; background: transparent; border-top: 1px solid rgb(206, 201, 201); border-bottom: 1px solid rgb(206, 201, 201); border-left: 1px solid rgb(206, 201, 201);" disabled><i class="fas fa-users"></i></button>
                                <select name="roleselect" id="roleselect" class="form-control form-control-sm" style="border-radius: 0px;">
                                    <option value="">Select a role</option>
                                    @foreach ($role as $item)
                                      @if ($item->name != "Student" && $item->name != "Teacher")
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                      @endif
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
                <button id="allocaterolebtn" type="button" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <script>
      function scrollocation(){
        document.getElementById('managestaffscroll').className = "nav-link active"
      }
  </script>
    
@endsection