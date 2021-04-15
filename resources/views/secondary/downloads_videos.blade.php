<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Alpha-Sims</title>
    
        {{-- <link rel="stylesheet" href="css/uikit.min.css" />
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script> --}}
    
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.14.0/css/mdb.min.css" rel="stylesheet">
    
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
                $(document).ready(function(){
                    $(function() {
                        $('#addvideos').click(function(e) {
                            e.preventDefault();
                            $("#videoform").submit();
                            document.getElementById('videomaincontainer').style.display = "none"
                            document.getElementById('videospinner').style.display = "flex"

                            $.ajax({
                            url: '/add_videos',
                            type: 'post',
                            dataType: 'json',
                            data: $('form#videoform').serialize(),
                            success: function(data) {
                                console.log(data)

                                    if (data.create) {

                                        $("#alertvideo").removeClass("alert-info");
                                        $("#alertvideo").removeClass("alert-danger");
                                        $("#alertvideo").addClass("alert-success");
                                        document.getElementById('alertvideo').style.display = "block"
                                        document.getElementById('videomaincontainer').style.display = "block"
                                        document.getElementById('videospinner').style.display = "none"
                                        document.getElementById('alertvideo').innerHTML = "Video submited successfully"
                                        
                                        
                                    }

                                    if (data.errors) {
                                        for (let index = 0; index < data.errors.length; index++) {
                                            const element = data.errors[index];
                                            document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                                        }

                                        $("#alertvideo").removeClass("alert-info");
                                        $("#alertvideo").removeClass("alert-success");
                                        $("#alertvideo").addClass("alert-danger");
                                        document.getElementById('alertvideo').style.display = "block"
                                        document.getElementById('videomaincontainer').style.display = "block"
                                        document.getElementById('videospinner').style.display = "none"
                                        document.getElementById('alertvideo').innerHTML = "an error occured. Ensure you fill all fields"
                                    }

                                    if (data.duplicateurl) {

                                        $("#alertvideo").removeClass("alert-info");
                                        $("#alertvideo").removeClass("alert-success");
                                        $("#alertvideo").addClass("alert-danger");
                                        document.getElementById('alertvideo').style.display = "block"
                                        document.getElementById('videomaincontainer').style.display = "block"
                                        document.getElementById('videospinner').style.display = "none"
                                        document.getElementById('alertvideo').innerHTML = "Duplicate videourl entry..."
                                        
                                    }

                                    if (data.duplicatetitle) {

                                        $("#alertvideo").removeClass("alert-info");
                                        $("#alertvideo").removeClass("alert-success");
                                        $("#alertvideo").addClass("alert-danger");
                                        document.getElementById('alertvideo').style.display = "block"
                                        document.getElementById('videomaincontainer').style.display = "block"
                                        document.getElementById('videospinner').style.display = "none"
                                        document.getElementById('alertvideo').innerHTML = "video title is duplicate"
                                        
                                    }

                                    if (data.errorurl) {

                                        $("#alertvideo").removeClass("alert-info");
                                        $("#alertvideo").removeClass("alert-success");
                                        $("#alertvideo").addClass("alert-danger");
                                        document.getElementById('alertvideo').style.display = "block"
                                        document.getElementById('videomaincontainer').style.display = "block"
                                        document.getElementById('videospinner').style.display = "none"
                                        document.getElementById('alertvideo').innerHTML = "video url is invalid. Please, use embed youtube url."

                                    }

                                },
                                error:function(errors){

                                    console.log(errors)
                                    $("#alertvideo").removeClass("alert-info");
                                    $("#alertvideo").removeClass("alert-sucess");
                                    $("#alertvideo").addClass("alert-danger");
                                    document.getElementById('alertvideo').style.display = "block"
                                    document.getElementById('videomaincontainer').style.display = "block"
                                    document.getElementById('videospinner').style.display = "none"
                                    document.getElementById('alertvideo').innerHTML = "Network error."

                                }
                            });
                        });
                    });

                    $('#videoform').on('keypress change', function(e) {
                        // console.log(e);
                        document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
                    });

//-----------------------------------------------------------------------------------------
//                                    fetch all videos
//-----------------------------------------------------------------------------------------
                    
                    $(function(){
                        var page = 1;
                        var from = 0;
                        var total = 0;
                        var pagelimit = 5;
                        var lastpage = 0;

                        fetchDataAll()

                        $("#previous").on("click", function(){
                            if (page > 1) {
                                page--
                                fetchDataAll()
                            }
                        });

                        $("#nextdata").on("click", function(){
                            if (page * pagelimit < total) {

                                page++;
                                fetchDataAll()
                            }
                        });      
     
                        function fetchDataAll(){
                            $.ajax({
                            url: '/all_videos',
                            type: 'GET',
                            data: {
                                page: page,
                                pagelimit: pagelimit
                            },
                            success: function(data) {
                            page = data.data.current_page
                            from = data.data.from
                            total = data.data.total
                            lastpage = data.data.last_page

                            console.log(total)

                                if (data.data) {

                                    if (page == lastpage) {
                                        document.getElementById('prevnextbtn').style.display = "none"
                                        // document.getElementById('previous').style.display = "none"
                                    }else{
                                        document.getElementById('prevnextbtn').style.display = "flex"
                                    }



                                    var dataArr = data.data;

                                    var html = "";
                                    for (let index = 0; index < data.data.data.length; index++) {
                                        const element = data.data.data[index];
                                        html += "<div class='col-md-3'>"
                                            +"<div class='card' style='margin-bottom: 10px;'>"+
                                            "<div class='card-body' style='padding: 0px;'>"+
                                            "<div class='embed-responsive embed-responsive-16by9'>"+
                                            "<iframe class='embed-responsive-item' src="+element.videourl+" allowfullscreen></iframe>"
                                            +"</div>"
                                            +"</div>"+"<div class='card-footer'>"+
                                            "<div style='display: flex;'>"+
                                            "<img src=storage/schimages/"+ element.profileimg+" class='rounded-circle' alt='' width='40px' height='40px'>"
                                            +"<div style='display: flex; flex-direction: column; margin-left: 5px;'>"+
                                            "<i style='font-size: 13px; font-style: normal;'>"+ element.title +"</i>"+"<i style='font-size: 10px; font-style: normal;'>"+element.firstname+'/'+element.classname+'/'+element.subjectcode+"</i>"
                                            +"<div>"+
                                            "<i>"+"<i style='font-size: 10px; margin-left: 2px;'>0</i>"+"<i style='color: green;' class='fas fa-thumbs-up'></i>"+"</i>"+"<i style='margin-left: 5px;'>"+"<i style='font-size: 10px; margin-left: 2px;'>0</i>"+"<i style='color: red;' class='fas fa-thumbs-down'></i>"+"</i>"
                                            +"</div>"+"</div>"+"</div>"
                                            +"</div>"
                                            +"</div>"+
                                        "</div>";
                                        // console.log(element)
                                        
                                    }
                                    $("#videosgotten").html(html);
                                    
                                }

                                },
                                error:function(errors){
                                
                                }
                            });
                            
                        }
                    });
            });


        </script>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Alpha-Sims
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->firstname }} {{Auth::user()->middlename}} {{Auth::user()->lastname}} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>


    <div class="container-fluid" style="margin-top: 70px;">
        {{-- <div class="card" style="margin-bottom: 5px;"> --}}
            <div class="row">
                <div class="col-md-7">
                    @if (Auth::user()->role != "Student")
                        <button data-toggle="collapse" data-target="#demo" class="btn btn-info btn-sm"><i class="fas fa-plus"></i> Add Video</button>
                    @endif
                    
                    <div id="demo" class="collapse">
                        <div id="videospinner" class="" style="display: none; align-Items: center; justify-content: center;">
                            <div class="spinner-border" style="height: 100px; width: 100px;"></div>
                        </div>

                        <div id="videomaincontainer">

                            <div id="alertvideo" style="display: none;" class="alert alert-info" role="alert">
                                A simple primary alert—check it out!
                            </div>

                            <form id="videoform" action="javascript:console.log('submited')" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <i style="font-style: normal; font-size: 12px;">Class</i>
                                            <select name="videoforclass" id="videoforclass" class="form-control form-control-sm" required>
                                                <option value="">Select a Class</option>
                                                @if (count($videodetails['classes']) > 0)
                                                    @foreach ($videodetails['classes'] as $classes)
                                                    <option value="{{$classes->id}}">{{$classes->classname}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <i style="font-style: normal; font-size: 12px;">Subject</i>
                                            <select name="videoforsubject" id="videoforsubject" class="form-control form-control-sm" required>
                                                <option value="">Select a Suject</option>
                                                @if (count($videodetails['addsubject']) > 0)
                                                    @foreach ($videodetails['addsubject'] as $subjects)
                                                    <option value="{{$subjects->id}}">{{$subjects->subjectname}}/{{$subjects->subjectcode}}/{{$subjects->classname}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <i style="font-style: normal; font-size: 12px;">Vide Url</i>
                                            <input type="url" name="videourl" placeholder="video url" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="form-group">
                                            <i style="font-style: normal; font-size: 12px;">Video title</i>
                                            <input type="text" name="videotitle" placeholder="video title" class="form-control form-control-sm" required>
                                        </div>
                                    </div>
                                    <div style="margin-left: 10px;">
                                        <button type="submit" id="addvideos" class="btn btn-info btn-sm">Process</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select name="" id="" class="browser-default custom-select form-control form-control-sm">
                            <option value="">select course</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="" id="" class="browser-default custom-select form-control form-control-sm">
                        <option value="">select class</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-sm btn-info" style="margin: 5px;">Filter</button>
                </div>
            </div>
        {{-- </div> --}}
        <div class="" style="">
            <div id="videosgotten" class="row">
                <div class="col-md-12" style="display: flex; height: 100px; align-items: center; justify-content: center;">
                    <div class="spinner-border" style="height: 100px; width: 100px;"></div>
                </div>
            </div>
        </div>

        <div id="prevnextbtn" style="display: none; align-items: center; justify-content: center;">
            <button id="previous" class="btn btn-sm btn-info"><i class="fas fa-angle-double-left"></i> Prev</button>
            <button id="nextdata" class="btn btn-sm btn-info">Next<i class="fas fa-angle-double-right"></i></button>
        </div>



        

    </div>
    {{-- <div style="margin-top: 150px;">
        @include('navs.footer')
    </div> --}}
</body>
</html>