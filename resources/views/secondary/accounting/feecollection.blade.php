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


        <div class="card" style="border-top: 2px solid #0B887C;">

                  <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-md-4">
                    <form action="{{ route('fetchstudentdataforfee') }}" method="post">
                      @csrf
                      
                      <div class="form-group">
                        <input type="text" name="identity" class="form-control form-control-sm" placeholder="reg no. or Admission no.">
                      </div>
                      <div class="form-group">
                        <button class="btn btn-sm btn-info">Query</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->

        </div>

        <div class="card" style="margin: 10px;">
          @if (\Session::has('data'))
          {{-- <div class="alert alert-success">
              <ul>
                  <li>{!! \Session::get('data') !!}</li>
              </ul>
          </div> --}}

          <div id="gottenstudentdata" style="">
            <div class="row">
              <div class="col-12 col-md-2 text-center">
                <img id="profileimgmainpix" style="margin: 10px;" src="{{ \Session::get('data')->profileimg == null ? "https://cdn.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png": asset('storage/schimages/'.\Session::get('data')->profileimg)}}" class="img-circle elevation-2" height="100px" alt="User Image">
              </div>
              <div class="col-12 col-md-10">
                <p id="studentname">Name: {{ \Session::get('data')->firstname }} {{ \Session::get('data')->middlename }} {{ \Session::get('data')->lastname }}</p>
                <p id="studentclass">Class: {{ \Session::get('data')->classname }}</p>
                <p id="studentclass">Admission No: {{ \Session::get('data')->admission_no }}</p>
              </div>
            </div>
            <br>
            <div style="margin: 10px;">
              <p>Fees Summary</p>
              <div class="row" id="feesummary">
                <div class="col-12 col-md-12">
                  @if (count(\Session::get('feesummary')) > 0)

                      @foreach (\Session::get('feesummary') as $item)
                          <div class="card">
                            <div style="margin: 10px;">
                              {{ $item->categoryname }} N{{ $item->amount }}
                            </div>
                          </div>
                      @endforeach
                      
                  @endif

                </div>
              </div>
            </div>
            <br>
            <div class="row" style="margin: 10px;">
              <div class='col-12 col-md-8' style='display: flex;'><i style='font-style: normal; font-weight: bold;'>Total</i><div style='flex:1;'></div><i id="totalfeesstd" style='font-style: normal;'>N{{ \Session::get('totalfees') }}</i></div>
            </div>
            <br>
            <div style="display: flex; flex-direction: column; margin-left: 10px;">
              <i style="font-style: normal; font-size: 13px;">Click the button below to confirm Fees has been recieved</i>
              
            </div>
            <div class="form-group" style="margin-left: 10px;">
              <form action="{{ route('confirm_money_received_fees') }}" method="post">
                @csrf
                {{-- <input type="hidden" name="classid" value="{{ \Session::get('data')->classid }}" id=""> --}}
                <input type="hidden" name="amount" value="{{ \Session::get('totalfees') }}">
                <input type="hidden" name="studentregno" value="{{ \Session::get('data')->id }}">
                <input type="hidden" name="usernamesystem" value="{{ \Session::get('data')->usernamesystem }}">
                <button class="btn btn-success btn-sm">Confirm</button>
              </form>
            </div>
            

          </div>
      @endif
        </div>
        <br>


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