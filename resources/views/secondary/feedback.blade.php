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

            });


        </script>
        
        <!--<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>-->
        
         <script src="https://www.google.com/recaptcha/api.js"></script>
         
          <script>
           function onSubmit(token) {
             document.getElementById("demo-form").submit();
           }
          </script>
        

</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
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


    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <i style="font-size: 25px; font-style: normal; font-weight: bold; padding: 10px 0px 10px 0px; ">FeedBack...</i>
    </div>
    
    <div class="container-fluid">
            <div class="row">
            <div class="col-12 col-sm-3 col-lg-3"></div>
            <div class="col-12 col-sm-6 col-lg-6">
            @include('layouts.message')
            <form id="demo-form" action="add_feedback" method="post">
                @csrf
                <div class="form-group">
                    <label>Select a relevant subject</label>
                    <select class="form-control form-control-sm" name="issueselected">
                        <option>Select a relevant subject</option>
                        <option>Account Issue</option>
                        <option>Payment</option>
                        <option>Report a bug</option>
                        <option>Data and Privacy</option>
                        <!--<option>Select a relevant subject</option>-->
                    </select>
                </div>
                <!--<input type="hidden" name="recaptcha" id="recaptcha">-->
                <div class="form-group">
                    <label>Account Type</label>
                    <input class="form-control form-control-sm" name="accounttype" type="text" value="{{Auth::user()->role}}" readonly>
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <textarea class="form-control form-control-sm" name="content" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label>Attachment (optional)</label>
                    <input class="form-control form-control-sm" type="file" name="attachment" value="">
                </div>
                <button class="btn btn-sm btn-info g-recaptcha" data-sitekey="{{ config('services.recaptcha.sitekey') }}" 
        data-callback='onSubmit' 
        data-action='submit'>Send Message</button>
            </form>
            </dvi>
            </div>
            <div class="col-12 col-sm-3 col-lg-3"></div>
        </div>
    </div>
    <div style="margin-top: 150px;">
        @include('navs.footer')
    </div>
</body>
</html>