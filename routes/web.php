<?php

use App\Http\Controllers\PromotionController_sec;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Multitenancy\Models\Tenant;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "PagesController@index");

Route::get('/selectdomain', [
    'as' => 'redirect-route',
    'uses' => 'PagesController@domainSelect',
]);




Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/admin', "LandLordController@dashUltimate")->name('admin');
    Route::get('/schoollist', "LandLordController@schoolList")->name('schoollist');
    Route::post('/onboard', "LandLordController@onBoard")->name('onboard');
});




Route::middleware(['tenant'])->group(function () {


    Auth::routes(['verify' => true]);

Route::group(['prefix' => 'pri'], function () {
    
    Route::group(['middleware' => ['auth', 'can:view edit class']], function () {
        Route::get('/viewclasslist', 'ClassesController@index')->name('viewclasslist');
    });

    Route::group(['middleware' => ['auth', 'can:assign subjects']], function () {
            //subject controller 
        Route::get('/addsubject', 'SubjectController_sec@addsubject_sec_page')->name('addsubject');
        Route::Post('/addsubjectpost', 'SubjectController@store')->name('addsubjectpost');
        Route::get('/subjectlist', 'SubjectController@subjectList')->name('subjectlist');
        Route::POST('/updatesubject', 'SubjectController@updateSubject')->name('updatesubject');
    });

    Route::group(['middleware' => ['auth', 'can:add students']], function () { //
        Route::get('/viewstudent', 'StudentController@viewlist')->name('viewstudent');
        Route::POST('/studentreg', 'StudentController@store')->name('studentreg');
        Route::get('/addstudent', 'StudentController_sec@index')->name('addstudent');

        //student
        // Route::get('/addstudent', ['uses' => 'StudentController@index','roles' => ['Admin', 'Teacher']])->middleware('roles');
        Route::POST('/confirmReg', 'StudentController@confirmReg')->name('confirmReg');
        Route::POST('/confirmRegNew', 'StudentController@confirmRegNew')->name('confirmRegNew');
        Route::POST('/verifyreg', 'StudentController@verifyuserregistration')->name('verifyreg');


    });

    Route::group(['middleware' => ['auth', 'can:assign form teacher']], function () { //
        Route::get('/addteacher', 'TeachersController_sec@index')->name('addteacher');
        Route::POST('addteachersverify', 'TeachersController@verifyTeacher')->name('addteachersverify');
        Route::POST('addteachermain', 'TeachersController@store')->name('addteachermain');
        Route::get('/viewteachers', 'TeachersController@viewteachers')->name('viewteachers');
    });

    Route::group(['middleware' => ['auth', 'role:Teacher']], function () {
        Route::get('/editprofileteacher', 'TeachersController@editprofileteacher')->name('editprofileteacher');
        
    });

    Route::group(['middleware' => ['auth']], function () { //, 'can:take teachers attendance'
        Route::get('/teachersattendance', 'TeachersController@teachersAttendance')->name('teachersattendance');
    });

    Route::group(['middleware' => ['auth', 'can:manage marks']], function () {

        //-------------------------------------------------------------------------------------
        //                                 marks controller
        //-------------------------------------------------------------------------------------

        Route::get('/managemarks', 'AddstudentmakrsController_secs@index')->name('managemarks');
        Route::POST('/getclasssubject', 'MarksController@getClassSubject')->name('getclasssubject');
        Route::POST('/getsubjectmarks', 'MarksController@getsubjectmarks')->name('getsubjectmarks');
        Route::POST('/fetchusersbyclass', 'MarksController@getclassStudentsbyname')->name('fetchusersbyclass');
        Route::POST('/addstudentmarks', 'MarksController@addStudentMarks')->name('addstudentmarks');
        Route::get('/viewmarks', 'MarksController@viewmarks')->name('viewmarks');
        Route::POST('/viewusersbyclass', 'MarksController@viewusersbyclass')->name('viewusersbyclass');
        Route::POST('/deletestudent', 'MarksController@deletestudent');
        Route::POST('/process_position_pri', 'MarksController@processPriPosition')->name('process_position_pri');
        
    });

    Route::group(['middleware' => ['auth', 'can:add psychomotor']], function () { // 
        Route::get('/moto', 'MotoController_sec@index')->name('moto');
        Route::get('/motosettings', 'PysoController@motosettings')->name('motosettings');
        Route::POST('/fetchstudentdata', 'PysoController@fetchStudentData')->name('fetchstudentdata');
        Route::POST('/addmoto', ['uses' => 'PysoController@addmoto','roles' => ['Admin', 'Teacher']])->middleware('roles');
        Route::get('/addmotopage', ['uses' => 'PysoController@addmotopage','roles' => ['Admin', 'Teacher']])->middleware('roles');
        Route::POST('/addmotopri', 'PysoController@addMotoPri')->name('addmotopri');
        Route::get('/addmotomain/{id}', 'PysoController@addmotomain')->name('addmotomain');
        Route::POST('/addmoto_post/{id}', 'PysoController@addmotoPost')->name('addmoto_post');
    });






    Route::group(['middleware' => ['auth', 'can:settings']], function () { //

        Route::get('/grades', 'PagesController@grades')->name('grades');
        Route::POST('/submitgrades', 'PagesController@submitMark')->name('submitgrades');
        Route::POST('/deletegrade', 'PagesController@deleteGrade')->name('deletegrade');
        Route::POST('/addsession', 'PagesController@addsession')->name('addsession');
        Route::get('/allusers', 'AllUsersController@index')->name('allusers');
        Route::get('/setupschool', 'SchoolsetupSecController@setup_school_sec')->name('setupschool');
        Route::POST('/add_term', 'PagesController@addTerm')->name('add_term');
        Route::get('/payment_details', 'PaymentDetailsController@index')->name('payment_details');
        Route::post('/add_details', 'PaymentDetailsController@addDetails')->name('add_details');
    
    });
    

    Route::group(['middleware' => ['auth']], function () { //, 'can:student promotion'
        // promotion controller 
        Route::get('/promotion', 'PromotionController_sec@index')->name('promotion');
        Route::POST('/fetchstudentspromotion', 'PromotionController@fetchstudentsforpromotion')->name('fetchstudentspromotion');
        Route::POST('/promotemain', 'PromotionController@promotemain')->name('promotemain');
    });

    // Route::group(['middleware' => ['auth']], function () { //, 'can:student promotion'
    //     // promotion controller 
    //     Route::get('/index_fees_pri', 'AccountController@index_fees')->name('index_fees_pri');
    //     Route::get('/summary_pri', 'AccountController@summary')->name('summary_pri')->middleware(['auth', 'can:view account summary']); 

    //     Route::post('/add_category_pri', 'AccountController@addPaymentCategory')->name('add_category_pri');
    //     Route::post('/update_category_pri/{id}', 'AccountController@updatePaymentCategory')->name('update_category_pri');
    //     // Route::post('/add_category_amount', 'AccountController@addcategoryamount')->name('add_category_amount');
    //     // Route::post('/deletepaymentcategory/{id}', 'AccountController@deletePaymentCategory')->name('deletepaymentcategory'); 
    //     // Route::post('/updatepaymentamount/{id}', 'AccountController@updateCategoryAmount')->name('updatepaymentamount'); 
    // });

    
    Route::group(['middleware' => ['auth', 'can:student attendance']], function () {

        Route::get('/studentattendance', 'StudentController@studentAttendance')->name('studentattendance');
        Route::POST('/studentatt', 'StudentController@studentAtt')->name('studentatt');

    });
  
});





//add school
Route::get('/addschool', "DashboardController@addschool")->middleware('auth')->middleware('verified');
Route::POST('/shoolreg', 'DashboardController@store')->middleware('auth')->name('shoolreg');
Route::POST('/updatelogosig', 'DashboardController@updatelogosig')->middleware('auth')->name('updatelogosig');
Route::POST('/contactform', 'DashboardController@contactform')->name('contactform');


Route::group(['middleware' => ['auth', 'can:view edit class']], function () {

    Route::POST('/viewallclass', 'StudentController@getAllStudent');
    Route::get('/viewallstudents', 'StudentController@viewallstudents')->name('viewallstudents');

});







Route::POST('/viewatstudents', 'StudentController@viewatstudent');
Route::get('/exammark', ['uses' => 'StudentController@getExamsMarks','roles' => ['Student']])->middleware('roles');
Route::POST('/specificresult', ['uses' => 'StudentController@specificresult','roles' => ['Student']])->middleware('roles');



Route::POST('/regusermanuall', ['uses' => 'StudentController@regUserManuallyAdmin','roles' => ['Admin']])->middleware('roles');



//setup school

Route::POST('/updateSchoolInitial', 'PagesController@updateSchoolInitial')->middleware('auth');
Route::POST('/addclasslist', 'PagesController@addclasslist')->middleware('auth');
Route::POST('/addhouses', 'PagesController@addhouses')->middleware('auth');
Route::POST('/addsection', 'PagesController@addsection')->middleware('auth');
Route::POST('/addclub', 'PagesController@addclublist')->middleware('auth');
Route::POST('/fetchtoschoolsetup', 'PagesController@fetchtoschoolsetup')->middleware('auth');

Route::group(['middleware' => ['auth', 'can:manage staff']], function () {
    Route::get('/manage_saff_sec', 'PagesController@manageStaff');
    Route::get('/manage_saff_sec_alloc', 'PagesController@manageStaffDetails');
    Route::POST('/allocate_role_sec', 'PagesController@manageStaffRole');
    Route::POST('/allocate_role_sec_main', 'PagesController@allocateroletostaff');
});



//teachers Controller


Route::POST('/singleTeacher', ['uses' => 'TeachersController@getTeacher','roles' => ['Admin', 'Supervisor']])->middleware('roles');
Route::POST('/getallteacher', ['uses' => 'TeachersController@getAllTeachers','roles' => ['Admin', 'Supervisor']])->middleware('roles');
Route::POST('/getallteacherforview', ['uses' => 'TeachersController@getAllTeachersforview','roles' => ['Admin', 'Supervisor']])->middleware('roles');

Route::POST('/teachersatt', ['uses' => 'TeachersController@teachersAtt','roles' => ['Admin', 'Supervisor']])->middleware('roles');
Route::get('/viewallteachers', ['uses' => 'TeachersController@viewallTeachers','roles' => ['Admin', 'Supervisor']])->middleware('roles');
Route::POST('/viewatteachers', ['uses' => 'TeachersController@viewatTeachers','roles' => ['Admin', 'Supervisor']])->middleware('roles');



Route::POST('/editteachersdata', ['uses' => 'TeachersController@editteachersdata','roles' => ['Teacher']])->middleware('roles');

// Route::POST('/editteachersdata', ['uses' => 'TeachersController@editteachersdata','roles' => ['Admin']])->middleware('roles');



//leads to class list




Route::POST('/deletesubject', ['uses' => 'SubjectController@deleteSubject','roles' => ['Admin', 'Teacher']])->middleware('roles');



// Route::get('/home', 'HomeController@index')->name('home');
Route::POST('/uploadProfilePix', 'HomeController@uploadProfilePix')->middleware('auth');
Route::POST('/uploadProfilePixwithout', 'HomeController@uploadProfilePixwithout')->middleware('auth');

Route::get('/home', 'HomeController@index')->middleware('auth');





// super controller
Route::get('/superadmin', ['uses' => 'SuperController@index','roles' => ['SuperAdmin']])->middleware('roles');
Route::get('/order', ['uses' => 'SuperController@order','roles' => ['SuperAdmin']])->middleware('roles');
Route::get('/manageadmin', ['uses' => 'SuperController@manageAdmin','roles' => ['SuperAdmin']])->middleware('roles');
Route::POST('/add_roles_and_permission', ['uses' => 'SuperController@addRolesAndPermission','roles' => ['SuperAdmin']])->middleware('roles')->name('add_roles_and_permission');
Route::POST('/revoke_permission_role', ['uses' => 'SuperController@revokePermissionFromRole','roles' => ['SuperAdmin']])->middleware('roles')->name('revoke_permission_role');
Route::POST('/add_permission', ['uses' => 'SuperController@addMorePermissions','roles' => ['SuperAdmin']])->middleware('roles')->name('add_permission');
Route::POST('/add_roles', ['uses' => 'SuperController@addMoresRoles','roles' => ['SuperAdmin']])->middleware('roles')->name('add_roles');
Route::get('/rolesmanage', ['uses' => 'SuperController@rolesmanage','roles' => ['SuperAdmin']])->middleware('roles');
Route::POST('/activateschool', ['uses' => 'SuperController@activateschool','roles' => ['SuperAdmin']])->middleware('roles');
Route::get('/view_schools_details', ['uses' => 'SuperController@viewSchool','roles' => ['SuperAdmin']])->middleware('roles');
Route::get('/messages', 'SuperController@messages');
Route::POST('/alocateadmin', ['uses' => 'SuperController@addRoleAdmin','roles' => ['SuperAdmin']])->middleware('roles');
Route::POST('/alocatefinal', ['uses' => 'SuperController@asignRoles','roles' => ['SuperAdmin']])->middleware('roles');
Route::get('/technicalsupport', ['uses' => 'SuperController@technicalSupport','roles' => ['SuperAdmin']])->middleware('roles');
Route::get('/callrequest', ['uses' => 'SuperController@callRequest','roles' => ['SuperAdmin']])->middleware('roles');
Route::POST('/submitcallrequest', ['uses' => 'SuperController@submitCallRequestForm','roles' => ['SuperAdmin']])->middleware('roles');
Route::POST('/oncalladd', ['uses' => 'SuperController@onCallAdd','roles' => ['SuperAdmin']])->middleware('roles');
Route::POST('/deleteschool', ['uses' => 'SuperController@deleteSchool','roles' => ['SuperAdmin']])->middleware('roles');
Route::get('/view_school_order/{id}', ['uses' => 'SuperController@viewSchoolOrder','roles' => ['SuperAdmin']])->middleware('roles');
Route::get('/role_list', ['uses' => 'SuperController@roleList','roles' => ['SuperAdmin']])->middleware('roles')->name('role_list');


// result controller
Route::get('/result', ['uses' => 'ResultController@index','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
Route::POST('/querystudentforresult', ['uses' => 'ResultController@fetchresultdetailsPri','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
Route::POST('/processresult', ['uses' => 'ResultController@processresult','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');

//messages controller
Route::POST('/fetchmessage', ['uses' => 'MessagesController@fetchMessages','roles' => ['Admin', 'Teacher']])->middleware('roles');

// //profile controller
// Route::get('student_profile', ['uses' => 'ProfileController@showo','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
// // Route::get('/schow_profile/{$id}', ['uses' => 'ProfileController@show','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
Route::resource('show_student', 'ProfileController');

//------------------------------------------------------------------------------------------
//                                   secondary school route
//------------------------------------------------------------------------------------------


Route::group(['middleware' => ['auth', 'can:view edit class']], function () {

    Route::get('/classes', 'ClassesController@index','roles');
    Route::POST('/editclassname', 'ClassesController@editClassName');

});



Route::group(['prefix' => 'sec', 'middleware'=>'tenant'], function () {

    Route::group(['prefix' => 'setting', 'middleware' => ['auth', 'can:settings']], function () { //School setup route grades_sec

        Route::get('/setupschool_sec', 'SchoolsetupSecController@index')->name('setupschool_sec');
        Route::get('/fetchschooldata', 'SchoolsetupSecController@fetchSchoolDetailsSetUp')->name('setupschool_sec'); // Route::view('/stagetwo', 'voting.competition.step_two_main');
        Route::get('/setup_school_sec', 'SchoolsetupSecController@setup_school_sec')->name('setup_school_sec');
        Route::get('/grades_sec', 'SchoolsetupSecController@grades_sec')->name('grades_sec');
        Route::POST('/delete_grades_sec', 'SchoolsetupSecController@delete_grades_sec')->name('delete_grades_sec');
        Route::POST('/submitgrades_sec', 'PagesController@submitMark_sec')->name('submitgrades_sec');
        Route::POST('/addschoolinitials', 'SchoolsetupSecController@addSchoolInitials')->name('addschoolinitials');
        Route::POST('/update_exams_status', 'SchoolsetupSecController@updateExamsStatus')->name('update_exams_status');
        Route::POST('/update_ca1_status', 'SchoolsetupSecController@updateCa1Status')->name('update_ca1_status');
        Route::POST('/update_ca2_status', 'SchoolsetupSecController@updateCa2Status')->name('update_ca2_status');
        Route::POST('/update_ca3_status', 'SchoolsetupSecController@updateCa3Status')->name('update_ca3_status');
        Route::POST('/addschoolsession', 'SchoolsetupSecController@addSchoolSession')->name('addschoolsession');
        Route::POST('/addclasses_sec', 'SchoolsetupSecController@addClasses')->name('addclasses_sec');
        Route::POST('/addhouses_sec', 'SchoolsetupSecController@addhouses_sec')->name('addhouses_sec');
        Route::get('/classstatus/{id}', 'SchoolsetupSecController@disableClass')->name('classstatus');
        Route::POST('/addsection_sec', 'SchoolsetupSecController@addsection_sec')->name('addsection_sec');
        Route::POST('/addclub_sec', 'SchoolsetupSecController@addclub_sec')->name('addclub_sec');
        Route::get('/addschool_sec', 'DashboardController@addschool')->middleware('auth')->middleware('verified')->name('addschool_sec');
        Route::POST('/update_term', 'SchoolsetupSecController@update_term')->name('update_term');
        Route::POST('/update_caset', 'SchoolsetupSecController@updatecaSet')->name('update_caset');
        Route::POST('/setupassesment', 'SchoolsetupSecController@setUpAssesment')->name('setupassesment');//
        Route::POST('/subsetupassesment', 'SchoolsetupSecController@subAssessmentSetUp')->name('subsetupassesment');
        Route::GET('/setupcomment', 'SchoolsetupSecController@setupComment')->name('setupcomment');
        Route::POST('/setupnewcomment', 'SchoolsetupSecController@setupNewComment')->name('setupnewcomment');
        Route::POST('/deletecomment', 'SchoolsetupSecController@deletecomment')->name('deletecomment');

        Route::get('/allusers_sec', 'AllUsersController@index_sec')->name('allusers_sec');
        Route::get('/fetch_all_student', 'AllUsersController@fetch_all_student')->name('fetch_all_student');
        Route::POST('/allusers_sec_fetch', 'AllUsersController@fetchuser_sec')->name('allusers_sec_fetch');
    
    });


    Route::group(['prefix' => 'moto', 'middleware' => ['auth', 'can:psychomotor module']], function () {

        //phycomoto secondary
        Route::get('/student_moto', 'MotoController_sec@index','roles')->name('student_moto')->middleware('can:add psychomotor');
        Route::get('/setting_moto', 'MotoController_sec@settingsmoto')->name('setting_moto')->middleware('can:add moto settings');
        Route::post('/edit_setting_moto', 'MotoController_sec@editSettingsmoto')->name('edit_setting_moto')->middleware('can:add moto settings');
        Route::post('/add_setting_moto', 'MotoController_sec@addSettingsMoto')->name('add_setting_moto')->middleware('can:add moto settings');;
        Route::POST('/get_students_for_pyco', 'MotoController_sec@get_students_for_psyco')->name('get_students_for_pyco');
        Route::POST('/addmoto_main', 'MotoController_sec@addmotomain','roles')->name('addmoto_main');
        Route::get('/view_student/{id}', 'MotoController_sec@addFunNowMain')->name('view_student');
        Route::POST('/add_student_moto', 'MotoController_sec@addmotomain')->name('add_student_moto');

     }); 

     Route::group(['prefix' => 'result', 'middleware' => ['auth', 'can:result module']], function () {
        Route::get('/result_by_class', 'ResultController_sec@result_by_class',)->name('result_by_class');
        Route::post('/result_view_sec_pdf', 'ResultController_sec@loadHtmlDoc')->name('result_view_sec_pdf');
        Route::POST('/view_by_class', 'ResultController_sec@view_by_class')->name('view_by_class'); 
        Route::Post('/result_print_single_sec', 'ResultController_sec@viewSingleResult')->name('result_print_single_sec');
        Route::get('/result_by_class', 'ResultController_sec@result_by_class')->name('result_by_class');
        Route::get('/generate_result', 'ResultController_sec@generateResult')->name('generate_result');
        Route::get('/get_result_ready_section', 'ResultController_sec@get_result_ready_section');
        Route::post('/generate_result_main', 'ResultController_sec@generateResultMain')->name('generate_result_main');
        Route::get('/print_entrire_class_result', 'ResultController_sec@printEntrireClassResult')->name('print_entrire_class_result');
     });

     Route::group(['prefix' => 'teacher', 'middleware' => ['auth', 'role:Teacher']], function () { 
        Route::get('/teacher_sec_remark', 'TeachersController_sec@resultremark')->name('teacher_sec_remark');
        Route::post('/resultremarkpost', 'TeachersController_sec@resultremarkpost')->name('resultremarkpost');
        Route::get('/form_teacher/{classid}/{sectionid}', 'TeachersController_sec@formTeacherMain')->name('form_teacher')->middleware('can:form teacher');
        Route::get('/form_teacher_multiple', 'TeachersController_sec@form_teacher_multiple')->name('form_teacher_multiple')->middleware('can:form teacher');
        Route::get('/view_student_form/{classid}/{sectionid}', 'TeachersController_sec@viewClassFormMaster')->name('view_student_form')->middleware('can:form teacher');
        Route::post('/update_student_form', 'TeachersController_sec@updateStudentData')->name('update_student_form')->middleware('can:form teacher');
        Route::post('/form_teacher_result_confirm', 'TeachersController_sec@confirmSubjectRecordEntered')->name('form_teacher_result_confirm'); 
        Route::get('/get_teacher_subject', 'TeachersController_sec@fetchTeachersSubject')->name('get_teacher_subject');
        Route::post('/add_student_comment', 'TeachersController_sec@addStudentComment')->name('add_student_comment')->middleware('can:form teacher');
        Route::post('/remove_elective', 'TeachersController_sec@remove_elective')->name('remove_elective')->middleware('can:form teacher');
     }); 



    //  --------------------------------------------------sec--------------------------------------------

    Route::group(['middleware' => ['auth', 'can:accommodation']], function () {
        //domitory management route
        Route::get('/dom_index', 'DometoryController@index')->name('dom_index');
        Route::POST('/add_hostel', 'DometoryController@addHostel')->name('add_hostel');
        Route::get('/add_rooms/{id}', 'DometoryController@show')->name('add_rooms');
        Route::POST('/add_room', 'DometoryController@addHostels')->name('add_room');
        Route::POST('/add_student_hostel', 'DometoryController@addStudentToHostel')->name('add_student_hostel');
        Route::POST('/fetch_students_in_room', 'DometoryController@fetchAllStudentInARoom')->name('fetch_students_in_room');
        Route::POST('/delete_roommate', 'DometoryController@deleteRoomMate')->name('delete_roommate');
        Route::POST('/delete_room', 'DometoryController@deleteRoom')->name('delete_room');
        Route::POST('/delete_hostel', 'DometoryController@deleteHostel')->name('delete_hostel');
    });
});



Route::group(['prefix' => 'main', 'middleware' => 'roles'], function () { 
    Route::get('/mail_main', ['uses' => 'MailController@index','roles' => ['Bursar', 'Admin']])->name('mail_main');
    Route::get('/mail_compose', ['uses' => 'MailController@compose','roles' => ['Bursar', 'Admin']])->name('mail_compose');
 });

Route::group(['prefix'=>'pay', 'middleware' => 'roles'], function(){ 
    
    
    Route::post('/make_payment', ['uses' => 'PaymentDetailsController@makePayment','roles' => ['Student']])->name('make_payment');
    Route::get('/payment_history', ['uses' => 'StudentController_sec@paymentHistory','roles' => ['Student']])->name('payment_history');
});



// subject route


Route::group(['middleware' => ['auth', 'can:assign subjects']], function () {
    Route::get('/subject_sec_index', 'SubjectController_sec@index');
    Route::get('/addsubject_sec', 'SubjectController_sec@addsubject_sec_page'); 
    Route::get('/get_all_subjects', 'SubjectController_sec@addsubject_sec');
    Route::POST('/subjectprocess_sec', 'SubjectController_sec@store');
    Route::POST('/add_subject_score_update', 'SubjectController_sec@addSubjectScore');
    Route::POST('/deletesubject_sec', 'SubjectController_sec@deleteSubject');
    Route::POST('/editsubject_sec', 'SubjectController_sec@editSubject_sec');
    Route::POST('/add_number_of_ellectives', 'SubjectController_sec@addNumberOfEllectives');
    Route::POST('/asign_subject_to_class', 'SubjectController_sec@asignSubjectToClass');
    Route::get('/get_subject_to_class/{subjectid}', 'SubjectController_sec@getClassForSubject');
    Route::get('/delete_subject_to_class/{subjectid}', 'SubjectController_sec@deleteClassForSubject');
    Route::get('/get_all_student_with_elective', 'SubjectController_sec@getStudentsWithElective');
});



// add student route 

Route::group(['prefix'=>'pay', 'middleware' => ['auth', 'role:Student']], function(){ 
    Route::get('/student_fees', 'StudentController_sec@feePayment')->name('student_fees');
    Route::get('/manage_subject_student', 'StudentController_sec@manage_subject_student')->name('manage_subject_student');
    Route::post('/add_electives', 'StudentController_sec@electiveadd')->name('add_electives');
 });

 Route::group(['middleware' => ['auth', 'can:add students']], function () {
    Route::get('/student_sec_index', 'StudentController_sec@index');
    Route::post('/student_sec_confirm', 'StudentController_sec@confirmStudentRegNumber');
    Route::post('/student_sec_add', 'StudentController_sec@store');
    Route::get('/viewstudentbyclass', 'StudentController_sec@viewStudentbyClass');
    Route::POST('/viewstudentsingleclass', 'StudentController_sec@viewStudentSingleClass');
    Route::POST('/add_astudent_modal', 'StudentController_sec@addStudentModal');
    Route::get('/reasign_class', 'StudentController_sec@reasign_class')->name('reasign_class');
    Route::post('/confirm_admission_no', 'StudentController_sec@confirmAdmissionNumber');
    Route::post('/reasign_confirm', 'StudentController_sec@reasignConfirm');
});



// add teachers
Route::group(['middleware' => ['auth', 'can:assign form teacher']], function () { //
    Route::get('/teacher_sec_index', 'TeachersController_sec@index');
    Route::get('/form_teacher_sec_index', 'TeachersController_sec@form_teacher_sec_index');
    Route::get('/get_teacher_page_details', 'TeachersController_sec@fetchDataForAddTeachersPage');
    Route::post('/teacher_sec_confirm', 'TeachersController_sec@confirmTeacherRegNumber');
    Route::post('/teachers_sec_confirm', 'TeachersController_sec@confirmTeacherRegNumber2');
    Route::post('/allocateformmaster', 'TeachersController_sec@allocateFormMaster');
    Route::post('/unallocateformmaster', 'TeachersController_sec@unallocateformmaster');
    Route::post('/allocatesubjectteacher', 'TeachersController_sec@allocateSubjectTeacher');
    Route::post('/un_asign_a_subject', 'TeachersController_sec@unAsignASubject');
    Route::get('/fetch_teacher_subjects/{userid}', 'TeachersController_sec@fetchTeacherSubject');
    
});

Route::group(['middleware' => ['auth', 'role:Teacher']], function () {

    Route::get('/add_student_electives', 'TeachersController_sec@addStudentElectives')->name('add_student_electives');
    Route::get('/fetch_form_teacher_class', 'TeachersController_sec@fetchFormTeacherClassSection');
    Route::post('/fetch_student_list', 'TeachersController_sec@getStudentInClass'); //getStudentsWithElective
    Route::post('/asign_subject_main', 'TeachersController_sec@asignSubjectMain'); 
    Route::get('/get_teacher_page_details_teachers', 'TeachersController_sec@fetchDataForAddTeachersPage');
    
});

Route::group(['middleware' => ['auth', 'role:Teacher']], function () {
    Route::get('/editteacherprofile', 'TeachersController_sec@teacherEditProfile');
    Route::post('/confirm_edited', 'TeachersController_sec@addEdited');
});


Route::group(['middleware' => ['auth', 'can:elearning']], function () { 
    //elearning 
    Route::get('/elearning', 'ElearningController_sec@index')->name('elearning');
    Route::get('/dowloads_videos', 'ElearningController_sec@downloadsVideos')->name('dowloads_videos');
    Route::post('/add_videos', 'ElearningController_sec@addVideos')->name('add_videos');
    Route::get('/all_videos', 'ElearningController_sec@ftechAllVieosStudent')->name('all_videos');
    Route::get('/all_pdfs', 'ElearningController_sec@ftechAllpdfStudent')->name('all_pdfs');

    //pdf upload
    Route::get('/dowloads_pdf', 'PdfController@index')->name('dowloads_pdf');
    Route::POST('/file-upload', 'PdfController@fileUploadPost')->name('file-upload');

    //main routes
    Route::post('/add_assignment', 'ElearningController_sec@submitAssignment')->middleware('roles');
    Route::post('/deletealignment', 'ElearningController_sec@deleteAssignment')->middleware('roles');
});







// attendance routes
Route::group(['middleware' => ['auth', 'can:student attendance']], function () {
    Route::get('/student_attendance_sec', 'StudentAttendance@index');
    Route::POST('/fetchalluserbyclass_sec', 'StudentAttendance@fetchalluserbyclass_sec');
    Route::POST('/student_att_main', 'StudentAttendance@studentattendanceMain');
    Route::POST('/view_all_at_sec', 'StudentAttendance@check_att_sec');
    Route::get('/view_all_at_route_sec', 'StudentAttendance@check_att_sec_route');
});



//add students marks secondary 

Route::group(['middleware' => ['auth', 'can:manage marks']], function () {

    Route::get('/student_add_marks', 'AddstudentmakrsController_secs@index');
    Route::get('get_school_basic_details', 'AddstudentmakrsController_secs@getSchoolBasicDetails');
    Route::get('/fetch_students_marks/{id}/{sectionid}', 'AddstudentmakrsController_secs@fetchstudentssubject');
    Route::get('fetch_student_sections/{id}', 'AddstudentmakrsController_secs@fetchStudentSections');
    Route::get('fetchsubassessment/{id}/{studentid}', 'AddstudentmakrsController_secs@fetchsubassessment');
    Route::POST('/fetch_subject_details', 'AddstudentmakrsController_secs@fetchsubjectdetails');
    Route::POST('/fetch_subject_student_details', 'AddstudentmakrsController_secs@getallstudentsandmarks');
    Route::POST('/add_marks_main', 'AddstudentmakrsController_secs@addmarksmiain')->name('add_marks_main');
    Route::POST('/marks_process_main', 'AddstudentmakrsController_secs@processPosition');
    Route::POST('/add_student_scores', 'AddstudentmakrsController_secs@addStudentRecord');
    Route::POST('/get_student_scores', 'AddstudentmakrsController_secs@getScoreRecord');
});




//teachers attendance
Route::group(['middleware' => ['auth', 'can:take teachers attendance']], function () {
    Route::get('/teacher_add_attendance', 'AttendanceTeachers@index');
    Route::POST('/fetch_teacher_add_attendance', 'AttendanceTeachers@fetchteachers');
    Route::POST('/teachers_att_main', 'AttendanceTeachers@teachersAttendance');
});


//secondary promotion route
Route::group(['middleware' => ['auth', 'can:student promotion']], function () {
    Route::get('/promotion_student_sec', 'PromotionController_sec@index');
    Route::POST('/promotion_student_ftech_sec', 'PromotionController_sec@fetchstudentforpromotion');
    Route::get('/get_school_details', 'PromotionController_sec@getSchoolDetails');
    Route::post('/update_promotion_average', 'PromotionController_sec@updatePromotionAverage');
    Route::POST('/promotion_main_query', 'PromotionController_sec@promotionmain');
    Route::POST('/promote_jss_ss', 'PromotionController_sec@promotejss3toss1');
});


Route::group(['middleware' => ['auth', 'can:access library']], function () { // library module
    Route::get('/school_library', 'LibraryController@index')->name('school_library');
    Route::get('/all_books', 'LibraryController@ftechAllbooks')->name('all_books');
});


Route::group(['middleware' => ['auth', 'role:Librarian']], function () {

    Route::POST('/book-upload', 'LibraryController@addbooks')->name('book-upload');
    Route::POST('/category_library', 'LibraryController@addcategory')->name('category_library');
    Route::get('/view_all_books', 'LibraryController@viewallbooks')->name('view_all_books');
    Route::POST('/delete_book', 'LibraryController@deletebook')->name('delete_book');
    Route::get('/trackbook', 'LibraryController@trackbook')->name('trackbook');
    Route::POST('/fetch_book_details', 'LibraryController@fetchbokdetailisbn')->name('fetch_book_details');
    Route::POST('/fetch_student_book', 'LibraryController@getstudentforbook')->name('fetch_student_book');
    Route::POST('/add_book_borrow_data', 'LibraryController@addBookBorrowData')->name('add_book_borrow_data');
    Route::get('/all_borrowed_books', 'LibraryController@allborrowedbook')->name('all_borrowed_books');
    Route::POST('/delete_borrow_book', 'LibraryController@deletebookborrowrecord')->name('delete_borrow_book');
    Route::POST('/return_borrow_book', 'LibraryController@approvereturnbook')->name('return_borrow_book');

});

// secondary school result computation

    Route::get('/result_view_sec', ['uses' => 'ResultController_sec@index','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
    
    Route::Post('/result_print_sec', ['uses' => 'ResultController_sec@viewResult','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
    Route::Post('/result_print_update_sec', ['uses' => 'ResultController_sec@fetchresultdetails','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');


Route::Post('/cookie/set','CookieController@setCookie');
Route::get('/cookie/get','CookieController@getCookie');


//feedback route
Route::get('/feed_back', ['uses'=>'DashboardController@feedBack', 'roles'=> ['Admin', 'Teacher', 'Student', 'Librarian', 'Supervisor']])->middleware('roles');
Route::POST('/add_feedback', ['uses'=>'DashboardController@addFeedBack', 'roles'=> ['Admin', 'Teacher', 'Student', 'Librarian', 'Supervisor']])->middleware('roles');
Route::get('/add_feedback_admin', ['uses'=>'DashboardController@feedBackAdmin', 'roles'=> ['SuperAdmin']])->middleware('roles');

// events uploaded
Route::POST('/add_event', ['uses'=>'DashboardController@addEventAll', 'roles'=> ['Admin']])->middleware('roles');

//subscription routes

Route::get('/sub_index', ['uses' => 'Subscription_sec@index','roles' => ['Admin']])->middleware('roles');
Route::POST('/pay_sub', ['uses' => 'Subscription_sec@pay_sub','roles' => ['Admin']])->middleware('roles');
Route::POST('/pay_sub_transfer', ['uses' => 'Subscription_sec@pay_sub_transfer','roles' => ['Admin']])->middleware('roles');

//payment routes
Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay');
Route::post('/payment/callback', 'PaymentController@handleGatewayCallback');
// Route::webHooks();
Route::post('webhook', 'WebhookController@handle');

//profile controller
Route::get('myprofile', 'MyProfileController@index')->name('myprofile');
Route::post('updatepassword', 'MyProfileController@updatePassword')->name('updatepassword');
Route::post('updateprofile', 'MyProfileController@updateProfile')->name('updateprofile');



Route::group(['prefix' => 'gen', 'middleware' => ['auth']], function () {

    Route::group(['prefix' => 'account', 'middleware' => ['auth', 'role_or_permission:Bursar|Serve as temporary Bursar' ]], function () {
        Route::get('/account_index', 'AccountController@index')->name('account_index');
        Route::get('/account_dash', 'AccountController@account_dash')->name('account_dash');
        Route::post('/add_category', 'AccountController@addPaymentCategory')->name('add_category');
        Route::post('/update_category/{id}', 'AccountController@updatePaymentCategory')->name('update_category');
        Route::post('/add_category_amount', 'AccountController@addcategoryamount')->name('add_category_amount');
        Route::post('/deletepaymentcategory/{id}', 'AccountController@deletePaymentCategory')->name('deletepaymentcategory'); 
        Route::post('/updatepaymentamount/{id}', 'AccountController@updateCategoryAmount')->name('updatepaymentamount'); 
    });


         Route::get('/index_fees', 'AccountController@index_fees')->name('index_fees');
         Route::get('/summary', 'AccountController@summary')->name('summary')->middleware(['auth', 'can:view account summary']); 
         Route::get('/invoices', 'AccountController@invoices')->name('invoices')->middleware(['auth', 'can:invoice management']); 
         Route::get('/viewinvoices/{id}', 'AccountController@viewinvoices')->name('viewinvoices')->middleware(['auth', 'can:invoice management']); 
         Route::get('/printinvoice/{id}', 'AccountController@printinvoice')->name('printinvoice')->middleware(['auth', 'can:invoice management']); 
         Route::get('/invoicepaymenthis/{id}', 'AccountController@invoicePaymentHistory')->name('invoicepaymenthis')->middleware(['auth', 'can:invoice management']); 
         Route::get('/unpaid_fees', 'AccountController@unpaid_fees')->name('unpaid_fees')->middleware(['auth', 'can:invoice management']); 
         Route::get('/order_request', 'AccountController@orderRequest')->name('order_request')->middleware(['auth', 'can:can send or receive request']);

         Route::get('/student_dicount', 'AccountController@student_dicount')->name('student_dicount')->middleware(['auth', 'can:can send or receive request']);

         Route::post('/request_response', 'AccountController@request_response')->name('request_response')->middleware(['auth', 'can:can send or receive request']); 
         Route::get('/feecollection', 'AccountController@feecollection')->name('feecollection')->middleware(['auth', 'can:fee collection']);
         Route::post('/fetchstudentdataforfee', 'AccountController@fetchstudentdataforfee')->name('fetchstudentdataforfee'); 
         Route::post('/confirm_money_received_fees', 'AccountController@confirmMoneyReceived')->name('confirm_money_received_fees');
         Route::post('/sendmoneyrequest', 'AccountController@sendMoneyRequest')->name('sendmoneyrequest');
         Route::post('/notify-item-finish', 'AccountController@item_finish_notification')->name('notify-item-finish');
         Route::get('/inventory', 'AccountController@inventory')->name('inventory')->middleware(['auth', 'can:access inventory']);
         Route::post('/inventory_add_item', 'AccountController@inventory_add_item')->name('inventory_add_item');
         Route::post('/add_invoice_order/{id}', 'AccountController@addInvoiceOrder')->name('add_invoice_order'); 
         Route::post('/update_invoice_items/{id}', 'AccountController@update_invoice_items')->name('update_invoice_items');
         Route::post('/order_invoice_checkout', 'AccountController@order_invoice_checkout')->name('order_invoice_checkout');
         Route::get('/get_student_list_fees/{classid}/{sectionid}', 'AccountController@getStudentListFees')->name('get_student_list_fees');
         Route::post('/fees_part_payment', 'AccountController@feesPartPayment')->name('fees_part_payment');
         Route::post('/add_student_discount', 'AccountController@addStudentDiscount')->name('add_student_discount');
         Route::get('/get_all_student_discount', 'AccountController@get_all_student_discount')->name('get_all_student_discount');
         Route::get('/discontinue_discount/{id}', 'AccountController@discontinue_discount')->name('discontinue_discount');

         Route::group(['middleware' => ['can:add event']], function () { // library module
            Route::post('/post_event', 'CalenderController@postAnEvent')->name('post_event');
        });
         //calender routes
         Route::get('/calender_index', 'CalenderController@index')->name('calender_index');
         Route::get('/get_all_posts', 'CalenderController@getAllEvents')->name('get_all_posts');


        // manage staff
         Route::group(['middleware' => ['auth']], function () { //, 'can:manage staff'
            Route::get('/addstaff', 'PagesController@manageStaff')->name('addstaff');
            Route::get('/viewstaff/{id}', 'PagesController@viewstaff')->name('viewstaff');
            Route::POST('/addstaffdata', 'TeachersController@addstaffdata')->name('addstaffdata');
            Route::POST('/addstaffrecord', 'TeachersController@addroles')->name('addstaffrecord');
        });

        Route::group(['middleware' => ['auth', 'role:Student']], function () { // assignment module
            Route::get('/assignment_student', 'AssignmentController@index')->name('assignment_student');
            Route::post('/assignment_submit', 'AssignmentController@submitAssignmentStudent')->name('assignment_submit');
            Route::get('/view_submission_student/{subjectid}/{classid}/{sectionid}/{submissionid}', 'AssignmentController@viewsubmissions')->name('view_submission_student');
        });

        Route::group(['middleware' => ['auth', 'role:Teacher']], function () { // assignment module
            Route::get('/assignment_teachers', 'AssignmentController@assignment_teachers')->name('assignment_teachers');
            Route::get('/assignment_view/{id}/{classid}/{sectionid}', 'AssignmentController@assignment_view')->name('assignment_view');
            Route::get('/assignment_remark', 'AssignmentController@assignment_remark')->name('assignment_remark');
            Route::get('/assignment_subject', 'AssignmentController@assignment_subject')->name('assignment_subject');
            Route::post('/post_assignment', 'AssignmentController@post_assignment')->name('post_assignment');
            Route::delete('/deleteassignment/{id}', 'AssignmentController@delete')->name('deleteassignment');
            Route::get('/view_submission/{subjectid}/{classid}/{sectionid}', 'AssignmentController@viewsubmissions')->name('view_submission');
            Route::post('/remark_assignment', 'AssignmentController@remarkAssignment')->name('remark_assignment');
        });

});

Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', 'AccountController@feesPartPayment')->name('fees_part_payment');
});

});
