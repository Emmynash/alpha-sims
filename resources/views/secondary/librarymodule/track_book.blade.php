<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book History</title>
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

//--------------------------------------------------------------------------------------------------------------------
//                                          get book details from isbn/issn
//--------------------------------------------------------------------------------------------------------------------

            $(function() {
                $('#fetchbookdetailsfromisbnbtn').click(function(e) {
                    e.preventDefault();
                    $("#fetchbookdetailsfromisbnform").submit();
                    

                    document.getElementById('isbnfetcheddetails').style.maxHeight = "0";
                    document.getElementById('isbnfetcheddetails').style.transition = "0s";
                    document.getElementById('mainbookdetailsisbn').style.visibility = "collapse";
                    document.getElementById('mainbookdetailsisbn').style.transition = "0s";
                    document.getElementById('notfoundnotifisbn').style.display = "none";

                    document.getElementById('verifystudentbookcard').style.width = "0";
                    document.getElementById('maincontentbooks').style.visibility = "collapse";

                    document.getElementById('bookisbnissn').value = document.getElementById('bookisbnentered').value;

                    $.ajax({
                    url: '/fetch_book_details',
                    type: 'post',
                    dataType: 'json',
                    data: $('form#fetchbookdetailsfromisbnform').serialize(),
                    success: function(data) {

                    // document.getElementById('psycospinner').style.display = "none";

                        console.log(data);

                        if(data.errors){
                            for (let index = 0; index < data.errors.length; index++) {
                                    const element = data.errors[index];
                                    document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                            }
                        }

                        if (data.notfound){
                            document.getElementById('isbnfetcheddetails').style.maxHeight = "0";
                            document.getElementById('isbnfetcheddetails').style.transition = "0s";
                            document.getElementById('mainbookdetailsisbn').style.visibility = "collapse";
                            document.getElementById('mainbookdetailsisbn').style.transition = "0s";
                            document.getElementById('notfoundnotifisbn').style.display = "block";
                        } {
                            
                        }

                        if (data.bookdetaild) {
                            document.getElementById('viewbookfromisbncover').src = "cover/"+data.bookdetaild.file;
                            document.getElementById('booktitleisbnquery').innerHTML = data.bookdetaild.booktitle;
                            document.getElementById('bookcategoryisbnquery').innerHTML = data.bookdetaild.categoryname;
                            document.getElementById('dateuploadedisbnquery').innerHTML = data.bookdetaild.datebook;
                            document.getElementById('bookauthorisbn').innerHTML = data.bookdetaild.bookauthor;
                            document.getElementById('bookid').value = data.bookdetaild.id;

                            var available = data.bookdetaild.available;
                            var borrowed = data.bookdetaild.borrowed

                            if (data.bookdetaild.quantity > borrowed) {
                                document.getElementById('bookavailabilityisbn').innerHTML = "Available";
                            }else{
                                document.getElementById('bookavailabilityisbn').innerHTML = "Unavailable";
                            }
                            document.getElementById('isbnfetcheddetails').style.maxHeight = "1000px";
                            document.getElementById('isbnfetcheddetails').style.transition = "1s";
                            document.getElementById('mainbookdetailsisbn').style.visibility = "visible";
                            document.getElementById('mainbookdetailsisbn').style.transition = "2s";
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
                            url: '/all_borrowed_books',
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
                                            borrowed = element.available
                                        }

                                        // a = element.aboutbook;
                                        // a = a.replace(/'/g, "\\'");
                                        // a = a.replace(/\./g, '\\.')

                                        var idforabouttext = "idforabouttext"+element.id;

                                        var names = element.firstname+" "+element.middlename+" "+element.lastname

                                        var userrolefilter = document.getElementById('userrolefilter').value;

                                        if (userrolefilter == "Librarian") {

                                            if (element.status == "Completed") {
                                            html += "<tr><td>"+element.id+"</td><td>"+element.studentreno+"</td><td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td><td>"+element.bookisbnissn+"</td><td>"+element.bookid+"</td><td>"+element.booktitle+"</td><td>"+element.dateborrow+"</td><td>"+element.datetoreturn+"</td><td>"+element.status+"</td><td><i onclick=\"viewBook()\" class='far fa-eye'></i>"+" "+"<i class='fab fa-rev' onclick=\"recievebookfromstudent('"+element.booktitle+"', '"+element.file+"', '"+element.id+"', '"+names+"', 'revoke')\"></i>"+" "+"<i onclick=\"deleteborrowdata('"+element.id+"')\" class='far fa-trash-alt'></i>"+"<textarea style='display: none;' type='text' id='"+idforabouttext+"'>"+element.aboutbook+"</textarea>"+"</td><tr>";

                                            }else{
                                                html += "<tr><td>"+element.id+"</td><td>"+element.studentreno+"</td><td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td><td>"+element.bookisbnissn+"</td><td>"+element.bookid+"</td><td>"+element.booktitle+"</td><td>"+element.dateborrow+"</td><td>"+element.datetoreturn+"</td><td>"+element.status+"</td><td><i onclick=\"viewBook()\" class='far fa-eye'></i>"+" "+"<i class='fas fa-exchange-alt' onclick=\"recievebookfromstudent('"+element.booktitle+"', '"+element.file+"', '"+element.id+"', '"+names+"', 'approve')\"></i>"+" "+"<i onclick=\"deleteborrowdata('"+element.id+"')\" class='far fa-trash-alt'></i>"+"<textarea style='display: none;' type='text' id='"+idforabouttext+"'>"+element.aboutbook+"</textarea>"+"</td><tr>";

                                            }

                                        }else{
                                            if (element.status == "Completed") {
                                            html += "<tr><td>"+element.id+"</td><td>"+element.studentreno+"</td><td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td><td>"+element.bookisbnissn+"</td><td>"+element.bookid+"</td><td>"+element.booktitle+"</td><td>"+element.dateborrow+"</td><td>"+element.datetoreturn+"</td><td>"+element.status+"</td><td><i onclick=\"viewBook()\" class='far fa-eye'></i>"+" "+"<textarea style='display: none;' type='text' id='"+idforabouttext+"'>"+element.aboutbook+"</textarea>"+"</td><tr>";

                                            }else{
                                                html += "<tr><td>"+element.id+"</td><td>"+element.studentreno+"</td><td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td><td>"+element.bookisbnissn+"</td><td>"+element.bookid+"</td><td>"+element.booktitle+"</td><td>"+element.dateborrow+"</td><td>"+element.datetoreturn+"</td><td>"+element.status+"</td><td><i onclick=\"viewBook()\" class='far fa-eye'></i>"+" "+"<textarea style='display: none;' type='text' id='"+idforabouttext+"'>"+element.aboutbook+"</textarea>"+"</td><tr>";

                                            }
                                        }



                                            
                                        }
                                        $("#booksborrowsgotten").html(html);
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
                $('#deleteborrowrecordbtn').click(function(e) {
                    e.preventDefault();
                    $("#deleteborrowrecordform").submit();

                    // document.getElementById('psycospinner').style.display = "flex";

                    $.ajax({
                    url: '/delete_borrow_book',
                    type: 'post',
                    dataType: 'json',
                    data: $('form#deleteborrowrecordform').serialize(),
                    success: function(data) {

                        location.reload();

                        },
                        error:function(errors){
                        console.log(errors)
                        }
                    });
                });
            });

//---------------------------------------------------------------------------------------------------------------
//                                     get student details for book borrow
//---------------------------------------------------------------------------------------------------------------

            $(function() {
                $('#getstudentforbookborrowbtn').click(function(e) {
                    e.preventDefault();
                    $("#getstudentforbookborrowform").submit();  

                    $.ajax({
                    url: '/fetch_student_book',
                    type: 'post',
                    dataType: 'json',
                    data: $('form#getstudentforbookborrowform').serialize(),
                    success: function(data) {
                        
                        if(data.errors){
                            for (let index = 0; index < data.errors.length; index++) {
                                    const element = data.errors[index];
                                    document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                            }
                        }

                        if (data.success) {
                            document.getElementById('verifystudentbookcard').style.width = "100%";
                            document.getElementById('verifystudentbookcard').style.transition = "1s";
                            document.getElementById('maincontentbooks').style.visibility = "visible";
                            document.getElementById('maincontentbooks').style.visibility = "2s";

                            var namemain = data.success[0].firstname+" "+data.success[0].middlename+" "+data.success[0].lastname;
                            document.getElementById('studentnamebook').innerHTML = namemain;
                            document.getElementById('studentclassbook').innerHTML = data.success[0].classnamee;
                            document.getElementById('studenregnobook').innerHTML = data.success[0].id;
                            document.getElementById('studentregnobook').value = data.success[0].id;
                        }

                        },
                        error:function(errors){
                        console.log(errors)
                        }
                    });
                });
            });

            $(function() {
                $('#borrowbookexecutionbtn').click(function(e) {
                    e.preventDefault();
                    $("#borrowbookexecutionform").submit();  

                    
                    document.getElementById('bookborrowexecutionbtnspinner').style.display = "block";
                    document.getElementById('borrowbookexecutionbtn').style.display = "none";

                    $.ajax({
                    url: '/add_book_borrow_data',
                    type: 'post',
                    dataType: 'json',
                    data: $('form#borrowbookexecutionform').serialize(),
                    success: function(data) {

                        console.log(data)

                        document.getElementById('bookborrowexecutionbtnspinner').style.display = "none";
                        document.getElementById('borrowbookexecutionbtn').style.display = "block";

                        
                        if(data.errors){
                            for (let index = 0; index < data.errors.length; index++) {
                                    const element = data.errors[index];
                                    document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                            }
                        }

                        if (data.success) {
                            location.reload();

                        }

                        if (data.duplicate) {
                            document.getElementById('errormessageaddborrow').innerHTML = "book already borrowed by the Student";
                        }

                        if (data.notavailable) {
                            document.getElementById('errormessageaddborrow').innerHTML = "book not available at the moment come back later";
                        }


                        },
                        error:function(errors){
                            document.getElementById('bookborrowexecutionbtnspinner').style.display = "none";
                            document.getElementById('borrowbookexecutionbtn').style.display = "block";
                        console.log(errors)
                        }
                    });
                });
            });

//------------------------approve returned book--------------------------

            $(function() {
                $('#returnbookbtn').click(function(e) {
                    e.preventDefault();
                    $("#returnbookform").submit();  

                    
                    // document.getElementById('bookborrowexecutionbtnspinner').style.display = "block";
                    // document.getElementById('borrowbookexecutionbtn').style.display = "none";

                    $.ajax({
                    url: '/return_borrow_book',
                    type: 'post',
                    dataType: 'json',
                    data: $('form#returnbookform').serialize(),
                    success: function(data) {

                        console.log(data)

                        // document.getElementById('bookborrowexecutionbtnspinner').style.display = "none";
                        // document.getElementById('borrowbookexecutionbtn').style.display = "block";

                        
                        if(data.errors){
                            for (let index = 0; index < data.errors.length; index++) {
                                    const element = data.errors[index];
                                    document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                            }
                        }

                        if (data.success) {
                            location.reload();

                        }

                        if (data.duplicate) {
                            // document.getElementById('errormessageaddborrow').innerHTML = "book already borrowed by the Student";
                        }

                        if (data.revoke) {
                            location.reload();
                        }


                        },
                        error:function(errors){
                            // document.getElementById('bookborrowexecutionbtnspinner').style.display = "none";
                            // document.getElementById('borrowbookexecutionbtn').style.display = "block";
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
                <!--    aria-haspopup="true" aria-expanded="false">Dropdown</a>-->
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
        {{-- @if (Auth::user()->role == "Librarian") --}}
            <div class="container-fluid">
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#borrowbookmodal">Give out Book</button>
            </div>
        {{-- @endif --}}

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
                                    <select class="form-control form-control-sm bootstrap-select" style="border-radius: 0px; border-left: none; border:1px solid #ddd;" id="bycategory" onchange="myFunction(8, 'bycategory')">
                                        <option value="">Search by Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Completed">Completed</option>
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
                                    <input placeholder="Search by Reg No." type="number" class="form-control form-control-sm bootstrap-select" style="border-radius: 0px; border-left: none; border:1px solid #ddd;" id="myInput" onkeyup="myFunction(1, 'myInput')">
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
                        <th scope="col">Reg No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Book ISBN/ISSN</th>
                        <th scope="col">Book ID</th>
                        <th scope="col">Book Name</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="booksborrowsgotten">

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


{{----------------------------------------------------------------------------------------------------------------}}
{{--                                              borrow book modal                                             --}}
{{----------------------------------------------------------------------------------------------------------------}}
        
        <!-- Central Modal Small -->
        <div class="modal fade" id="borrowbookmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
        
            <!-- Change class .modal-sm to change the size of the modal -->
            <div class="modal-dialog modal-lg" role="document">
        
        
            <div class="modal-content">
                <div class="modal-header">
                <h6 class="modal-title w-100" style="font-weight: bold;" id="myModalLabel">Give out Book</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <form id="fetchbookdetailsfromisbnform" action="javascript:console.log('submitted')" method="post">
                                @csrf
                                <div>
                                    <i style="font-size: 13px; font-style: normal;">Enter the book ISBN</i>
                                </div>
                                <div class="form-group" style="display: flex; flex-direction: row;">
                                    <button style="background: transparent; border: none; border-left: 1px solid rgb(212, 205, 205); border-top: 1px solid rgb(212, 205, 205); border-bottom: 1px solid rgb(212, 205, 205);"><i class="fas fa-book-open"></i></button>
                                    <input type="text" name="bookisbnentered" id="bookisbnentered" placeholder="Book ISBN" style="border-radius: 0px;" class="form-control form-control-sm">
                                </div>
                                <button id="fetchbookdetailsfromisbnbtn" class="btn btn-sm btn-info">Process</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <img id="viewbookfromisbncover" class="rounded mx-auto d-block" src="" alt="" width="100px" height="auto">
                        </div>
                    </div>
                </div>
                <br>

                <div id="isbnfetcheddetails" style="max-height: 0px;">
                    <div id="mainbookdetailsisbn" class="row" style="visibility:collapse;">
                        <div class="col-md-6" style="">
                            <div class="card">
                                <i style="font-size: 15px; font-style: normal; padding: 5px;">Book Details</i>
                            </div>
                            <br>
                            <div>
                                <div>
                                    <span class="badge badge-danger">Book Title</span>
                                    <i id="booktitleisbnquery" style="font-size: 13px; font-style: normal;">sdaddasd</i>
                                </div>
                                <div>
                                    <span class="badge badge-danger">Book Category</span>
                                    <i id="bookcategoryisbnquery" style="font-size: 13px; font-style: normal;">sdaddasd</i>
                                </div>
                                <div>
                                    <span class="badge badge-danger">Date Uploaded</span>
                                    <i id="dateuploadedisbnquery" style="font-size: 13px; font-style: normal;">sdaddasd</i>
                                </div>
                                <div>
                                    <span class="badge badge-danger">Book Author</span>
                                    <i id="bookauthorisbn" style="font-size: 13px; font-style: normal;">sdaddasd</i>
                                </div>
                                <div>
                                    <span class="badge badge-danger">Book Status</span>
                                    <i id="bookavailabilityisbn" style="font-size: 13px; font-style: normal;">sdaddasd</i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="">
                            <div class="card">
                                <i style="font-size: 15px; font-style: normal; padding: 5px;">Student Details</i>
                            </div>
                            <br>
                            <div>
                                <div id="verifystudentbookcard" class="card" style="height: 150px; width: 0; z-index: 999; position: absolute; top: 50px; bottom: 0; right: 0; left: 0;">

                                    <div id="maincontentbooks" style="visibility: collapse">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-3" style="display: flex; align-items: center; justify-content: center;">
                                                <img src="{{asset('storage/schimages/'.Auth::user()->profileimg)}}" class="rounded-circle" alt="Cinque Terre" width="50px" height="auto">
                                            </div>
                                            <div class="col-md-9 container-fluid">
                                                <div>
                                                    <span class="badge badge-success">Name</span>
                                                    <i id="studentnamebook" style="font-style: normal; font-size: 13px;">Student</i>
                                                </div>
                                                <div>
                                                    <span class="badge badge-success">Class</span>
                                                    <i id="studentclassbook" style="font-style: normal; font-size: 13px;">Student</i>
                                                </div>
                                                <div>
                                                    <span class="badge badge-success">Reg No</span>
                                                    <i id="studenregnobook" style="font-style: normal; font-size: 13px;">Student</i>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="position: absolute; bottom: 0; right: 0;">
                                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#approvebookorder"><i class="fas fa-check"></i> Approve</button>
                                        </div>
                                    </div>

                                </div>
                                <form id="getstudentforbookborrowform" action="javascript:console.log('submitted')" method="post">
                                    @csrf
                                    <i style="font-size: 13px; font-style: normal;">Verify student Reg Number</i>
                                    <div class="form-group" style="display: flex; flex-direction: row;">
                                        <button style="background: transparent; border: none; border-left: 1px solid rgb(212, 205, 205); border-top: 1px solid rgb(212, 205, 205); border-bottom: 1px solid rgb(212, 205, 205);"><i class="far fa-registered"></i></button>
                                        <input type="text" name="studentregno" placeholder="Student Reg No" style="border-radius: 0px; outline: none;" class="form-control form-control-sm">
                                    </div>
                                    <button id="getstudentforbookborrowbtn" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="notfoundnotifisbn" style="display: none;">
                    <div class="alert alert-info" role="alert">
                        The ISBN/ISSN you provided is not on our database. If you are sure what you gave us is correct,
                        then use this as an oppurtunity to add the book to your e-Library. Thank You.
                    </div>

                    <div>
                        <a href="/school_library"><button class="btn btn-info btn-sm">Add book to Library</button></a>
                    </div>

                </div>

                    <!-- Central Modal Small -->
                    <div class="modal fade" id="approvebookorder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                
                    <!-- Change class .modagetstudentforbookborrowforml-sm to change the size of the modal -->
                    <div class="modal-dialog modal-sm" role="document">
                
                    <div class="modal-content">
                        <div class="modal-header">
                        <h6 class="modal-title w-100" id="myModalLabel">Return Date</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div style="">
                                <form id="borrowbookexecutionform" action="javascript:console.log('submited')" method="post">
                                    @csrf
                                    <i id="errormessageaddborrow" style="font-style: normal; font-size: 13px; color: red;"></i><br>
                                    <input id="studentregnobook" name="studentregnobook" type="hidden">
                                    <input id="bookid" name="bookid" type="hidden">
                                    <input type="hidden" name="bookisbnissn" id="bookisbnissn">
                                    <i style="font-style: normal; font-size: 13px;">Please, select the return date</i>
                                    <div class="form-group" style="margin: 3px; display: flex; flex-direction: row;">
                                        <button style="background-color: transparent; border: none; border-left: 1px solid rgb(197, 194, 194); border-top: 1px solid rgb(197, 194, 194); border-bottom: 1px solid rgb(197, 194, 194);" disabled><i class="fas fa-calendar-alt"></i></button>
                                        <input type="date" name="datetoreturnbook" class="form-control form-control-sm" style="border-radius: 0px;">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>

                        <button id="bookborrowexecutionbtnspinner" class="btn btn-success btn-sm" type="button" disabled style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="sr-only">Loading...</span>
                        </button>

                        <button type="button" id="borrowbookexecutionbtn" form="borrowbookexecutionform" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- Central Modal Small -->

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary btn-sm">Save changes</button> --}}
                </div>
            </div>
            </div>
        </div>
        <!-- Central Modal Small -->
            

        {{-- delete borrow record --}}
        
        <!-- Central Modal Small -->
        <div class="modal fade" id="deletebookborrowrecord" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
        
            <!-- Change class .modal-sm to change the size of the modal -->
            <div class="modal-dialog modal-sm" role="document">
        
        
            <div class="modal-content">
                <div class="modal-header">
                <h6 class="modal-title w-100" id="myModalLabel">Warning</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <i style="font-style: normal; font-size: 12px;">Are you sure you want to delete this book record? 
                        Remember that this process cannot be reversed.</i>
                    <form id="deleteborrowrecordform" action="javascript:console.log('submited')" method="post">
                        @csrf
                        <input type="hidden" id="borrowidtodelete" name="borrowrecordid">
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
                <button type="button" id="deleteborrowrecordbtn" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                </div>
            </div>
            </div>
        </div>
        <!-- Central Modal Small -->

{{-- recieve book from student --}}

        <!-- Button trigger modal -->
        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#recievebookfromstudent">
            Launch demo modal
        </button> --}}
        
        <!-- Central Modal Small -->
        <div class="modal fade" id="recievebookfromstudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
        
            <!-- Change class .modal-sm to change the size of the modal -->
            <div class="modal-dialog modal-md" role="document">
        
        
            <div class="modal-content">
                <div class="modal-header">
                <h6 class="modal-title w-100" id="returnmodaltitle">Modal title</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <i id="booktitlereturn" style="font-style: normal; font-size: 14px; font-weight: bold;"></i>
                    <br>
                    <div class="row">
                        <div class="col-md-3" style="display: flex; align-items: center; justify-content: center;">
                            <img id="bookcovermodal" src="https://mdbootstrap.com/img/Others/documentation/img%20(75)-mini.jpg" alt="thumbnail" class="img-thumbnail" style="width: 100px; height: auto;">
                        </div>
                        <div class="col-md-9">
                            <form id="returnbookform" action="javascript:console.log('submitted')" method="post">
                                @csrf
                                <div class="form-group">
                                    <select name="bookcondition" id="bookcondition" class="form-control form-control-sm" style="border-radius: 0px;">
                                        <option value="">Select book condition</option>
                                        <option value="Bad">Bad</option>
                                        <option value="Good">Good</option>
                                    </select>
                                </div><br>
                                <i id="infobookrevokeapprovereturn" style="font-style: normal; font-size: 14px;">Please confirm book condition before accepting.</i>
                                <input id="borrowrecordid" name="borrowrecordid" type="hidden">
                                <input type="hidden" id="actiontype" name="actiontype">
                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
                <button type="button" id="returnbookbtn" class="btn btn-success btn-sm" form="returnbookform"><i id="btnapproveicon" class="fas fa-check"></i></button>
                </div>
            </div>
            </div>
        </div>
        <!-- Central Modal Small -->


        <input id="userrolefilter" type="hidden" value="{{Auth::user()->getRoleNames()[0]}}">

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

        function deleteborrowdata(borrowbookid){

            document.getElementById('borrowidtodelete').value = borrowbookid;

            $("#deletebookborrowrecord").modal()
        }

        function recievebookfromstudent(booktitle, bookcover, borrowid, studentname, action){

            if (action == "revoke") {

                document.getElementById('bookcovermodal').src = "storage/cover/"+bookcover;
                document.getElementById('booktitlereturn').innerHTML = booktitle;
                document.getElementById('borrowrecordid').value = borrowid;
                document.getElementById('returnmodaltitle').innerHTML = studentname;
                document.getElementById('btnapproveicon').classList.remove("fa-check");
                document.getElementById('btnapproveicon').classList.remove("fas");
                document.getElementById('btnapproveicon').classList.add("fa-rev");
                document.getElementById('btnapproveicon').classList.add("fab");
                document.getElementById('btnapproveicon').style.color = "black";
                document.getElementById('returnbookbtn').classList.remove('btn-success');
                document.getElementById('returnbookbtn').classList.add('btn-warning');
                document.getElementById('actiontype').value = action;
                document.getElementById('bookcondition').value = "Good"
                document.getElementById('infobookrevokeapprovereturn').innerHTML = "Revoke only when you are sure you approved a wrong order.";
                
            }else{
                document.getElementById('bookcovermodal').src = "storage/cover/"+bookcover;
                document.getElementById('booktitlereturn').innerHTML = booktitle;
                document.getElementById('borrowrecordid').value = borrowid;
                document.getElementById('returnmodaltitle').innerHTML = studentname;

                document.getElementById('btnapproveicon').classList.add("fa-check");
                document.getElementById('btnapproveicon').classList.add("fas");
                document.getElementById('btnapproveicon').classList.remove("fa-rev");
                document.getElementById('btnapproveicon').classList.remove("fab");
                document.getElementById('btnapproveicon').style.color = "white";
                document.getElementById('returnbookbtn').classList.add('btn-success');
                document.getElementById('returnbookbtn').classList.remove('btn-warning');
                document.getElementById('actiontype').value = action;
                document.getElementById('infobookrevokeapprovereturn').innerHTML = "Please confirm book condition before accepting.";
            }

            $("#recievebookfromstudent").modal()

        }
    </script>
</body>
</html>