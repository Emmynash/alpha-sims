@extends('layouts.app_dash')

@section('content')


  <!-- Main Sidebar Container -->
  @include('layouts.asideside')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div style="width: 90%; margin: 0 auto; padding-top: 10px;">
      @include('layouts.message')
    </div>
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Student List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- SELECT2 EXAMPLE -->
        @if ($studentDetails['userschool'][0]['status'] != "Pending")
        <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <input id="initialvalue" name="schoolInitial" value="{{$studentDetails['userschool'][0]['shoolinitial']}}" style="border: none; background-color:#EEF0F0; text-transform:uppercase" class="form-control form-control-lg" type="text" placeholder="School Initial">
                        <button data-toggle="collapse" data-target="#demo" style="background: transparent; border: none; outline: none; color: blue;">What is school initials?</button>
                        <div id="demo" class="collapse" style="border-bottom: 10px;">
                          <p style="margin-left: 10px; font-size: 13px;">
                            Shool initial is required for Registration number generation.
                            example: school A with Initials MSC will have one of its Registration numbers as MSC101010.
                            <i style="color: red;">School initial is a compulsory field and cannot be changed.</i>
                          </p>
                        </div><p></p>
                        @if ($studentDetails['userschool'][0]['shoolinitial'] == "")
                            <button onclick="addschoolinitial('{{$studentDetails['userschool'][0]['schoolId']}}')" class="btn btn-sm btn-info">Add school Initial</button>
                        @endif
                    </div>
                    
                </div>
                <div class="col-md-6">
                  <form id="schoolsessionSetterform" method="POST" action="javascript:console.log('submitted');">
                    @csrf
                      <i id="processConfirm" style="display: none; color: green; font-size: 12px; font-style: normal;"> <i class="fas fa-check-circle"></i> Session succefully added</i>
                      <div class="form-group">
                        <input id="schoolsessionSetter" name="schoolsessionSetter" value="{{$studentDetails['userschool'][0]['schoolsession']}}" style="border: none; background-color:#EEF0F0; text-transform:uppercase" class="form-control form-control-lg" type="text" placeholder="School Session">
                      </div>
                      
                  </form>
                  <button class="btn btn-sm btn-info" data-toggle="collapse" data-target="#schoolsessioprocesscol" style="margin: 5px;">Next</button>
                      <div id="schoolsessioprocesscol" class="collapse" style="margin-bottom: 5px;">
                        Are you sure you want to update your school session? <button id="schoolsessionSetterbtn" class="btn btn-sm btn-success">Proceed</button>
                      </div>
                </div>
            </div>



            <div class="row">
                
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Setup Class List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      
                        <div class="form-group">
                          <label style="font-weight: normal; color: red;" for="classlistvalue">Note: class list should be entered in accending order.</label>
                            <textarea id="classlistvalue" name="classname" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Enter className eg primary 1, primary 2, etc"></textarea>
                            <button data-toggle="collapse" data-target="#classnametip" style="background: transparent; border: none; outline: none; color: blue;">How to add class list?</button>
                            <div id="classnametip" class="collapse" style="border-bottom: 10px;">
                              <p style="margin-left: 10px; font-size: 13px;">
                                Enter the names of your classes. For multiple entries, separate each classname with a comma.
                                Example, Primary 1, Primary 2, etc...
                                <i style="color: red;">Classlist is a compulsory field.</i>
                              </p>
                            </div>
                        </div>
                        <button id="classlistsubmitbtn" class="btn btn-sm btn-info" onclick="addclasslist()">Add classList</button>
                        
                        <button id="classlistsprocessbtn" style="display: none;" class="btn btn-sm btn-info" disabled>
                          <span class="spinner-border spinner-border-sm"></span>
                          Loading..
                        </button>

                      <div class="bg-info" style="height: 100px; margin-top: 5px;">
                          <center><button onclick="fetchclasssetup()" style="position: absolute; border-radius: 50%; outline: none; border:none;"><i class="fas fa-redo"></i></button></center>
                          <div id="classdiv" style="height: 100px; overflow-x: scroll;">

                          </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col (left) -->
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Setup Houses</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="form-group">
                        <textarea id="houselistvalue" name="schoolname" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Example Red house, Blue house, etc..."></textarea>
                      </div>
                      <button id="addhouselistbtn" onclick="addhouseslist()" class="btn btn-sm btn-info">Add houses</button>

                      <button id="addhouselistprocessbtn" style="display: none;" class="btn btn-sm btn-info" disabled>
                        <span class="spinner-border spinner-border-sm"></span>
                        Loading..
                      </button>

                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col (right) -->
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Class section Patterns/Arm</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="form-group">
                        <textarea id="sectionlistvalue" name="schoolname" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Example A, B, etc..."></textarea>
                      </div>
                      <button id="sectionaddbtn" onclick="addsectionlist()" class="btn btn-sm btn-info">Add section</button>
                      
                      <button id="sectionaddprocessbtn" style="display: none;" class="btn btn-sm btn-info" disabled>
                        <span class="spinner-border spinner-border-sm"></span>
                        Loading..
                      </button>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
                <div class="col-md-6">

                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Club/Society</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="form-group">
                        <textarea id="clublistvalue" name="schoolname" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Example Drama club, Science club, etc..."></textarea>
                      </div>
                      <button id="clubaddbtn" onclick="addclublist()" class="btn btn-sm btn-info">Add club/society</button>
                      
                      <button id="clubaddprocessbtn" style="display: none;" class="btn btn-sm btn-info" disabled>
                        <span class="spinner-border spinner-border-sm"></span>
                        Loading..
                      </button>
                    </div>
                    <!-- /.card-body -->
                  </div>

                </div>
              </div>







            

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin. --}}
          </div>
        </div>

        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Student List</h3>
  
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
                  <table class="table table-hover text-nowrap" id="studenttable">
                    <thead>
                      <tr>
                        <th>Reg No</th>
                        <th>Class</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Religion</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        @if ($studentDetails['userschool'][0]["status"] !="Approved")
  
                        @foreach ($userschool as $schools)
                          <td>{{$userschool[0]['schoolId']}}</td>
                          <td>{{$userschool[0]['schoolemail']}}</td>
                          <td>{{$userschool[0]['mobilenumber']}}</td>
                          <td>{{$userschool[0]['periodfrom']}}</td>
                          <td>{{$userschool[0]['periodto']}}</td>
                          <td><span class="tag tag-success">{{$userschool[0]['status']}}</span></td>
                        @endforeach
                          
                        @endif
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>


        <!-- /.card -->
        @endif
        @if ($studentDetails['userschool'][0]["status"] !="Approved")
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Status</h3>

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
                      <th>School Id</th>
                      <th>Email</th>
                      <th>Phone Number</th>
                      <th>Active From</th>
                      <th>End On</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      @if ($studentDetails['userschool'][0]["status"] !="Approved")

                      @foreach ($userschool as $schools)
                        <td>{{$userschool[0]['schoolId']}}</td>
                        <td>{{$userschool[0]['schoolemail']}}</td>
                        <td>{{$userschool[0]['mobilenumber']}}</td>
                        <td>{{$userschool[0]['periodfrom']}}</td>
                        <td>{{$userschool[0]['periodto']}}</td>
                        <td><span class="tag tag-success">{{$userschool[0]['status']}}</span></td>
                      @endforeach
                        
                      @endif
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        @endif



        </div><!-- /.container-fluid -->
      </section>
  </div>


  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.3-pre
    <input id="schoolidfetchclass" type="hidden" value="{{Auth::user()->schoolid}}">
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<!-- ./wrapper -->

<script>
    function addschoolinitial(schoolInitialValue){
        var schoolInitialValue;
    var initialvalue = document.getElementById('initialvalue').value

        if (initialvalue == "") {
          toastError('fieild is empty')
          document.getElementById('initialvalue').style.borderColor = "1px solid red"
        }else{
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
              $.ajax({
                url:"/updateSchoolInitial", //the page containing php script
                method: "POST", //request type,
                cache: false,
                data: {initialvalue: initialvalue, schoolInitialValue: schoolInitialValue},
                success:function(result){
                    toastSuccess('School initials successfully added.')
              },
              error:function(){
                alert('failed')
              }
              
            });
        }
     };



     function addclasslist(){
      var classlistvalue = document.getElementById('classlistvalue').value

      if (classlistvalue == "") {
        toastError('Empty field not allowed')
      }else{

        document.getElementById('classlistsubmitbtn').style.display = "none"
        document.getElementById('classlistsprocessbtn').style.display = "block"

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          $.ajax({
            url:"/addclasslist", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {classlist: classlistvalue },
            success:function(result){
                    // alert(result.msg)
                    if (result.msg == "failed") {
                      toastError('Empty field not allowed')
                      document.getElementById('classlistsubmitbtn').style.display = "block"
                      document.getElementById('classlistsprocessbtn').style.display = "none"
                    } else {
                      document.getElementById('classlistvalue').value = ""
                      toastSuccess('classlist successfully added.')
                      document.getElementById('classlistsubmitbtn').style.display = "block"
                      document.getElementById('classlistsprocessbtn').style.display = "none"
                    }
           },
           error:function(){
            document.getElementById('classlistsubmitbtn').style.display = "block"
            document.getElementById('classlistsprocessbtn').style.display = "none"
           }
           
         });

      }
     };


     function addhouseslist(){
      var houselistvalue = document.getElementById('houselistvalue').value

      if (houselistvalue == "") {
        toastError('Empty field not allowed')
      }else{

        document.getElementById('addhouselistbtn').style.display = "none"
        document.getElementById('addhouselistprocessbtn').style.display = "block"

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          $.ajax({
            url:"/addhouses", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {houselist: houselistvalue },
            success:function(result){
              document.getElementById('addhouselistbtn').style.display = "block"
              document.getElementById('addhouselistprocessbtn').style.display = "none"
                    // alert(result.msg)
                    if (result.msg == "failed") {
                      toastError('Empty field not allowed')
                    } else {
                      document.getElementById('houselistvalue').value = ""
                      toastSuccess('classlist successfully added.')
                    }
           },
           error:function(){
            document.getElementById('addhouselistbtn').style.display = "block"
            document.getElementById('addhouselistprocessbtn').style.display = "none"
           }
           
         });

      }
     };

     function addsectionlist(){
      var sectionlistvalue = document.getElementById('sectionlistvalue').value

      if (sectionlistvalue == "") {
        toastError('Empty field not allowed')
      }else{

        document.getElementById('sectionaddbtn').style.display = "none"
        document.getElementById('sectionaddprocessbtn').style.display = "block"

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          $.ajax({
            url:"/addsection", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {sectionlist: sectionlistvalue },
            success:function(result){
              document.getElementById('sectionaddbtn').style.display = "block"
              document.getElementById('sectionaddprocessbtn').style.display = "none"
                    if (result.msg == "failed") {
                      toastError('Empty field not allowed')
                    } else {
                      document.getElementById('sectionlistvalue').value = ""
                      toastSuccess('classlist successfully added.')
                    }
           },
           error:function(){
            document.getElementById('sectionaddbtn').style.display = "block"
            document.getElementById('sectionaddprocessbtn').style.display = "none"
           }
           
         });
      }
     };

     function addclublist(){
      var clublistvalue = document.getElementById('clublistvalue').value

      if (clublistvalue == "") {
        toastError('Empty field not allowed')
      }else{

        document.getElementById('clubaddbtn').style.display = "none"
        document.getElementById('clubaddprocessbtn').style.display = "block"

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          $.ajax({
            url:"/addclub", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {clublist: clublistvalue },
            success:function(result){
              document.getElementById('clubaddbtn').style.display = "block"
              document.getElementById('clubaddprocessbtn').style.display = "none"
                    if (result.msg == "failed") {
                      toastError('Empty field not allowed')
                    } else {
                      document.getElementById('clublistvalue').value = ""
                      toastSuccess('classlist successfully added.')
                    }
           },
           error:function(){
            document.getElementById('clubaddbtn').style.display = "block"
            document.getElementById('clubaddprocessbtn').style.display = "none"
           }
           
         });
      }
     };

     function scrollocation(){

        document.getElementById('settingsaside').className = "nav-link active"
        document.getElementById('schoolsetupaside').className = "nav-link active"

      fetchclasssetup()
     }

     function fetchclasssetup(){

      var schoolid = document.getElementById('schoolidfetchclass').value

      document.getElementById('classdiv').innerHTML = "";

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          $.ajax({
            url:"/fetchtoschoolsetup", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {schoolid:schoolid},
            success:function(result){
              console.log(result)
              
              for (let index = 0; index < result.length; index++) {
                const element = result[index]['classnamee'];
                // console.log(element)
                var innerDiv = document.createElement('div');
                // innerDiv.className = 'block-2';
                var innerDiv1 = document.createElement('i');
                innerDiv1.style.fontStyle = "normal"
                innerDiv1.style.fontSize = "12px"
                innerDiv1.style.marginLeft = "5px"


                document.getElementById('classdiv').appendChild(innerDiv)
                // innerDiv.innerHTML = "hjhjhdfd"
                innerDiv.appendChild(innerDiv1)
                innerDiv1.innerHTML = element
                
              }
              
              // alert(result.msg)

                
              // }
        
          },
          error:function(){
            alert('failed')
          }
        });
     }

    //  function scrollocation(){
        
    // }

</script>

    
@endsection