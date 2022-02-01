@extends($schooldetails->schooltype == "Primary" ? 'layouts.app_dash' : 'layouts.app_sec')

@section('content')

@if ($schooldetails->schooltype == "Primary")
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
            <h1 class="m-0 text-dark">psychomotor</h1>
            <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Psychomotor"
                data-content="On this module, you are required to fill out phychomoto for all students in each class. this is required for result generation">Need help?</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">psychomotor</li>
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
          <div id="spinnermotoprocess" style="position: absolute; top: 0; bottom: 0; right: 0; left: 0; display: none; align-items: center; justify-content: center; z-index: 999;">
            <div class="spinner-border" style="width: 100px; height: 100px;"></div>
          </div>

            <form id="" action="{{ route('add_setting_moto') }}" method="POST">
              @csrf

              <div class="row" style="margin: 10px 10px 0px 10px">
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="">Enter Psycomoto value</label>
                          <input type="text" class="form-control form-control-sm" name="name" placeholder="enter value">
                      </div>
                  </div>
              </div>

              <div class="row" style="margin: 0px 10px 0px 10px">
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="">Select Category</label>
                          <select name="category" class="form-control form-control-sm" name="" id="">
                            <option value="">Select an option</option>
                            <option value="behaviour">Behaviour</option>
                            <option value="skills">Skills</option>
                          </select>
                      </div>
                  </div>
              </div>

                <button type="submit" style="margin:0 0 10px 20px;" id="" class="btn btn-sm btn-info">Add</button>

            </form>


            <div class="text-center">
                <i style="font-size: 20px; font-weight: bold;">Psycomotor Record</i>
            </div>
            <br>
            <div class="row" style="margin: 10px;">

                @if ($addmoto->count() < 1)
                    <div class="col-md-4 col-12 card">
                        <p>No record Added</p>
                    </div>
                @else
                    @foreach ($addmoto as $moto)
                        <div class="col-md-4 col-12">
                            <div class="card" style="border-radius: 0px; border-left: 10px solid green;">
                                <p style="padding-left: 10px;">{{ $moto->name }}</p>
                                {{-- <i style="position: absolute; top:0; right: 0; bottom: 0; border-radius: 5px; color: #fff; background-color: red; padding: 5px;" class="">x</i> --}}
                            </div>
                        </div>
                    @endforeach
                @endif



                
            </div>


        </div>
                
        
        
    




  
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
        document.getElementById('psyhcomoto').className = "nav-link active"
        document.getElementById('psyhcomotosettings').className = "nav-link active"
      }

      function takemoto(regno, userid, firstname, middlename, lastname){
        $('#modalmoto').modal('show');

        document.getElementById('systemnumber').value = userid;
        document.getElementById('regno').value = regno;
        document.getElementById('term').value = document.getElementById('selectedtermmoto').value;

        document.getElementById('modalnamemoto').innerHTML = firstname+" "+middlename+" "+lastname
      }
  </script>
    
@endsection