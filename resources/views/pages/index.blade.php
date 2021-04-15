<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alpha-Sims</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!--<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>-->
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/css/mdb.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){

            $("#searchmaininputclicker").click(function(){
                document.getElementById('searchdisplay').style.height = "200px";
                document.getElementById("searchdisplay").style.transition = "all 0.5s";
                document.getElementById('searchformlandingpage').style.opacity = "0";
                document.getElementById('searchformmain').style.display = "flex";
                document.getElementById('btnclosesearch').style.display = "block";
                document.getElementById('myDropdown').style.visibility = "visible";
                document.getElementById('myDropdown').style.height = "150px";
                document.getElementById('myDropdown').style.transition = "all 1s";
                
                // document.getElementById('oldcontent').innerHTML = document.getElementById('myDropdown').innerHTML
                
                
            });
            

            $(function() {
                $('#contactbtn').click(function(e) {
                    e.preventDefault();
                    $("#contact-form").submit();
                    
                    document.getElementById('btn-process-contact').style.display = "block";
                    document.getElementById('contactbtn').style.display = "none";
                    document.getElementById('spinnercontact').style.display = "block";

                    $.ajax({
                    url: '/contactform',
                    type: 'post',
                    dataType: 'json',
                    data: $('form#contact-form').serialize(),
                    success: function(data) {
                        
                        document.getElementById('btn-process-contact').style.display = "none";
                        document.getElementById('contactbtn').style.display = "block";
                        document.getElementById('spinnercontact').style.display = "none";

                        // console.log(data)
                        
                        if (data.errors) {
    
                          for (let index = 0; index < data.errors.length; index++) {
                              const element = data.errors[index];
    
                              document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
    
                              // console.log(element)
                              
                            }
                          
                        }
                        
                        if(data.success){
                            $('#contact-form')[0].reset();
                            document.getElementById("alert-display_result").classList.remove('alert-primary');
                            document.getElementById("alert-display_result").classList.remove('alert-danger');
                            document.getElementById("alert-display_result").classList.add('alert-success');
                            document.getElementById("alert-display_result").style.display = "block";
                            document.getElementById("alert-display_result").innerHTML = "Message sent successfully. We will get back to you shortly.";
                        }
                        
                        if(data.notsent){
                            document.getElementById("alert-display_result").classList.remove('alert-primary');
                            document.getElementById("alert-display_result").classList.remove('alert-success');
                            document.getElementById("alert-display_result").classList.add('alert-danger');
                            document.getElementById("alert-display_result").style.display = "block";
                            document.getElementById("alert-display_result").innerHTML = "An error occured. Please, try again later.";
                        }


                        },
                        error:function(errors){
                        // console.log(errors)
                        // fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...')

                        }
                    });
            });
          });
          
          $('#contact-form').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
          });
          
          
// submit a call request...a superadmin will be expected to call the client only when it is necessary...alert-danger
          $(function() {
                $('#submitcallrequestbtn').click(function(e) {
                    e.preventDefault();
                    $("#callrequest-form").submit();

                    document.getElementById('callrequest-form').style.display = "none";
                    document.getElementById('callrequestsubmitspinner').style.display = "flex";


                    $.ajax({
                    url: '/submitcallrequest',
                    type: 'post',
                    dataType: 'json',
                    data: $('form#callrequest-form').serialize(),
                    success: function(data) {

                    console.log(data)
                    document.getElementById('callrequest-form').style.display = "block";
                    document.getElementById('callrequestsubmitspinner').style.display = "none";

                        if (data.errors) {

                            for (let index = 0; index < data.errors.length; index++) {
                                const element = data.errors[index];

                                document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");

                                // console.log(element)
                                
                            }

                        }


                        },
                        error:function(errors, status, message){
                        console.log(errors)
                        alert(status)
                        document.getElementById('callrequest-form').style.display = "block";
                        document.getElementById('callrequestsubmitspinner').style.display = "none";
                        $('#callrequest-form').trigger("reset");
                        // fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...')

                        }
                    });
            });
          });
          $('#callrequest-form').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
          });
          
          

        navigator.sayswho= (function(){
            var ua= navigator.userAgent, tem, 
            M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
            if(/trident/i.test(M[1])){
                tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
                return 'IE '+(tem[1] || '');
            }
            if(M[1]=== 'Chrome'){
                tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
                if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
            }
            M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
            if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
            return M.join(' ');
        })();

            var str = navigator.sayswho;

            var res = str.split(" ");
           if (res.length < 2) {
               
           }else{
    
               if (res[0] == "Safari") {
                if (res[1] < 13) {
                   $('#frameModalBottom').modal('show'); 
                }else{
                    
                }
               }
    
               if (res[0] == "Chrome") {
                if (res[1] < 81) {
                    $('#frameModalBottom').modal('show'); 
                }else{
                
                }
               }
               
               if(res[0] == "Firefox"){
                   if (res[1] < 77) {
                    $('#frameModalBottom').modal('show'); 
                }else{
                    
                }
               }
    
            
    
           }




        });
        
        //  grecaptcha.ready(function() {
        //      grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: '/submitcallrequest'}).then(function(token) {
        //         if (token) {
        //           document.getElementById('recaptcha').value = token;
        //         }
        //      });
        //  });
    </script>
    
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5f638f34f0e7167d0011504e/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
    <style>
            .searchvalues::-webkit-scrollbar {
            display: none;
            }

            /* Hide scrollbar for IE and Edge */
            .searchvalues {
            -ms-overflow-style: none;
            }
            
             *{padding:0;margin:0;}


            .label-container{
                position:fixed;
                bottom:48px;
                right:105px;
                display:table;
                visibility: hidden;
            }

            .label-text{
                color:#FFF;
                background:rgba(51,51,51,0.5);
                display:table-cell;
                vertical-align:middle;
                padding:10px;
                border-radius:3px;
            }

            .label-arrow{
                display:table-cell;
                vertical-align:middle;
                color:#333;
                opacity:0.5;
            }

            .float{
                position:fixed;
                width:60px;
                height:60px;
                bottom:40px;
                right:40px;
                background-color:#f0ec18;
                color:#FFF;
                border-radius:50px;
                text-align:center;
                box-shadow: 2px 2px 3px #999;
                z-index: 999;
            }

            .my-float{
                font-size:24px;
                margin-top:18px;
            }

            a.float + div.label-container {
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.5s ease;
            }

            a.float:hover + div.label-container{
            visibility: visible;
            opacity: 1;
            }
    </style>
</head>
<body>
    <!--Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark default-color-dark fixed-top scrolling-navbar">
        <a class="navbar-brand" href="/">Alpha-Sims</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
        aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
            <a class="nav-link" href="/">Home
                <span class="sr-only">(current)</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#features">Features</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Help
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
                <a class="dropdown-item" href="/messages#faq">FAQ</a>
                <a class="dropdown-item" href="#contactusformg">Contact Us</a>
                <a class="dropdown-item" href="#">Suggestions</a>
            </div>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto nav-flex-icons">
            <li class="nav-item">
                <a href="/register"><button class="btn btn-sm align-middle btn-outline-white" type="button">Get Started</button></a>
            </li>
            <li class="nav-item">
                <a href="/login"><button class="btn btn-sm align-middle btn-outline-white" type="button">Login</button></a>

            </li>
        </ul>
        </div>
    </nav>
    <!--/.Navbar -->
    
    <!--    <a href="#" class="float" data-toggle="modal" data-target="#sideModalTR">-->
    <!--    {{-- <i class="fa fa-envelope my-float"></i> --}}-->
    <!--    {{-- <i class="fas fa-question-circle my-float"></i> --}}-->
    <!--    <i class="fas fa-question my-float" style="color: black;"></i>-->
    <!--</a>-->

    <div class="container-sm" style="margin-top: 100px;">
        <div class="row">
            <div class="col-md-5">
                <div class="card shadow-none" style="border: none;">
                    <div id="searchformlandingpage">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend" style="border-radius: 0px;">
                              <span class="input-group-text" id="addon-wrapping" style="border-radius: 0px; border-right: none; background-color: #fff;"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchmaininputclicker" class="form-control" placeholder="School name or State" aria-label="School name or State" aria-describedby="addon-wrapping" style="border-radius: 0px; border-left: none; outline: 0 none; border-color: #d8d3d3; box-shadow: none; background-color: #fff;" readonly>
                        </div>
                    </div>
                    
                    <div id="searchdisplay" class="card" style="height: 0px; position: absolute; width:100%; z-index: 999; display: block; top: 0;">
                        <button id=btnclosesearch onclick="searchselect()" style="position: absolute; top: 0; right: 0; display: none; border: none; background: transparent;">x</button>
                        
                        <div class="container-fluid">
                              <div id="searchformmain" class="md-form mt-0" style="display: none; align-items: center;">
                                  <i class="fas fa-search" style="margin-right: 5px;"></i>
                                <input type="text" id="myInput" onkeyup="filterFunction()" class="form-control" placeholder="Search by school name or state" autocomplete="off">
                              </div>
                              <div id="myDropdown" class="searchvalues" style="overflow-y: scroll; height: 0px; display: flex; flex-direction: column;">
                                @if (count($addpost) > 0)
                                    @foreach ($addpost as $schools)
                                        <a href="#" style="font-style: normal; font-size: 13px; text-decoration: none; color: black; margin: 2px 2px 2px 10px;" onclick="fetchSelectedSchool('{{$schools->schoolname}}', '{{$schools->schooladdress}}', '{{$schools->dateestablished}}', '{{$schools->schooltype}}', '{{$schools->mobilenumber}}', '{{$schools->schoolemail}}', '{{$schools->schoolstate}}', '{{$schools->schoolLogo}}')">{{$schools->schoolname}} <i style="font-size: 10px;">{{$schools->schoolstate}}</i></a>
                                    @endforeach
                                @endif
                              </div>
                              
                              
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 50px;">
            <div class="col-md-6">
                <h2>Introducing an All-in-one solution for managing Schools.</h2>
            </div>
            <!--<textarea id="oldcontent"></textarea>-->
        </div>
        <div class="">
            <div class="row no-gutters" style="margin-top: 20px;">
                <div class="col-md-6 col-6">
                    <div class="card" style="margin-right:5px;">
                        <div class="row no-gutters" style="">
                            <div id="imagesforcardhomepage" class="col-md-4 imagesforcardhomepagewhat" style="border-radius: 5px 5px 5px 5px;">
                            {{-- <img src="{{asset('images/whatisalpha.png')}}" alt=""> --}}
                            </div>
                            <div class="col-md-8" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <div>
                                    <div style="margin: 0px 0px 0px 15px;">
                                        <i id="cardTitle" style="font-style: normal; font-weight: bold;">What is Alpha-Sims</i>
                                        <i id="desktoponlycardtext" style="font-style: normal; font-size: 13px;">Alpha-sims is a leading school information management system, designed to...</i><br>
                                        <i id="mobileonlycardtext" style="font-style: normal; font-size: 13px;">Alpha-sims is a leading school information management system, designed to...</i><br>
                                    </div>
                                    <a href="/messages"><button id="btn-desktop" class="btn default-color-dark text-white btn-sm">Read More <i class="fas fa-angle-right"></i></button></a>
                                    <a href="/messages" id="btn-mobile" style="margin: 0 auto; text-align: center;">Read More <i class="fas fa-angle-right"></i></a>
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-6">
                    <div class="card" style="margin-left: 5px;">
                        <div class="row no-gutters">
                            <div id="imagesforcardhomepage" class="col-md-4 imagesforcardhomepageget" style="border-radius: 5px 5px 5px 5px;">
    
                            </div>
                            <div class="col-md-8" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <div>
                                    <div style="margin: 0px 0px 0px 15px;">
                                        <i id="cardTitle" style="font-style: normal; font-weight: bold;">Get Started</i>
                                        <i id="desktoponlycardtext" style="font-style: normal; font-size: 13px;">Alpha-sims is just a click away, you can get started rightaway.</i><br>
                                        <i id="mobileonlycardtext" style="font-style: normal; font-size: 13px;">Alpha-sims is just a click away, you can get started rightaway.</i><br>
                                    </div>
                                    <button id="btn-desktop" class="btn default-color-dark text-white btn-sm">Get Started Now <i class="fas fa-angle-right"></i></button>
                                    <a href="#" id="btn-mobile" style="margin: 0 auto; text-align: center;">Get Started <i class="fas fa-angle-right"></i></a>
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="features" class="default-color-dark" style="margin-top: 50px;">
        <div class="container">
            <!-- Card deck -->
            <div class="card-deck">

                <!-- Card -->
                <div class="card mb-4 shadow-none" style="margin-top: 50px; background: transparent; border: none;">
            
                <!--Card image-->
                <div class="view overlay">
                    <img class="card-img-top" src="{{ asset('images/mainsecurity.png')}}"
                    alt="Card image cap">
                    <a href="#!">
                    <div class="mask rgba-white-slight"></div>
                    </a>
                </div>
            
                <!--Card content-->
                <div class="card-body">
            
                    <!--Title-->
                    <h4 class="card-title text-white">Security</h4>
                    <!--Text-->
                    <p class="card-text text-white">We have implemented multiple layers of security to ensure your data are safe and secure. Unauthorized individuals cannot gain access to them...</p>
                    <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
                    {{-- <button type="button" class="btn btn-white btn-md">Read more</button> --}}
            
                </div>
            
                </div>
                <!-- Card -->
            
                <!-- Card -->
                <div class="card mb-4 shadow-none" style="margin-top: 50px; background: transparent; border: none;">
            
                <!--Card image-->
                <div class="view overlay">
                    <img class="card-img-top" src="{{ asset('images/elraningmain.png')}}"
                    alt="Card image cap">
                    <a href="#!">
                    <div class="mask rgba-white-slight"></div>
                    </a>
                </div>
            
                <!--Card content-->
                <div class="card-body">
            
                    <!--Title-->
                    <h4 class="card-title text-white">eLearning</h4>
                    <!--Text-->
                    <p class="card-text text-white">To keep students connected and always learning anytime and anywhere, Alpha-sims eLearning module ensures distance is never a barrier.</p>
                    <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
                    {{-- <button type="button" class="btn btn-white btn-md">Read more</button> --}}
            
                </div>
            
                </div>
                <!-- Card -->
            
                <!-- Card -->
                <div class="card mb-4 shadow-none" style="margin-top: 50px; background: transparent; border: none;">
            
                <!--Card image-->
                <div class="view overlay">
                    <img class="card-img-top" src="{{ asset('images/resultprocess.png') }}"
                    alt="Card image cap">
                    <a href="#!">
                    <div class="mask rgba-white-slight"></div>
                    </a>
                </div>
            
                <!--Card content-->
                <div class="card-body">
            
                    <!--Title-->
                    <h4 class="card-title text-white">Result Processing</h4>
                    <!--Text-->
                    <p class="card-text text-white">Result processing is a tedious task prone to mistakes when computed manually. Alpha-sims is here to ease result computation... </p>
                    <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
                    {{-- <button type="button" class="btn btn-white btn-md">Read more</button> --}}
            
                </div>
            
                </div>
                <!-- Card -->
            
            </div>
            <!-- Card deck -->
        </div>

    </div>

    <div style="background-color: #fff;">

        <div class="container">
            <div class="row">
                <div class="col-md-4" style="height: 300px; display: flex; flex-direction: center; align-items: center;">
                    <div>
                        <i style="font-style: normal; font-size: 25px; font-weight: bold;">Access endless benefits with Alpha-sims Within minutes.</i><br>
                        {{-- <i>Health articles that keep you informed about good health practices and achieve your goals.</i><br> --}}
                        <a href="/messages"><button class="btn default-color-dark text-white">Want to see more</button></a>
                    </div>
                </div>
                <div class="col-md-8" style="">

                    <!-- Card deck -->
                    <div class="card-deck">

                        <!-- Card -->
                        <div class="card mb-4 shadow-none" style="margin-top: 20px; border: none;">
                    
                        <!--Card image-->
                        <div class="view overlay">
                            {{-- <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Others/images/16.jpg"
                            alt="Card image cap"> --}}
                            {{-- <div class="bg-success" style="display: flex; align-items: center; justify-content: center;"> --}}
                                <i class="fas fa-users card-img-top text-center" style="font-size: 60px;"></i>
                            {{-- </div> --}}
                            <a href="#!">
                            <div class="mask rgba-white-slight"></div>
                            </a>
                        </div>
                    
                        <!--Card content-->
                        <div class="card-body">
                    
                            <!--Title-->
                            <h4 class="card-title">Parents</h4>
                            <!--Text-->
                            <p class="card-text">Parents can access their kids records both academic and behevioral anywhere anytime.</p>
                    
                        </div>
                    
                        </div>
                        <!-- Card -->
                    
                        <!-- Card -->
                        <div class="card mb-4 shadow-none" style="margin-top: 20px; border: none;">
                    
                        <!--Card image-->
                        <div class="view overlay">
                            {{-- <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Others/images/14.jpg"
                            alt="Card image cap"> --}}
                            <i class="fas fa-user-graduate card-img-top text-center" style="font-size: 60px;"></i>
                            <a href="#!">
                            <div class="mask rgba-white-slight"></div>
                            </a>
                        </div>
                    
                        <!--Card content-->
                        <div class="card-body">
                    
                            <!--Title-->
                            <h4 class="card-title">Students</h4>
                            <!--Text-->
                            <p class="card-text">Students data and result processing is an important aspect in every school and requires alot of time. Alpha-Sims will help process result print ready.</p>
                    
                        </div>
                    
                        </div>
                        <!-- Card -->
                    
                        <!-- Card -->
                        <div class="card mb-4 shadow-none" style="margin-top: 20px; border: none;">
                    
                        <!--Card image-->
                        <div class="view overlay">
                            {{-- <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Others/images/15.jpg"
                            alt="Card image cap"> --}}
                            <i class="fas fa-school card-img-top text-center" style="font-size: 60px;"></i>
                            <a href="#!">
                            <div class="mask rgba-white-slight"></div>
                            </a>
                        </div>
                    
                        <!--Card content-->
                        <div class="card-body">
                    
                            <!--Title-->
                            <h4 class="card-title">Schools</h4>
                            <!--Text-->
                            <p class="card-text">Keeping track of school activities requires alot of record keeping and consumes time, so, we at Aplha-sims are dedicated to ensuring your school processes are easy.</p>
                    
                        </div>
                    
                        </div>
                        <!-- Card -->
                    
                    </div>
                    <!-- Card deck -->

                </div>
            </div>
        </div>
    </div>
    <hr style="width: 90%;">

    <style>
        .carousel-item.active,
        .carousel-item-next,
        .carousel-item-prev{
            display:block;
        }
    </style>


    <div class="container" id="contactusform">
        <!--Section: Contact v.2-->
            <section class="mb-4">

                <!--Section heading-->
                <h2 class="h1-responsive font-weight-bold text-center my-4">Contact us</h2>
                <!--Section description-->
                <p class="text-center w-responsive mx-auto mb-5">Do you have any questions? Please do not hesitate to contact us directly. Our team will come back to you within
                    a matter of minutes to help you.</p>

                    <div class="d-flex justify-content-center">
                        <div id="spinnercontact" class="spinner-border" role="status" style="display: none;">
                          <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    <div id="alert-display_result" class="alert alert-primary" role="alert" style="display: none;">
                        A simple primary alert—check it out!
                    </div>

                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-12 mb-md-0 mb-5">
                        <form id="contact-form" name="contact-form" action="javascript:console.log('submitted')" method="POST">
                            @csrf
                            <!--Grid row-->
                            <div class="row">

                                <!--Grid column-->
                                <div class="col-md-4">
                                    <div class="md-form mb-0">
                                        <input type="text" id="name" name="name" class="form-control">
                                        <label for="name" class="">Your name</label>
                                    </div>
                                </div>
                                <!--Grid column-->

                                <!--Grid column-->
                                <div class="col-md-4">
                                    <div class="md-form mb-0">
                                        <input type="text" id="email" name="email" class="form-control">
                                        <label for="email" class="">Your email</label>
                                    </div>
                                </div>
                                <!--Grid column-->

                                <!--Grid column-->
                                <div class="col-md-4">
                                    <div class="md-form mb-0">
                                        <input type="text" id="number" name="Phone_Number" class="form-control">
                                        <label for="number" class="">Your Phone Number</label>
                                    </div>
                                </div>

                            </div>
                            <!--Grid row-->

                            <!--Grid row-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="md-form mb-0">
                                        <input type="text" id="subject" name="subject" class="form-control">
                                        <label for="subject" class="">Subject</label>
                                    </div>
                                </div>
                            </div>
                            <!--Grid row-->

                            <!--Grid row-->
                            <div class="row">

                                <!--Grid column-->
                                <div class="col-md-12">

                                    <div class="md-form">
                                        <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea"></textarea>
                                        <label for="message">Your message</label>
                                    </div>

                                </div>
                            </div>
                            <!--Grid row-->

                        </form>

                        <div class="text-center text-md-left">
                            <button id="contactbtn" type="submit" class="btn btn-sm default-color-dark text-white" form="contact-form">Send</button>
                            
                            <button id="btn-process-contact" class="btn btn-sm default-color-dark" type="button" disabled style="display: none;">
                              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                              Loading...
                            </button>
                        </div>
                        <div class="status"></div>
                    </div>
                    <!--Grid column-->

                </div>

            </section>
            <!--Section: Contact v.2-->
    </div>
    
    <!-- Full Height Modal Right -->
        <div class="modal fade right" id="schooprofilemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
        
            <!-- Add class .modal-full-height and then add class .modal-right (or other classes from list above) to set a position to the modal -->
            <div class="modal-dialog modal-full-height modal-right" role="document">
        
        
            <div class="modal-content">
                <div class="modal-header">
                <h6 class="modal-title w-100" id="myModalLabel">Modal title</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                
                    <div class="text-center" style="width: 100px; height: 100px; margin: 0 auto;">

                        <img id="schoolimg" src="" class="img-fluid z-depth-1 rounded-circle"
                        alt="Responsive image">

                    </div>
                    <br>
                    <div>
                        <ul class="list-group">
                            {{-- <li class="list-group-item disabled">School Name</li> --}}
                            <li id="schooladdressmodel" class="list-group-item">School Address</li>
                            <li id="dateestablished" class="list-group-item">Year establisched</li>
                            <li id="schooltype" class="list-group-item">school type</li>
                            <li id="mobilenumber" class="list-group-item">Phone number</li>
                            <li id="schoolemail" class="list-group-item">Email Address</li>
                            <li id="schoolstate" class="list-group-item">State</li>
                            <li class="list-group-item">Application Status</li>
                        </ul>
                    </div>


                </div>
                <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-danger waves-effect btn-sm" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-sm btn-primary">Save changes</button> --}}
                </div>
            </div>
            </div>
        </div>
        <!-- Full Height Modal Right -->
        
        <!-- To change the direction of the modal animation change .right class -->
            <div class="modal fade right" id="sideModalTR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">

            <!-- Add class .modal-side and then add class .modal-top-right (or other classes from list above) to set a position to the modal -->
            <div class="modal-dialog modal-side modal-bottom-right" role="document">


                <div class="modal-content" style="border-radius: 0px;">
                <div class="modal-header">
                    <h4 class="modal-title w-100" id="myModalLabel"><i class="fas fa-headset"></i> Contact Us</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--<div class="alert alert-info">-->
                    <!--    Don't know where to start? Submit the form and we will give you a call.-->

                    <!--</div>-->

                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <i class="far fa-envelope" style="padding: 5px;"></i>
                                    <i>Send a Message</i>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card">
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                        <i class="fas fa-cogs" style="padding: 5px;"></i>
                                        <i>Report an Issue</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger px-3" data-dismiss="modal"><i class="fas fa-times" aria-hidden="true"></i></button>
                    <!--<button type="submit" id="submitcallrequestbtn" class="btn btn-success px-3" form="callrequest-form"><i class="fas fa-chevron-right" aria-hidden="true"></i></button>-->
                </div>
                </div>
            </div>
            </div>
            <!-- Side Modal Top Right -->



<!-- browser check-->
<!-- Button trigger modal -->
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#frameModalBottom">-->
<!--  Launch demo modal-->
<!--</button>-->

        <!-- Frame Modal Bottom -->
        <div class="modal fade bottom" id="frameModalBottom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true" data-backdrop="false">
        
          <!-- Add class .modal-frame and then add class .modal-bottom (or other classes from list above) to set a position to the modal -->
          <div class="modal-dialog modal-frame modal-bottom" role="document">
        
        
            <div class="modal-content">
              <div class="modal-body">
                <div class="row d-flex justify-content-center align-items-center">
        
                  <p class="pt-3 pr-2">We noticed you are using an older version of a browser which might make some features not work. Please, update your browser to gain full access.</p>
        
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                  <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Frame Modal Bottom -->



    {{-- <div>
        <div class="container-fluid" style="height: 200px;">
            <div style="display: flex; align-items: center; justify-content: center;">
                <i style="font-style: normal; font-size: 25px; font-weight: bold; text-align: center;">What our users have to say</i>
            </div>
            <div class="container">
                <div id="carouselContent" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active text-center p-4">
                            <div id="testimonialscarousel" style= "margin: 0 auto;">
                                <p>Some quick example text to build on the card title and make up the bulk of the card's content.
                                    Some quick example text to build on the card title and make up the bulk of the card's content.
                                    Some quick example text to build on the card title and make up the bulk of the card's content..
                                </p>
                                <i><i class="fas fa-user-circle"></i> name name name</i>
                            </div>
                        </div>
                        <div class="carousel-item text-center p-4">
                            
                            <div id="testimonialscarousel" style="margin: 0 auto;">
                                <p>Some quick example text to build on the card title and make up the bulk of the card's content.
                                    Some quick example text to build on the card title and make up the bulk of the card's content.
                                    Some quick example text to build on the card title and make up the bulk of the card's content..
                                </p>
                                <i><i class="fas fa-user-circle"></i> name name name</i>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselContent" role="button" data-slide="prev">
                        <i class="fas fa-angle-left" style="color: black;"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselContent" role="button" data-slide="next">
                        <i class="fas fa-angle-right" style="color: black;"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
    

    <div style="margin-top: 30px;">
        <!-- Footer -->
        <footer class="page-footer font-small default-color-dark pt-4">

            <!-- Footer Text -->
            <div class="container-fluid text-center text-md-left">
        
            <!-- Grid row -->
            <div class="row">
        
                <!-- Grid column -->
                <div class="col-md-6 mt-md-0 mt-3">
        
                    <form action="">
                        @csrf
                        Join our mailing list to recieve awesome information about our system to your school upto-date.
                        <div class="form-group">
                            <i style="font-size: 12px; color: #fff; font-style: normal;">NewsLetter</i>
                            <input type="text" placeholder="email address" class="form-control form-control-sm">
                        </div>
                        <button class="btn-sm btn text-black btn-white">Join</button>
                    </form>
        
                </div>
                <!-- Grid column -->
        
                <hr class="clearfix w-100 d-md-none pb-3">
        
                <!-- Grid column -->
                <div class="col-md-6 mb-md-0 mb-3">

                    <h4>How do i start using Alpha-sims?</h4>
        
                    To start using Alpha-Sims, you need to first create an account. Follow the steps below
                    1. Click on register or follow this link HERE.
                    2. Fill in the form and submit to create the account.
                    3. If you are a school and after successfull registration, head to add Institution and submit and application filling the appropriate fields and selecting a school type.
        
                </div>
                <!-- Grid column -->
        
            </div>
            <!-- Grid row -->
        
            </div>
            <!-- Footer Text -->
        
            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2020 Copyright:
            <a href="#"> Alpha-Sims.com</a>
            </div>
            <!-- Copyright -->
  
        </footer>
        <!-- Footer -->
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
        function searchselect(){
            // alert('worked')
            // document.getElementById('searchdisplay').style.display = "none";
            // document.getElementById('searchformlandingpage').style.opacity = "1";
            
                document.getElementById('searchdisplay').style.height = "0px";
                document.getElementById("searchdisplay").style.transition = "all 1s";
                document.getElementById('searchformlandingpage').style.opacity = "1";
                document.getElementById('searchformmain').style.display = "none";
                document.getElementById('btnclosesearch').style.display = "none";
                document.getElementById('myDropdown').style.visibility = "hidden";
                document.getElementById('myDropdown').style.height = "0px";
                // document.getElementById('myInput').value = '';
        }

        function filterFunction() {
            var input, filter, ul, li, a, i;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            div = document.getElementById("myDropdown");
            a = div.getElementsByTagName("a");
            for (i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
                } else {
                a[i].style.display = "none";
                }
            }
        }
        
        function fetchSelectedSchool(schoolname, schooladdress, dateestablished, schooltype, mobilenumber, schoolemail, schoolstate, schoollogo){
            // alert(schoolname);

            document.getElementById('myModalLabel').innerHTML = schoolname;
            document.getElementById('schooladdressmodel').innerHTML = schooladdress;
            document.getElementById('dateestablished').innerHTML = 'Established '+ dateestablished;
            document.getElementById('schooltype').innerHTML = 'School Type '+ schooltype;
            document.getElementById('mobilenumber').innerHTML = 'Phone '+ mobilenumber;
            document.getElementById('schoolemail').innerHTML = 'Email '+ schoolemail;
            document.getElementById('schoolstate').innerHTML = 'State '+ schoolstate;
            document.getElementById('schoolimg').src = "storage/schimages/"+schoollogo;

            $("#schooprofilemodal").modal("show");
        }
    </script>
</body>
</html>