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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Inventory</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Inventory</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      @include('layouts.message')

        <div>
                    <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-dolly-flatbed"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Total Items</span>
                  <span class="info-box-number">
                    {{ $schooldetails->getItemsInventody->count() }}
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dolly-flatbed"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Available Items</span>
                  <span class="info-box-number">{{ $schooldetails->getAvailableItems($schooldetails->id) }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
  
            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>
  
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dolly-flatbed"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Unavailable Itmes</span>
                  <span class="info-box-number">{{ $schooldetails->getItemsInventody->count() - $schooldetails->getAvailableItems($schooldetails->id) }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-dolly-flatbed"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Item Request</span>
                  <span class="info-box-number">0</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
              <div>
                  <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#additeminventory">Add item</button>
                  <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalCart">Invoice  <span class="badge badge-danger">0</span></button>
              </div>
          </h3>

          <div class="card-tools">
            {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button> --}}
          </div>
        </div>
      </div>
      <!-- /.card -->


      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Inventory</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Name</th>
              <th>Amount</th>
              <th>Quantity</th>
              <th>Class</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @if ($schooldetails->getItemsInventody->count() < 1)
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td></td>
                    </tr>
                @else

                    @foreach ($schooldetails->getItemsInventody as $item)
                        <tr>
                            <td>{{ $item->nameofitem }}</td>
                            <td>{{ number_format($item->amount) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $schooldetails->schooltype == "Primary" ? ($item->classid == "Others" ? $item->othersval:$schooldetails->getClassName($item->classid)->classnamee) : ($item->classid == "Others" ? $item->othersval:$schooldetails->getClassName($item->classid)->classname) }}</td>
                            <td>{{ $item->quantity <1 ? "Unavailable":"Available" }}</td>
                            <td><button class="btn btn-sm btn-info" data-toggle="modal" data-target="#bookoptions{{ $item->id }}">View</button></td>

                                  <!-- The Modal -->
                            <div class="modal fade" id="bookoptions{{ $item->id }}">
                                <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                    <h4 class="modal-title">Items Options</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                    <p>{{ $item->nameofitem }}</p>
                                      <div style="display: flex; flex-direction: column;">
                                        <button class="btn btn-sm btn-info" style="margin-bottom: 5px;" data-toggle="collapse" data-target="#additemtoinvoice{{ $item->invoice }}">Add to invoice</button>
                                          <div style="margin-bottom: 5px;">
                                            <div id="additemtoinvoice{{ $item->invoice }}" class="collapse">
                                                <form action="{{ route('add_invoice_order', $item->id) }}" method="post">
                                                  @csrf
                                                  <div class="form-group">
                                                    <label for="">Quantity (available is {{ $item->quantity }})</label>
                                                    <input type="number" name="quantity" class="form-control form-control-sm">
                                                  </div>
                                                  <button class="btn btn-sm btn-info">Add</button>
                                                </form>
                                            </div>
                                          </div>
                                        <button class="btn btn-sm btn-warning" style="margin-bottom: 5px;" data-toggle="collapse" data-target="#updateitem{{ $item->id }}">Update Item</button>
                                        <div style="margin-bottom: 5px">
                                          <div id="updateitem{{ $item->id }}" class="collapse">
                                            <form action="{{ route('update_invoice_items', $item->id) }}" method="post">
                                              @csrf
                                              <div class="form-group">
                                                <label for="">item price Quantity (available is {{ $item->quantity }})</label>
                                                <input type="number" name="amount" value="{{ $item->amount }}" class="form-control form-control-sm">
                                              </div>
                                              <div class="form-group">
                                                <label for="">Quantity to add</label>
                                                <input type="number" name="quantity" class="form-control form-control-sm">
                                              </div>
                                              <button class="btn btn-success btn-sm">Proceed</button>
                                            </form>
                                          </div>
                                        </div>
                                        <button class="btn btn-sm btn-danger" style="margin-bottom: 5px;">Delete Item</button>
                                        <button class="btn btn-sm btn-success">Click to notify the admin that an item is about to finish</button>
                                      </div>
                                    </div>
                                    
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                                    </div>
                                    
                                </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                    
                @endif

            </tbody>
            <tfoot>
            <tr>
                <th>Name</th>
                <th>Amount</th>
                <th>Quantity</th>
                <th>Class</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>

    </section>
    <!-- /.content -->


  <!-- The Modal -->
  <div class="modal fade" id="additeminventory">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Items</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form action="{{ route('inventory_add_item') }}" method="post" id="sunmititems">
              @csrf
              <div class="form-group">
                    <label for="">Select a Class(optional)</label>
                    <select name="classid" onchange="getOthersCategory(this)" class="form-control form-control-sm" id="" required>
                        <option value="">Select a class</option>
                        @if($schooldetails->getClassList($schooldetails->id)->count() < 1)

                        @else

                            @foreach ($schooldetails->getClassList($schooldetails->id) as $item)

                                <option value="{{ $item->id }}">{{ $schooldetails->schooltype == "Primary" ? $item->classnamee: $item->classname }}</option>
                                
                            @endforeach

                        @endif
                        <option value="Others">Others</option>
                    </select>
               </div>
               <div class="form-group" id="othercategoryfield" style="display: none;">
                    <label for="">Enter a Value</label>
                    <input name="Otherfield" type="text" class="form-control form-control-sm" id="" placeholder="enter other value">
               </div>
               <div class="form-group">
                        <label for="">Name of item</label>
                        <input name="nameofitem" type="text" class="form-control form-control-sm" id="" placeholder="enter name of item">
                </div>
                <div class="form-group">
                    <label for="">Amount</label>
                    <input name="amount" type="number" class="form-control form-control-sm" id="" placeholder="enter amount">
                </div>
                <div class="form-group">
                    <label for="">Quantity</label>
                    <input type="number" name="quantity" placeholder="enter amount" class="form-control form-control-sm">
                </div>
          </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="submit" form="sunmititems" class="btn btn-success btn-sm">Send</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

  <!-- Modal: modalCart -->
  <div class="modal fade" id="modalCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Your cart</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <!--Body-->
      <div class="modal-body">
        <div>
        </div>
        <table class="table table-hover table-responsive">
          <thead>
            <tr>
              <th>#</th>
              <th>Product name</th>
              <th>Price</th>
              <th>Qty</th>
              <th>total(₦)</th>
              <th>Remove</th>
            </tr>
          </thead>
          <tbody>
            @if ($itemforInventory == NULL)
              <tr>
                <th scope="row">--</th>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
              </tr>
            @else
            @php $count = method_exists($itemforInventory->getInvoiceItems, 'links') ? 1 : 0; @endphp
              @foreach ($itemforInventory->getInvoiceItems as $item)
              @php $count = method_exists($itemforInventory->getInvoiceItems, 'links') ? ($itemforInventory->getInvoiceItems ->currentpage()-1) * $itemforInventory->getInvoiceItems ->perpage() + $loop->index + 1 : $count + 1; @endphp
                <tr>
                  <th scope="row">{{ $count }}</th>
                  <td>{{ $itemforInventory->getItemName($item->item_id)->nameofitem }}</td>
                  <td>{{ $itemforInventory->getItemName($item->item_id)->amount }}</td>
                  <td>{{ $item->quantity }}</td>
                  <td id="loop">{{ $itemforInventory->getItemName($item->item_id)->amount * $item->quantity }}</td>
                  <td><a><i class="fas fa-times"></i></a></td>
                </tr>
              @endforeach
                
            @endif
          </tbody>
          <tbody>
            <tr>
              <td>Invoice No</td>
              <td>{{ $itemforInventory == null ? "": $itemforInventory->invoicenumber }}</td>
            </tr>
            <tr>
              <td class="text-right">Total</td>
              <td style="font-weight: bold;" id="total"></td>
          </tr>
          </tbody>
        </table>
      </div>
      <!--Footer-->

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
        <form action="{{ route('order_invoice_checkout') }}" method="post" id="checkoutinventory">
          @csrf
          <input type="hidden" name="invoiceid" value="{{ $itemforInventory == null ? "": $itemforInventory->id }}">
          <input type="hidden" name="itemsamount" id="totalamountinvent">
        </form>
        <button type="submit" form="checkoutinventory" class="btn btn-primary">Checkout</button>
      </div>
    </div>
  </div>
  </div>
  <!-- Modal: modalCart -->

  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.3-pre
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@endsection

@push('custom-scripts')

{{-- <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}"></script>
<script src="{{ asset("plugins/datatables-responsive/js/dataTables.responsive.min.js") }}"></script> --}}


<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

    $(function() {

      var TotalValue = 0;

      $("tr #loop").each(function(index,value){
        currentRow = parseFloat($(this).text());
        TotalValue += currentRow
      });

      document.getElementById('total').innerHTML = "₦"+TotalValue;
      document.getElementById('totalamountinvent').value = TotalValue

    });

    function scrollocation(){
        document.getElementById('accountscroll').className = "nav-link active"
        document.getElementById('inventory').className = "nav-link active"
    }

    function getOthersCategory(select) {
        console.log(select.value)
        if (select.value == "Others") {
          document.getElementById('othercategoryfield').style.display = "block";
        }else{
          document.getElementById('othercategoryfield').style.display = "none";
        }
    }

  </script>
    
@endpush