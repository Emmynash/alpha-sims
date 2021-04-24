<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alpha-sim dormitory</title>
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
</head>
<body>
    <div>
        <!--Navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark default-color-dark">

            <!-- Navbar brand -->
            <a class="navbar-brand" href="#" style="font-weight: bold;">The Dormitory</a>
        
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
                <a class="nav-link" href="/home">Home
                    <span class="sr-only">(current)</span>
                </a>
                </li>
        
            </ul>
            <!-- Links -->
        
            <div>
                <button class="btn btn-outline-primary waves-effect"><i class="fas fa-sign-out-alt" style="color: #fff;"></i></button>
            </div>
            </div>
            <!-- Collapsible content -->
        
        </nav>
  <!--/.Navbar-->
    </div>
    <br>
        <div class="container-fluid">
            <button class="btn default-color-dark btn-sm text-white" data-toggle="modal" data-target="#hostelnamecollect">Add Hostel</button>
        </div>
    <br>
    <div class="container-fluid">
        @if (count($allhostels) < 1)
            <div class="alert alert-info alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>	
                    <strong>You are yet to add Hostels to your school. Please start by adding hostels. Thank you</strong>
            </div>
        @endif
        <br>
        <div>
            @include('layouts.message')
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col" style="white-space:nowrap;">Hostel ID</th>
                      <th scope="col" style="white-space:nowrap;">Hostel Name</th>
                      <th scope="col" style="white-space:nowrap;">Room Count</th>
                      <th scope="col" style="white-space:nowrap;">Student Count</th>
                      <th scope="col" style="white-space:nowrap;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      @if (count($allhostels) > 0)
                        @foreach ($allhostels as $allhostel)
                            <tr>
                                <th scope="row">{{$allhostel->id}}</th>
                                <td>{{$allhostel->hostelname}}</td>
                                <td>{{$allhostel->roomcount}}</td>
                                <td>{{$allhostel->studentcount}}</td>

                                <div class="modal fade" id="deleteHostel{{$allhostel->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                aria-hidden="true">
                                <!-- Change class .modal-sm to change the size of the modal -->
                                    <div class="modal-dialog modal-sm" role="document">
                            
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h6 class="modal-title w-100" id="myModalLabel">{{$allhostel->hostelname}}</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <i style="font-style: normal; font-size: 12px;">Are you sure about this decision? All students in this hostel with be rendered roomless.</i>
                                            </div>
                                            <div>
                                                <i style="font-style: normal; color: red; font-size: 15px;">Proceed?</i>
                                            </div>
                                            <form id="deletehostelid{{$allhostel->id}}" action="{{ route('delete_hostel') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="hostelidDelete" value="{{$allhostel->id}}">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
                                        <button type="submit" class="btn btn-success btn-sm" form="deletehostelid{{$allhostel->id}}">Yes</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <td><div style="display: flex; flex-direction: row;"><a href="{{ route('add_rooms', $allhostel->id) }}"><i style="color: rgb(204, 204, 68);" class="far fa-eye"></i></a> <div style="width:5px;"></div>  <i style="color: red;" class="far fa-trash-alt" data-toggle="modal" data-target="#deleteHostel{{$allhostel->id}}"></i></div></td>
                            </tr>
                        @endforeach
                      @endif
                    
                  </tbody>
                </table>
              </div>
        </div>








{{-- ------------------------------------------------------------------- --}}

        <!-- Central Modal Small -->
        <div class="modal fade" id="hostelnamecollect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
        
            <!-- Change class .modal-sm to change the size of the modal -->
            <div class="modal-dialog modal-sm" role="document">
        
        
            <div class="modal-content">
                <div class="modal-header">
                <h6 class="modal-title w-100" id="myModalLabel">Enter hostel Name</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form id="addhoselform" action="{{ route('add_hostel') }}" method="post">
                        @csrf
                        <div class="form-group" style="display: flex; flex-direction: row;">
                            <button style="border: none; background: transparent; border-left: 1px solid rgb(202, 198, 198); border-top: 1px solid rgb(202, 198, 198); border-bottom: 1px solid rgb(202, 198, 198);" disabled><i class="fas fa-school"></i></button>
                            <input type="text" name="hostelname" class="form-control form-control-sm" style="border-radius: 0px;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    <button type="submit" class="btn btn-success btn-sm" form="addhoselform"><i class="fas fa-check"></i></button>
                </div>
            </div>
            </div>
        </div>
        <!-- Central Modal Small -->
    </div>

    <br><br>

    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/js/mdb.min.js"></script>
</body>
</html>