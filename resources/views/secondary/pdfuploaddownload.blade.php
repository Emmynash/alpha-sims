<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
    <style>
        .progress { position:relative; width:100%; border: 1px solid #7F98B2; padding: 1px; border-radius: 3px; }
        .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
        .percent { position:absolute; display:flex; align-items: center; justify-content: center; top:0; left:0; bottom: 0; right: 0; color: #7F98B2;}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script>
        $(document).ready(function () {

            $("#fileUploadBtn").click(function (event) {

                //stop submit the form, we will post it manually.
                event.preventDefault();

                // Get form
                var form = $('#fileUploadForm')[0];

                document.getElementById('spinneraddpdf').style.display = "flex"

                // Create an FormData object
                var data = new FormData(form);

                var fileInput = document.getElementById('poster');
                var file = fileInput.files[0];

                // If you want to add an extra field for the FormData
                data.append('file', file);

                // disabled the submit button
                // $("#fileUploadBtn").prop("disabled", true);

                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "{{ route('file-upload') }}",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function (data) {

                        document.getElementById('spinneraddpdf').style.display = "none"

                        if (data.imgerr) {

                            document.getElementById('fileStatus').style.display = "flex";
                            document.getElementById('textresponse').innerHTML = "no image was selected."
                            document.getElementById('fileStatus').classList.remove("bg-success")
                            document.getElementById('fileStatus').classList.add("bg-danger");
                            document.getElementById('logoresponse').classList.remove("fa-check-circle");
                            document.getElementById('logoresponse').classList.add("fa-exclamation-triangle");
                        }

                        if(data.errors){
                            for (let index = 0; index < data.errors.length; index++) {
                                    const element = data.errors[index];

                                    document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                                    
                            }
                        }

                        if (data.success) {

                            document.getElementById('fileStatus').style.display = "flex";
                            document.getElementById('textresponse').innerHTML = "Your file was uploaded successfully";
                            document.getElementById('fileStatus').classList.remove("bg-danger");
                            document.getElementById('fileStatus').classList.add("bg-success");
                            document.getElementById('logoresponse').classList.add("fa-check-circle");
                            document.getElementById('logoresponse').classList.remove("fa-exclamation-triangle");
                            
                        }

                    },
                    error: function (e) {
                        document.getElementById('spinneraddpdf').style.display = "none"

                        document.getElementById('fileStatus').style.display = "flex";
                        document.getElementById('textresponse').innerHTML = "an error occured. Please, try again later"
                        document.getElementById('fileStatus').classList.remove("bg-success")
                        document.getElementById('fileStatus').classList.add("bg-danger");
                        document.getElementById('logoresponse').classList.remove("fa-check-circle");
                        document.getElementById('logoresponse').classList.add("fa-exclamation-triangle");

                    }
                });

            });


//---------------------------------------------------------------------------------------------------
//                                           fetch subject for each class
//---------------------------------------------------------------------------------------------------

        $('#pdfgotclass').on('change', function() {
            // alert( this.value );

            // document.getElementById('fetchsubjects_sec_process').style.display = "flex"

                $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                  });
                  $.ajax({
                      url:"/fetch_students_marks", //the page containing php script
                      method: "POST", //request type,
                      cache: false,
                      data: {classid:this.value},
                      success:function(result){

                        // document.getElementById('fetchsubjects_sec_process').style.display = "none"

                        if (result.subjectlist) {
                        //   document.getElementById('fetchsubjects_sec_process').style.display = "none"

                          var html="";

                          for (let index = 0; index < result.subjectlist.length; index++) {
                            const element = result.subjectlist[index];
                            html += "<option value='"+element.id+"'>"+element.subjectname+"</option>"
                          }

                          var mainhtml = "<option value=''>Select a subject</option>"+html

                          $("#pdfsubject").html(mainhtml);


                        }

                        // document.getElementById('attendancespinnersp').style.display = "none"
                      //   document.getElementById('checkboxattendance').setAttribute("enable", "");
                        
                  
                    },
                    error:function(){
                      alert('failed')
                    //   document.getElementById('fetchsubjects_sec_process').style.display = "none"
                    }
                  });
          });


//-------------------------------------------------------------------------------------------------
//                                       fetch all pdfs
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
                            $.ajax({
                            url: '/all_pdfs',
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

                                    if (data.data.data.length >0) {
                                        for (let index = 0; index < data.data.data.length; index++) {
                                        const element = data.data.data[index];
                                        html += "<div class='col-md-2'>"+"<div class='card' style='margin-bottom: 10px;'>"+"<div class='card-body' style='padding: 0px; display: flex; flex-direction: column; align-items: center; justify-content: center;'>"+"<i style='font-size: 50px; margin-top: 10px; color: #C70039;' class='far fa-copy'></i>"+"<i class='text-center' style='padding: 5px; font-style: normal; font-size: 13px;'>"+element.filetitle+"</i>"+"<div style='margin-bottom: 10px;'>"+"<img src='{{asset('storage/schimages/'.Auth::user()->profileimg)}}' class='rounded-circle' alt='' width='30px' height='30px'>"+"<i style='padding: 5px; font-style: normal; font-size: 10px;'>"+element.firstname+"/"+element.classname+"/"+element.subjectcode+"</i>"+"<a href=storage/pdffiles/"+element.filename+" target='_blank'><i class='fas fa-download'></i></a>"+"</div>"+"</div>"+"</div>"+"</div>";
                                        // console.log(element)
                                        }
                                        $("#pdfsgotten").html(html);
                                    }else{

                                        html += "<div style='display: flex; align-items: center; justify-content: center; height: 100px;'><i class='text-center' style='font-style: normal; text-align: center;'>you are yet to upload a pdf file</i></div>"
                                        $("#pdfsgotten").html(html);
                                    }
                                    
                                    
                                    
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
    <div id="fileStatus" class="card bg-success" style="height: 50px; border-radius: 0px; border: none; display: none; align-items: center; justify-content: center;">
        <i style="color: #fff;"><i id="logoresponse" class="far fa-check-circle"></i> <i style="font-size: 12px; font-style: normal;" id="textresponse">success</i> <i onclick="closealert()" class="fas fa-times"></i></i>
    </div>

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

    <div class="container-fluid" style="margin-top: 20px;">
        <div>
            <a href="/home"><button class="btn btn-sm btn-danger"><i class="fas fa-angle-left"></i> Back</button></a>
            @if(Auth::user()->role != "Student")
                <button class="btn btn-sm btn-info" data-toggle="collapse" data-target="#demo"><i class="far fa-plus-square"></i> Add PDF</button>
                
            <div id="demo" class="collapse row" style="margin: 5px;">
                <div class="col-md-6 card">
                    <div id="spinneraddpdf" style="position: absolute; top: 0; bottom: 0; right: 0; left: 0; display: none; align-items: center; justify-content: center;">
                        <div class="spinner-border" style="width: 100px; height: 100px;"></div>
                    </div>
                    <form id="fileUploadForm" method="POST" style="margin-top: 20px;" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <i style="font-style: normal; font-size: 12px;">Class</i>
                            <select name="pdfgotclass" id="pdfgotclass" class="form-control form-control-sm">
                                <option value="">select a class</option>
                                @if (count($alldata['classlists']))
                                    @foreach ($alldata['classlists'] as $classes)
                                    <option value="{{$classes->id}}">{{$classes->classname}}</option>
                                        
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <i style="font-style: normal; font-size: 12px;">Subject</i>
                            <select name="pdfsubject" id="pdfsubject" class="form-control form-control-sm">
                                <option value="">select a subject</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <i style="font-style: normal; font-size: 12px;">title</i>
                            <input type="text" name="pdftitle" class="form-control form-control-sm" placeholder="title">
                        </div>
                        <div class="form-group">
                            <i style="font-size: 12px; font-style: normal; color: red;">Your file should not be greater than 2MB and must be a PDF/DOCX/DOC file.</i>
                            <input type="file" name="file" id="poster" class="form-control form-control-sm"><br>
                            
                        </div>
                        <button id="fileUploadBtn" type="submit" class="btn btn-sm btn-success">Add</button>
                    </form>
                </div>
            </div>
            
            @endif
            
            
        </div>

        <div class="container-fluid">
            <div class="row" id="pdfsgotten">
                <div class="col-md-12" style="display: flex; height: 100px; align-items: center; justify-content: center;">
                    <div class="spinner-border" style="height: 100px; width: 100px;"></div>
                </div>
            </div>

            <div id="prevnextbtn" style="display: none; align-items: center; justify-content: center;">
                <button id="previous" class="btn btn-sm btn-info"><i class="fas fa-angle-double-left"></i> Prev</button>
                <button id="nextdata" class="btn btn-sm btn-info">Next<i class="fas fa-angle-double-right"></i></button>
            </div>
        </div>

    </div>
    
</body>
</html>