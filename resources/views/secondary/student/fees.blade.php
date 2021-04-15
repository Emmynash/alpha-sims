@extends('layouts.app_sec')

@section('content')

@include('layouts.aside_sec')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Fee Payment</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Fee Payment</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
    </section>

    <section class="content">
    <!-- /.row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Active Invoice</h3>

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
                    <th>ID</th>
                    <th>Payment Category</th>
                    <th>Amount</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($schoolData->count() < 1)
                        
                    @else
                    @php $count = method_exists($schoolData, 'links') ? 1 : 0; @endphp
                        @foreach ($schoolData as $item)
                        @php $count = method_exists($schoolData, 'links') ? ($schoolData ->currentpage()-1) * $schoolData ->perpage() + $loop->index + 1 : $count + 1; @endphp
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $item->categoryname }}</td>
                                <td>₦{{ $item->amount }}</td>
                                <td><i class="fas fa-ban"></i></td>
                            </tr>
                        @endforeach
                        
                    @endif

                </tbody>
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Total</td>
                        <td>₦{{ $sumAmount }}</td>
                    </tr>
                </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            </div>
              <div class="alert alert-info">
                    <strong>Info!</strong> Click the button below to make payment...
              </div>
            <!-- /.card -->
            <form action="{{ route('make_payment') }}" method="post">
                @csrf
                <input type="hidden" name="amount" value="{{ $sumAmount }}" >
                <button class="btn btn-success btn-sm">Pay...</button>
            </form>
            
        </div>
        </div>
        <!-- /.row -->
    </section>
</div>

@endsection