@extends($schooldetails->schooltype == "Primary" ? 'layouts.app_dash' : 'layouts.app_sec')

@section('content')

@if ($schooldetails->schooltype == "Primary")
@include('layouts.asideside') 
@else
  @include('layouts.aside_sec')
@endif


    <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Student With Discount</h1>
        
                        <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                        
                        <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Summary"
                        data-content="View the financial runnings of your school at a glance.">Need help?</button>
        
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Student With Discount</li>
                    </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->



            <div class="container-fluid" id="studentdiscountroot">

                <div class="text-center">
                    <div class="spinner-border"></div>
                </div>
               
            </div>
    </div>

    <script src="{{ asset('js/app_discount.js') }}"></script>
    
@endsection