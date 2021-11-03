<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alpha-sims accomodation</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/css/mdb.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Piedra&display=swap" rel="stylesheet">

    <style>
        textarea:focus, 
        textarea.form-control:focus, 
        select.form-control:focus, 
        input[type=text]:focus, 
        input[type=password]:focus, 
        input[type=email]:focus, 
        input[type=number]:focus, 
        [type=text].form-control:focus, 
        [type=password].form-control:focus, 
        [type=email].form-control:focus, 
        [type=tel].form-control:focus, 
        [contenteditable].form-control:focus {
        box-shadow: inset 0 -1px 0 #ddd;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $(function() {
                $('#addstudenthostelbtn').click(function(e) {
                    e.preventDefault();
                    $("#addstudenthostelform").submit();

                    // document.getElementById('addschoolinitialsbtn').style.display = "none"
                    // document.getElementById('addschoolinitialsbtnprocess').style.display = "block"

                    document.getElementById('infodatahostel').innerHTML = "Loading...";

                    $.ajax({
                    url: '{{ route('add_student_hostel') }}',
                    type: 'post',
                    dataType: 'json',
                    data: $('form#addstudenthostelform').serialize(),
                    success: function(data) {

                        console.log(data.exist);

                        if (data.errors) {
                            document.getElementById('infodatahostel').innerHTML = "";
                            for (let index = 0; index < data.errors.length; index++) {
                                const element = data.errors[index];

                                document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");

                                // console.log(element)
                                
                                }

                            document.getElementById('subjectaddprocessspinner').style.display = "none"
                        }else if(data.success){

                            var existids = "";
                            var invalidids = "";
                            var roomfulls = "";

                            if(data.exist.length > 0){
                                existids = data.exist
                            }else{
                                existids = "0"
                            }

                            if(data.invalid.length > 0){
                                invalidids = data.invalid
                            }else{
                                invalidids = "0"
                            }

                            if(data.roomfull.length > 0){
                                roomfulls = data.roomfull
                            }else{
                                roomfulls = "0"
                            }

                            document.getElementById('infodatahostel').innerHTML = "the following regestration numbers already have accomodation"+" "+existids+" "+"while the follwing are invalid"+" "+invalidids+" "+"the following Registration Numbers where not given rooms because the room is full"+" "+roomfulls+" ";

                        }

                        },
                        error:function(errors){
                        console.log(errors)
                        },
                        timeout: 10000
                    });
                });
            });

          $('#addstudenthostelform').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
          });

            // $(function() {
            //     $('#addstudenthostelbtn').click(function(e) {

            //         // document.getElementById('addschoolinitialsbtn').style.display = "none"
            //         // document.getElementById('addschoolinitialsbtnprocess').style.display = "block"

            //         // document.getElementById('infodatahostel').innerHTML = "Loading...";

            //         $.ajax({
            //         url: '/fetch_students_in_room',
            //         type: 'post',
            //         dataType: 'json',
            //         data: $('form#addstudenthostelform').serialize(),
            //         success: function(data) {

            //             console.log(data.exist);

                        // if (data.errors) {
                        //     for (let index = 0; index < data.errors.length; index++) {
                        //         const element = data.errors[index];

                        //         document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");

                        //         // console.log(element)
                                
                        //         }

                        //     document.getElementById('subjectaddprocessspinner').style.display = "none"
                        // }else if(data.success){

                        //     var existids = "";
                        //     var invalidids = "";

                        //     if(data.exist.length > 0){
                        //         existids = data.exist
                        //     }else{
                        //         existids = "0"
                        //     }

                        //     if(data.invalid.length > 0){
                        //         invalidids = data.invalid
                        //     }else{
                        //         invalidids = "0"
                        //     }

                        //     document.getElementById('infodatahostel').innerHTML = "the following regestration numbers already have accomodation"+" "+existids+" "+"while the follwing are invalid"+" "+invalidids+"";

                        // }

            //             },
            //             error:function(errors){
            //             console.log(errors)
            //             },
            //             timeout: 10000
            //         });
            //     });
            // });
        });
    </script>
</head>
<body>
    <div>
        <!--Navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark default-color-dark">

            <!-- Navbar brand -->
            <a class="navbar-brand" href="/dom_index">The Dometory</a>
        
            <!-- Collapse button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
            aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        
            <!-- Collapsible content -->
            <div class="collapse navbar-collapse" id="basicExampleNav">
        
            <!-- Links -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                <a class="nav-link" href="#">Home
                    <span class="sr-only">(current)</span>
                </a>
                </li>
                {{-- <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
                </li> --}}
                {{-- <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
                </li> --}}
        
                <!-- Dropdown -->
                {{-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
                </li> --}}
        
            </ul>
            <!-- Links -->
        
            {{-- <form class="form-inline">
                <div class="md-form my-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                </div>
            </form> --}}
            </div>
            <!-- Collapsible content -->
        
        </nav>
  <!--/.Navbar-->
    </div>

    <div class="container-fluid">
        <button class="btn btn-sm default-color-dark text-white" data-toggle="modal" data-target="#addhostels">Add Rooms</button>
    </div>
    <br>
    <div class="container-fluid">
        @include('layouts.message')
    </div>
    
    <div class="card" style="border-radius: 0px;">
        <div style="display: flex; align-items: center; flex-direction: column;">
            <h4 style="font-family: 'Piedra', cursive;">{{$allarrayhostels['fetchhostel']['hostelname']}}</h4>
            <h6 style="font-family: 'Piedra', cursive;">---------------------------</h6>
        </div>
    </div>
    <br>
    <div class="container-fluid">
        <div class="card">
            <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col" style="white-space:nowrap;">Room Id</th>
                      <th scope="col" style="white-space:nowrap;">Room Name</th>
                      <th scope="col" style="white-space:nowrap;">Student count</th>
                      <th scope="col" style="white-space:nowrap;">Capacity</th>
                      <th scope="col" style="white-space:nowrap;">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    @if (count($allarrayhostels['fetchhosteldetails']) > 0)

                        @foreach ($allarrayhostels['fetchhosteldetails'] as $hostel)
                            <tr>
                                <th scope="row">{{$hostel->id}}</th>
                                <td>{{$hostel->roomname}}</td>
                                <td>{{$hostel->roomcount}}</td>
                                <td>{{$hostel->roomcapacity}}</td>
                                <td><div style="display: flex; flex-direction: row;"><i class="fas fa-plus" style="color: green; white-space:nowrap;"></i> <div style="width:5px;"></div> <i data-toggle="modal" data-target="#allocateroomviewroom" onclick="getRoomId('{{$hostel->id}}', '{{$hostel->hostelid}}')" class="far fa-eye" style="color: rgb(175, 175, 22);"></i> <div style="width:5px;"></div> <i style="color: red;" class="far fa-trash-alt" data-toggle="modal" data-target="#roomstodelete{{$hostel->id}}"></i></div></td>
                                    
                                    <!-- Central Modal Small -->
                                    <div class="modal fade" id="roomstodelete{{$hostel->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                        aria-hidden="true">
                                    
                                        <!-- Change class .modal-sm to change the size of the modal -->
                                        <div class="modal-dialog modal-sm" role="document">
                                    
                                    
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h6 class="modal-title w-100" id="myModalLabel">Notice!!!  <i style="color: red;" class="fas fa-exclamation-circle"></i></h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <i>{{$hostel->roomname}}</i>
                                                </div>
                                                <i style="font-style: normal; font-size: 12px; color: red;">Are you sure about this? Remember, this request cannot be undone. All students in this room will be rendered roomless.</i>
                                                <form id="deleteroom{{$hostel->id}}" action="{{ route('delete_room') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" value="{{$hostel->id}}" name="roomidvalue">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
                                            <button type="submit" class="btn btn-success btn-sm" form="deleteroom{{$hostel->id}}"><i class="fas fa-check"></i></button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <!-- Central Modal Small -->
                                
                            </tr>
                        @endforeach
                        
                    @endif
                  </tbody>
                </table>
              </div>
        </div>





        
        <!-- Central Modal Small -->
        <div class="modal fade" id="addhostels" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
        
            <!-- Change class .modal-sm to change the size of the modal -->
            <div class="modal-dialog modal-sm" role="document">
        
        
            <div class="modal-content">
                <div class="modal-header">
                <h6 class="modal-title w-100" id="myModalLabel">Add Room</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form id="addhostelmodal" action="{{ route('add_room') }}" method="post">
                        @csrf
                        <div class="text-center">
                            <i style="font-style: normal; font-size: 10px; color: red;">All fields are required</i>
                        </div>
                        <div class="form-group">
                            <div style="display: flex; flex-direction: row;">
                                <button style="background: transparent; border: none; border-top: 1px solid rgb(196, 191, 191); border-bottom: 1px solid rgb(196, 191, 191); border-left: 1px solid rgb(196, 191, 191);" disabled><i class="far fa-hospital" style="border-radius: 0px;"></i></button>
                                <input type="text" name="roomname" class="form-control form-control-sm" placeholder="Room name" style="border-radius: 0px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <div style="display: flex; flex-direction: row;">
                                <button style="background: transparent; border: none; border-top: 1px solid rgb(196, 191, 191); border-bottom: 1px solid rgb(196, 191, 191); border-left: 1px solid rgb(196, 191, 191);" disabled><i class="fas fa-sort-numeric-up"></i></button>
                                <input type="number" name="roomcapacity" class="form-control form-control-sm" placeholder="Room Capacity" style="border-radius: 0px;">
                            </div>
                        </div>
                        <input type="hidden" value="{{$allarrayhostels['fetchhostel']['id']}}" name="hostelid">
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
                <button type="submit" class="btn btn-success btn-sm" form="addhostelmodal"><i class="fas fa-check"></i></button>
                </div>
            </div>
            </div>
        </div>
        <!-- Central Modal Small -->



        {{------------------------------------------------------------------------------------------------------}}
        {{--                                           view/addstudent                                        --}}
        {{------------------------------------------------------------------------------------------------------}}
        
        <!-- Central Modal Small -->
        <div class="modal fade" id="allocateroomviewroom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
        
            <!-- Change class .modal-sm to change the size of the modal -->
            <div class="modal-dialog modal-md" role="document">
        
        
            <div class="modal-content">
                <div class="modal-header">
                <h6 class="modal-title w-100" id="myModalLabel">View student/add</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="card shadow-none" style="border: 1px solid rgb(207, 203, 203); border-radius: 0px;">

                        <div class="text-center">
                            <i id="infodatahostel" style="font-size: 10px; font-style: normal; color: blue;"></i>
                        </div>

                        <form id="addstudenthostelform" action="javascript:console.log('submited');" method="post" style="margin: 10px;">
                            @csrf
                            <div>
                                <i style="font-size: 10px; font-style: normal; color: blue;">Add students to hostel by REGNO (Seperate each REGNO with a comma for multile entries) </i>
                            </div>
                            <div class="form-group">
                                <div style="display: flex; flex-direction: row;">
                                    <button style="background: transparent; border: none; border-top: 1px solid rgb(44, 141, 231); border-bottom: 1px solid rgb(196, 191, 191); border-left: 1px solid rgb(196, 191, 191);" disabled><i class="fas fa-sort-numeric-up"></i></button>
                                    <input type="text" name="addstudentstorooms" class="form-control form-control-sm" placeholder="eg. 23,45,67" style="border-radius: 0px;">
                                </div>
                            </div>
                            <input type="hidden" name="hostelidadd" value="{{$allarrayhostels['fetchhostel']['id']}}">
                            <input type="hidden" name="roomidhostel" id="roomidhostel">
                            <div>
                                <button id="addstudenthostelbtn" type="submit" class="btn btn-sm default-color-dark text-white">Allocate</button>
                            </div>
                        </form>
                        
                    </div>
                    <br>

                    <div>
                        <form action="" method="post">
                            @csrf
                            <div class="form-group">
                                <div style="display: flex; flex-direction: row;">
                                    <button style="background: transparent; border: none; border-top: 1px solid rgb(196, 191, 191); border-bottom: 1px solid rgb(196, 191, 191); border-left: 1px solid rgb(196, 191, 191);" disabled><i class="fas fa-search"></i></button>
                                    <input type="text" name="addstudentstorooms" class="form-control form-control-sm" placeholder="Search..." style="border-radius: 0px;">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card shadow-none" style="height: 250px; border: 1px solid rgb(207, 203, 203); overflow-y: scroll; border-radius: 0px;">
                        <div id="roomlistspinner" style="position: absolute; z-index: 999; top: 0; bottom: 0; left: 0; right: 0; display: flex; align-items: center; justify-content: center;">
                            <div class="spinner-border"></div>
                        </div>
                        <div id="mainroomlist" style="display: none">
                            <ul class="list-group" id="studentRoomList">
                                <li class="list-group-item">
                                    <div style="display: flex; flex-direction: column;">
                                        <i style="font-size: 13px; font-style: normal;">students name</i>
                                        <i style="font-size: 13px; font-style: normal;">students class</i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm">Save changes</button> --}}
                </div>
            </div>
            </div>
        </div>
        <!-- Central Modal Small -->
    </div>
    





     <!-- JQuery -->
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <!-- Bootstrap tooltips -->
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
     <!-- Bootstrap core JavaScript -->
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
     <!-- MDB core JavaScript -->
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/js/mdb.min.js"></script>

     <script>
         function getRoomId(roomid, hostelid){
            document.getElementById('roomidhostel').value = roomid;

            
            // document.getElementById('atprocess').style.display = "inline-block"
            document.getElementById('roomlistspinner').style.display = "flex"
            
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
                $.ajax({
                url:"{{ route('fetch_students_in_room') }}", //the page containing php script
                method: "POST", //request type,
                cache: false,
                data: {roomid: roomid, hostelid:hostelid},
                success:function(result){
                          console.log(result)
                          document.getElementById('mainroomlist').style.display = "block"
                          document.getElementById('roomlistspinner').style.display = "none"
                        if (result.success) {
                            html = "";

                            for (let index = 0; index < result.success.length; index++) {
                                const element = result.success[index];

                                var fullname = element.firstname+" "+element.middlename+" "+element.lastname

                                var newidcollapse = "#demo"+element.id;
                                var newidcollapsehash = "demo"+element.id;
                                var imguser = element.profileimg == null ? 'https://gravatar.com/avatar/?s=200&d=retro' :'/storage/schimages/'+element.profileimg;

                                console.log(newidcollapsehash)

                                html += "<li class='list-group-item'>"+"<img src='"+imguser+"' class='rounded-circle' width='50px'>"+"<div style='display: flex; flex-direction: column;'>"+"<i style='font-size: 13px; font-style: normal;'>"+fullname+" "+"(Reg No."+element.regno+")</i>"+"<i style='font-size: 13px; font-style: normal;'></i>"+"</div>"+"<i style='color: red;' class='far fa-trash-alt' data-toggle='collapse' data-target='"+newidcollapse+"'></i>"+"<div id='"+newidcollapsehash+"' class='collapse'><i style='font-size: 10px; color: red; font-style: normal;'>Are you sure you want to delete?</i>"+" "+"<button style='font-size: 10px; border-radius: 5px; border: none; background-color: green;' onclick=\"deleteRoomMate('"+element.id+"', '"+element.roomid+"', '"+element.hostelid+"')\"><i style='color: white;' class='fas fa-check'></i></botton>"+"</div>"+"</li>" 
                            }                                                                                                                                                                                                                                       
                            $("#studentRoomList").html(html);
                        }
                },
                error:function(){
                alert('failed')
                document.getElementById('roomlistspinner').style.display = "none"
                }
                
            });

         }

         function deleteRoomMate(studenthostelid, roomid, hostelid) {

            document.getElementById('roomlistspinner').style.display = "flex"

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
                $.ajax({
                url:"{{ route('delete_roommate') }}", //the page containing php script
                method: "POST", //request type,
                cache: false,
                data: {studenthostelid: studenthostelid, roomid:roomid, hostelid:hostelid},
                success:function(result){
                          console.log(result)
                          document.getElementById('roomlistspinner').style.display = "none"
                        //   document.getElementById('mainroomlist').style.display = "block"
                        //   document.getElementById('roomlistspinner').style.display = "none"
                        if (result.success) {
                               getRoomId(roomid, hostelid);
                        }
                       
                },
                error:function(){
                alert('failed')
                document.getElementById('roomlistspinner').style.display = "none"
                }
                
            });
         }

     </script>
</body>
</html>

