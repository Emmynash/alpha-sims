<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alpha-sims Library</title>
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

        body{
            background-image: url('/images/newbackmm.jpg');
            background-repeat: no-repeat;
            background-size: cover
        }
    </style>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

    <script>
        $(document).ready(function () {
            $("#bookUploadBtn").click(function (event) {

            //stop submit the form, we will post it manually.
            event.preventDefault();

            // Get form
            var form = $('#bookUploadForm')[0];

            document.getElementById('spinneraddbook').style.display = "flex";
            document.getElementById('bookUploadBtn').style.display = "none";

            // Create an FormData object
            var data = new FormData(form);

            var fileInput = document.getElementById('idfilemail');
            var file = fileInput.files[0];

            // If you want to add an extra field for the FormData
            data.append('file', file);

            // disabled the submit button
            // $("#fileUploadBtn").prop("disabled", true);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "{{ route('book-upload') }}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    console.log(data)

                    document.getElementById('spinneraddbook').style.display = "none";
                    document.getElementById('bookUploadBtn').style.display = "block";
                    document.getElementById('bookuploadedindicator').style.display = "block";

                    if(data.errors){
                        document.getElementById('alertconfirmaddbook').classList.add('alert-danger');
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-success');
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-info');
                        document.getElementById('alertconfirmaddbook').innerHTML = "Check the form below for errors";

                        for (let index = 0; index < data.errors.length; index++) {
                            const element = data.errors[index];
                            document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                        }
                    }


                    if (data.imgerr) {

                        document.getElementById('alertconfirmaddbook').classList.add('alert-danger');
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-success');
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-info');
                        document.getElementById('alertconfirmaddbook').innerHTML = "book cover is a compulsory feilds";


                    }

                    if (data.success) {
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-danger');
                        document.getElementById('alertconfirmaddbook').classList.add('alert-success');
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-info');
                        document.getElementById('alertconfirmaddbook').innerHTML = "Book added successfully";

                        $('#bookUploadForm')[0].reset();

                        
                    }

                    if (data.already) {
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-danger');
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-success');
                        document.getElementById('alertconfirmaddbook').classList.add('alert-info');
                        document.getElementById('alertconfirmaddbook').innerHTML = "Book already added!";
                        
                    }


                },
                error: function (e) {
                    document.getElementById('spinneraddbook').style.display = "none";
                    document.getElementById('bookUploadBtn').style.display = "block";

                    document.getElementById('alertconfirmaddbook').classList.remove('alert-danger');
                    document.getElementById('alertconfirmaddbook').classList.remove('alert-success');
                    document.getElementById('alertconfirmaddbook').classList.add('alert-info');
                    document.getElementById('alertconfirmaddbook').innerHTML = "an unknown error occured. Please, try again later";

                }
            });

            });

//-------------------------------------------------------------------------------------------
//                                    add e-book to database
//-------------------------------------------------------------------------------------------

            $("#ebookUploadbtn").click(function (event) {

            //stop submit the form, we will post it manually.
            event.preventDefault();

            // Get form
            var form = $('#ebookUploadForm')[0];

            document.getElementById('spinneraddbook').style.display = "flex";
            document.getElementById('ebookUploadbtn').style.display = "none";

            // Create an FormData object
            var data = new FormData(form);

            var fileInput = document.getElementById('idfilemail');
            var file = fileInput.files[0];

            var fileInputebook = document.getElementById('ebookmainfile');
            var fileebook = fileInputebook.files[0];

            // If you want to add an extra field for the FormData
            data.append('file', file);
            data.append('fileebook', fileebook);

            // disabled the submit button
            // $("#fileUploadBtn").prop("disabled", true);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "{{ route('book-upload') }}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    console.log(data)

                    document.getElementById('spinneraddbook').style.display = "none";
                    document.getElementById('ebookUploadbtn').style.display = "block";
                    document.getElementById('bookuploadedindicator').style.display = "block";

                    if(data.errors){
                        document.getElementById('alertconfirmaddbook').classList.add('alert-danger');
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-success');
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-info');
                        document.getElementById('alertconfirmaddbook').innerHTML = "All fields are required";

                        for (let index = 0; index < data.errors.length; index++) {
                            const element = data.errors[index];
                            document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                        }
                    }


                    if (data.imgerr) {
                        document.getElementById('alertconfirmaddbook').classList.add('alert-danger');
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-success');
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-info');
                        document.getElementById('alertconfirmaddbook').innerHTML = "Book cover and ebook pdf are required fields";

                    }

                    if (data.success) {
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-danger');
                        document.getElementById('alertconfirmaddbook').classList.add('alert-success');
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-info');
                        document.getElementById('alertconfirmaddbook').innerHTML = "Book added successfully.";

                        $('#ebookUploadForm')[0].reset();
                        
                    }

                    if (data.already) {
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-danger');
                        document.getElementById('alertconfirmaddbook').classList.remove('alert-success');
                        document.getElementById('alertconfirmaddbook').classList.add('alert-info');
                        document.getElementById('alertconfirmaddbook').innerHTML = "Book already added!";
                        
                    }


                },
                error: function (e) {
                    document.getElementById('spinneraddbook').style.display = "none";
                    document.getElementById('ebookUploadbtn').style.display = "block";

                    document.getElementById('alertconfirmaddbook').classList.add('alert-danger');
                    document.getElementById('alertconfirmaddbook').classList.remove('alert-success');
                    document.getElementById('alertconfirmaddbook').classList.remove('alert-info');
                    document.getElementById('alertconfirmaddbook').innerHTML = "An unknowm error occured";

                }
            });

            });

//-------------------------------------------------------------------------------------------


            $(function() {
                $('#addcategorybtn').click(function(e) {
                    e.preventDefault();
                    $("#addcategoryform").submit();

                    // document.getElementById('psycospinner').style.display = "flex";

                    $.ajax({
                    url: '{{ route('category_library') }}',
                    type: 'post',
                    dataType: 'json',
                    data: $('form#addcategoryform').serialize(),
                    success: function(data) {

                    // document.getElementById('psycospinner').style.display = "none";

                        console.log(data);

                        if(data.errors){
                            for (let index = 0; index < data.errors.length; index++) {
                                    const element = data.errors[index];
                                    document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                            }
                        }

                        if (data.success) {
                            document.getElementById('catprocessindicator').style.display = "block";
                            location.reload();
                        }


                        

                        },
                        error:function(errors){
                        console.log(errors)
                        }
                    });
                });
            });

            $('#addcategoryform').on('keypress change', function(e) {
                // console.log(e);
                document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
            });


//-------------------------------------------------------------------------------------------------
//                                       fetch all books
//-------------------------------------------------------------------------------------------------

                    $(function(){
                        var page = 1;
                        var from = 0;
                        var total = 0;
                        var pagelimit = 6;
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
                            // document.getElementById('booksgotten').style.display = "block";
                            $.ajax({
                            url: '{{ route('all_books') }}',
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
                            prev_page_url = data.data.prev_page_url

                            // document.getElementById('booksgotten').style.display = "none";

                            console.log(data)

                                if (data.data) {

                                    if (page == lastpage) {
                                        document.getElementById('nextdata').style.display = "none"
                                        document.getElementById('previous').style.display = "flex"
                                    }else{
                                        document.getElementById('prevnextbtn').style.display = "flex"
                                        document.getElementById('nextdata').style.display = "flex"
                                        document.getElementById('previous').style.display = "flex"
                                    }

                                    if (prev_page_url == null && page != lastpage) {
                                        document.getElementById('nextdata').style.display = "flex"
                                        document.getElementById('previous').style.display = "none"
                                    }

                                    document.getElementById('currentpagecount').innerHTML = page;
                                    document.getElementById('lastpagecount').innerHTML = lastpage;



                                    var dataArr = data.data;

                                    var html = "";

                                    if (data.data.data.length >0) {
                                        for (let index = 0; index < data.data.data.length; index++) {
                                        const element = data.data.data[index];

                                        var available = "";
                                        var borrowed = "";

                                        if (element.available == null) {
                                            available = "---"
                                        }else{
                                            available = element.available
                                        }

                                        if (element.borrowed == null) {
                                            borrowed = "---"
                                        }else{
                                            borrowed = element.available
                                        }

                                        a = element.aboutbook;
                                        a = a.replace(/'/g, "\\'");
                                        a = a.replace(/\./g, '\\.')

                                        var idforabouttext = "idforabouttext"+element.id;

                                        // console.log(idforabouttext)
                                        
                                        // document.getElementById(idforabouttext).value = element.aboutbook;

                                        html += "<div class='col-md-2' style='margin-bottom: 30px;'><div class='card' style='height: 200px; margin-bottom:5px; display: flex; flex-direction: column;'>"+"<div class='text-center' style='height: 70%;'><img src='/storage/cover/"+element.file+"' alt='' width='auto' height='100%'></div>"+"<div class='default-color-dark' style='height: 30%;'><div class='text-center' style='display: flex; flex-direction: column;''>"+"<i class='text-white' style='font-style: normal; font-size: 10px;'>"+element.booktitle+"</i>"+"<h5 class='cat_text'><i class='text-white' style='font-style: normal; font-size: 10px;'>"+element.categoryname+"</i></h5>"+"</div></div>"+"<div class='default-color-dark' style='display: flex; align-items: center; justify-content: center; margin-bottom: -5px;'><button onclick=\"detailsModal('"+element.booktitle+"', '"+idforabouttext+"', '"+element.bookauthor+"', '"+element.categoryname+"', '"+element.id+"', '"+element.file+"', '"+element.bookisbn+"', '"+element.datebook+"', '"+element.booktype+"', '"+element.fileebook+"')\" style='padding: 5px; font-size: 9px;' class='btn btn-sm btn-info'><i class='fas fa-eye'></i> Details</button><textarea id='"+idforabouttext+"' style='display: none;'>"+element.aboutbook+"</textarea></div>"+"</div></div>";
                                            
                                        }
                                        $("#bookssgotten").html(html);
                                        notificationModal();
                                    }
                                    
                                    
                                    
                                }

                                },
                                error:function(errors){

                                    // document.getElementById('booksgotten').style.display = "none";
                                
                                }
                            });
                            
                        }
                    });

            $(function() {
                $('#abortajax').click(function(e) {
                    // alert('jj');
                });
            });

            $('#aboutthebook').on('focus keypress', '.sam_notes', function (e) {
    
                var $this = $(this);
                var msgSpan = $this.parents('#aboutthebook').find('.counter_msg');
                var ml = parseInt($this.attr('maxlength'), 10);
                var length = this.value.length;
                var msg = ml - length + ' characters of ' + ml + ' characters left';

                msgSpan.html(msg);
            });

//--------------------------------------------------------------------------------------------------------------------
//                                              notification show determinant
//--------------------------------------------------------------------------------------------------------------------


            function notificationModal(){

                $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                  });
                    $.ajax({
                      url:"/cookie/get", //the page containing php script
                      method: "get", //request type,
                      cache: false,
                      data: {seen: 1 },
                      success:function(result){

                        // console.log(result)

                        var notificatiokey = document.getElementById('userrolefornotification').value

                        if (notificatiokey == "Librarian") {
                            if (result.success != "1") {
                                $("#notificationmodal").modal()
                            }
                        }

                    },
                    error:function(){
                      console.log('failed')
                    }
                  });
            }

        });
    </script>
</head>
<body>
    <!--Navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark default-color-dark">

            <!-- Navbar brand -->
            <a class="navbar-brand" href="/school_library">The Library</a>
        
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
                <a class="nav-link" href="/home">Dashboard
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
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Menu</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/trackbook">My Books</a>
                    <!--<a class="dropdown-item" href="#">Another action</a>-->
                    <!--<a class="dropdown-item" href="#">Something else here</a>-->
                </div>
                </li>
        
            </ul>
            <!-- Links -->
        
            {{-- <form class="form-inline">
                <div class="md-form my-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                </div>
            </form> --}}
            @if (Auth::user()->hasRole('Librarian'))
                <a href="/view_all_books"><button type="button" class="btn btn-sm btn-outline-default waves-effect">View all Books(Admin)</button></a>
            @endif
            
            </div>
            <!-- Collapsible content -->
        
        </nav>
        <!--/.Navbar-->

        <div class="container-fluid" style="margin-top: 10px;">
            @if (Auth::user()->hasRole('Librarian'))
                <div class="col-md-6" style="">
                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#centralModalSm">Books</button>

                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#centralModalcat">Categories</button>
                    
                    <a href="/trackbook"><button class="btn btn-sm btn-info">Track</button></a>
                </div>
            @endif

            <div class="card" style="">
                <div class="row">
                    <div class="col-md-6">
                        <form action="">
                            <div class="row" style="margin: 10px;">
                                <div class="col-md-6" style="display: flex; flex-direction: row;">
                                    <button class="" style="background: #fff; border: none; border-top: 1px solid rgb(202, 199, 199); border-bottom: 1px solid rgb(202, 199, 199); border-left: 1px solid rgb(202, 199, 199);" disabled><i class="fas fa-filter"></i></button>
                                    <select class="form-control form-control-sm bootstrap-select" id="myFilter" onchange="myFunction()" style="border-radius: 0px; border-left: none; border:1px solid #ddd;">
                                        <option value="">Select a Category</option>
                                    @if (count($libcategory) > 0)
                                        @foreach ($libcategory as $library)
                                            <option style="text-transform: uppercase;" value="{{$library->id}}">{{$library->categoryname}}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div style="display: flex; align-items: center; flex-direction: column;">
                            <h4 style="font-family: 'Piedra', cursive;">You are now in the Library</h4>
                            @if($addschool != null)
                                <h6 style="font-family: 'Piedra', cursive;">{{$addschool->schoolname}}</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div>
                <div class="row" id="bookssgotten">
                    <div class="col-md-2" id="categorysearch">
                        {{-- <div class="card" style="height: 200px; margin-bottom:5px; display: flex; flex-direction: column;">
                            <div class="text-center" style="height: 70%;">
                            <img src="{{asset('images/bookcover.png')}}" alt="" width="auto" height="100%">
                            </div>
                            <div class="default-color-dark" style="height: 30%;">
                                <div class="text-center" style="display: flex; flex-direction: column;">
                                    <i class="text-white" style="font-style: normal; font-size: 10px;">title of book</i>
                                    <i class="text-white" style="font-style: normal; font-size: 10px;">title of book</i>
                                </div>
                                <div style="display: flex; align-items: center; justify-content: center; margin-bottom: -5px;">
                                    <button style="padding: 5px; font-size: 9px;" class="btn btn-sm btn-info">Details</button>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    
                </div>
            </div>

            <br>
            <div class="container-fluid">
                <div class="card" id="prevnextbtn" style="display: none; flex-direction: row; align-items: center; justify-content: center;">
                    <button id="previous" class="btn btn-sm btn-info"><i class="fas fa-angle-double-left"></i></button>
                    <i id="currentpagecount" style="font-size: 10px; font-style: normal;">4</i>
                    <i style="font-size: 10px; font-style: normal;"> / </i>
                    <i id="lastpagecount" style="font-size: 10px; font-style: normal;">7</i>
                    <button id="nextdata" class="btn btn-sm btn-info"><i class="fas fa-angle-double-right"></i></button>
                </div>
            </div>
            <br>








{{-- library management modal --}}
  
            <!-- Central Modal Small -->
            <div class="modal fade" id="centralModalSm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
            
                <!-- Change class .modal-sm to change the size of the modal -->
                <div class="modal-dialog modal-lg" role="document">
            
            
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title w-100" id="myModalLabel">Add Books</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Default checked -->
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" onchange="switchBookInputType()" class="custom-control-input" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1">Add an e-Book.</label>
                                </div>
                            </div>
                        </div>
                        <div id="spinneraddbook" style="display: none; align-items: center; justify-content: center; flex-direction: column;">
                            <div class="spinner-border"></div>
                            <i style="font-size: 10px;">Please Wait...</i>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button id="offlinebooksbtn" class="btn btn-sm default-color-dark btn-block text-white" style="border-radius: 50px; ">Add offline Book</button>
                            </div>
                            <div class="col-md-6">
                                <button id="onlinebookbtn" class="btn btn-sm btn-block" style="border-radius: 50px; display: none;">Add e-Books</button>
                            </div>
                        </div>
                        <br>
                        <div id="bookuploadedindicator" class="" style="display: none;">
                            <div id="alertconfirmaddbook" class="alert alert-danger" role="alert">
                                A simple primary alert—check it out!
                            </div>
                        </div>
                        <form id="bookUploadForm" action="javascript:console.log('submited')" method="post" style="">
                            @csrf
                        <div class="row">
                            <div class="col-md-6">
                                
                                    <div class="form-group">
                                        <i style="font-size: 10px;">Book title</i>
                                        <input type="text" name="booktitle" class="form-control form-control-sm" placeholder="book title">
                                    </div>
                                    <div class="form-group">
                                        <i style="font-size: 10px;">Select a category</i>
                                        <select name="bookcategory" id="" class="form-control form-control-sm">
                                            <option value="">select a category</option>
                                            @if (count($libcategory) > 0)
                                                @foreach ($libcategory as $library)
                                                    <option style="text-transform: uppercase;" value="{{$library->id}}">{{$library->categoryname}}</option>
                                                @endforeach
                                                
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <i style="font-size: 10px;">Quantity</i>
                                        <input type="text" name="quantity" class="form-control form-control-sm" placeholder="quantity">
                                    </div>
                                    <div class="form-group">
                                        <i style="font-size: 10px;">ISBN</i>
                                        <input type="text" name="bookisbn" class="form-control form-control-sm" placeholder="Book ISBN">
                                    </div>
                                    <div class="form-group">
                                        <i style="font-size: 10px;">Book Author</i>
                                        <input type="text" name="bookauthor" class="form-control form-control-sm" placeholder="Book Author">
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div id="aboutthebook" class="form-group">
                                    <i style="font-size: 10px;">About the book/author</i>
                                    <textarea id="editor1" maxlength="800" name="editor1" class="sam_notes form-control form-control-sm" id="" cols="30" rows="10"></textarea>
                                    <span style="font:normal 11px sans-serif;color:#B00400;"><span class='counter_msg'></span></span>
                                </div>
                                <div class="form-group">
                                    <i style="font-size: 10px;">Book Cover</i>
                                    <div class="alert alert-info" role="alert">
                                        <i style="font-style: normal; font-size: 12px;">Book cover must be 371 X 479 and not morethan 200kb. You can use <a href="canva.com" style="color: red;">Canva.com</a> to resize your book cover.</i>
                                    </div>
                                    <input type="file" name="file" id="idfilemail" class="form-control form-control-sm" placeholder="Book Cover">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="submittype" value="0">
                    </form>

                    <form id="ebookUploadForm" action="javascript:console.log('submited')" method="post" style="display: none;">
                            @csrf
                        <div class="row">
                            <div class="col-md-6">
                                
                                    <div class="form-group">
                                        <i style="font-size: 10px;">Book title</i>
                                        <input type="text" name="booktitle" class="form-control form-control-sm" placeholder="book title">
                                    </div>
                                    <div class="form-group">
                                        <i style="font-size: 10px;">Select a category</i>
                                        <select name="bookcategory" id="" class="form-control form-control-sm">
                                            <option value="">select a category</option>
                                            @if (count($libcategory) > 0)
                                                @foreach ($libcategory as $library)
                                                    <option style="text-transform: uppercase;" value="{{$library->id}}">{{$library->categoryname}}</option>
                                                @endforeach
                                                
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <i style="font-size: 10px;">ISBN</i>
                                        <input type="text" name="bookisbn" class="form-control form-control-sm" placeholder="Book ISBN">
                                    </div>
                                    <div class="form-group">
                                        <i style="font-size: 10px;">Book Author</i>
                                        <input type="text" name="bookauthor" class="form-control form-control-sm" placeholder="Book Author">
                                    </div>
                                    <div class="form-group">
                                        <i style="font-size: 10px;">upload ebook here</i>
                                        <input type="file" id="ebookmainfile" name="ebookmainfile" class="form-control form-control-sm">
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div id="aboutthebook" class="form-group">
                                    <i style="font-size: 10px;">About the book/author</i>
                                    <textarea id="editor1" maxlength="800" name="editor1" class="sam_notes form-control form-control-sm" id="" cols="30" rows="10"></textarea>
                                    <span style="font:normal 11px sans-serif;color:#B00400;"><span class='counter_msg'></span></span>
                                </div>
                                <div class="form-group">
                                    <i style="font-size: 10px;">Book Cover</i>
                                    <div class="alert alert-info" role="alert">
                                        <i style="font-style: normal; font-size: 12px;">Book cover must be 371 X 479 and not morethan 200kb. You can use <a href="canva.com" style="color: red;">Canva.com</a> to resize your book cover.</i>
                                    </div>
                                    <input type="file" name="file" id="idfilemail" class="form-control form-control-sm" placeholder="Book Cover">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="submittype" value="1">
                    </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" id="bookUploadBtn" class="btn btn-success btn-sm" form="bookUploadform" style="display: block;">Add</button>
                        <button type="button" id="ebookUploadbtn" class="btn btn-success btn-sm" form="ebookUploadForm" style="display: none; ">Upload e-Book</button>
                    </div>
                </div>
                </div>
            </div>
            <!-- Central Modal Small -->

{{-- add category --}}

            <!-- Button trigger modal -->
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#centralModalcat">
                Launch demo modal
            </button> --}}
            
            <!-- Central Modal Small -->
            <div class="modal fade" id="centralModalcat" tabindex="-1" role="dialog" aria-labelledby="myModalLabelcat"
                aria-hidden="true">
            
                <!-- Change class .modal-sm to change the size of the modal -->
                <div class="modal-dialog modal-sm" role="document">
            
            
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title w-100" id="myModalLabelcat">Add books Categories</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <i id="catprocessindicator" style="font-size: 10px; color: green; display: none;"><i class="fas fa-check-circle"></i> Process was successfull</i>
                        </div>
                        <form id="addcategoryform" action="javascript:console.log('submitted')" method="post">
                            @csrf
                            <div class="form-group">
                                <i style="font-size: 10px; color: red;">Note: please, for multiple categories, seperate each with a comma</i>
                                <textarea style="text-transform: uppercase;" name="category" class="form-control form-control-sm" id="" cols="30" rows="5"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button id="addcategorybtn" type="button" class="btn btn-success btn-sm" form="addcategoryform">Add</button>
                    </div>
                </div>
                </div>
            </div>
            <!-- Central Modal Small -->


            <!-- Button trigger modal -->
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bookdetailsmodal">
                Launch demo modal
            </button> --}}

{{-------------------------------------------------------------------------------------------------}}
{{--                                        view books modal                                     --}}
{{-------------------------------------------------------------------------------------------------}}

            <!-- Modal -->
            <div class="modal fade" id="bookdetailsmodal" tabindex="-1" role="dialog" aria-labelledby="booktitleview"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title"  id="booktitleview">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                <img id="bookcovermodal" src="https://mdbootstrap.com/img/Others/documentation/img%20(75)-mini.jpg" alt="thumbnail" class="img-thumbnail" style="width: 200px; height: auto;">
                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <i style="font-style: normal; font-size: 13px;">ISBN: <i id="isbnmainvalue" style="font-style: normal; font-size: 13px;"></i></i>
                                    <i id="bookcategorymain" style="font-style: normal; font-size: 13px; text-transform: uppercase;"></i>
                                </div>
                            </div>
                            <div class="col-md-6" style="">
                                <i style="font-size: 15px; font-style: normal; font-weight: bold;">About the book</i>
                                <div style="margin-bottom: 10px;">
                                    <i style="font-style: normal; font-size: 13px;" id="abouttheauthor"></i>
                                </div>
    
                            </div>
                        </div>

                        <div class="row">
                            <div id="ebookcard" class="col-md-6">
                                <div class="card">
                                    <i style="font-style: normal; padding: 5px;">Download link</i>
                                </div>
                                <div>
                                    <i style="font-style: normal; padding: 5px;">Download e-book or view online.</i>
                                    <a id="sethreffordownload" href="" target="_blank"><button class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Read/Download</button></a>
                                </div>
                            </div>
                            <div id="hardcopycard" class="col-md-6">
                                <div class="card">
                                    <i style="font-style: normal; padding: 5px;">I need this book</i>
                                </div>
                                <div>
                                    <i style="font-style: normal; padding: 5px;">Want to borrow this?.</i>
                                    <button class="btn btn-info btn-sm" type="button" data-toggle="collapse" data-target="#collapseborrow"
                                    aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-hand-holding"></i> Borrow</button>
                                    <!-- Collapsible element -->
                                    <div class="collapse" id="collapseborrow">
                                        <div class="mt-3">
                                            <i style="font-style: normal; font-size: 13px;">This book is in hardcopy, visit the Library to get a copy. Use the info provided by the administrator to easily access the book.</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <i style="font-style: normal; padding: 5px;">Other details</i>
                                </div>
                                <div>
                                    <div>
                                        <span class="badge badge-danger">Author</span>
                                        <i id="bookauthortext" style="font-style: normal; font-size: 13px;">value</i>
                                    </div>
                                    <div>
                                        <span class="badge badge-danger">Category</span>
                                        <i id="categorynamemodal" style="font-style: normal; font-size: 13px;">value</i>
                                    </div>
                                    <div>
                                        <span class="badge badge-danger">Date Uploaded</span>
                                        <i id="datebookmodal" style="font-style: normal; font-size: 13px;">value</i>
                                    </div>
                                    <div>
                                        <span class="badge badge-danger">Book Number</span>
                                        <i id="bookidnumber" style="font-style: normal; font-size: 13px;">value</i>
                                    </div>
                                    <div>
                                        <span class="badge badge-danger">Book Type</span>
                                        <i id="booktype" style="font-style: normal; font-size: 13px;">value</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" id="abortajax" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                    </div>
                </div>
                </div>
            </div>


{{------------------------------------------------------------------------------------------------------------}}
{{--                                         notification modal                                             --}}
{{------------------------------------------------------------------------------------------------------------}}

            <!-- Button trigger modal -->
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#notificationmodal">
                Launch demo modal
            </button> --}}
            
            <!-- Modal -->
            <div class="modal fade" id="notificationmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
            
                <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
                <div class="modal-dialog modal-dialog-centered" role="document">
            
            
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Welcome</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            @csrf
                            <div style="display: flex; flex-direction: column;">
                                <i style="font-style: normal; font-size: 13px; margin-right: 5px;"> Hi, {{Auth::user()->firstname}}</i>
                                <i style="font-style: normal; font-size: 13px; margin-right: 5px;">
                                    Welcome to your library portal. As a Library admin you hold a duty of 
                                    adding books to your library so that students can access and gain knowledge.
                                </i>
                                <i style="font-style: normal; font-size: 13px; margin-right: 5px;">
                                    First start by adding categories before adding books.
                                    Also note that you can add both ebooks and hardcopy books, however,
                                    only ebooks can be accessed only. Hardcopy books are online for tracking/borrowing poposes.
                                </i>
                            </div>
                            <hr>
                            <div class="" style="display: flex; align-items: center;">
                                <i style="font-style: normal; font-size: 13px; margin-right: 5px;">I don't want to see this again</i>
                                <input onclick="notificationModalset()" type="checkbox" name="checkboxaction" class="">
                            </div>
                        </form>
                    </div>
                    {{-- <div class="modal-footer"> --}}
                    {{-- <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">x</button> --}}
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}

                    {{-- </div> --}}
                </div>
                </div>
            </div>


            <input type="hidden" id="userrolefornotification" value="{{Auth::user()->role}}">
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
        function detailsModal(booktitle, aboutbookid, bookauthor, categoryname, bookidnumber, bookcover, bookisbn, datebook, booktype, ebooklink){

            document.getElementById('booktitleview').innerHTML = booktitle;
            document.getElementById('abouttheauthor').innerHTML = document.getElementById(aboutbookid).value;
            document.getElementById('bookauthortext').innerHTML = bookauthor;
            document.getElementById('categorynamemodal').innerHTML = categoryname;
            document.getElementById('bookidnumber').innerHTML = bookidnumber;
            document.getElementById('bookcovermodal').src = "storage/cover/"+bookcover;
            document.getElementById('isbnmainvalue').innerHTML = bookisbn;
            document.getElementById('datebookmodal').innerHTML = datebook;
            document.getElementById('booktype').innerHTML = booktype;

            if (booktype == "ebook") {
                document.getElementById('ebookcard').style.display = "block";
                document.getElementById('hardcopycard').style.display = "none";
                document.getElementById('sethreffordownload').href = "storage/ebook/"+ebooklink;
                
            } else {
                document.getElementById('ebookcard').style.display = "none";
                document.getElementById('hardcopycard').style.display = "block";
            }

            $("#bookdetailsmodal").modal()
        }

        function abortCall(){
            // alert("fd")
        }

        function myFunction() {

            var input, filter, cards, cardContainer, h5, title, f;
            input = document.getElementById("myFilter");
            filter = input.value.toUpperCase();
            cardContainer = document.getElementById("bookssgotten");
            cards = cardContainer.getElementsByClassName("card");
            for (f = 0; f < cards.length; f++) {
                title = cards[f].querySelector("h5.cat_text i");

                console.log(filter)
                
                if (title.innerText.toUpperCase().indexOf(filter) > -1) {
                    cards[f].style.display = "";
                    
                } else {
                    cards[f].style.display = "none";
                    // console.log(title)
                }
            }
        }

        function switchBookInputType(){
            if (document.getElementById('customSwitch1').checked) {
                document.getElementById('ebookUploadForm').style.display = "block";
                document.getElementById('bookUploadForm').style.display = "none";
                document.getElementById('onlinebookbtn').classList.add('default-color-dark')
                document.getElementById('offlinebooksbtn').classList.remove('default-color-dark')
                document.getElementById('offlinebooksbtn').classList.remove('text-white')
                document.getElementById('offlinebooksbtn').style.display = "none";
                document.getElementById('onlinebookbtn').style.display = "block";
                document.getElementById('onlinebookbtn').classList.add('text-white')
                document.getElementById('ebookUploadbtn').style.display = "block";
                document.getElementById('bookUploadBtn').style.display = "none";
            }else{
                document.getElementById('bookUploadForm').style.display = "block";
                document.getElementById('ebookUploadForm').style.display = "none";
                document.getElementById('onlinebookbtn').classList.remove('default-color-dark');
                document.getElementById('offlinebooksbtn').classList.add('default-color-dark');
                document.getElementById('offlinebooksbtn').style.display = "block";
                document.getElementById('onlinebookbtn').style.display = "none";
                document.getElementById('onlinebookbtn').classList.remove('text-white')
                document.getElementById('offlinebooksbtn').classList.add('text-white')
                document.getElementById('ebookUploadbtn').style.display = "none";
                document.getElementById('bookUploadBtn').style.display = "block";
            }
        }

        function testfunc(){
            alert();
        }

        function notificationModalset(){

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
                $.ajax({
                url:"/cookie/set", //the page containing php script
                method: "post", //request type,
                cache: false,
                data: {seen: 1 },
                success:function(result){

                    console.log(result)

                },
                error:function(){
                console.log('failed')
                }
            });
        }
    </script>
    

</body>
</html>