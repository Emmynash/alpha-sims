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
            <h1 class="m-0 text-dark">My Profile</h1>
            {{-- <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Addsubjects"
                data-content="On this module, you are required to enter all subjects offered by your school according to the classes you have.">Need help?</button> --}}
                    
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">My profile</li>
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
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card">
                  <div class="text-center" style="margin: 5px;">
                    <img id="profileimgmainpix" src="{{Auth::user()->profileimg == NULL ? "https://cdn.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png":Auth::user()->profileimg}}" class="img-circle elevation-2" alt="User Image" height="150px" width="150px">
                  </div>
                  
                </div>
                <div class="card">
                  <div style="margin: 10px;">
                    <form action="/updatelogosig" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group" style="display: flex; align-item: center; justify-content: center;">
                        <div class="file-input">
                          <input type="file" name="image" id="" class="">
                          <input type="hidden" name="key" value="profile" id="">
                          </label>
                        </div>
                      </div>
                      <button class="btn btn-sm btn-info" style="margin: 0 10px 10px 10px;">upload pix</button>
                    </form>
                    
                  </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
              {{-- @if (Auth::user()->hasAnyRole(['Admin', 'HeadOfSchool'])) --}}

              <div class="card">
                <form action="{{ route('updateprofile') }}" method="post" id="updatenames">
                    @csrf
                    <div class="row" style="margin: 10px;">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" name="firstname" value="{{ Auth::user()->firstname }}" placeholder="firstname">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" name="middlename" value="{{ Auth::user()->middlename }}" placeholder="middlename">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" name="lastname" value="{{ Auth::user()->lastname }}" placeholder="lastname">
                            </div>
                        </div>
                    </div>
                    {{-- <div style="margin: 10px;">
                        <textarea name="" class="form-control form-control-sm" id="" cols="30" rows="5" placeholder="Address"></textarea>
                    </div>
                    <div class="row" style="margin: 10px;">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control form-control-sm" placeholder="contact">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <input type="date" class="form-control form-control-sm" placeholder="Date of birth">
                            </div>
                        </div>
                    </div> --}}
                </form>
                <div class="card-footer">
                  <div class="form-group">
                    <button class="btn btn-sm btn-info" type="submit" form="updatenames">Save</button>
                  </div>
                </div>
            </div>

            <div class="card">
              <div class="card-header">
                <h5>Update Password</h5>
              </div>
              <div class="body">
                <form action="{{ route('updatepassword') }}" method="post" style="margin: 10px;" id="updatepassword">
                  @csrf
                  <div class="form-group">
                    <input type="password" name="currentpassword" class="form-control" id="" placeholder="current password" required>
                  </div>
                  <div class="form-group">
                    <input type="password" name="newpassword" class="form-control" id="" placeholder="New password" required>
                  </div>
                  <div class="form-group">
                    <input type="password" name="repeatpassword" class="form-control" id="" placeholder="Repeat Password" required>
                  </div>
                </form>
              </div>
              <div class="card-footer">
                <div class="form-group">
                  <button class="btn btn-sm btn-info" type="submit" form="updatepassword">Save</button>
                </div>
              </div>
            </div>
                  
              {{-- @elseif (Auth::user()->hasAnyRole(['Teacher']))

              @elseif (Auth::user()->hasAnyRole(['Student']))

              @elseif (Auth::user()->hasAnyRole(['Bursar']))

              @endif --}}
                
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

@endsection



@push('custom-style-head')
  <style>

      .file {
        opacity: 0;
        width: 0.1px;
        height: 0.1px;
        position: absolute;
      }

      .file-input label {
        display: block;
        position: relative;
        width: 200px;
        height: 50px;
        border-radius: 25px;
        background: linear-gradient(40deg,#ff6ec4,#7873f5);
        box-shadow: 0 4px 7px rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        transition: transform .2s ease-out;
      }

      .file-name {
        position: absolute;
        bottom: -35px;
        left: 10px;
        font-size: 0.85rem;
        color: #555;
      }

      input:hover + label,
      input:focus + label {
        transform: scale(1.02);
      }

      /* Adding an outline to the label on focus */
      input:focus + label {
        outline: 1px solid #000;
        outline: -webkit-focus-ring-color auto 2px;
      }
    
  </style>
@endpush

@push('custom-script')
  <script>
    function scrollocation(){
      document.getElementById('managestaffscroll').className = "nav-link active"
    }
  </script>
@endpush

@push('custom-script-head')

<script>


</script>
    
@endpush