<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alpha-sims FAQ</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/css/mdb.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>

    <!--Navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark default-color-dark">

            <!-- Navbar brand -->
            <a class="navbar-brand" href="/"><button class="btn btn-sm btn-white">Back</button></a>
        
            <!-- Collapse button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
            aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        
            <!-- Collapsible content -->
            <div class="collapse navbar-collapse" id="basicExampleNav">
        
            <!-- Links -->
            <ul class="navbar-nav mr-auto">
                {{-- <li class="nav-item active">
                <a class="nav-link" href="#">Home
                    <span class="sr-only">(current)</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
                </li>
        
                <!-- Dropdown -->
                <li class="nav-item dropdown">
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
            <i class="form-inline" style="color: #fff; font-style: normal; font-weight: bold;">About Alpha-Sims</i>
            </div>
            <!-- Collapsible content -->
        
        </nav>
        <!--/.Navbar-->

        <div>
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="#faq"><button type="button" class="btn btn-outline-mdb-color waves-effect"><i class="fas fa-question-circle fa-sm pr-2"
                    aria-hidden="true"></i> FAQ</button></a>
                {{-- <button type="button" class="btn btn-outline-mdb-color waves-effect"><i class="fas fa-plane fa-sm pr-2"
                    aria-hidden="true"></i>Middle</button>
                <button type="button" class="btn btn-outline-mdb-color waves-effect"><i class="fas fa-train fa-sm pr-2"
                    aria-hidden="true"></i>Right</button> --}}
              </div>
        </div>

    <div class="container-fluid" style="margin-top: 50px;">

        <div class="">
            <div class="card">
                <button class="btn btn-sm default-color-dark text-white">Elearning Module</button>
                <div style="margin: 20px;">
                    <p class="">To keep students connected and always learning anytime and anywhere, 
                        Alpha-sims eLearning module ensures distance is never a barrier. eLearning 
                        is learning which involves utilizing electronic technologies to access 
                        knowledge outside of a traditional classroom. it in most casses 
                        refer to programs delivered online.
                        Alpha-Sims provide a condusive environment for learning outside a class. 
                        Teacher and student interract on the secured platform . in addition, 
                        students can be given assignments and course materials all on the platform.
                        So, with ALpha-sims, learning never ends.
                    </p>
                </div>

                <button class="btn btn-sm default-color-dark text-white">Result Processing/Computation Module</button>
                <div style="margin: 20px;">
                    <p class="">
                        Result processing is a tedious task prone to mistakes when computed manually. 
                        Alpha-sims is here to ease result computation.
                        Imagine computing results for alot of student at a time, error will always 
                        be the outcome. you can eliminate such with alpha-sims as it computes your results giving you a print ready result printout
                    </p>
                </div>

                <button class="btn btn-sm default-color-dark text-white">Attendance Module</button>
                <div style="margin: 20px;">
                    <p class="">
                        Keeping track of all school activities is a must including attendance. Knowing the location of each student is 
                         crucial and the data required is massive. Our robust school management system will take care of all
                         that for you making querying of student attendance on demand super easy. Now parents can view their kids
                          dedication to classes. 
                    </p>
                </div>

                <button class="btn btn-sm default-color-dark text-white">Application/Admission Module</button>
                <div style="margin: 20px;">
                    <p class="">
                         Prospective students will have an option of applying to a school of their choice using a simple form. 
                         We have in place a searching system for schools to enable prospective students make informed decisions.
                         All registered schools will have an option where they can review all application and either accept or decline.
                          With alpha-sims no more tedius addmission processes.
                    </p>
                </div>

                <button class="btn btn-sm default-color-dark text-white">Library Management Module</button>
                <div style="margin: 20px;">
                    <p class="">
                        Availablity of information is of paramount importance in every stage of education and for that reason, 
                        making books easily accesible to students is key to a progressive growth. Searching for books in 
                        shelves and documenting book rentals is alot of work. To help keep knowledge sharing organized and trackable, 
                        we have developed a library system for effective management of school books/information.
                         
                    </p>
                </div>

                {{-- <button class="btn btn-sm default-color-dark text-white">Library Management Module</button>
                <div style="margin: 20px;">
                    <p class="">
                        Availablity of information is of paramount importance in every stage of education and for that reason, 
                        making books easily accesible to students is key to a progressive growth. Searching for books in 
                        shelves and documenting book rentals is alot of work. To help keep knowledge sharing organized and trackable, 
                        we have developed a library system for effective management of school books/information.
                         
                    </p>
                </div> --}}
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-top: 20px; margin-bottom: 20px;" id="faq">
        <!--Accordion wrapper-->
        <div class="accordion md-accordion accordion-3 z-depth-1-half" id="accordionEx194" role="tablist"
        aria-multiselectable="true">

        <ul class="list-unstyled d-flex justify-content-center pt-5 default-color-dark-text">
        <li><i class="fas fa-question-circle mr-3 fa-2x" aria-hidden="true" style=""></i></li>
        <li><i class="fas fa-question-circle mr-3 fa-2x" aria-hidden="true"></i></li>
        <li><i class="fas fa-question-circle mr-3 fa-2x" aria-hidden="true"></i></li>
        </ul>

        <h2 class="text-center text-uppercase default-color-dark-text py-4 px-3">Frequently Asked Questions</h2>

        <hr class="mb-0">

        <!-- Accordion card -->
        <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="heading4">
            <a data-toggle="collapse" data-parent="#accordionEx194" href="#collapse4" aria-expanded="true"
            aria-controls="collapse4">
            <h3 class="mb-0 default-color-dark-text">
                What is Alpha-Sims? <div class="animated-icon1 float-right mt-1"><span></span><span></span><span></span></div>
            </h3>
            </a>
        </div>

        <!-- Card body -->
        <div id="collapse4" class="collapse show" role="tabpanel" aria-labelledby="heading4" data-parent="#accordionEx194">
            <div class="card-body pt-0">
            <p>Alpha-Sims is a School Management System that provides all key features required for the effective 
                administration of any school: Nursery, Kindergarten, Elementary, Secondary or High school. 
                By using Alpha-Sims, you can easily implement a state-of-the-art system that can offer 
                you all the features you may need.</p>
            </div>
        </div>
        </div>
        <!-- Accordion card -->

        <!-- Accordion card -->
        <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="heading5">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx194" href="#collapse5" aria-expanded="false"
            aria-controls="collapse5">
            <h3 class="mb-0 default-color-dark-text">
                Who is eligible to use Alpha-Sims? <div class="animated-icon1 float-right mt-1"><span></span><span></span><span></span></div>
            </h3>
            </a>
        </div>

        <!-- Card body -->
        <div id="collapse5" class="collapse" role="tabpanel" aria-labelledby="heading5" data-parent="#accordionEx194">
            <div class="card-body pt-0">
            <p>Any Primary or Secondary school.</p>
            </div>
        </div>
        </div>
        <!-- Accordion card -->

        <!-- Accordion card -->
        <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="heading6">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx194" href="#collapse6" aria-expanded="false"
            aria-controls="collapse6">
            <h3 class="mb-0 default-color-dark-text">
                Of what benefit is Alpha-Sims? <div class="animated-icon1 float-right mt-1"><span></span><span></span><span></span></div>
            </h3>
            </a>
        </div>

        <!-- Card body -->
        <div id="collapse6" class="collapse" role="tabpanel" aria-labelledby="heading6" data-parent="#accordionEx194">
            <div class="card-body pt-0">
            <p>Alpha-sims is a school management system which will benefit you in easing the normal runings of your school such as:</p>
                <p style="margin: 0px;">1. Student registration</p>
                <p style="margin: 0px;">2. Teachers registration</p>
                <p style="margin: 0px;">3. Take Students and Teachers Attendance</p>
                <p style="margin: 0px;">4. Process students results</p>
                <p style="margin: 0px;">5. Student result printing.</p>
            </div>
        </div>
        </div>
        <!-- Accordion card -->

        <!-- Accordion card -->
        <div class="card">

            <!-- Card header -->
            <div class="card-header" role="tab" id="heading7">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx194" href="#collapse7" aria-expanded="false"
                aria-controls="collapse6">
                <h3 class="mb-0 default-color-dark-text">
                    How do i start using Aplha-Sims? <div class="animated-icon1 float-right mt-1"><span></span><span></span><span></span></div>
                </h3>
                </a>
            </div>
    
            <!-- Card body -->
            <div id="collapse7" class="collapse" role="tabpanel" aria-labelledby="heading7" data-parent="#accordionEx194">
                <div class="card-body pt-0">
                <p>To start using Alpha-Sims, you need to first create an account. Follow the steps below</p>
                    <p style="margin: 0px;">1. Click on register or follow this link HERE.</p>
                    <p style="margin: 0px;">2. Fill in the form and submit to create the account.</p>
                    <p style="margin: 0px;">If you are a school and after successfull registration, 
                        head to add Institution and 
                        submit and application filling 
                        the appropriate fields and selecting a school type.</p>
                </div>
            </div>
        </div>
            <!-- Accordion card -->

            <!-- Accordion card -->
        <div class="card">

            <!-- Card header -->
            <div class="card-header" role="tab" id="heading7">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx194" href="#collapse8" aria-expanded="false"
                aria-controls="collapse6">
                <h3 class="mb-0 default-color-dark-text">
                    How secure is our data? <div class="animated-icon1 float-right mt-1"><span></span><span></span><span></span></div>
                </h3>
                </a>
            </div>
    
            <!-- Card body -->
            <div id="collapse8" class="collapse" role="tabpanel" aria-labelledby="heading7" data-parent="#accordionEx194">
                <div class="card-body pt-0">
                <p>We have implemented multiple layers of security to ensure your data are safe and secure. 
                    Unauthorized individuals cannot gain access to them</p>
                </div>
            </div>
        </div>
            <!-- Accordion card -->
        </div>
        <!--/.Accordion wrapper-->
    </div>

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