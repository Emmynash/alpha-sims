<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
                url: "/book-upload",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    console.log(data)

                    document.getElementById('spinneraddbook').style.display = "none";
                    document.getElementById('bookUploadBtn').style.display = "block";

                    if(data.errors){
                        for (let index = 0; index < data.errors.length; index++) {
                            const element = data.errors[index];
                            document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                        }
                    }


                    if (data.imgerr) {


                    }

                    if (data.success) {

                        
                    }

                    if (data.already) {

                        
                    }


                },
                error: function (e) {
                    document.getElementById('spinneraddbook').style.display = "none";
                    document.getElementById('bookUploadBtn').style.display = "block";

                }
            });

            });


            $(function() {
                $('#addcategorybtn').click(function(e) {
                    e.preventDefault();
                    $("#addcategoryform").submit();

                    // document.getElementById('psycospinner').style.display = "flex";

                    $.ajax({
                    url: '/category_library',
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
                            document.getElementById('booksgotten').style.display = "block";
                            $.ajax({
                            url: '/all_books',
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

                            document.getElementById('booksgotten').style.display = "none";

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
                                            borrowed = element.borrowed
                                        }

                                        a = element.aboutbook;
                                        a = a.replace(/'/g, "\\'");
                                        a = a.replace(/\./g, '\\.')

                                        var idforabouttext = "idforabouttext"+element.id;

                                        // console.log(idforabouttext)
                                        
                                        // document.getElementById(idforabouttext).value = element.aboutbook;

                                        html += "<tr><td>"+element.id+"</td><td>"+element.booktitle+"</td><td>"+element.booktype+"</td><td>"+element.bookisbn+"</td><td>"+element.quantity+"</td><td>"+available+"</td><td>"+borrowed+"</td><td>"+element.bookauthor+"</td><td>"+element.categoryname+"</td><td><i onclick=\"viewBook('"+element.id+"', '"+element.booktitle+"', '"+element.file+"', '"+idforabouttext+"', '"+element.bookisbn+"', '"+element.categoryname+"')\" class='far fa-eye'></i>"+" "+"<i onclick=\"deletebook('"+element.id+"', '"+element.file+"', '"+element.booktitle+"')\" class='far fa-trash-alt'></i>"+"<textarea style='display: none;' type='text' id='"+idforabouttext+"'>"+element.aboutbook+"</textarea>"+"</td><tr>";
                                            
                                        }
                                        $("#bookssgotten").html(html);
                                    }
                                    
                                    
                                    
                                }

                                },
                                error:function(errors){

                                    document.getElementById('booksgotten').style.display = "none";
                                
                                }
                            });
                            
                        }
                    });


//-------------------------------------------------------------------------------------
//                                  delete book
//-------------------------------------------------------------------------------------

            $(function() {
                $('#deletebookbtn').click(function(e) {
                    e.preventDefault();
                    $("#deletebookform").submit();

                    // document.getElementById('psycospinner').style.display = "flex";

                    $.ajax({
                    url: '/delete_book',
                    type: 'post',
                    dataType: 'json',
                    data: $('form#deletebookform').serialize(),
                    success: function(data) {

                    // document.getElementById('psycospinner').style.display = "none";

                        console.log(data);

                        location.reload();

                        // if(data.errors){
                        //     for (let index = 0; index < data.errors.length; index++) {
                        //             const element = data.errors[index];
                        //             document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                        //     }
                        // }

                        // if (data.success) {
                        //     document.getElementById('catprocessindicator').style.display = "block";
                        //     location.reload();
                        // }


                        

                        },
                        error:function(errors){
                        console.log(errors)
                        }
                    });
                });
            });


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
            {{-- <input type="text" value=""> --}}
        
            <!-- Collapsible content -->
            <div class="collapse navbar-collapse" id="basicExampleNav">
        
            <!-- Links -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                <a class="nav-link" href="/school_library">Home
                    <span class="sr-only">(current)</span>
                </a>
                </li>
                {{-- <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
                </li> --}}
        
                <!-- Dropdown -->
                <!--<li class="nav-item dropdown">-->
                <!--<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"-->
                <!--    aria-haspopup="true" aria-expanded="false">Menu</a>-->
                <!--<div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">-->
                <!--    <a class="dropdown-item" href="#">Action</a>-->
                <!--    <a class="dropdown-item" href="#">Another action</a>-->
                <!--    <a class="dropdown-item" href="#">Something else here</a>-->
                <!--</div>-->
                <!--</li>-->
        
            </ul>
            <!-- Links -->
        
            {{-- <form class="form-inline">
                <div class="md-form my-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                </div>
            </form> --}}
            <a href="#"><button type="button" class="btn btn-sm btn-outline-default waves-effect">View all Books(Admin)</button></a>
            </div>
            <!-- Collapsible content -->
        
        </nav>
        <!--/.Navbar-->

        <div class="container-fluid" style="margin-top: 10px;">
            <div class="col-md-6" style="">
                {{-- <i>sdfsdfdsfds</i> --}}
            </div>

            <div class="card" style="">
                <div class="row">
                    <div class="col-md-6">
                        <form action="">
                            <div class="row" style="margin: 10px;">
                                <div class="col-md-6" style="display: flex; flex-direction: row;">
                                    <button class="" style="background: #fff; border: none; border-top: 1px solid rgb(202, 199, 199); border-bottom: 1px solid rgb(202, 199, 199); border-left: 1px solid rgb(202, 199, 199);"><i class="fas fa-filter"></i></button>
                                    <select class="form-control form-control-sm bootstrap-select" style="border-radius: 0px; border-left: none; border:1px solid #ddd;" id="bycategory" onchange="myFunction(7, 'bycategory')">
                                        <option value="">Search by category</option>
                                    @if (count($libcategory) > 0)
                                        @foreach ($libcategory as $library)
                                            <option style="text-transform: uppercase;" value="{{$library->categoryname}}">{{$library->categoryname}}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form action="">
                            <div class="row" style="margin: 10px;">
                                <div class="col-md-6" style="display: flex; flex-direction: row;">
                                    <button class="" style="background: #fff; border: none; border-top: 1px solid rgb(202, 199, 199); border-bottom: 1px solid rgb(202, 199, 199); border-left: 1px solid rgb(202, 199, 199);"><i class="fas fa-search"></i></i></button>
                                    <input placeholder="Search by Book Number" type="number" class="form-control form-control-sm bootstrap-select" style="border-radius: 0px; border-left: none; border:1px solid #ddd;" id="myInput" onkeyup="myFunction(0, 'myInput')">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <br>


            <div class="card">
                <div id="booksgotten" style="position: absolute; z-index: 999; top: 0; bottom: 0; right: 0; left: 0;">
                    <div class="row">
                        <div class="col-md-12" style="display: flex; height: 100px; align-items: center; justify-content: center;">
                            <div class="spinner-border" style="height: 50px; width: 50px;"></div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="myTable">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Book Title</th>
                        <th scope="col">Book Type</th>
                        <th scope="col">ISBN</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Available</th>
                        <th scope="col">Borrowed</th>
                        <th scope="col">Author</th>
                        <th scope="col">Category</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="bookssgotten">

                    </tbody>
                    </table>
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

        </div>

        <div class="container-fluid">
            <!-- Central Modal Small -->
            <div class="modal fade" id="viewbookslibrary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">

            <!-- Change class .modal-sm to change the size of the modal -->
            <div class="modal-dialog modal-lg" role="document">


            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title w-100" id="myModalLabel">Modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    {{-- <i id="booktitlemodal" style="font-size: 20px; font-weight: bold; font-style: normal;">Book title</i> --}}
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
                            <div>
                                <i style="font-style: normal; font-size: 13px;" id="abouttheauthor"></i>
                            </div>

                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-md-6" style="">
                                <div class="card" style="margin: 10px 0px 10px 1px; display: flex; flex-direction: row; align-items: center;">
                                    <i style="font-style: normal; padding: 10px;">Active</i>
                                    <div style="flex: 1;"></div>
                                    <div style="display: flex; flex-direction: row; margin-right: 5px;">
                                        <input type="text" style="border-radius: 0px; border-rignt: 1px solid #fff;" class="form-control form-control-sm" placeholder="Search by Id">
                                        <button style="border: none; border-top: 1px solid rgb(206, 201, 201); border-right: 1px solid rgb(206, 201, 201); border-bottom: 1px solid rgb(206, 201, 201); background-color: #fff;"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div style="height: 200px; background-color: rgb(177, 169, 169); margin-bottom: 10px;">
                                    {{-- <div style="">
                                        <div class="spinner-border"></div>
                                    </div> --}}
                                    <div class="card" style="display: flex; flex-direction: row; align-items: center; border-radius: 0px; margin: 2px;">
                                        <i style="margin-left: 5px; font-size:13px; font-style: normal;">name</i>
                                        <div style="flex: 1;"></div>
                                        <i style="margin-right: 5px;" class="fas fa-eye"></i>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6" style="">
                                <div class="card" style="margin: 10px 0px 10px 1px; display: flex; flex-direction: row; align-items: center;">
                                    <i style="font-style: normal; padding: 10px;">Expired</i>
                                    <div style="flex: 1;"></div>
                                    <div style="display: flex; flex-direction: row; margin-right: 5px;">
                                        <input type="text" style="border-radius: 0px; border-rignt: 1px solid #fff;" class="form-control form-control-sm" placeholder="Search by Id">
                                        <button style="border: none; border-top: 1px solid rgb(206, 201, 201); border-right: 1px solid rgb(206, 201, 201); border-bottom: 1px solid rgb(206, 201, 201); background-color: #fff;"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div style="height: 200px; background-color: rgb(177, 169, 169); margin-bottom: 10px;">
                                    {{-- <div style="">
                                        <div class="spinner-border"></div>
                                    </div> --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
            </div>
            <!-- Central Modal Small -->

{{-------------------------------------------------------------------------------------}}
{{--                            modal confirm book deleting                       --}}
{{-------------------------------------------------------------------------------------}}

            <!-- Button trigger modal -->
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deletebookmodal">
                Launch demo modal
            </button> --}}
            
            <!-- Central Modal Small -->
            <div class="modal fade" id="deletebookmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
            
                <!-- Change class .modal-sm to change the size of the modal -->
                <div class="modal-dialog modal-sm" role="document">
            
            
                <div class="modal-content">
                    <div class="modal-header">
                    <h6 class="modal-title w-100" id="myModalLabel">confirm</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body text-center">
                        <i id="deletebooktitle" style="font-style: normal;">Book Title to delete</i>
                        <div style="">
                            <img id="deleteimg" class="rounded mx-auto d-block" src="" alt="" width="100px" height="auto">
                        </div>
                        <div style="display: flex; flex-direction: column;">
                            <i style="font-style: normal; font-size: 12px; color: red;">Note: this process can not be reversed.</i>
                            <i style="font-style: normal; font-size: 12px;">Are you sure you want to delete this book?</i>
                        </div>
                        <form id="deletebookform" action="javascript:console.log('submited')" method="post">
                            @csrf
                            <input id="bookidtodelete" name="bookidtodelete" type="hidden" value="">
                        </form>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
                    <button id="deletebookbtn" type="button" class="btn btn-success btn-sm" form="deletebookform">Yes</button>
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
        function myFunction(bycolumn, bycategory) {

          // Declare variables
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById(bycategory);
          filter = input.value.toUpperCase();
          table = document.getElementById("myTable");
          tr = table.getElementsByTagName("tr");
        
          // Loop through all table rows, and hide those who don't match the search query
          for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[bycolumn];
            if (td) {
              txtValue = td.textContent || td.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }
          }
        }

        function viewBook(bookid, booktitle, bookcover, aboutbookid, bookisbn, bookcategory){
            // alert(bookid);

            document.getElementById('myModalLabel').innerHTML = booktitle;
            document.getElementById('bookcovermodal').src = "storage/cover/"+bookcover;
            document.getElementById('abouttheauthor').innerHTML = document.getElementById(aboutbookid).value;
            document.getElementById('isbnmainvalue').innerHTML = bookisbn;
            document.getElementById('bookcategorymain').innerHTML = bookcategory;

            $("#viewbookslibrary").modal()
        }

        function deletebook(bookid, bookcover, booktitle){

            document.getElementById('deleteimg').src = "storage/cover/"+bookcover;
            document.getElementById('deletebooktitle').innerHTML = booktitle;
            document.getElementById('bookidtodelete').value = bookid;

            $("#deletebookmodal").modal()
        }
    </script>
</body>
</html>