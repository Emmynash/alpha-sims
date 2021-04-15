// verification of temporary registration number
function confirmRegNo(){
    var regNumber = document.getElementById('studentRegNoConfirm').value
    var classId = document.getElementById('classid')
    var studentsectionvalue = document.getElementById('studentsectionvalue')
    var schoolSession = document.getElementById('schoolsession').value
    var studentshift = document.getElementById('studentshift')

    var classIdMain = classId.options[classId.selectedIndex].value;

    var studentsectionvalueMain = studentsectionvalue.options[studentsectionvalue.selectedIndex].value;

    var studentshiftMain = studentshift.options[studentshift.selectedIndex].value;

    if(regNumber == ""){
      toastError('Empty fields not allowed Reg number required')
    }else if(classIdMain == ""){
        toastError('Choose student class')
    }else if (studentsectionvalueMain == ""){
        toastError('Choose student section')
    }else if(schoolSession == ""){
        toastError('School current session is empty')
    } else if(studentshiftMain == ""){
        toastError('choose student shift')
    }else{
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          $.ajax({
            url:"/confirmReg", //the page containing php script
            method: "POST", //request type,
            cache: false,
            data: {regNumber: regNumber, classId:classIdMain, studentsectionvalue:studentsectionvalueMain, studentshiftMain:studentshiftMain},
            success:function(result){
                    // alert(result.msg)
                    if (result.msg != null) {
                      toastError('School initials not set.')
                    } else {
                    document.getElementById('firstname').value = result.firstname
                    document.getElementById('middlename').value = result.middlename
                    document.getElementById('lastname').value = result.lastname
                    document.getElementById('newregnumber').value = Number(result.highestRoll)
                    document.getElementById('studentprofileimg').src = "storage/schimages/"+result.profileimg
                    }
           },
           error:function(){
            toastError('Incorrect number entered')
           }
           
         });
    }
     };

function verifyStudentEntry(){
    var verifystudent = document.getElementById('verifystudent')
    var addstudentbtn = document.getElementById('addstudentbtn')
    var newregnumber = document.getElementById('newregnumber').value

    if (newregnumber != "") {
        verifystudent.style.display = "none"
        addstudentbtn.style.display = "inline-block"
    }else{
        toastError('confirm student details first')
    }
}

//verify teachers details before class allocation

function teacherDetails(){

    var teacherRegNoConfirm = document.getElementById('teacherRegNoConfirm').value

    if (teacherRegNoConfirm  == "") {
        toastError('Registration number cannot be empty')
    }else{
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
              $.ajax({
                url:"/addteachersverify", //the page containing php script
                method: "POST", //request type,
                cache: false,
                data: {regNumber: teacherRegNoConfirm},
                success:function(result){
                        // alert(result.firstname)
                        if (result.msg != null) {
                          toastError('School initials not set.')
                        } else {
                        document.getElementById('firstname').value = result.firstname
                        document.getElementById('middlename').value = result.middlename
                        document.getElementById('lastname').value = result.lastname
                        // document.getElementById('newregnumber').value = Number(result.highestRoll)
                        document.getElementById('studentprofileimgteacher').src = "storage/schimages/"+result.profileimg
                        }
               },
               error:function(){
                toastError('Incorrect number entered')
               }
               
             });
    }


}







 
  
 


