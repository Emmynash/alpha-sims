@extends('secondary.accounting.layouts.app_account')


@section('content')

@include('secondary.accounting.layouts.aside_account')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Fee Collection</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Order Request"
                data-content="Send a money request to the school head for approval. Untill confirmed no action is required">Need help?</button>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Fee Collection</li>
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
                <h3 class="card-title"><button class="btn btn-sm btn-info" data-toggle="modal" data-target="#cashpaymentmodal">Cash Payment</button></h3>

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
                      <th>Code</th>
                      <th>class</th>
                      <th>Number of student</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    {{-- @if (count($classesAll) > 0)
                      @foreach ($classesAll as $classesall)
                        <tr>
                          <td>{{$classesall->id}}</td>
                          <td>{{$classesall->classname}}</td>
                          <td>{{$classesall->getClassCount($classesall->id)}}</td>
                  
                          <td><button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editclassname"><i class="fas fa-eye"></i></button> <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editclassname{{$classesall->id}}"><i class="fas fa-edit"></i></button></td>
                        </tr>
                      @endforeach
                    @endif --}}
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


        <!-- The Modal -->
        <div class="modal" id="cashpaymentmodal">
            <div class="modal-dialog">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Confirm Payment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    {{-- <div class="spinner-border"></div> --}}
                    <form id="form_student_data">
                        <div class="form-group">
                            <label for="">Student Reg Number</label>
                            <input type="text" name="admission_no" class="form-control form-control-sm">
                        </div>
                    </form>

                    <div id="gottenstudentdata" style="display: none;">
                      <div class="row">
                        <div class="col-12 col-md-6 text-center">
                          <img id="profileimgmainpix" src="{{asset('storage/schimages/'.Auth::user()->profileimg)}}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="col-12 col-md-6 text-center">
                          <p id="studentname">Name:</p>
                          <p id="studentclass">Class:</p>
                        </div>
                      </div>
                      <br>
                      <div>
                        <p>Fees Summary</p>
                        <div class="row" id="feesummary">

                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class='col-12 col-md-8' style='display: flex;'><i style='font-style: normal; font-weight: bold;'>Total</i><div style='flex:1;'></div><i id="totalfeesstd" style='font-style: normal;'>N4000</i></div>
                      </div>
                      <br>
                      <div style="display: flex; flex-direction: column;">
                        <i style="font-style: normal; font-size: 13px;">Click the button below to confirm Fees has been recieved</i>
                        <button class="btn btn-success btn-sm">Confirm</button>
                      </div>

                    </div>

                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" form="form_student_data" class="btn btn-success btn-sm btn-submit">Proceed</button>
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
        document.getElementById('feecollection').className = "nav-link active"
      }
  </script>

@endsection

@push('custom-scripts')

    <script>



    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $(".btn-submit").click(function(e){
    
            e.preventDefault();
    
            var admission_no = $("input[name=admission_no]").val();

            document.getElementById('gottenstudentdata').style.display = "none";
    
            $.ajax({
            type:'POST',
            url:"{{ route('fetchstudentdataforfee') }}",
            data:{admission_no:admission_no},
            success:function(data){
                if (data.data != null) {

                  document.getElementById('studentname').innerHTML = "Name:"+" "+data.data.firstname+" "+data.data.middlename+" "+data.data.lastname;
                  document.getElementById('studentclass').innerHTML = "Class:"+" "+data.data.classname+data.data.sectionname;

                  var html = "";

                  for (let index = 0; index < data.feesummary.length; index++) {
                    const element = data.feesummary[index];

                    html += "<div class='col-12 col-md-8' style='display: flex;'><i style='font-style: normal;'>"+element.categoryname+"</i><div style='flex:1;'></div><i style='font-style: normal;'>₦"+element.amount+"</i></div>"

                  }

                  

                  $("#feesummary").html(html); 

                  document.getElementById('totalfeesstd').innerHTML = "₦"+data.totalfees;

                  document.getElementById('gottenstudentdata').style.display = "block";
                  
                }else{
                  console.log(data.data);
                }

                console.log(data);
            }
            });
  
    });




    </script>
    
@endpush