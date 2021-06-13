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
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- JQVMap -->
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('../../plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('../../plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


  <style>
    #myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 12px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myUL {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

#myUL li a {
  border: 1px solid #ddd;
  margin-top: -1px; /* Prevent double borders */
  background-color: #f6f6f6;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  color: black;
  display: block
}

#myUL li a:hover:not(.header) {
  background-color: #eee;
}
  </style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
//--------------------------------------------------------------------------------------------
//                                   adding school initials
//--------------------------------------------------------------------------------------------
        $(function() {
            $('#addschoolinitialsbtn').click(function(e) {
                e.preventDefault();
                $("#addschoolinitialsform").submit();

                document.getElementById('addschoolinitialsbtn').style.display = "none"
                document.getElementById('addschoolinitialsbtnprocess').style.display = "block"

                $.ajax({
                url: "{{ route('addschoolinitials') }}",
                type: 'post',
                dataType: 'json',
                data: $('form#addschoolinitialsform').serialize(),
                success: function(data) {

                      if (data.msg == "1") {

                        document.getElementById('schoolinitialsinput').style.borderColor = "green"
                        document.getElementById('addschoolinitialsbtn').style.display = "none"
                        document.getElementById('addschoolinitialsbtnprocess').style.display = "none"

                      }else{
                        document.getElementById('schoolinitialsinput').style.borderColor = "red"
                        document.getElementById('addschoolinitialsbtn').style.display = "block"
                        document.getElementById('addschoolinitialsbtnprocess').style.display = "none"
                      }

                    },
                    error:function(errors){
                      console.log(errors)
                    },
                    timeout: 60000
                });
            });
        });

//--------------------------------------------------------------------------------------------
//                                      Add school session
//--------------------------------------------------------------------------------------------
        $('#schoolsessionbtnmodal').click(function() {
          $inputsession = document.getElementById('schoolsessioninput')
            if ($inputsession.value == "") {
              document.getElementById('schoolsessioninput').style.borderColor = "red"
            }else{
              $('#modalschoolsession').modal('show')
            }     
        });
        
        $(function() {
            $('#schoolsessionbtn').click(function(e) {
                e.preventDefault();
                $("#schoolsessionform").submit();

                document.getElementById('schoolsessionbtnmodal').style.display = "none"
                document.getElementById('schoolsessionspinner').style.display ="block"

                $.ajax({
                url: "{{ route('addschoolsession') }}",
                type: 'post',
                dataType: 'json',
                data: $('form#schoolsessionform').serialize(),
                success: function(data) {

                      if (data.msg == "1") {

                        document.getElementById('schoolsessioninput').style.borderColor = "green"
                        document.getElementById('schoolsessionbtnmodal').style.display = "block"
                        document.getElementById('schoolsessionspinner').style.display ="none"

                      }else{
                        document.getElementById('schoolsessioninput').style.borderColor = "red"
                        document.getElementById('schoolsessionbtnmodal').style.display = "block"
                        document.getElementById('schoolsessionspinner').style.display ="none"

                      }

                    },
                    error:function(errors){
                      console.log(errors)
                    },
                    timeout: 60000
                });
            });
          });

//-----------------------------------------------------------------------------------------
//                                        add classes
//-----------------------------------------------------------------------------------------
          $(function() {
            $('#addclasses_secbtn').click(function(e) {
                e.preventDefault();
                $("#addclasses_secform").submit();

                document.getElementById('addclasses_secbtn').style.display = "none"
                document.getElementById('classes_spinner_sec').style.display ="block"

                $.ajax({
                url: "{{ route('addclasses_sec') }}",
                type: 'post',
                dataType: 'json',
                data: $('form#addclasses_secform').serialize(),
                success: function(data) {

                  console.log(data)

                      if (data.msg == "1") {
                        document.getElementById('addclasses_input').style.borderColor = "green"
                        document.getElementById('addclasses_secbtn').style.display = "block"
                        document.getElementById('classes_spinner_sec').style.display ="none"
                        document.getElementById('addclasses_input').value = ""

                      }else{
                        document.getElementById('addclasses_input').style.borderColor = "red"
                        document.getElementById('addclasses_secbtn').style.display = "block"
                        document.getElementById('classes_spinner_sec').style.display ="none"
                      }

                    },
                    error:function(errors){
                      console.log(errors)
                    },
                    timeout: 60000
                });
            });
          });

//--------------------------------------------------------------------------------
//                                   add school houses 
//--------------------------------------------------------------------------------

          $(function() {
            $('#addhouses_secbtn').click(function(e) {
                e.preventDefault();
                $("#addhouses_secform").submit();

                document.getElementById('addhouses_secbtn').style.display = "none"
                document.getElementById('houses_spinner_sec').style.display ="block"

                $.ajax({
                url: '{{ route('addhouses_sec') }}',
                type: 'post',
                dataType: 'json',
                data: $('form#addhouses_secform').serialize(),
                success: function(data) {

                //   console.log(data)

                      if (data.msg == "1") {
                        document.getElementById('addhouses_input').style.borderColor = "green"
                        document.getElementById('addhouses_secbtn').style.display = "block"
                        document.getElementById('houses_spinner_sec').style.display ="none"
                        document.getElementById('addhouses_input').value = ""

                      }else{
                        document.getElementById('addhouses_input').style.borderColor = "red"
                        document.getElementById('addhouses_secbtn').style.display = "block"
                        document.getElementById('houses_spinner_sec').style.display ="none"
                      }

                    },
                    error:function(errors){
                      console.log(errors)
                    },
                    timeout: 60000
                });
            });
          });

//-----------------------------------------------------------------------------
//                                   add section
//-----------------------------------------------------------------------------

          $(function() {
            $('#addsection_secbtn').click(function(e) {
                e.preventDefault();
                $("#addsection_secform").submit();

                document.getElementById('addsection_secbtn').style.display = "none"
                document.getElementById('section_spinner_sec').style.display ="block"

                $.ajax({
                url: "{{ route('addsection_sec') }}",
                type: 'post',
                dataType: 'json',
                data: $('form#addsection_secform').serialize(),
                success: function(data) {

                //   console.log(data)

                      if (data.msg == "1") {
                        document.getElementById('addsection_input').style.borderColor = "green"
                        document.getElementById('addsection_secbtn').style.display = "block"
                        document.getElementById('section_spinner_sec').style.display ="none"
                        document.getElementById('addsection_input').value = ""

                      }else{
                        document.getElementById('addsection_input').style.borderColor = "red"
                        document.getElementById('addsection_secbtn').style.display = "block"
                        document.getElementById('section_spinner_sec').style.display ="none"
                      }

                    },
                    error:function(errors){
                      console.log(errors)
                    },
                    timeout: 60000
                });
            });
          });

//------------------------------------------------------------------------------
//                                    add club
//------------------------------------------------------------------------------

          $(function() {
            $('#addclub_secbtn').click(function(e) {
                e.preventDefault();
                $("#addclub_secform").submit();

                document.getElementById('addclub_secbtn').style.display = "none"
                document.getElementById('club_spinner_sec').style.display ="block"

                $.ajax({
                url: "{{ route('addclub_sec') }}",
                type: 'post',
                dataType: 'json',
                data: $('form#addclub_secform').serialize(),
                success: function(data) {

                //   console.log(data)

                      if (data.msg == "1") {
                        document.getElementById('addclub_input').style.borderColor = "green"
                        document.getElementById('addclub_secbtn').style.display = "block"
                        document.getElementById('club_spinner_sec').style.display ="none"
                        document.getElementById('addclub_input').value = ""

                      }else{
                        document.getElementById('addclub_input').style.borderColor = "red"
                        document.getElementById('addclub_secbtn').style.display = "block"
                        document.getElementById('club_spinner_sec').style.display ="none"
                      }

                    },
                    error:function(errors){
                      console.log(errors)
                    },
                    timeout: 60000
                });
            });
          });

//------------------------------------------------------------------------------------------------
//                                        add subjects
//------------------------------------------------------------------------------------------------

          $(function() {
            $('#addsubjectprocess_secbtn').click(function(e) {
                e.preventDefault();
                $("#addsubjectprocess_secform").submit();

                  document.getElementById('subjectaddprocessspinner').style.display = "flex"

                $.ajax({
                url: '/subjectprocess_sec',
                type: 'post',
                dataType: 'json',
                data: $('form#addsubjectprocess_secform').serialize(),
                success: function(data) {

                  console.log(data)

                  if (data.errors) {
                      for (let index = 0; index < data.errors.length; index++) {
                          const element = data.errors[index];

                          document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");

                          // console.log(element)
                          
                        }

                      document.getElementById('subjectaddprocessspinner').style.display = "none"
                  }else if(data.duplicate){

                      $("#subjectalertduplicate").removeClass("alert-info");
                      $("#subjectalertduplicate").addClass("alert-danger");
                      document.getElementById('subjectadd_sec').innerHTML = "Subject code already in use"
                      document.getElementById('subjectaddprocessspinner').style.display = "none"

                  }else{

                      $("#subjectalertduplicate").removeClass("alert-info");
                      $("#subjectalertduplicate").removeClass("alert-danger");
                      $("#subjectalertduplicate").addClass("alert-success");
                      document.getElementById('subjectadd_sec').innerHTML = "Subject successfully added"
                      document.getElementById('subjectaddprocessspinner').style.display = "none"
                      fullscreenerror('subject added successfully.', ' ', '#', 'Success', 'success')

                  }

                    },
                    error:function(errors){
                      console.log(errors)
                      document.getElementById('subjectaddprocessspinner').style.display = "none"
                      // var arrayOfErrors = errors.responseJSON.errors
                      // console.log(arrayOfErrors)
                      // var keys = Object.keys(arrayOfErrors)

                      // console.log(arrayOfErrors.length)

                      // for (let index = 0; index < keys.length; index++) {
                      //   const element = keys[index];

                      //   document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");

                      //   // console.log(element)
                        
                      // }
                    },
                    timeout: 60000
                });
            });
          });

          $('#addsubjectprocess_secform').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
          });

//------------------------------------------------------------------------------------
//                           confirm students registration
//------------------------------------------------------------------------------------


          $(function() {
            $('#studentregconfirmbtn').click(function(e) {
                e.preventDefault();
                $("#studentregconfirmform").submit();

                  // document.getElementById('subjectaddprocessspinner').style.display = "flex"

                  document.getElementById('studentclassallocated').value = document.getElementById('allocatedclass').value
                  document.getElementById('studentsectionallocated').value = document.getElementById('allocatedsection').value
                  document.getElementById('studentsystemnumber').value = document.getElementById('systemnumber').value
                  document.getElementById('schoolsession').value = document.getElementById('currentsession').value
                  document.getElementById('studenttype').value = document.getElementById('allocatedshift').value

                $.ajax({
                url: '/student_sec_confirm',
                type: 'post',
                dataType: 'json',
                data: $('form#studentregconfirmform').serialize(),
                success: function(data) {

                //   console.log(data)

                    if (data.errors) {

                      for (let index = 0; index < data.errors.length; index++) {
                          const element = data.errors[index];

                          document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");

                          // console.log(element)
                          
                        }
                      
                    }else if(data.create){

                        for (let index = 0; index < data.create.length; index++) {
                          const element = data.create[index];

                          console.log(element)
                          document.getElementById('registeredfirstname').value = data.create[index]['firstname'];
                          document.getElementById('registeredmiddlename').value = data.create[index]['middlename']; 
                          document.getElementById('registeredlastname').value = data.create[index]['lastname']
                           if (data.create[index]['profileimg'] == null) {
                            document.getElementById('passportconfirm_sec').src = 'storage/schimages/profile.png'
                           }else{
                            document.getElementById('passportconfirm_sec').src = 'storage/schimages/'+ data.create[index]['profileimg']
                           }
                          
                          
                        }

                    }else{
                      $("#subjectalertduplicate").removeClass("alert-info");
                      $("#subjectalertduplicate").removeClass("alert-danger");
                      $("#subjectalertduplicate").addClass("alert-success");
                      document.getElementById('subjectadd_sec').innerHTML = "Student record Already Added..."
                      fullscreenerror('Student record already exist.', ' ', '#', 'Ooops...', 'error')
                    }

                    },
                    error:function(errors){
                      // console.log(errors)
                      fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...', 'error')

                    },
                    timeout: 60000
                });
            });
          });

          $('#studentregconfirmform').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
          });
          
          
          


//----------------------------------------------------------------------------------------
//                                 fetch students by class
//----------------------------------------------------------------------------------------

          $(function() {
            $('#viewsingleclassbtn').click(function(e) {
                e.preventDefault();
                $("#viewsingleclassform").submit();

                $("#viewstudentsingleclass").find("tr:gt(0)").remove();
                document.getElementById('viewstudentsingleclassprogress').style.display = "flex"

                $.ajax({
                url: '/viewstudentsingleclass',
                type: 'post',
                dataType: 'json',
                data: $('form#viewsingleclassform').serialize(),
                success: function(data) {

                  document.getElementById('viewstudentsingleclassprogress').style.display = "none"

                //   console.log(data)
                  if (data.errors) {

                    for (let index = 0; index < data.errors.length; index++) {
                        const element = data.errors[index];

                        document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");

                        // console.log(element)
                        
                    }

                  }else{

                      for (let index = 0; index < data.length; index++) {
                        const element = data[index];

                        var tablee = document.getElementById('viewstudentsingleclass');
                        var row = tablee.insertRow(1);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);
                        var cell6 = row.insertCell(5);
                        cell1.innerHTML = data[index]['id'];
                        cell2.innerHTML = data[index]['classname'];
                        cell3.innerHTML = data[index]['firstname']+" "+data[index]['middlename']+" "+data[index]['lastname'];
                        cell4.innerHTML = data[index]['gender'];
                        cell5.innerHTML = data[index]['studentshift'];
                        cell6.innerHTML = '<button class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button> <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>';
                      
                    }

                  }
                  


                    },
                    error:function(errors){
                      // console.log(errors)
                      fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...', 'error')

                    },
                    timeout: 60000
                });
            });
          });

          $('#viewsingleclassform').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
          }); 

//-------------------------------------------------------------------------------------------
//                             confirm teachers registration
//-------------------------------------------------------------------------------------------

          $(function() {
            $('#teacherregconfirmbtn').click(function(e) {
                e.preventDefault();
                $("#teacherregconfirmform").submit();

                  // document.getElementById('subjectaddprocessspinner').style.display = "flex"

                  document.getElementById('formteacherclass').value = document.getElementById('masterallocatedclass').value
                  document.getElementById('formsection').value = document.getElementById('masterallocatedsection').value
                  document.getElementById('systemidformmaster').value = document.getElementById('mastersystemnumber').value
                  // document.getElementById('schoolsession').value = document.getElementById('currentsession').value
                  // document.getElementById('studenttype').value = document.getElementById('allocatedshift').value

                $.ajax({
                url: '/teacher_sec_confirm',
                type: 'post',
                dataType: 'json',
                data: $('form#teacherregconfirmform').serialize(),
                success: function(data) {

                //   console.log(data)

                    if (data.errors) {

                      for (let index = 0; index < data.errors.length; index++) {
                          const element = data.errors[index];

                          document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");

                          // console.log(element)
                          
                        }
                      
                    }else if(data.create){
                        
                        console.log(data)

                        for (let index = 0; index < data.create.length; index++) {
                          const element = data.create[index];

                          console.log(element)
                          document.getElementById('registeredfirstname').value = data.create[index]['firstname'];
                          document.getElementById('registeredmiddlename').value = data.create[index]['middlename']; 
                          document.getElementById('registeredlastname').value = data.create[index]['lastname']
                           if (data.create[index]['profileimg'] == null) {
                            document.getElementById('passportconfirm_sec').src = 'storage/schimages/profile.png'
                           }else{
                            document.getElementById('passportconfirm_sec').src = 'storage/schimages/'+ data.create[index]['profileimg']
                           }
                          
                          
                        }

                    }else{
                      $("#subjectalertduplicate").removeClass("alert-info");
                      $("#subjectalertduplicate").removeClass("alert-danger");
                      $("#subjectalertduplicate").addClass("alert-success");
                    //   document.getElementById('subjectadd_sec').innerHTML = "Student record Already Added..."
                      fullscreenerror('Student record already exist.', ' ', '#', 'Ooops...', error)
                    }

                    },
                    error:function(errors){
                      // console.log(errors)
                      fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...', 'error')

                    },
                    timeout: 60000
                });
            });
          });

          $('#teacherregconfirmform').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
          });
          
          $('#addstudent_modal').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
          });

//-----------------------------------------------------------------------------------------------------
//                                       add form master
//-----------------------------------------------------------------------------------------------------

          $(function() {
            $('#allocatemastermainbtn').click(function(e) {
                e.preventDefault();
                $("#allocatemastermainform").submit();

                  // document.getElementById('subjectaddprocessspinner').style.display = "flex"

                  // document.getElementById('formteacherclass').value = document.getElementById('masterallocatedclass').value
                  // document.getElementById('formsection').value = document.getElementById('masterallocatedsection').value
                  // document.getElementById('systemidformmaster').value = document.getElementById('mastersystemnumber').value
                  // document.getElementById('schoolsession').value = document.getElementById('currentsession').value
                  // document.getElementById('studenttype').value = document.getElementById('allocatedshift').value

                $.ajax({
                url: '/allocateformmaster',
                type: 'post',
                dataType: 'json',
                data: $('form#allocatemastermainform').serialize(),
                success: function(data) {

                //   console.log(data)

                    if (data.errors) {

                      fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...', 'error')
                      
                    }else if(data.exist){

                      fullscreenerror('Teacher already a form master', ' ', '#', 'Ooops...', 'error')

                    }else if(data.done){

                      fullscreenerror('Process successfull', ' ', '#', 'Success...', 'success')

                    }
                    

                    },
                    error:function(errors){
                      // console.log(errors)
                      fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...', 'error')

                    },
                    timeout: 60000
                });
            });
          });

//------------------------------------------------------------------------------------------------
//                               confirm teacher 2
//------------------------------------------------------------------------------------------------

          $(function() {
            $('#allocatesubjectbtn').click(function(e) {
                e.preventDefault();
                $("#allocatesubjectform").submit();

                  // document.getElementById('subjectaddprocessspinner').style.display = "flex"

                //   document.getElementById('allocatedclass').value = document.getElementById('allocateclasssubject').value
                  document.getElementById('allocatesubject').value = document.getElementById('allocationsubject').value
                  document.getElementById('systemidsubjectalloc').value = document.getElementById('systemidstudentalloc').value
                  // document.getElementById('schoolsession').value = document.getElementById('currentsession').value
                  // document.getElementById('studenttype').value = document.getElementById('allocatedshift').value

                $.ajax({
                url: '/teachers_sec_confirm',
                type: 'post',
                dataType: 'json',
                data: $('form#allocatesubjectform').serialize(),
                success: function(data) {

                  console.log(data)

                    if (data.errors) {

                        for (let index = 0; index < data.errors.length; index++) {
                          const element = data.errors[index];

                          document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");

                          // console.log(element)
                          
                        }
                      
                    }else if(data.create){

                        for (let index = 0; index < data.create.length; index++) {
                          const element = data.create[index];

                          console.log(element)
                          document.getElementById('registeredfirstname2').value = data.create[index]['firstname'];
                          document.getElementById('registeredmiddlename2').value = data.create[index]['middlename']; 
                          document.getElementById('registeredlastname2').value = data.create[index]['lastname']
                           if (data.create[index]['profileimg'] == null) {
                            document.getElementById('passportconfirm_sec2').src = 'storage/schimages/profile.png'
                           }else{
                            document.getElementById('passportconfirm_sec2').src = 'storage/schimages/'+ data.create[index]['profileimg']
                           }
                          
                          
                        }

                    }else{
                      // $("#subjectalertduplicate").removeClass("alert-info");
                      // $("#subjectalertduplicate").removeClass("alert-danger");
                      // $("#subjectalertduplicate").addClass("alert-success");
                      // document.getElementById('subjectadd_sec').innerHTML = "Student record Already Added..."
                      fullscreenerror('Student record already exist.', ' ', '#', 'Ooops...', 'error')
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

          $('#allocatesubjectform').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
          });

//----------------------------------------------------------------------------------------------------
//                                        alocate subject for teacher
//----------------------------------------------------------------------------------------------------

          $(function() {
            $('#subjectallocationbtn').click(function(e) {
                e.preventDefault();
                $("#subjectallocationform").submit();

                  // document.getElementById('subjectaddprocessspinner').style.display = "flex"

                  // document.getElementById('formteacherclass').value = document.getElementById('masterallocatedclass').value
                  // document.getElementById('formsection').value = document.getElementById('masterallocatedsection').value
                  // document.getElementById('systemidformmaster').value = document.getElementById('mastersystemnumber').value
                  // document.getElementById('schoolsession').value = document.getElementById('currentsession').value
                  // document.getElementById('studenttype').value = document.getElementById('allocatedshift').value

                $.ajax({
                url: '/allocatesubjectteacher',
                type: 'post',
                dataType: 'json',
                data: $('form#subjectallocationform').serialize(),
                success: function(data) {

                  console.log(data)

                    if (data.errors) {

                      fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...', 'error')
                      
                    }else if(data.exist){

                      fullscreenerror('Subject already allocated to this teacher', ' ', '#', 'Ooops...', 'error')

                    }else if(data.done){

                      fullscreenerror('Process successfull', ' ', '#', 'Success...', 'success')

                    }
                    

                    },
                    error:function(errors){
                      // console.log(errors)
                      fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...', 'error')

                    },
                    timeout: 60000
                });
            });
          });

            $("#myInput").on("keyup", function() {
              var value = $(this).val().toLowerCase();
              $("#myList li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
              });
            });


//---------------------------------------------------------------------------------------------
//                                     fetch entire class
//--------------------------------------------------------------------------------------------- 
          $(function() {
            $('#fetchslass_secbtn').click(function(e) {
                e.preventDefault();
                $("#fetchslass_sec").submit();

              document.getElementById('attendanceprocessbtn').style.display = "block"
              document.getElementById('fetchslass_secbtn').style.display = "none"

                $.ajax({
                url: '/fetchalluserbyclass_sec',
                type: 'post',
                dataType: 'json',
                data: $('form#fetchslass_sec').serialize(),
                success: function(data) {

                  if (data.fetch) {

                    var html = "";

                    for (let index = 0; index < data.fetch.length; index++) {
                      const element = data.fetch[index];
                      
                      var attendanceCheck = data.attids

                      var elementMain = element.id

                      var n = attendanceCheck.includes(elementMain.toString());
                      console.log(n)

                      if (n) {
                        html += "<tr>"+"<td>"+element.id+"</td>"+"<td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td>"+"<td>"+element.classname+element.sectionname+"</td>"+"<td>"+"<i style='color: green;' class='fas fa-check'></i>"+"</td>"+"</tr>";
                      }else{
                        html += "<tr>"+"<td>"+element.id+"</td>"+"<td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td>"+"<td>"+element.classname+element.sectionname+"</td>"+"<td>"+"<input id='checkboxattendance' type='checkbox' onclick='test("+element.id+")'>"+"</td>"+"</tr>";
                      }

                      
                      
                    }

                    $("#fetcheduserstableattendance").html(html);
                    document.getElementById('attendanceprocessbtn').style.display = "none"
                    document.getElementById('fetchslass_secbtn').style.display = "block"
                    
                  }

                  if (data.errors) {
                    for (let index = 0; index < data.errors.length; index++) {
                          const element = data.errors[index];

                          document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");

                          // console.log(element)
                          
                    }
                    document.getElementById('attendanceprocessbtn').style.display = "none"
                    document.getElementById('fetchslass_secbtn').style.display = "block"
                  }


                    },
                    error:function(errors){
                      console.log(errors)
                      // fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...')
                      document.getElementById('attendanceprocessbtn').style.display = "none"
                      document.getElementById('fetchslass_secbtn').style.display = "block"

                    },
                    timeout: 60000
                });
            });
          });
          $('#fetchslass_sec').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
          });
          
//---------------------------------------------------------------------------------------------
//                                 fetch students view
//---------------------------------------------------------------------------------------------

        $(function() {
            $('#fetchslass_secbtn_view').click(function(e) {
                e.preventDefault();
                $("#fetchslass_secbtn_viewform").submit();

              document.getElementById('attendanceprocessbtn').style.display = "block"
              document.getElementById('fetchslass_secbtn_view').style.display = "none"

                $.ajax({
                url: '/view_all_at_sec',
                type: 'post',
                dataType: 'json',
                data: $('form#fetchslass_secbtn_viewform').serialize(),
                success: function(data) {
                    
                    console.log(data);

                  if (data.fetch) {

                    var html = "";

                    for (let index = 0; index < data.fetch.length; index++) {
                      const element = data.fetch[index];
                      
                      var attendanceCheck = data.attids

                      var elementMain = element.id

                      var n = attendanceCheck.includes(elementMain.toString());
                      console.log(n)

                      if (n) {
                        html += "<tr>"+"<td>"+element.id+"</td>"+"<td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td>"+"<td>"+element.classname+element.sectionname+"</td>"+"<td>"+"<i style='color: green;' class='fas fa-check'></i>"+"</td>"+"</tr>";
                      }else{
                        html += "<tr>"+"<td>"+element.id+"</td>"+"<td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td>"+"<td>"+element.classname+element.sectionname+"</td>"+"<td>"+"<i class='fas fa-times' style='color: red;'></i>"+"</td>"+"</tr>";
                      }

                      
                      
                    }

                    $("#fetcheduserstableattendancesview").html(html);
                    document.getElementById('attendanceprocessbtn').style.display = "none"
                    document.getElementById('fetchslass_secbtn_view').style.display = "block"
                    
                  }

                  if (data.errors) {
                    for (let index = 0; index < data.errors.length; index++) {
                          const element = data.errors[index];

                          document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");

                          // console.log(element)
                          
                    }
                    document.getElementById('attendanceprocessbtn').style.display = "none"
                    document.getElementById('fetchslass_secbtn_view').style.display = "block"
                  }


                    },
                    error:function(errors){
                      console.log(errors)
                      // fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...')
                      document.getElementById('attendanceprocessbtn').style.display = "none"
                      document.getElementById('fetchslass_secbtn_view').style.display = "block"

                    },
                    timeout: 60000
                });
            });
          });

//---------------------------------------------------------------------------------------------
//                             fetch subjects for each class
//---------------------------------------------------------------------------------------------

          $('#classselect').on('change', function() {
            // alert( this.value );

            document.getElementById('fetchsubjects_sec_process').style.display = "flex"

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

                        console.log(result);

                        document.getElementById('fetchsubjects_sec_process').style.display = "none"

                        if (result.subjectlist) {
                          document.getElementById('fetchsubjects_sec_process').style.display = "none"

                          var html="";

                          for (let index = 0; index < result.subjectlist.length; index++) {
                            const element = result.subjectlist[index];
                            html += "<option value='"+element.id+"'>"+element.subjectname+"</option>"
                          }

                          var mainhtml = "<option value=''>Select a subject</option>"+html

                          $("#subjectlistfetched").html(mainhtml);


                        }

                        // document.getElementById('attendancespinnersp').style.display = "none"
                      //   document.getElementById('checkboxattendance').setAttribute("enable", "");
                        
                  
                    },
                    error:function(){
                      alert('failed')
                      document.getElementById('fetchsubjects_sec_process').style.display = "none"
                    },
                    timeout: 60000
                  });
          });

          $('#subjectlistfetched').on('change', function() {
            // alert(this.value)

            document.getElementById('fetchsubjects_sec_process').style.display = "flex"

            if (this.value != '') {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                  });
                  $.ajax({
                      url:"/fetch_subject_details", //the page containing php script
                      method: "POST", //request type,
                      cache: false,
                      data: {subjectid:this.value},
                      success:function(result){
                        document.getElementById('fetchsubjects_sec_process').style.display = "none"

                        
                        if (result.subjectdetails) {

                          for (let index = 0; index < result.subjectdetails.length; index++) {
                            const element = result.subjectdetails[index];

                            document.getElementById('selectedsubject').innerHTML = element.subjectname

                            document.getElementById('exams_sec_f').innerHTML = element.examfull
                            document.getElementById('ca1_sec_f').innerHTML = element.ca1full
                            document.getElementById('ca2_sec_f').innerHTML = element.ca2full
                            document.getElementById('ca3_sec_f').innerHTML = element.ca3full
                            document.getElementById('total_sec_f').innerHTML = element.totalfull

                            document.getElementById('exams_sec_p').innerHTML = element.exampass
                            document.getElementById('ca1_sec_p').innerHTML = element.ca1pass
                            document.getElementById('ca2_sec_p').innerHTML = element.ca2pass
                            document.getElementById('ca3_sec_p').innerHTML = element.ca3pass
                            document.getElementById('total_sec_p').innerHTML = element.totalpass
                            
                          }
                          
                        }
                        
                  
                    },
                    error:function(){
                      alert('failed')
                      document.getElementById('fetchsubjects_sec_process').style.display = "none"
                      
                    },
                    timeout: 60000
                  });
            }


          });

//-------------------------------------------------------------------------------------------------
//                                  main fetch students for marks query
//-------------------------------------------------------------------------------------------------
          $(function() {
            $('#fetchstudentforresultbtn').click(function(e) {
                e.preventDefault();
                $("#fetchstudentforresultform").submit();

                  document.getElementById('processgetstudentsspinner').style.display = "flex" 
                  document.getElementById('processterm').value = document.getElementById('selected_term').value;
                  document.getElementById('classidmarks').value = document.getElementById('classselect').value;
                  document.getElementById('sessionprocessmark').value = document.getElementById('currentsession').value;
                  

                  // document.getElementById('formteacherclass').value = document.getElementById('masterallocatedclass').value
                  // document.getElementById('formsection').value = document.getElementById('masterallocatedsection').value
                  // document.getElementById('systemidformmaster').value = document.getElementById('mastersystemnumber').value
                  // document.getElementById('schoolsession').value = document.getElementById('currentsession').value
                  // document.getElementById('studenttype').value = document.getElementById('allocatedshift').value
                  
                //   document.getElementById('notificationalertmarks').style.display = "none"
                //   document.getElementById('processresultpositionmarks').style.display = "none"

                $.ajax({
                url: '/fetch_subject_student_details',
                type: 'post',
                dataType: 'json',
                data: $('form#fetchstudentforresultform').serialize(),
                success: function(data) {

                  document.getElementById('processgetstudentsspinner').style.display = "none"

                  if(data.errors){
                    for (let index = 0; index < data.errors.length; index++) {
                          const element = data.errors[index];

                          document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                          
                    }
                  }else{
                      
                      document.getElementById('notificationalertmarks').style.display = "block"
                      document.getElementById('processresultpositionmarks').style.display = "block"

                    var html = "";

                    for (let index = 0; index < data.studentlist.length; index++) {
                      const element = data.studentlist[index];

                      var exams = ""
                      var ca1 = ""
                      var ca2 = ""
                      var ca3 = ""
                      var total = ""
                      var grades = ""
                      var positions = ""

                      if (element.exams == null) {
                        exams = "---"
                      }else{
                        exams = element.exams
                      }

                      if (element.ca1 == null) {
                        ca1 = "---"
                      }else{
                        ca1 = element.ca1
                      }

                      if (element.ca2 == null) {
                        ca2 = "---"
                      }else{
                        ca2 = element.ca2
                      }

                      if (element.ca3 == null) {
                        ca3 = "---"
                      }else{
                        ca3 = element.ca3
                      }

                      if (element.totalmarks == null) {
                        total = "---"
                      }else{
                        total = element.totalmarks
                      }

                      if (element.grades == null) {
                        grades = "---"
                      }else{
                        grades = element.grades
                      }
                      
                      if (element.position == null) {
                        positions = "---"
                      }else{
                        positions = element.position
                      }
                      
                      

                            html += "<tr>"+"<td>"+element.id+"</td>"+"<td>"+element.renumberschoolnew+"</td>"+"<td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td>"+"<td>"+exams+"</td>"+"<td>"+ca1+"</td>"+"<td>"+ca2+"</td>"+"<td>"+ca3+"</td>"+"<td>"+total+"</td>"+"<td>"+positions+"</td>"+"<td>"+grades+"</td>"+"<td>"+"<button class='btn btn-success btn-sm' onclick=\"addmarksmodaltrigger('"+element.firstname+"', '"+element.middlename+"', '"+element.lastname+"', '"+element.exams+"', '"+element.ca1+"', '"+element.ca2+"', '"+element.ca3+"', '"+element.id+"', '"+element.classid+"', '"+element.markid+"')\">"+"<i class='far fa-plus-square'></i>"+"</button></td>"+"</tr>";

                      
                    }

                    $("#studentmarkslist").html(html);
                  }
                    
                    },
                    error:function(errors){
                      document.getElementById('processgetstudentsspinner').style.display = "none"
                    },
                    timeout: 60000
                });
            });
          });

//-------------------------------------------------------------------------------------------------------------
//                                     addmarks main script
//-------------------------------------------------------------------------------------------------------------

          $(function() {
            $('#submitmarksmainbtn').click(function(e) {
                e.preventDefault();
                $("#submitmarksmainform").submit();

                document.getElementById('addmarkprogress').style.display = "block";
                document.getElementById('submitmarksmainbtn').style.display = "none"

                $.ajax({
                url: '{{ route("add_marks_main") }}',
                type: 'post',
                dataType: 'json',
                data: $('form#submitmarksmainform').serialize(),
                success: function(data) {
                    
                    console.log(data)

                  document.getElementById('addmarkprogress').style.display = "none";
                  document.getElementById('submitmarksmainbtn').style.display = "block"
                    
                  if(data.errors){

                    for (let index = 0; index < data.errors.length; index++) {
                          const element = data.errors[index];
                          document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                    }
                  }
                  
                  if(data.empty){
                      document.getElementById('messagedisplay').innerHTML = "Process failed, ensure all fields are filled";
                      document.getElementById('messagedisplay').style.color = "red";
                  }

                  if (data.success) {
                    fullscreenerror('Added successfully.', ' ', '#', 'Success', 'success');
                      document.getElementById('messagedisplay').innerHTML = "Process success, student marks successfully added";
                      document.getElementById('messagedisplay').style.color = "green";
                    
                  }
                  
                  if(data.grade){
                      document.getElementById('messagedisplay').innerHTML = "Process failed. Please setup school grading system <a href='/grades_sec'>HERE</a>";
                      document.getElementById('messagedisplay').style.color = "red";
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
          

//--------------------------------------------------------------------------------------------------------------------
//                                          psycomoto
//--------------------------------------------------------------------------------------------------------------------

        $(function() {
            $('#motoaddid').click(function(e) {
                e.preventDefault();
                $("#motoaddform").submit();

                document.getElementById('spinnermotoprocess').style.display = "flex";

                $.ajax({
                url: '{{ route('get_students_for_pyco') }}',
                type: 'post',
                dataType: 'json',
                data: $('form#motoaddform').serialize(),
                success: function(data) {
                  document.getElementById('spinnermotoprocess').style.display = "none";

                    // console.log(data);

                    if(data.errors){
                      for (let index = 0; index < data.errors.length; index++) {
                            const element = data.errors[index];
                            document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                      }
                    }

                    if (data.success) {

                      var atlistarray = data.atlist;

                      var html =""

                      for (let index = 0; index < data.success.length; index++) {
                        const element = data.success[index];

                        var layer_id = $(this).data('id');
                        var url = '{{ route("view_student", ":id") }}';
                        url = url.replace(':id', element.userid );

                        var n = atlistarray.includes(element.id);

                        if (n) {

                          html += "<tr><td>"+element.id+"</td><td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td><td>"+element.classname+element.sectionname+"</td><td><button class='btn btn-sm btn-success'><i class='fas fa-check'></i></button></td></tr>";
                          
                        }else{

                          html += "<tr><td>"+element.id+"</td><td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td><td>"+element.classname+element.sectionname+"</td><td><a href="+url+"><button class='btn btn-sm btn-success'><i class='far fa-plus-square'></i></button></a></td></tr>";

                        }

                      }
                      
                    }

                    $("#tablemoto").html(html);


                    },
                    error:function(errors){
                      console.log(errors)
                    },
                    timeout: 60000
                });
            });
        });

        $('#motoaddform').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
        });

        $(function() {
            $('#modalformbtn').click(function(e) {
                e.preventDefault();
                $("#modalformform").submit();

                document.getElementById('psycospinner').style.display = "flex";

                $.ajax({
                url: '/addmoto_main',
                type: 'post',
                dataType: 'json',
                data: $('form#modalformform').serialize(),
                success: function(data) {

                  document.getElementById('psycospinner').style.display = "none";

                    // console.log(data);

                    if(data.errors){
                      for (let index = 0; index < data.errors.length; index++) {
                            const element = data.errors[index];
                            document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                      }
                    }

                    if (data.duplicate) {

                      fullscreenerror('Psycomoto already added.', ' ', '#', 'Duplicate', 'error');
                      
                    }

                    if (data.success) {
                      fullscreenerror('Psycomoto added successfully.', ' ', '#', 'Success', 'success');
                    }


                    },
                    error:function(errors){
                      console.log(errors)
                    },
                    timeout: 60000
                });
            });
        });

        $('#modalformform').on('keypress change', function(e) {
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
                url: '/marks_process_main',
                type: 'post',
                dataType: 'json',
                data: $('form#processformmarksform').serialize(),
                success: function(data) {


                //   console.log(data)

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
          
          
        function checkInternetConnection(){
            var status = navigator.onLine;
            if (status) {
                // console.log('Internet Available !!');
                document.getElementById('navbarofflineonline').style.borderBottomColor = "rgb(75, 201, 50)"
            } else {
                // console.log('No internet Available !!');
                document.getElementById('navbarofflineonline').style.borderBottomColor = "red"
            }  
            
            
            setTimeout(function() {
                checkInternetConnection();
                
            }, 1000);
        }
        
        
        checkInternetConnection();
        
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
        
//---------------------------role allocation section----------------------------------
        
        
        $(function() {
            $('#addrolebtn').click(function(e) {
                e.preventDefault();
                $("#addroleform").submit();

                  document.getElementById('spinnerroleallocation').style.display = "block"
                  document.getElementById('addrolebtn').style.display = "none"

                $.ajax({
                url: '/allocate_role_sec',
                type: 'post',
                dataType: 'json',
                data: $('form#addroleform').serialize(),
                success: function(data) {
                  document.getElementById('spinnerroleallocation').style.display = "none"
                  document.getElementById('addrolebtn').style.display = "block"

                  console.log(data)

                    if (data.errors) {
                      for (let index = 0; index < data.errors.length; index++) {
                          const element = data.errors[index];
                          document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                        }
                    }

                    if (data.userdetails) {

                      if (data.userdetails[0].profileimg != null) {
                        document.getElementById('allocateroleimg').src = "storage/schimages/"+data.userdetails[0].profileimg;
                      }else{
                        document.getElementById('allocateroleimg').src = "https://cdn.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png";
                      }

                      
                      document.getElementById('fullnamerole').innerHTML = data.userdetails[0].firstname+" "+data.userdetails[0].middlename+" "+data.userdetails[0].lastname
                      document.getElementById('systemnumberrole').value = data.userdetails[0].id;

                      $("#addrolequery").modal()
                      
                    }

                    if (data.none) {
                      fullscreenerror('No response. Please, check that the number you entered is correct', ' ', '#', 'Ooops...', 'error')
                    }


                    },
                    error:function(errors){
                      // console.log(errors)
                      document.getElementById('spinnerroleallocation').style.display = "none"
                      document.getElementById('addrolebtn').style.display = "block"
                      fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...', 'error')

                    },
                    timeout: 60000
                });
            });
          });


          $(function() {
            $('#allocaterolebtn').click(function(e) {
                e.preventDefault();
                $("#allocateroleform").submit();

                  // document.getElementById('spinnerroleallocation').style.display = "block"
                  document.getElementById('allocaterolebtn').style.display = "none"
                  document.getElementById('spinnerallocaterolemain').style.display = "block"

                $.ajax({
                url: '/allocate_role_sec_main',
                type: 'post',
                dataType: 'json',
                data: $('form#allocateroleform').serialize(),
                success: function(data) {
                  document.getElementById('spinnerallocaterolemain').style.display = "none"
                  // document.getElementById('addrolebtn').style.display = "block"
                  document.getElementById('allocaterolebtn').style.display = "block"

                  console.log(data)

                  if (data.success) {
                    fullscreensuccess('Role allocated', ' ', '#', 'Success...')
                  }

                    if (data.errors) {
                      for (let index = 0; index < data.errors.length; index++) {
                          const element = data.errors[index];
                          document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                        }
                    }

                    if (data.notallow) {
                      fullscreenerror('Operation not allowed', ' ', '#', 'Ooops...', 'error')
                      
                    }




                    },
                    error:function(errors){
                      // console.log(errors)
                      // document.getElementById('spinnerroleallocation').style.display = "none"
                      // document.getElementById('addrolebtn').style.display = "block"
                      fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...', 'error')

                    },
                    timeout: 60000
                });
            });
          });
          
          
          
//--------------------------------------------------------------------------------------------------
//                                    fetch student for promotion  
//--------------------------------------------------------------------------------------------------

        $(function() {
            $('#fetchstudentforprotionbtn').click(function(e) {
                e.preventDefault();
                $("#fetchstudentforprotionform").submit();

                document.getElementById('spinnerfetchstudentpromotion').style.display = "block";
                document.getElementById('fetchstudentforprotionbtn').style.display = "none";
                document.getElementById('promotebtnall').style.display = "none" 

                $.ajax({
                url: '/promotion_student_ftech_sec',
                type: 'post',
                dataType: 'json',
                data: $('form#fetchstudentforprotionform').serialize(),
                success: function(data) {

                  document.getElementById('spinnerfetchstudentpromotion').style.display = "none";
                  document.getElementById('fetchstudentforprotionbtn').style.display = "block";
                  

                  

                    console.log(data.success);

                    if(data.errors){

                      for (let index = 0; index < data.errors.length; index++) {
                            const element = data.errors[index];
                            document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                      }
                    }

                    if(data.success){
                        
                        document.getElementById('promotebtnall').innerHTML = "Promote"

                      var html = "";
                      var classidpromoto = data.success.classlist_secs[0].id
                      var classnamepromoto = data.success.classlist_secs[0].classname
                      var currentclassold = "";
                      if (data.success.addstudent_sec.length > 0) {
                        currentclassold = data.success.addstudent_sec[0].classname
                        document.getElementById('promotebtnall').style.display = "block";
                      }else{
                          document.getElementById('promotebtnall').style.display = "none";
                      }

                      document.getElementById('nextClassDisplay').value = classidpromoto;

                      document.getElementById('nextClassDisplayname').value = classnamepromoto;

                      document.getElementById('nextclassforjss3').value = classnamepromoto

                      document.getElementById('nextpromotoss1jss3').value = classidpromoto

                      console.log(currentclassold)

                      var regno_array = [];

                      for (let index = 0; index < data.success.addstudent_sec.length; index++) {
                        const element = data.success.addstudent_sec[index];
                        regno_array.push(element.id);
                        if (currentclassold == "JSS3") {
                          html += "<tr>"+"<td>"+element.id+"</td>"+"<td>"+element.renumberschoolnew+"</td>"+"<td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td>"+"<td>"+Math.round(element.promomarks * 100)/100+"</td>"+"<td>"+"<button class='btn btn-sm btn-info' onclick=\"triggerpromojsstosss('"+element.id+"')\"><i class='fas fa-arrow-circle-right'></i></button>"+" "+"<button class='btn btn-sm btn-info'><i class='fas fa-arrow-circle-right'></i></button>"+"</td>"+"</tr>";
                        }else{
                          html += "<tr>"+"<td>"+element.id+"</td>"+"<td>"+element.renumberschoolnew+"</td>"+"<td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td>"+"<td>"+Math.round(element.promomarks * 100)/100+"</td>"+"<td>"+"<button class='btn btn-sm btn-info'><i class='fas fa-arrow-circle-right'></i></button>"+" "+"<button class='btn btn-sm btn-info'><i class='fas fa-arrow-circle-right'></i></button>"+"</td>"+"</tr>";
                        }
                      }

                      if (currentclassold == "JSS3") {
                        document.getElementById('fullpromotionform').style.display = "none";
                        document.getElementById('jss3toss1promo').style.display = "block";
                      }else{
                        document.getElementById('fullpromotionform').style.display = "block";
                      }

                      // console.log(regno_array);
                      document.getElementById('studentsforpromotion').value = regno_array;

                      $("#promostudentlist").html(html);

                    }

                    if (data.nopromo) {

                      console.log(data.addstudent_sec);

                      document.getElementById('promotebtnall').innerHTML = "Graduate"

                      var regno_array = [];

                      for (let index = 0; index < data.addstudent_sec.length; index++) {

                        document.getElementById('nextClassDisplay').value = "GRAD";

                        document.getElementById('nextClassDisplayname').value = "GRAD";


                        const element = data.addstudent_sec[index];
                        regno_array.push(element.id);
                        if (currentclassold == "JSS3") {
                          html += "<tr>"+"<td>"+element.id+"</td>"+"<td>"+element.renumberschoolnew+"</td>"+"<td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td>"+"<td>"+Math.round(element.promomarks * 100)/100+"</td>"+"<td>"+"<button class='btn btn-sm btn-info' onclick=\"triggerpromojsstosss('"+element.id+"')\"><i class='fas fa-arrow-circle-right'></i></button>"+" "+"<button class='btn btn-sm btn-info'><i class='fas fa-arrow-circle-right'></i></button>"+"</td>"+"</tr>";
                        }else{
                          html += "<tr>"+"<td>"+element.id+"</td>"+"<td>"+element.renumberschoolnew+"</td>"+"<td>"+element.firstname+" "+element.middlename+" "+element.lastname+"</td>"+"<td>"+Math.round(element.promomarks * 100)/100+"</td>"+"<td>"+"<button class='btn btn-sm btn-info'><i class='fas fa-arrow-circle-right'></i></button>"+" "+"<button class='btn btn-sm btn-info'><i class='fas fa-arrow-circle-right'></i></button>"+"</td>"+"</tr>";
                        }
                      }

                      document.getElementById('studentsforpromotion').value = regno_array;

                      $("#promostudentlist").html(html);
                    }

                    },
                    error:function(errors){
                      console.log(errors)
                    },
                    timeout: 60000
                });
            });
        });

        $('#fetchstudentforprotionform').on('keypress change', function(e) {
            // console.log(e);
            document.getElementsByName(e.target.name)[0].style.setProperty("background-color", "#EEF0F0", "important");
        });
        
        
        
        $(function() {
            $('#btnjss_sssbtn').click(function(e) {
                e.preventDefault();
                $("#btnjss_sssform").submit();

                  // document.getElementById('spinnerroleallocation').style.display = "block"
                  // document.getElementById('allocaterolebtn').style.display = "none"
                  // document.getElementById('spinnerallocaterolemain').style.display = "block"

                $.ajax({
                url: '/promote_jss_ss',
                type: 'post',
                dataType: 'json',
                data: $('form#btnjss_sssform').serialize(),
                success: function(data) {
                  // document.getElementById('spinnerallocaterolemain').style.display = "none"
                  // document.getElementById('addrolebtn').style.display = "block"
                  // document.getElementById('allocaterolebtn').style.display = "block"

                  console.log(data)
                  

                    if (data.errors) {
                      for (let index = 0; index < data.errors.length; index++) {
                          const element = data.errors[index];
                          document.getElementsByName(element)[0].style.setProperty("background-color", "#FB9DA2", "important");
                        }
                    }

                    if (data.success) {
                      document.getElementById("fetchstudentforprotionbtn").click(); 
                      fullscreenerror('Student successfully promoted', ' ', '#', 'Success...', 'success')
                      
                    }

                    },
                    error:function(errors){
                      // console.log(errors)
                      // document.getElementById('spinnerroleallocation').style.display = "none"
                      // document.getElementById('addrolebtn').style.display = "block"
                      console.log(errors);
                      fullscreenerror('Oops an error occured', ' ', '#', 'Ooops...', 'error')

                    },
                    timeout: 60000
                });
            });
          });
          
            $(function () {
              $('[data-toggle="popover-hover"]').popover({
                trigger: 'hover',
              })
            })
            
            // Tooltips Initialization
            $(function () {
              $('[data-toggle="tooltip"]').tooltip()
            })



    });
  </script>
  
  <style>
                  
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
<body onload="scrollocation()" class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
  <!-- Navbar -->
  <nav id="navbarofflineonline" class="main-header navbar navbar-expand navbar-white navbar-light" style="border-bottom: 2px solid rgb(75, 201, 50);">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-sm-inline-block">
        <a href="#" class="nav-link"><button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#addevents">Add Events</button></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <!--<form class="form-inline ml-3">-->
    <!--  <div class="input-group input-group-sm">-->
    <!--    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">-->
    <!--    <div class="input-group-append">-->
    <!--      <button class="btn btn-navbar" type="submit">-->
    <!--        <i class="fas fa-search"></i>-->
    <!--      </button>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</form>-->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
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
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
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
 
        
    <a href="/feed_back" class="float" data-target="#sideModalTR" data-toggle="tooltip" data-placement="top" title="FeedBack">
        <i class="fas fa-reply my-float" style="color: black;"></i>
    </a>

    @yield('content')
    
    <!-- Modal -->
    <div class="modal fade" id="addevents" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add School Event</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="eventform" action="/add_event" method="POST">
                @csrf
                <div class="form-group">
                    <label>Event subject</label>
                    <input name="eventsubject" type="text" class="form-control form-control-sm" placeholder="Event subject">
                </div>
                <div class="form-group">
                    <label>Event details</label>
                    <textarea name="eventdetails" class="form-control form-control-sm" row="30" col="7" placeholder="Event subject"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Start date</label>
                            <input name="eventstartdate" type="date" class="form-control form-control-sm" placeholder="Start date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>End date</label>
                            <input name="eventenddate" type="date" class="form-control form-control-sm" placeholder="End date">
                        </div>
                    </div>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" form="eventform" class="btn btn-success btn-sm">Add</button>
          </div>
        </div>
      </div>
    </div>
    
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
 
  function fullscreenerror(message, message1, link, title, type){
    Swal.fire({
    icon: type,
    title: title,
    text: message,
    footer: '<a href='+ link +'>'+ message1 +'</a>'
  })
 }
 
 
 function triggerpromojsstosss(regno){

    document.getElementById('studenttopromoteregno').value = regno

  $('#jssthreetosssone').modal('show');

 }
 </script>
  @stack('custom-scripts')
</body>
</html>