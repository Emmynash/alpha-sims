@extends('layouts.app')

@section('content')




<div class="container-fluid">
    <div class="row h-100" style="height: 100%;">
        <div class="col-12 col-md-12 h-100" style="margin: 0 auto;">
            <br>
            <br>
            <div style="display: flex; align-items: center; justify-content: center;">
                <p class="h4 mb-4">{{ app('currentTenant')->name }}</p>
            </div>
           <div class="card login-card">
                <!-- Default form login -->
                <form class="text-center border border-light p-3" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <p class="h4 mb-4">Reset Password</p>
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <input id="email" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" type="text" placeholder="Enter registered email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Sign in button -->
                    <button class="btn btn-info btn-block my-4" type="submit" style="color: #fff;">Send Link</button>

                    <!-- Register -->
                    <p>
                        <a href="/login">I Just remembered</a>
                    </p>

                </form>
                <!-- Default form login -->
            </div>
            
            </div>
      </div>
</div>

























<!--{{-- <div class="container">-->
<!--    <div class="row justify-content-center">-->
<!--        <div class="col-md-8">-->
<!--            <div class="card">-->
<!--                <div class="card-header">{{ __('Reset Password') }}</div>-->

<!--                <div class="card-body">-->
<!--                    @if (session('status'))-->
<!--                        <div class="alert alert-success" role="alert">-->
<!--                            {{ session('status') }}-->
<!--                        </div>-->
<!--                    @endif-->

<!--                    <form method="POST" action="{{ route('password.email') }}">-->
<!--                        @csrf-->

<!--                        <div class="form-group row">-->
<!--                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>-->

<!--                            <div class="col-md-6">-->
<!--                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>-->

<!--                                @error('email')-->
<!--                                    <span class="invalid-feedback" role="alert">-->
<!--                                        <strong>{{ $message }}</strong>-->
<!--                                    </span>-->
<!--                                @enderror-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="form-group row mb-0">-->
<!--                            <div class="col-md-6 offset-md-4">-->
<!--                                <button type="submit" class="btn btn-primary">-->
<!--                                    {{ __('Send Password Reset Link') }}-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div> --}}-->
@endsection
