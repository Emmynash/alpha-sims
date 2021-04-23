<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Alpha-Sims</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('../../plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">

  <style>
      /* width */
      ::-webkit-scrollbar {
          width: 10px;
        }
        
        /* Track */
        ::-webkit-scrollbar-track {
          background: #f1f1f1; 
        }
        
        /* Handle */
        ::-webkit-scrollbar-thumb {
          background: #888; 
        }
        
        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
          background: #555; 
        }

        .subjectcard_student:hover {
          background-color: #ddd;
        }
  </style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $(function() {
            $('#mytest').click(function(e) {
                e.preventDefault();
                $("#myForm").submit();
                document.getElementById('motoform').style.display = "none";
                document.getElementById('mytest').style.display = "none"
                document.getElementById('spinner').style.display = "block";
                $.ajax({
                url: '/addmoto',
                type: 'post',
                dataType: 'json',
                data: $('form#myForm').serialize(),
                success: function(data) {
                      console.log(data)
                      document.getElementById('successindicator').style.display = "block";
                      document.getElementById('spinner').style.display = "none";
                      document.getElementById('motoform').style.display = "none";
                      document.getElementById('alertmoto').style.display = "none";
                      document.getElementById('spinner').style.display = "none";
                    },
                    error:function(errors){
                      document.getElementById('alertmoto').style.display = "block";
                      document.getElementById('motoform').style.display = "block";
                      document.getElementById('mytest').style.display = "block"
                      document.getElementById('spinner').style.display = "none";
                    }
                });
            });
        });

        $(function() {
            $('#formSubmit').click(function(e) {
                e.preventDefault();
                $("#addsubject").submit();

                

                document.getElementById('subjectprocess').style.display = "block"

                $.ajax({
                url: "{{ route('addsubjectpost') }}",
                type: 'post',
                dataType: 'json',
                data: $('form#addsubject').serialize(),
                success: function(data) {
                      console.log(data)
                      if (data.msg == "0") {
                        document.getElementById('subjectprocess').style.display = "none"
                        $("#projectalert").removeClass("alert-warning");
                        $("#projectalert").removeClass("alert-danger");
                        $("#projectalert").addClass("alert-success");
                        // document.getElementById('subjectalertmessage').innerHTML = "subject added successfully"
                        fullscreensuccess('subject added Successfully.', ' ', '/grades', 'Success...')
                        window.scrollTo(0, 0);
                      }else{
                        document.getElementById('subjectprocess').style.display = "none"
                        $("#projectalert").removeClass("alert-warning");
                        $("#projectalert").addClass("alert-danger");
                        $("#projectalert").remove("alert-success");
                        // document.getElementById('subjectalertmessage').innerHTML = "subject already added"
                        window.scrollTo(0, 0);
                        fullscreenerror('subject already added.', ' ', '/grades', 'Oops...')
                      }
                      
                    },
                    error:function(errors){

                      $("#projectalert").removeClass("alert-warning");
                      $("#projectalert").addClass("alert-danger");
                      // document.getElementById('subjectalertmessage').innerHTML = "An error occured. Caused either due to empty fields or field not filled properly"
                      document.getElementById('subjectprocess').style.display = "none"
                      window.scrollTo(0, 0);

                      var arrayOfErrors = errors.responseJSON.errors
                      // console.log(arrayOfErrors)
                      var keys = Object.keys(arrayOfErrors)

                      // console.log(arrayOfErrors.length)

                      for (let index = 0; index < keys.length; index++) {
                        const element = keys[index];

                        document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");

                        // console.log(element)
                        
                      }

                    }
                });
            });
        });


        $('#subjectform').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
        });


        $(function() {
            $('#addstaffbtn').click(function(e) {
                e.preventDefault();
                $("#addstaff").submit();

                document.getElementById('staffconfirmprocess').style.display = "block"

                $.ajax({
                url: '{{ route('addstaffdata') }}',
                type: 'post',
                dataType: 'json',
                data: $('form#addstaff').serialize(),
                success: function(data) {
                      
                      if (data.length > 0) {
                        var firstname = data[0]['firstname']
                        var middlename = data[0]['middlename']
                        var lastname = data[0]['lastname']
                        var profileimg = data[0]['profileimg']

                        $('#myModal').modal('show')
                        document.getElementById('staffconfirmprocess').style.display = "none"
                        document.getElementById('firstnamemain').innerHTML = firstname
                        document.getElementById('middlenamemain').innerHTML = middlename
                        document.getElementById('lastnamemain').innerHTML = lastname
                        document.getElementById('profileuploaded').style.display = "block"
                        document.getElementById('profileuploaded').src = "storage/schimages/"+profileimg
                        document.getElementById('profilepix').style.display = "none"
                        document.getElementById('staffid').value = data[0]['id']
                      }else{
                        document.getElementById('teacherRegNoConfirm').style.setProperty("background-color", "#FB9DA2", "important")
                        document.getElementById('staffconfirmprocess').style.display = "none"
                      }
                    },
                    error:function(errors){
                      document.getElementById('teacherRegNoConfirm').style.setProperty("background-color", "#FB9DA2", "important")
                      document.getElementById('staffconfirmprocess').style.display = "none"
                    }
                });
            });
        });

        $('#addstaff').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
        });

        $(function() {
            $('#promotionfrombtn').click(function(e) {
                e.preventDefault();
                $("#promotionfrom").submit();

               document.getElementById('tablepromofetch').style.display ="visible"

              //  $("#promotiontable tbody").empty();
              //  $("#promotiontable > tr").remove();
              $("#promotiontable").find("tr:gt(0)").remove();

                $.ajax({
                url: '/fetchstudentspromotion',
                type: 'post',
                dataType: 'json',
                data: $('form#promotionfrom').serialize(),
                success: function(data) {

                  if (data[0].length > 0) {
                    console.log(data)
                    document.getElementById('promoalert').style.display = "none";
                    document.getElementById('tablepromofetch').style.display ="none"
                    document.getElementById('arrayregno').value = data[1]
                    document.getElementById('initialsession').value = data[0][0]['schoolsession']
                    for (let index = 0; index < data[0].length; index++) {
                      const element = data[0][index]['id'];
                      console.log(element)

                      var tablee = document.getElementById('promotiontable');
                      var row = tablee.insertRow(1);
                      var cell1 = row.insertCell(0);
                      var cell2 = row.insertCell(1);
                      var cell3 = row.insertCell(2);
                      var cell4 = row.insertCell(3);
                      cell1.innerHTML = data[0][index]['id'];
                      cell2.innerHTML = data[0][index]['renumberschoolnew'];
                      cell3.innerHTML = data[0][index]['firstnamenew'] +" "+ data[0][index]['middlenamenew'] +" "+ data[0][index]['lastnamenew'];
                      cell4.innerHTML = "<button data-toggle=\"modal\" data-target=\"#modal-lg\" onclick=\"ttt()\" class=\" btn btn-sm bg-success\"><i class=\"fas fa-angle-double-right\"></i></button class=\" btn btn-sm bg-info\">";

                      
                    }
                  }else{
                    console.log(data)
                    document.getElementById('promoalert').style.display = "block";
                  }
                      
                      

                    },
                    error:function(errors){

                      console.log(errors)
                    }
                });
            });
        });

        $(function() {
            $('#resultstudenttable').click(function(e) {
                e.preventDefault();
                $("#fetchresult").submit();

              //  document.getElementById('tablepromofetch').style.display ="visible"

              //  $("#promotiontable tbody").empty();
              //  $("#promotiontable > tr").remove();
              $("#studenttable").find("tr:gt(0)").remove();

                $.ajax({
                url: '/specificresult',
                type: 'post',
                dataType: 'json',
                data: $('form#fetchresult').serialize(),
                success: function(data) {
                      
                      if (data.length > 0) {
                        for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        var tablee = document.getElementById('studenttable');
                        var row = tablee.insertRow(1);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);
                        var cell6 = row.insertCell(5);
                        var cell7 = row.insertCell(6);
                        var cell8 = row.insertCell(7);
                        var cell9 = row.insertCell(8);
                        var cell10 = row.insertCell(9);
                        cell1.innerHTML = data[index]['subjectcode'];
                        cell2.innerHTML = data[index]['subjectname'];
                        cell3.innerHTML = data[index]['exams'];
                        cell4.innerHTML = data[index]['ca1'];
                        cell5.innerHTML = data[index]['ca2'];
                        cell6.innerHTML = data[index]['ca3'];
                        cell7.innerHTML = data[index]['totalmarks'];
                        cell8.innerHTML = data[index]['grades'];
                        cell9.innerHTML = data[index]['term'];
                        cell10.innerHTML = '<button class="btn btn-sm btn-info"><i class="fas fa-ban"></i></button>';
                        }
                      } else{

                        

                      }

                    },
                    error:function(errors){

                      console.log(errors)
                    }
                });
            });
        });

//-----------------------------------------------------------------------------------------------
//                                      fetch single user
//-----------------------------------------------------------------------------------------------

        $(function() {
            $('#regNumberQuerybtn').click(function(e) {
                e.preventDefault();
                $("#querysingleuser").submit();

              //  document.getElementById('tablepromofetch').style.display ="visible"

              //  $("#promotiontable tbody").empty();
              //  $("#promotiontable > tr").remove();
              $("#studenttable").find("tr:gt(0)").remove();

                $.ajax({
                url: '{{ route('confirmRegNew') }}',
                type: 'post',
                dataType: 'json',
                data: $('form#querysingleuser').serialize(),
                success: function(data) {

                  console.log(data)
                      
                      if (data.length > 0) {
                        for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        var tablee = document.getElementById('studenttable');
                        var row = tablee.insertRow(1);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);
                        var cell6 = row.insertCell(5);
                        cell1.innerHTML = data[index]['id'];
                        cell2.innerHTML = data[index]['classid'];
                        cell3.innerHTML = data[index]['firstname'] +" "+ data[index]['middlename'] +" "+ data[index]['lastname']
                        cell4.innerHTML = data[index]['gender'];
                        cell5.innerHTML = data[index]['studentreligion'];
                        cell6.innerHTML = '<button class="btn btn-sm btn-success"><i class="far fa-eye"></i></button> <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>'
                        }
                      } else{

                        console.log(data)

                      }

                    },
                    error:function(errors){

                      console.log(errors)
                    }
                });
            });
        });

//------------------------------------------------------------------------------------------
//                                       fetch students by class
//------------------------------------------------------------------------------------------
        $(function() {
            $('#addschoolentire').click(function(e) {
                e.preventDefault();
                $("#addschool").submit();

              //  document.getElementById('tablepromofetch').style.display ="visible"

              //  $("#promotiontable tbody").empty();
              //  $("#promotiontable > tr").remove();
              $("#studenttable").find("tr:gt(0)").remove();

                $.ajax({
                url: '/confirmReg',
                type: 'post',
                dataType: 'json',
                data: $('form#addschool').serialize(),
                success: function(data) {

                  console.log(data)
                      
                      if (data.length > 0) {
                        for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        var tablee = document.getElementById('studenttable');
                        var row = tablee.insertRow(1);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);
                        var cell6 = row.insertCell(5);
                        cell1.innerHTML = data[index]['id'];
                        cell2.innerHTML = data[index]['classnamee'];
                        cell3.innerHTML = data[index]['firstname'] +" "+ data[index]['middlename'] +" "+ data[index]['lastname']
                        cell4.innerHTML = data[index]['gender'];
                        cell5.innerHTML = data[index]['studentreligion'];
                        cell6.innerHTML = "<a href='/show_student/"+ data[index]['id'] +"' target='_blank'><button class='btn btn-sm btn-success'><i class='far fa-eye'></i></button></a> <button class='btn btn-sm btn-info'><i class='fas fa-edit'></i></button>"
                        }
                      } else{

                        console.log(data)

                      }

                    },
                    error:function(errors){

                      console.log(errors)
                    }
                });
            });
        });

//-----------------------------------------------------------------------------------------
//                                confirm users registration
//-----------------------------------------------------------------------------------------

        $(function() {
            $('#btnuserreg').click(function(e) {
                e.preventDefault();
                $("#addstudent").submit();

                  document.getElementById('classidstd').value = document.getElementById('classid').value
                  document.getElementById('StudentSectionstd').value = document.getElementById('studentsectionvalue').value
                  document.getElementById('systemnumberstd').value = document.getElementById('studentRegNoConfirm').value
                  // document.getElementById('currentsessionstd').value = document.getElementById('schoolsession').value
                  document.getElementById('shiftstd').value = document.getElementById('studentshift').value
                  document.getElementById('spinnerprocessstd').style.display = "block"

                $.ajax({
                url: '{{ route('verifyreg') }}',
                type: 'post',
                dataType: 'json',
                data: $('form#addstudent').serialize(),
                success: function(data) {

                  // console.log(data['errors'])
                      
                      if (data != null && data != "already") {

                          document.getElementById('confirstname').value = data['firstname']
                          document.getElementById('conmiddlename').value = data['middlename']
                          document.getElementById('conlastname').value = data['lastname']
                          document.getElementById('conprofileimg').src = '/storage/schimages/'+ data['profileimg']
                          
                        // document.getElementById('formforstudent').style.display = "block"
                        document.getElementById('spinnerprocessstd').style.display = "none"
                       
                      } else{

                        // console.log(data)

                        document.getElementById('confirstname').value = ""
                        document.getElementById('conmiddlename').value = ""
                        document.getElementById('conlastname').value = ""
                        document.getElementById('conprofileimg').src = ""

                        document.getElementById('spinnerprocessstd').style.display = "none"
                        fullscreenerror('Role already alocated', ' ', 'ff', 'Oops...')

                      }

                    },
                    error:function(errors){

                      // console.log(errors)

                      document.getElementById('confirstname').value = ""
                      document.getElementById('conmiddlename').value = ""
                      document.getElementById('conlastname').value = ""
                      document.getElementById('conprofileimg').src = ""

                      document.getElementById('spinnerprocessstd').style.display = "none"
                    }
                });
            });
        });

        $(function() {
            $('#schoolsessionSetterbtn').click(function(e) {
                e.preventDefault();
                $("#schoolsessionSetterform").submit();

                $.ajax({
                url: '/addsession',
                type: 'post',
                dataType: 'json',
                data: $('form#schoolsessionSetterform').serialize(),
                success: function(data) {
                      if (data.result == "1") {
                        document.getElementById('processConfirm').style.display = "block"
                      } else{
                        
                      }
                    },
                    error:function(errors){
                      console.log(errors)
                    }
                });
            });
        });

//-----------------------------------------------------------------------------------
//                                         moto
//-----------------------------------------------------------------------------------

        $(function() {
            $('#psycomotoquerybtn').click(function(e) {
                e.preventDefault();
                $("#psycomotoquery").submit();

                $("#psycomotoqueryform").find("tr:gt(0)").remove();
                $.ajax({
                url: '{{ route('fetchstudentdata') }}',
                type: 'post',
                dataType: 'json',
                data: $('form#psycomotoquery').serialize(),
                success: function(data) {
                  console.log(data)

                      if (data.length > 0) {

                        for (let index = 0; index < data[0].length; index++) {
                          var mainName = data[0][index]['firstname'] +" "+ data[0][index]['middlename'] +" "+ data[0][index]['lastname']

                        const element = data[0][index];
                        var tablee = document.getElementById('psycomotoqueryform');
                        var row = tablee.insertRow(1);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);
                        cell1.innerHTML = data[0][index]['id'];
                        cell2.innerHTML = data[0][index]['renumberschoolnew'];
                        cell3.innerHTML = mainName
                        cell4.innerHTML = data[0][index]['classnamee'];
                        
                        var motocheck = data[1]

                        var elementMain = data[0][index]['id']

                        var n = motocheck.includes(elementMain.toString());

                        var layer_id = $(this).data('id');
                        var url = '{{ route("addmotomain", ":id") }}';
                        url = url.replace(':id', data[0][index]['usernamesystem'] );

                        if (n) {
                          cell5.innerHTML = '<button class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>'
                        }else{
                          cell5.innerHTML = '<a target="_blank" href=\"'+url+'\"><button class="btn btn-sm btn-success" data-toggle="modal" data-target="#motomodal"><i class="fas fa-plus-square"></i></button></a>'
                        }


                        
                        }

                      } else{
                        
                      }
                    },
                    error:function(errors){
                      console.log(errors)
                    }
                });
            });
        });

        $(function() {
            $('#mainbtnmoto').click(function(e) {
                e.preventDefault();
                $("#mainformmoto").submit();

                // $("#psycomotoqueryform").find("tr:gt(0)").remove();
                $.ajax({
                url: '/addmoto',
                type: 'post',
                dataType: 'json',
                data: $('form#mainformmoto').serialize(),
                success: function(data) {
                  

                      if (data.msg == "1") {
                        // console.log(data)

                        // var studentId = document.getElementById('studentregnomoto').value

                        // var icon = "addconfirm"+studentId
                        // // console.log(icon)

                        // document.getElementById(icon).className = "fas fa-check"

                      } else{
                        
                        console.log(data)
                      }
                    },
                    error:function(errors){
                      console.log(errors)
                    }
                });
            });
        });

//--------------------------------------------------------------------------------------
//                              fetch users for marks entry
//--------------------------------------------------------------------------------------

        $(function() {
            $('#studentmarksbtn').click(function(e) {
                e.preventDefault();
                $("#studentmarksform").submit();

                $("#tableformarks").find("tr:gt(0)").remove();
                document.getElementById('studentmarksbtn').style.display = "none"
                document.getElementById('markmanagebtnprocess').style.display = "block"
                document.getElementById('processterm').value = document.getElementById('schoolterm').value; 
                document.getElementById('classidmarks').value = document.getElementById('selectedClass').value;
                document.getElementById('sessionprocessmark').value = document.getElementById('sessionquery').value;
                document.getElementById('selectedsessionmarksin').value = document.getElementById('studentsection').value;
                $.ajax({
                url: '{{ route('viewusersbyclass') }}',
                type: 'post',
                dataType: 'json',
                data: $('form#studentmarksform').serialize(),
                success: function(data) {

                  console.log(data)

                  try {
                    if (data[0].length > 0) {
                      window.scrollTo(300, 500);
                      
                      document.getElementById('notificationalertmarks').style.display = "block";
                      document.getElementById('processresultpositionmarks').style.display = "block";

                      var subjectidmarks = document.getElementById('selectedClass').value

                      document.getElementById('studentmarksbtn').style.display = "block"
                          document.getElementById('markmanagebtnprocess').style.display = "none"

                        for (let index = 0; index < data[0].length; index++) {
                          const element = data[0][index];



                          var mainName = data[0][index]['firstname'] +" "+ data[0][index]['middlename'] +" "+ data[0][index]['lastname']

                          // const element = data[0][index];
                          var tablee = document.getElementById('tableformarks');
                          var row = tablee.insertRow(1);
                          var cell1 = row.insertCell(0);
                          var cell2 = row.insertCell(1);
                          var cell3 = row.insertCell(2);
                          var cell4 = row.insertCell(3);
                          var cell5 = row.insertCell(4);
                          var cell6 = row.insertCell(5);
                          var cell7 = row.insertCell(6);
                          var cell8 = row.insertCell(7);
                          var cell9 = row.insertCell(8);
                          var cell10 = row.insertCell(9);
                          var cell11 = row.insertCell(10);
                          cell1.innerHTML = data[0][index]['id'];
                          cell2.innerHTML = data[0][index]['renumberschoolnew'];
                          cell3.innerHTML = mainName
                          if (data[0][index]['exams'] == null) {
                            cell4.innerHTML =  "--";
                          }else{
                            cell4.innerHTML =  data[0][index]['exams'];
                          }
                          if (data[0][index]['ca1'] == null) {
                            cell5.innerHTML =  "--";
                          }else{
                            cell5.innerHTML =  data[0][index]['ca1'];
                          }
                          if (data[0][index]['ca2'] == null) {
                            cell6.innerHTML =  "--";
                          }else{
                            cell6.innerHTML =  data[0][index]['ca2'];
                          }
                          if (data[0][index]['ca3'] == null) {
                            cell7.innerHTML =  "--";
                          }else{
                            cell7.innerHTML =  data[0][index]['ca3'];
                          }
                          if (data[0][index]['totalmarks'] == null) {
                            cell8.innerHTML =  "--";
                          }else{
                            cell8.innerHTML =  data[0][index]['totalmarks'];
                          }

                          if (data[0][index]['position'] == null) {
                            cell9.innerHTML =  "--";
                          }else{
                            cell9.innerHTML =  data[0][index]['position'];
                          }
                          
                          if (data[0][index]['grades'] == null) {
                            cell10.innerHTML =  "--";
                          }else{
                            cell10.innerHTML =  data[0][index]['grades'];
                          }
                          
                          var motocheck = data[1]

                          var elementMain = data[0][index]['id']

                          var n = motocheck.includes(elementMain.toString());
                          

                          if (n) {
                            cell11.innerHTML = '<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#marsmodalmain" onclick="marksprocessupdate(\''+data[0][index]["firstname"]+'\', \''+data[0][index]["middlename"]+'\', \''+data[0][index]["lastname"]+'\', \''+data[0][index]["id"]+'\', \''+data[0][index]["markid"]+'\', \''+data[0][index]["exams"]+'\', \''+data[0][index]["ca1"]+'\', \''+data[0][index]["ca2"]+'\', \''+data[0][index]["ca3"]+'\')"><i class="fas fa-user-edit"></i></button>'
                          }else{
                            var nodata = "NA"
                            cell11.innerHTML = '<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#marsmodalmain" onclick="marksprocess(\''+data[0][index]["firstname"]+'\', \''+data[0][index]["middlename"]+'\', \''+data[0][index]["lastname"]+'\', \''+data[0][index]["id"]+'\', \''+nodata+'\')"><i class="fas fa-plus-square"></i></button>'
                          }
                          
                        }

                        } else{

                          document.getElementById('studentmarksbtn').style.display = "block"
                          document.getElementById('markmanagebtnprocess').style.display = "none"

                          toastError(' All Fields are required')

                        }
                  } catch (error) {
                    // console.log(data)

                    document.getElementById('studentmarksbtn').style.display = "block"
                    document.getElementById('markmanagebtnprocess').style.display = "none"
                    toastError(' All Fields are required')

                  }


                    },
                    error:function(errors){
                      // console.log(errors)
                    }
                });
            });
        });

        $(function() {
            $('#marksformmainbtn').click(function(e) {
                e.preventDefault();
                $("#marksformmain").submit();

                // $("#tableformarks").find("tr:gt(0)").remove();
                $.ajax({
                url: '{{ route('addstudentmarks') }}',
                type: 'post',
                dataType: 'json',
                data: $('form#marksformmain').serialize(),
                success: function(data) {
                  
                  // console.log(data)
                  $('#studentmarksbtn').trigger('click');
                  toastSuccess('Marks added successfull')

                  if (data.msg == "grades") {

                    fullscreenerror('You are yet to setup school grading system. Note: you need to enter atleast 5 grades.', 'Please, I need help', '/grades', 'Oops...')
                    
                  }

                      // if (data.length > 0) {

                        

                      // } else{
                        
                      //   console.log(data)
                      // }
                    },
                    error:function(errors){
                      console.log(errors)
                    }
                });
            });
        });

        var _URL = window.URL || window.webkitURL;

        $("#profilepix").change(function(e) {
          var file, img;


          if ((file = this.files[0])) {
              img = new Image();
              img.onload = function() {
                  // alert(this.width + " " + this.height);
                  if (this.width == this.height) {
                    alert('valid')
                  }else{
                    alert('invalid')
                  }
              };
              img.onerror = function() {
                  alert( "not a valid file: " + file.type);
              };
              img.src = _URL.createObjectURL(file);


          }

        }); 

        // $("#studentfathernumber").on("keypress", "paste", function (evt) {
        //     // var keyCode = e.which ? e.which : e.keyCode
                
        //     if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
        //     {
        //         evt.preventDefault();
        //     }
        // });

          // window.setInterval(function(){
          //   /// call your function here
          //   var sectionlistvalue = "43"
            
          //   $.ajaxSetup({
          //         headers: {
          //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          //         }
          //         });
          //           $.ajax({
          //             url:"/fetchmessage", //the page containing php script
          //             method: "POST", //request type,
          //             cache: false,
          //             data: {sectionlist: sectionlistvalue },
          //             success:function(result){


                        // console.log("fdfdfd")
                        // var covertag = document.createElement('a');
                        // covertag.className = "dropdown-item"
                        // var firstdiv = document.createElement('div');
                        // firstdiv.className = "media"
                        // var img = document.createElement('img');
                        // img.className = "img-size-50 mr-3 img-circle"
                        // img.src = ""
                        // var seconddiv = document.createElement('div')
                        // seconddiv.className ="media-body"
                        // var mytext = document.createElement('p')


                        // document.getElementById('chatstart').appendChild(covertag)
                        // firstdiv.appendChild(covertag)
                        // img.appendChild(firstdiv)
                        // seconddiv.appendChild(firstdiv)
                        // mytext.appendChild(firstdiv)
                        // mytext.innerHTML = "dasddsds"





          //               <a href="#" class="dropdown-item">
          //   <!-- Message Start -->
          //   <div class="media">
          //     <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
          //     <div class="media-body">
          //       <h3 class="dropdown-item-title">
          //         Brad Diesel
          //         <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
          //       </h3>
          //       <p class="text-sm">Call me whenever you can...</p>
          //       <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
          //     </div>
          //   </div>
          //   <!-- Message End -->
          // </a>

          //           },
          //           error:function(){
          //             console.log('failed')
          //           }
                    
          //         });
                

          // }, 5000);

//------------------------------------------------------------------------------------
//                                register user manually
//------------------------------------------------------------------------------------

      $(function() {
            $('#manualcreateuserbtn').click(function(e) {
                e.preventDefault();
                $("#manualcreateuser").submit();

                

                // document.getElementById('subjectprocess').style.display = "block"

                $.ajax({
                url: '/regusermanuall',
                type: 'post',
                dataType: 'json',
                data: $('form#manualcreateuser').serialize(),
                success: function(data) {
                      console.log(data)

                      
                    },
                    error:function(errors){

                        console.log(errors)
                      try {
                          var arrayOfErrors = errors.responseJSON.errors
                          // console.log(arrayOfErrors)
                          var keys = Object.keys(arrayOfErrors)

                          // console.log(arrayOfErrors.length)

                          for (let index = 0; index < keys.length; index++) {
                            const element = keys[index];

                            document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");

                            // console.log(element)
                            
                          }
                      } catch (error) {
                        console.log(error)
                      }
                        

                    }
                });
            });
        });

        $(function() {
            $('#submitadminform').click(function(e) {
                e.preventDefault();
                $("#submitadminrole").submit();

                // document.getElementById('addschoolinitialsbtn').style.display = "none"
                // document.getElementById('addschoolinitialsbtnprocess').style.display = "block"

                $.ajax({
                url: '/alocateadmin',
                type: 'post',
                dataType: 'json',
                data: $('form#submitadminrole').serialize(),
                success: function(data) {

                      console.log(data);
                      if (data.success) {
                        console.log(data.success)
                        document.getElementById('fetchedname').innerHTML = data.success[0].firstname+" "+data.success[0].middlename+" "+data.success[0].lastname;
                        document.getElementById('rolefetched').innerHTML = "Role: "+data.success[0].role;
                        document.getElementById('emailfetched').innerHTML = "Email: "+data.success[0].email;
                        document.getElementById('phonefetched').innerHTML = "Phone: "+data.success[0].phonenumber;
                        document.getElementById('whotoasign').value = data.success[0].id;

                        if (data.success[0].schoolid != null) {
                          document.getElementById('alertschoolfetched').style.display = "block"
                          document.getElementById('schoolfetched').innerHTML = "This ID belongs to a User with a school. To avoid data bridge, this operation will not be allowed..."
                        }
                        $('#adminrole').modal('show');
                      }

                      if (data.none) {
                        console.log(data.none)
                        
                      }

                      if (data.errors) {
                        document.getElementById('adminsystemid').style.backgroundColor = "#F59C90"
                      }

                    },
                    error:function(errors){
                      console.log(errors)
                      alert("sdsds");
                    }
                });
            });
        });

        $('#submitadminrole').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
          });
          
          
//----------------------------------------------------------------------------------------------------
//                               result process btn
//----------------------------------------------------------------------------------------------------

          $(function() {
            $('#processformmarksbtn').click(function(e) {
                e.preventDefault();
                $("#processformmarksform").submit();

                document.getElementById('spinnerprocess').style.display = "flex";
                document.getElementById('processnotice').style.display = "none";
                document.getElementById('processformmarksbtn').style.display = "none"


                $.ajax({
                url: '{{ route('process_position_pri') }}',
                type: 'post',
                dataType: 'json',
                data: $('form#processformmarksform').serialize(),
                success: function(data) {


                  console.log(data)

                  if (data.already) {
                    document.getElementById('spinnerprocess').style.display = "none";
                    document.getElementById('spinnerprocesssuccessfailure').style.display = "flex";
                    document.getElementById('processformmarksbtn').style.display = "none";
                    document.getElementById('successfailuretext').innerHTML = "Result already generated for this class."
                    document.getElementById('successfailureicon').style.color = "red"

                    $("#successfailureicon").removeClass("fa-check-circle");
                    $("#successfailureicon").addClass("fa-exclamation-circle");
                  }

                  if (data.success) {
                    
                    document.getElementById('spinnerprocess').style.display = "none";
                    document.getElementById('spinnerprocesssuccessfailure').style.display = "flex";
                    document.getElementById('processformmarksbtn').style.display = "none";
                    document.getElementById('successfailuretext').innerHTML = "Result computed successfully"
                    document.getElementById('successfailureicon').style.color = "green"

                    $("#successfailureicon").addClass("fa-check-circle");
                    $("#successfailureicon").removeClass("fa-exclamation-circle");

                  }
                    
                    
                    },
                    error:function(errors){
                      console.log(errors)
                      // fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...')
                      // document.getElementById('attendanceprocessbtn').style.display = "none"
                      // document.getElementById('fetchslass_secbtn').style.display = "block"

                    },
                    timeout: 60000
                });
            });
          });
          
//----------------------------------------------------------------------------------------------------------------------
//                         asign formmasters and subject allocation
//----------------------------------------------------------------------------------------------------------------------
          
        $(function() {
            $('#formteacherallocationbtn').click(function(e) {
                e.preventDefault();
                $("#formteacherallocationform").submit();

                $.ajax({
                url: '/addteachermain',
                type: 'post',
                dataType: 'json',
                data: $('form#formteacherallocationform').serialize(),
                success: function(data) {

                  console.log(data)
                  
                  if(data.already){
                      fullscreenerror('Teacher already a form master', ' ', '#', 'Ooops...')
                  }

                    },
                    error:function(errors){
                      // console.log(errors)
                      fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...')

                    },
                    timeout: 60000
                });
            });
          });

        //   $('#teacherregconfirmform').on('keypress change', function(e) {
        //     // console.log(e);
        //     document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
        //   });
          
        //   $('#addstudent_modal').on('keypress change', function(e) {
        //     // console.log(e);
        //     document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
        //  });
        
        $(function() {
            $('#allocatesubjectteacherbtn').click(function(e) {
                e.preventDefault();
                $("#allocatesubjectteacherform").submit();


                $.ajax({
                url: "{{ route('addteachermain') }}",
                type: 'post',
                dataType: 'json',
                data: $('form#allocatesubjectteacherform').serialize(),
                success: function(data) {

                  console.log(data)
                  
                  if(data.already){
                      fullscreenerror('Teacher already a form master', ' ', '#', 'Ooops...')
                  }
                  
                  if(data.success){
                      fullscreensuccess('Operation was successfull', ' ', '#', 'Success...')
                  }

                    },
                    error:function(errors){
                      // console.log(errors)
                      fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...')

                    },
                    timeout: 60000
                });
            });
            
        });
        
                
//---------------------------------------------------------------------------------
//                   upload profile pix wthout uploading
//---------------------------------------------------------------------------------
        
        document.getElementById('button').addEventListener('click', () => {
          document.getElementById('profilepix').click()
        })

        
        $(function() {

          $("#profilepix").change(function (event) {

            //stop submit the form, we will post it manually.
            event.preventDefault();

            // Get form
            var form = $('#pixupdatelater')[0];

            document.getElementById('spinnerimageupload').style.display = "block";
            // document.getElementById('bookUploadBtn').style.display = "none";

            // Create an FormData object
            var data = new FormData(form);

            var fileInput = document.getElementById('profilepix');
            var file = fileInput.files[0];

            // If you want to add an extra field for the FormData
            data.append('file', file);

            // disabled the submit button
            // $("#fileUploadBtn").prop("disabled", true);

            $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/uploadProfilePixwithout",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
              document.getElementById('spinnerimageupload').style.display = "none";
                console.log(data)

                if (data.success) {
                  document.getElementById('profileimgmainpix').src = 'storage/schimages/'+data.success;
                }

            },
            error: function (e) {
              document.getElementById('spinnerimageupload').style.display = "none";
              console.log(e)

              fullscreenerror('An error occured. Try again later.', ' ', '#', 'error');

            }
           
            });

            });
        });
 
    });

    function fetchclasses(){



    }



    </script>
</head>
<body onload="scrollocation()" class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

          <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/home" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    {{-- <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div id="chatstart" class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
        
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

        @yield('content')

    </div>
    {{-- <!-- jQuery --> --}}
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
{{-- <!-- jQuery UI 1.11.4 --> --}}
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
{{-- <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip --> --}}
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
{{-- //  Bootstrap 4 --}}
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- // <!-- ChartJS --> --}}
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
{{-- // <!-- Sparkline --> --}}
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
{{-- // <!-- JQVMap --> --}}
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
{{-- // <!-- jQuery Knob Chart --> --}}
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
{{-- // <!-- daterangepicker --> --}}
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
{{-- // <!-- Tempusdominus Bootstrap 4 --> --}}
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
{{-- // <!-- Summernote --> --}}
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('../../plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('../../plugins/toastr/toastr.min.js') }}"></script>
{{-- // <!-- AdminLTE App --> --}}
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
{{-- // <!-- AdminLTE dashboard demo (This is only for demo purposes) --> --}}
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
{{-- // <!-- AdminLTE for demo purposes --> --}}
<script src="{{ asset('dist/js/demo.js') }}"></script>

<script src="{{ asset('../../plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});

function toastSuccess(message) {
  var message;
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

        Toast.fire({
          type: 'success',
          title: message
        })


}

function toastError(message) {
  var message;
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

        Toast.fire({
          type: 'error',
          title: message
        })
}

function fullscreenerror(message, message1, link, title){
    Swal.fire({
      icon: 'error',
      title: title,
      text: message,
      footer: '<a href='+ link +'>'+ message1 +'</a>'
    })
}

function fullscreensuccess(message, message1, link, title){
    Swal.fire({
      icon: 'success',
      title: title,
      text: message,
      footer: '<a href='+ link +'>'+ message1 +'</a>'
    })
}

// $('.sidebar1 a').click(function(){
//     $('.sidebar1 .active').removeClass('active');
//     $(this).parent().addClass('active');
// });
</script>
<script src="{{ asset('js/main.js') }}"></script>

@stack('custom-scripts')
</body>

</html>