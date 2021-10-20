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
            <h1 class="m-0 text-dark">Payment Setup</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Payment Setup"
                data-content="Setup school fees categories and amount ">Need help?</button>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Payment Setup</li>
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


        <div class="card" style="height: 200px; border-top: 2px solid #0B887C;">

                  <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><button class="btn btn-sm btn-info" data-toggle="modal" data-target="#addpaymentcategory"><i class="far fa-plus-square"></i> Add Payment Category</button></h3>

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
                      <th>id</th>
                      <th>Category Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                        @if ($schooldetails->getPaymentCategory->count() < 1)
                        <tr>
                            <td></td>
                            <td><center>No Record</center></td>
                            <td></td>
                        </tr>
                        @else
                        @php $count = method_exists($schooldetails->getPaymentCategory, 'links') ? 1 : 0; @endphp
                            @foreach ($schooldetails->getPaymentCategory as $item)
                            @php $count = method_exists($schooldetails->getPaymentCategory, 'links') ? ($schooldetails->getPaymentCategory ->currentpage()-1) * $schooldetails->getPaymentCategory ->perpage() + $loop->index + 1 : $count + 1; @endphp
                                <tr>
                                    <td>{{ $count }}</td>
                                    <td>{{ $item->categoryname }}</td>
                                    <td><button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editcategoryname{{ $item->id }}"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletecategoryname{{ $item->id }}"><i class="fas fa-trash"></i></button></td>
                                      
                                      <!-- The Modal -->
                                        <div class="modal fade" id="editcategoryname{{ $item->id }}">
                                            <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                            
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h6 class="modal-title">Update Category Name</h6>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                <form action="{{ route('update_category', $item->id) }}" method="post" id="updatepaymentform{{ $item->id }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="">Payment Category <i style="font-size: 9px; font-style: normal;">eg.PTA fees</i></label>
                                                        <input type="text" value="{{ $item->categoryname }}" name="paymentcategoryform" class="form-control form-control-sm" placeholder="enter a value">
                                                    </div>
                                                </form>
                                                </div>
                                                
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                <button form="updatepaymentform{{ $item->id }}" class="btn btn-sm btn-info">Proceed</button>
                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                                </div>
                                                
                                            </div>
                                            </div>
                                        </div>

                                        <!-- The Modal -->
                                        <div class="modal fade" id="deletecategoryname{{ $item->id }}">
                                          <div class="modal-dialog modal-sm">
                                          <div class="modal-content">
                                          
                                              <!-- Modal Header -->
                                              <div class="modal-header">
                                              <h6 class="modal-title">Delete Record</h6>
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              </div>
                                              
                                              <!-- Modal body -->
                                              <div class="modal-body">
                                                <p>Note: Process cannot be reverted. Proceed with caution</p>
                                                <p>Delete Category {{ $item->categoryname }}?</p>
                                              <form action="{{ route('deletepaymentcategory', $item->id) }}" method="post" id="deletepaymentform{{ $item->id }}">
                                                  @csrf

                                              </form>
                                              </div>
                                              
                                              <!-- Modal footer -->
                                              <div class="modal-footer">
                                              <button form="deletepaymentform{{ $item->id }}" class="btn btn-sm btn-info">Proceed</button>
                                              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                              </div>
                                              
                                          </div>
                                          </div>
                                      </div>
                                </tr>
                            @endforeach
                            
                        @endif

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->

        <br>
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"><button class="btn btn-sm btn-info" data-toggle="modal" data-target="#addpaymentcategoryprice"><i class="far fa-plus-square"></i> Add Payment Category Amount</button></h3>
  
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
                        <th>id</th>
                        <th>Category Name</th>
                        <th>Class Name</th>
                        <th>Amount</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                          @if ($schooldetails->getAmountCategory->count() < 1)
                          <tr>
                              <td></td>
                              <td><center>No Record</center></td>
                              <td></td>
                              
                          </tr>
                          @else
                          @php $count = method_exists($schooldetails->getAmountCategory, 'links') ? 1 : 0; @endphp
                              @foreach ($schooldetails->getAmountCategory as $item)
                              @php $count = method_exists($schooldetails->getAmountCategory, 'links') ? ($schooldetails->getAmountCategory ->currentpage()-1) * $schooldetails->getAmountCategory ->perpage() + $loop->index + 1 : $count + 1; @endphp
                                  <tr>
                                      <td>{{ $count }}</td>
                                      <td>{{ $schooldetails->getCategoryName($item->payment_category_id)->categoryname }}</td>
                                      <td>{{ $schooldetails->schooltype == "Primary" ? $schooldetails->getClassName($item->class_id)->classnamee:$schooldetails->getClassName($item->class_id)->classname }}</td>
                                      <td>{{ $item->amount }}</td>
                                      <td><button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editamountrecord{{ $item->id }}"><i class="fas fa-edit"></i></button> 
                                        {{-- <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#editclassname"><i class="fas fa-trash"></i></button> --}}
                                      </td>
                                        <!-- The Modal -->
                                          <div class="modal fade" id="editamountrecord{{ $item->id }}">
                                              <div class="modal-dialog modal-sm">
                                              <div class="modal-content">
                                              
                                                  <!-- Modal Header -->
                                                  <div class="modal-header">
                                                  <h6 class="modal-title">Update payment Category</h6>
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  </div>
                                                  
                                                  <!-- Modal body -->
                                                  <div class="modal-body">
                                                    <form action="{{ route('updatepaymentamount', $item->id) }}" method="post" id="update_payment_category_form_amount{{ $item->id }}">
                                                      @csrf
                                                      {{-- <div class="form-group">
                                                          <label for="">Payment Category <i style="font-size: 9px; font-style: normal;">eg.PTA fees</i></label>
                                                          <select name="paymentcategoryform" id="" class="form-control form-control-sm">
                                                              <option value="">Select a category</option>
                                                              @foreach ($schooldetails->getPaymentCategory as $itemcat)
                                                                  <option value="{{ $itemcat->id }}" {{ $itemcat->id == $item->payment_category_id ? "selected":"" }}>{{ $itemcat->categoryname }}</option>
                                                              @endforeach
                                                          </select>
                                                      </div> --}}
                                                      <div class="form-group">
                                                          <label for="">Select a Class</label>
                                                          <select name="classSelected" id="" class="form-control form-control-sm">
                                                              <option value="">Select a class</option>
                                                              @foreach ($schooldetails->getClassList($schooldetails->id) as $itemselect)
                                                                  <option value="{{ $itemselect->id }}" {{ $itemselect->id == $item->class_id ? "selected":"" }}>{{ $schooldetails->schooltype == "Primary" ? $itemselect->classnamee:$itemselect->classname }}</option>
                                                              @endforeach
                                                          </select>
                                                      </div>
                                                      <div class="form-group">
                                                          <label for="">Amount</label>
                                                          <input type="number" name="amount" value="{{ $item->amount }}" class="form-control form-control-sm" placeholder="enter an amount">
                                                      </div>
                                                    </form>
                                                  </div>
                                                  
                                                  <!-- Modal footer -->
                                                  <div class="modal-footer">
                                                  <button form="update_payment_category_form_amount{{ $item->id }}" class="btn btn-sm btn-info">Proceed</button>
                                                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                                  </div>
                                                  
                                              </div>
                                              </div>
                                          </div>
                                  </tr>
                              @endforeach
                              
                          @endif
  
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.row -->


        </div>

{{-- add category modal --}}

        <!-- The Modal -->
        <div class="modal fade" id="addpaymentcategory">
            <div class="modal-dialog modal-sm">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title">Payment Category</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('add_category') }}" method="post" id="add_payment_category_form">
                        @csrf
                        <div class="form-group">
                            <label for="">Payment Category <i style="font-size: 9px; font-style: normal;">eg.PTA fees</i></label>
                            <input type="text" name="paymentcategoryform" class="form-control form-control-sm" placeholder="enter a value">
                        </div>
                    </form>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" form="add_payment_category_form" class="btn btn-info btn-sm"">Proceed</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
                
            </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="addpaymentcategoryprice">
            <div class="modal-dialog modal-sm">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title">Payment Category</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('add_category_amount') }}" method="post" id="add_payment_category_form_amount">
                        @csrf
                        <div class="form-group">
                            <label for="">Payment Category <i style="font-size: 9px; font-style: normal;">eg.PTA fees</i></label>
                            <select name="paymentcategoryform" id="" class="form-control form-control-sm">
                                <option value="">Select a category</option>
                                @foreach ($schooldetails->getPaymentCategory as $item)
                                    <option value="{{ $item->id }}">{{ $item->categoryname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Select a Class</label>
                            <select name="classSelected" id="" class="form-control form-control-sm">
                                <option value="">Select a class</option>
                                @foreach ($schooldetails->getClassList($schooldetails->id) as $item)
                                    <option value="{{ $item->id }}">{{ $schooldetails->schooltype == "Primary" ? $item->classnamee:$item->classname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="number" name="amount" class="form-control form-control-sm" placeholder="enter an amount">
                        </div>
                    </form>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" form="add_payment_category_form_amount" class="btn btn-info btn-sm"">Proceed</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
                
            </div>
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <script>
      function scrollocation(){
        document.getElementById('feesetup').className = "nav-link active"
      }
  </script>
    
@endsection