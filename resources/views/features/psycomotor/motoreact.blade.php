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
          <h1 class="m-0 text-dark">Psychomotor</h1>
          <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Psychomotor" data-content="On this module, you are required to fill out phychomoto for all students in each class. this is required for result generation">Need help?</button>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">psychomotor</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
      <center>
        <div style="width: 95%; margin: 3px auto;">
          <i style="font-size: 15px; font-style: normal;">Excellent = <b>5</b>,</i>
          <i style="font-size: 15px; font-style: normal;">Very good = <b>4</b>,</i>
          <i style="font-size: 15px; font-style: normal;">Good = <b>3</b>,</i>
          <i style="font-size: 15px; font-style: normal;">Average = <b>2</b>,</i>
          <i style="font-size: 15px; font-style: normal;">Fair = <b>1</b></i>
        </div>
      </center>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid" id="addmotoroot">


      <div class="text-center">
        <div class="spinner-border"></div>
      </div>

    </div><!-- /.container-fluid -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="{{ asset('js/appmoto.js?v=9') }}"></script>

<script>
  function scrollocation() {
    document.getElementById('psyhcomoto').className = "nav-link active"
  }
</script>

@endsection