@extends($schoolDetails->schooltype == "Primary" ? 'layouts.app_dash' : 'layouts.app_sec')

@section('content')

@if ($schoolDetails->schooltype == "Primary")
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
              <h1 class="m-0 text-dark">Payment Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Payment Details</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <section class="content">
        <div class="container-fluid">

            @include('layouts.message')

            <div class="card">
                <form action="{{ route('add_details') }}" method="post">
                    @csrf
                    <div class="row" style="margin: 10px;">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Paystack Public key</label>
                                <input type="text" value="{{ $schoolDetails->getPaymentDetails == null ? "":$schoolDetails->getPaymentDetails->paystack_pk }}" name="paystack_pk" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label for="">Paystack Payment Url</label>
                                <input type="text" value="{{ $schoolDetails->getPaymentDetails == null ? "":$schoolDetails->getPaymentDetails->paystack_payment_url }}" name="paystack_payment_url" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Paystack Secret key</label>
                                <input type="text" value="{{ $schoolDetails->getPaymentDetails == null ? "":$schoolDetails->getPaymentDetails->paystack_sk }}" name="paystack_sk" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label for="">Merchant Email</label>
                                <input type="text" value="{{ $schoolDetails->getPaymentDetails == null ? "":$schoolDetails->getPaymentDetails->merchant_url }}" name="merchant_url" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-info btn-sm">Save</button>
                        </div>
                    </div>
                    
                </form>
                <a href="{{ route('make_payment') }}">pay</a>
            </div>
        </div>
      </section>

</div>

@endsection