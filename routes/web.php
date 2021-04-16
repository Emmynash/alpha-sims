<?php

use Illuminate\Support\Facades\Route;


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
Route::get('/grades', ['uses' => 'PagesController@grades','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/submitgrades', ['uses' => 'PagesController@submitMark','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/deletegrade', ['uses' => 'PagesController@deleteGrade','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/addsession', ['uses' => 'PagesController@addsession','roles' => ['Admin']])->middleware('roles');



//add school
Route::get('/addschool', "DashboardController@addschool")->middleware('auth')->middleware('verified');
Route::POST('/shoolreg', 'DashboardController@store')->name('shoolreg');
Route::POST('/updatelogosig', 'DashboardController@updatelogosig')->name('updatelogosig');
Route::POST('/contactform', 'DashboardController@contactform')->name('contactform');

//student
Route::get('/addstudent', ['uses' => 'StudentController@index','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/confirmReg', 'StudentController@confirmReg')->middleware('auth');
Route::POST('/confirmRegNew', 'StudentController@confirmRegNew')->middleware('auth');

Route::get('/addstudent', ['uses' => 'StudentController@index','roles' => ['Admin', 'Teacher']])->middleware('roles');

Route::get('/viewstudent', 'StudentController@viewlist')->middleware('auth');
Route::POST('/studentreg', 'StudentController@store')->middleware('auth');
Route::POST('/viewallclass', 'StudentController@getAllStudent')->middleware('auth');
Route::get('/studentattendance', ['uses' => 'StudentController@studentAttendance','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/studentatt', ['uses' => 'StudentController@studentAtt','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::get('/viewallstudents', ['uses' => 'StudentController@viewallstudents','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
Route::POST('/viewatstudents', ['uses' => 'StudentController@viewatstudent','roles' => ['Admin', 'Teacher', "Student"]])->middleware('roles');
Route::get('/exammark', ['uses' => 'StudentController@getExamsMarks','roles' => ['Student']])->middleware('roles');
Route::POST('/specificresult', ['uses' => 'StudentController@specificresult','roles' => ['Student']])->middleware('roles');
Route::POST('/verifyreg', ['uses' => 'StudentController@verifyuserregistration','roles' => ['Admin']])->middleware('roles');
Route::POST('/regusermanuall', ['uses' => 'StudentController@regUserManuallyAdmin','roles' => ['Admin']])->middleware('roles');



//setup school
Route::get('/setupschool', 'PagesController@setUpSchool')->middleware('auth');
Route::POST('/updateSchoolInitial', 'PagesController@updateSchoolInitial')->middleware('auth');
Route::POST('/addclasslist', 'PagesController@addclasslist')->middleware('auth');
Route::POST('/addhouses', 'PagesController@addhouses')->middleware('auth');
Route::POST('/addsection', 'PagesController@addsection')->middleware('auth');
Route::POST('/addclub', 'PagesController@addclublist')->middleware('auth');
Route::POST('/fetchtoschoolsetup', 'PagesController@fetchtoschoolsetup')->middleware('auth');

Route::get('/manage_saff_sec', ['uses' => 'PagesController@manageStaff','roles' => ['Admin']])->middleware('roles');
Route::POST('/allocate_role_sec', ['uses' => 'PagesController@manageStaffRole','roles' => ['Admin']])->middleware('roles');
Route::POST('/allocate_role_sec_main', ['uses' => 'PagesController@allocateroletostaff','roles' => ['Admin']])->middleware('roles');

//teachers Controller
Route::get('/addteacher', 'TeachersController@index')->middleware('auth');
Route::POST('addteachersverify', 'TeachersController@verifyTeacher')->middleware('auth');
Route::POST('addteachermain', 'TeachersController@store')->middleware('auth');
Route::get('/viewteachers', ['uses' => 'TeachersController@viewteachers','roles' => ['Admin', 'Supervisor']])->middleware('roles');
Route::POST('/singleTeacher', ['uses' => 'TeachersController@getTeacher','roles' => ['Admin', 'Supervisor']])->middleware('roles');
Route::POST('/getallteacher', ['uses' => 'TeachersController@getAllTeachers','roles' => ['Admin', 'Supervisor']])->middleware('roles');
Route::POST('/getallteacherforview', ['uses' => 'TeachersController@getAllTeachersforview','roles' => ['Admin', 'Supervisor']])->middleware('roles');
Route::get('/teachersattendance', ['uses' => 'TeachersController@teachersAttendance','roles' => ['Admin', 'Supervisor']])->middleware('roles');
Route::POST('/teachersatt', ['uses' => 'TeachersController@teachersAtt','roles' => ['Admin', 'Supervisor']])->middleware('roles');
Route::get('/viewallteachers', ['uses' => 'TeachersController@viewallTeachers','roles' => ['Admin', 'Supervisor']])->middleware('roles');
Route::POST('/viewatteachers', ['uses' => 'TeachersController@viewatTeachers','roles' => ['Admin', 'Supervisor']])->middleware('roles');
Route::get('/addstaff', ['uses' => 'TeachersController@addStaff','roles' => ['Admin']])->middleware('roles');
Route::POST('/addstaffdata', ['uses' => 'TeachersController@addstaffdata','roles' => ['Admin']])->middleware('roles');
Route::POST('/addstaffrecord', ['uses' => 'TeachersController@addroles','roles' => ['Admin']])->middleware('roles');
Route::get('/editprofileteacher', ['uses' => 'TeachersController@editprofileteacher','roles' => ['Teacher']])->middleware('roles');
Route::POST('/editteachersdata', ['uses' => 'TeachersController@editteachersdata','roles' => ['Teacher']])->middleware('roles');

// Route::POST('/editteachersdata', ['uses' => 'TeachersController@editteachersdata','roles' => ['Admin']])->middleware('roles');

//subject controller 
Route::get('/addsubject', 'SubjectController@index')->middleware('auth');
Route::Post('/addsubjectpost', 'SubjectController@store')->middleware('auth');
Route::get('/subjectlist', 'SubjectController@subjectList')->middleware('auth');
Route::POST('/updatesubject', ['uses' => 'SubjectController@updateSubject','roles' => ['Admin']])->middleware('roles');

//leads to class list
Route::get('/viewclasslist', 'SubjectController@viewClass')->middleware('auth');
Route::POST('/deletesubject', ['uses' => 'SubjectController@deleteSubject','roles' => ['Admin', 'Teacher']])->middleware('roles');

Auth::routes(['verify' => true]);

// Route::get('/home', 'HomeController@index')->name('home');
Route::POST('/uploadProfilePix', 'HomeController@uploadProfilePix')->middleware('auth');
Route::POST('/uploadProfilePixwithout', 'HomeController@uploadProfilePixwithout')->middleware('auth');

Route::get('/home', 'HomeController@index')->middleware('auth');

//-------------------------------------------------------------------------------------
//                                 marks controller
//-------------------------------------------------------------------------------------

Route::get('/managemarks', ['uses' => 'MarksController@index','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/getclasssubject', ['uses' => 'MarksController@getClassSubject','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/getsubjectmarks', ['uses' => 'MarksController@getsubjectmarks','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/fetchusersbyclass', ['uses' => 'MarksController@getclassStudentsbyname','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/addstudentmarks', ['uses' => 'MarksController@addStudentMarks','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::get('/viewmarks', ['uses' => 'MarksController@viewmarks','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/viewusersbyclass', ['uses' => 'MarksController@viewusersbyclass','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/deletestudent', ['uses' => 'MarksController@deletestudent','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/process_position_pri', ['uses' => 'MarksController@processPriPosition','roles' => ['Admin', 'Teacher']])->middleware('roles');

Route::get('/allusers', ['uses' => 'AllUsersController@index','roles' => ['Admin', 'Teacher']])->middleware('roles');


Route::get('/moto', ['uses' => 'PysoController@index','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/fetchstudentdata', ['uses' => 'PysoController@fetchStudentData','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/addmoto', ['uses' => 'PysoController@addmoto','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::get('/addmotopage', ['uses' => 'PysoController@addmotopage','roles' => ['Admin', 'Teacher']])->middleware('roles');

// super controller
Route::get('/superadmin', ['uses' => 'SuperController@index','roles' => ['SuperAdmin']])->middleware('roles');
Route::get('/order', ['uses' => 'SuperController@order','roles' => ['SuperAdmin']])->middleware('roles');
Route::get('/manageadmin', ['uses' => 'SuperController@manageAdmin','roles' => ['SuperAdmin']])->middleware('roles');
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


// result controller
Route::get('/result', ['uses' => 'ResultController@index','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
Route::POST('/querystudentforresult', ['uses' => 'ResultController@fetchresultdetailsPri','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
Route::POST('/processresult', ['uses' => 'ResultController@processresult','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');

// promotion controller 
Route::get('/promotion', ['uses' => 'PromotionController@index','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/fetchstudentspromotion', ['uses' => 'PromotionController@fetchstudentsforpromotion','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/promotemain', ['uses' => 'PromotionController@promotemain','roles' => ['Admin', 'Teacher']])->middleware('roles');

//messages controller
Route::POST('/fetchmessage', ['uses' => 'MessagesController@fetchMessages','roles' => ['Admin', 'Teacher']])->middleware('roles');

// //profile controller
// Route::get('student_profile', ['uses' => 'ProfileController@showo','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
// // Route::get('/schow_profile/{$id}', ['uses' => 'ProfileController@show','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
Route::resource('show_student', 'ProfileController');

//------------------------------------------------------------------------------------------
//                                   secondary school route
//------------------------------------------------------------------------------------------

Route::get('/classes', ['uses' => 'ClassesController@index','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/editclassname', ['uses' => 'ClassesController@editClassName','roles' => ['Admin']])->middleware('roles');


Route::group(['prefix' => 'sec'], function () {

    Route::group(['prefix' => 'setting', 'middleware' => 'roles'], function () { //School setup route grades_sec

        Route::get('/setupschool_sec', ['uses' => 'SchoolsetupSecController@index','roles' => ['Admin']])->name('setupschool_sec');
        Route::get('/grades_sec', ['uses' => 'SchoolsetupSecController@grades_sec','roles' => ['Admin', 'Teacher']])->name('grades_sec');
        Route::POST('/submitgrades_sec', ['uses' => 'PagesController@submitMark_sec','roles' => ['Admin', 'Teacher']])->name('submitgrades_sec');
        Route::POST('/addschoolinitials', ['uses' => 'SchoolsetupSecController@addSchoolInitials','roles' => ['Admin']])->name('addschoolinitials');
        Route::POST('/addschoolsession', ['uses' => 'SchoolsetupSecController@addSchoolSession','roles' => ['Admin']])->name('addschoolsession');
        Route::POST('/addclasses_sec', ['uses' => 'SchoolsetupSecController@addClasses','roles' => ['Admin']])->name('addclasses_sec');
        Route::POST('/addhouses_sec', ['uses' => 'SchoolsetupSecController@addhouses_sec','roles' => ['Admin']])->name('addhouses_sec');
        Route::POST('/addsection_sec', ['uses' => 'SchoolsetupSecController@addsection_sec','roles' => ['Admin']])->name('addsection_sec');
        Route::POST('/addclub_sec', ['uses' => 'SchoolsetupSecController@addclub_sec','roles' => ['Admin']])->name('addclub_sec');
        Route::get('/addschool_sec', ['uses' => 'DashboardController@addschool','roles' => ['Admin']])->middleware('auth')->middleware('verified')->name('addschool_sec');
        Route::POST('/update_term', ['uses' => 'SchoolsetupSecController@update_term','roles' => ['Admin']])->name('update_term');

        Route::get('/allusers_sec', ['uses' => 'AllUsersController@index_sec','roles' => ['Admin']])->name('allusers_sec');
        Route::POST('/allusers_sec_fetch', ['uses' => 'AllUsersController@fetchuser_sec','roles' => ['Admin']])->name('allusers_sec_fetch');
    
    });


    Route::group(['prefix' => 'moto', 'middleware' => 'roles'], function () {

        //phycomoto secondary
        Route::get('/student_moto', ['uses' => 'MotoController_sec@index','roles' => ['Admin', 'Teacher']])->name('student_moto');
        Route::get('/setting_moto', ['uses' => 'MotoController_sec@settingsmoto','roles' => ['Admin', 'Teacher']])->name('setting_moto');
        Route::post('/add_setting_moto', ['uses' => 'MotoController_sec@addSettingsMoto','roles' => ['Admin', 'Teacher']])->name('add_setting_moto');
        Route::POST('/get_students_for_pyco', ['uses' => 'MotoController_sec@get_students_for_psyco','roles' => ['Admin', 'Teacher']])->name('get_students_for_pyco');
        Route::POST('/addmoto_main', ['uses' => 'MotoController_sec@addmotomain','roles' => ['Admin', 'Teacher']])->name('addmoto_main');
        Route::get('/view_student/{id}', ['uses' => 'MotoController_sec@addFunNowMain','roles' => ['Admin', 'Teacher']])->name('view_student');
        Route::POST('/add_student_moto/{id}', ['uses' => 'MotoController_sec@addmotomain','roles' => ['Admin', 'Teacher']])->name('add_student_moto');

     }); 

     Route::group(['prefix' => 'result', 'middleware' => 'roles'], function () {
        Route::get('/result_by_class', ['uses' => 'ResultController_sec@result_by_class','roles' => ['Admin', 'Teacher', 'Student']])->name('result_by_class');
        Route::POST('/view_by_class', ['uses' => 'ResultController_sec@view_by_class','roles' => ['Admin', 'Teacher', 'Student']])->name('view_by_class'); 
        Route::Post('/result_print_single_sec', ['uses' => 'ResultController_sec@viewSingleResult','roles' => ['Admin', 'Teacher', 'Student']])->name('result_print_single_sec');
        Route::get('/result_by_class', ['uses' => 'ResultController_sec@result_by_class','roles' => ['Admin', 'Teacher', 'Student']])->name('result_by_class');
        Route::get('/generate_result', ['uses' => 'ResultController_sec@generateResult','roles' => ['Admin']])->name('generate_result');
        Route::post('/generate_result_main', ['uses' => 'ResultController_sec@generateResultMain','roles' => ['Admin']])->name('generate_result_main');
     });

     Route::group(['prefix' => 'teacher', 'middleware' => 'roles'], function () { 
        Route::get('/teacher_sec_remark', ['uses' => 'TeachersController_sec@resultremark','roles' => ['Admin', 'Teacher']])->name('teacher_sec_remark');
        Route::post('/resultremarkpost', ['uses' => 'TeachersController_sec@resultremarkpost','roles' => ['Admin', 'Teacher']])->name('resultremarkpost');
        Route::get('/form_teacher', ['uses' => 'TeachersController_sec@formTeacherMain','roles' => ['Admin', 'Teacher']])->name('form_teacher');
        Route::post('/form_teacher_result_confirm', ['uses' => 'TeachersController_sec@confirmSubjectRecordEntered','roles' => ['Admin', 'Teacher']])->name('form_teacher_result_confirm');
     });

     Route::group(['prefix' => 'account', 'middleware' => 'roles'], function () { 

         Route::get('/account_index', ['uses' => 'AccountController@index','roles' => ['Bursar']])->name('account_index');
         Route::get('/account_dash', ['uses' => 'AccountController@account_dash','roles' => ['Bursar']])->name('account_dash');
         Route::get('/index_fees', ['uses' => 'AccountController@index_fees','roles' => ['Bursar']])->name('index_fees');
         Route::post('/add_category', ['uses' => 'AccountController@addPaymentCategory','roles' => ['Bursar']])->name('add_category');
         Route::post('/update_category/{id}', ['uses' => 'AccountController@updatePaymentCategory','roles' => ['Bursar']])->name('update_category');
         Route::post('/add_category_amount', ['uses' => 'AccountController@addcategoryamount','roles' => ['Bursar']])->name('add_category_amount');
         Route::post('/deletepaymentcategory/{id}', ['uses' => 'AccountController@deletePaymentCategory','roles' => ['Bursar']])->name('deletepaymentcategory'); 
         Route::post('/updatepaymentamount/{id}', ['uses' => 'AccountController@updateCategoryAmount','roles' => ['Bursar']])->name('updatepaymentamount'); 
         Route::get('/summary', ['uses' => 'AccountController@summary','roles' => ['Bursar']])->name('summary'); 
         Route::get('/invoices', ['uses' => 'AccountController@invoices','roles' => ['Bursar']])->name('invoices'); 
         Route::get('/order_request', ['uses' => 'AccountController@orderRequest','roles' => ['Bursar']])->name('order_request');
         Route::get('/feecollection', ['uses' => 'AccountController@feecollection','roles' => ['Bursar']])->name('feecollection');
         Route::post('/fetchstudentdataforfee', ['uses' => 'AccountController@fetchstudentdataforfee','roles' => ['Bursar']])->name('fetchstudentdataforfee'); 
         Route::post('/sendmoneyrequest', ['uses' => 'AccountController@sendMoneyRequest','roles' => ['Bursar']])->name('sendmoneyrequest');
         Route::get('/inventory', ['uses' => 'AccountController@inventory','roles' => ['Bursar', 'Admin']])->name('inventory');
         Route::post('/inventory_add_item', ['uses' => 'AccountController@inventory_add_item','roles' => ['Bursar', 'Admin']])->name('inventory_add_item');
         Route::post('/add_invoice_order/{id}', ['uses' => 'AccountController@addInvoiceOrder','roles' => ['Bursar', 'Admin']])->name('add_invoice_order');


     });

});



Route::group(['prefix' => 'main', 'middleware' => 'roles'], function () { 
    Route::get('/mail_main', ['uses' => 'MailController@index','roles' => ['Bursar', 'Admin']])->name('mail_main');
    Route::get('/mail_compose', ['uses' => 'MailController@compose','roles' => ['Bursar', 'Admin']])->name('mail_compose');
 });

Route::group(['prefix'=>'pay', 'middleware' => 'roles'], function(){ 
    Route::get('/payment_details', ['uses' => 'PaymentDetailsController@index','roles' => ['Admin']])->name('payment_details');
    Route::post('/add_details', ['uses' => 'PaymentDetailsController@addDetails','roles' => ['Admin']])->name('add_details');
    Route::post('/make_payment', ['uses' => 'PaymentDetailsController@makePayment','roles' => ['Student']])->name('make_payment');
    Route::get('/payment_history', ['uses' => 'StudentController_sec@paymentHistory','roles' => ['Student']])->name('payment_history');
});






// subject route
Route::get('/subject_sec_index', ['uses' => 'SubjectController_sec@index','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::get('/addsubject_sec', ['uses' => 'SubjectController_sec@addsubject_sec','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/subjectprocess_sec', ['uses' => 'SubjectController_sec@store','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/deletesubject_sec', ['uses' => 'SubjectController_sec@deleteSubject','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/editsubject_sec', ['uses' => 'SubjectController_sec@editSubject_sec','roles' => ['Admin', 'Teacher']])->middleware('roles');

// add student route 

Route::group(['prefix'=>'pay', 'middleware' => 'roles'], function(){ 
    Route::get('/student_fees', ['uses' => 'StudentController_sec@feePayment','roles' => ['Student']])->name('student_fees');
 });

Route::get('/student_sec_index', ['uses' => 'StudentController_sec@index','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::post('/student_sec_confirm', ['uses' => 'StudentController_sec@confirmStudentRegNumber','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::post('/student_sec_add', ['uses' => 'StudentController_sec@store','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::get('/viewstudentbyclass', ['uses' => 'StudentController_sec@viewStudentbyClass','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/viewstudentsingleclass', ['uses' => 'StudentController_sec@viewStudentSingleClass','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/add_astudent_modal', ['uses' => 'StudentController_sec@addStudentModal','roles' => ['Admin']])->middleware('roles');

// add teachers
Route::get('/teacher_sec_index', ['uses' => 'TeachersController_sec@index','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::post('/teacher_sec_confirm', ['uses' => 'TeachersController_sec@confirmTeacherRegNumber','roles' => ['Admin']])->middleware('roles');
Route::post('/teachers_sec_confirm', ['uses' => 'TeachersController_sec@confirmTeacherRegNumber2','roles' => ['Admin']])->middleware('roles');
Route::post('/allocateformmaster', ['uses' => 'TeachersController_sec@allocateFormMaster','roles' => ['Admin']])->middleware('roles');
Route::post('/allocatesubjectteacher', ['uses' => 'TeachersController_sec@allocateSubjectTeacher','roles' => ['Admin']])->middleware('roles');
Route::get('/editteacherprofile', ['uses' => 'TeachersController_sec@teacherEditProfile','roles' => ['Teacher']])->middleware('roles');
Route::post('/confirm_edited', ['uses' => 'TeachersController_sec@addEdited','roles' => ['Teacher']])->middleware('roles');


//elearning 
Route::get('/elearning', ['uses' => 'ElearningController_sec@index','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
Route::get('/dowloads_videos', ['uses' => 'ElearningController_sec@downloadsVideos','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
Route::post('/add_videos', ['uses' => 'ElearningController_sec@addVideos','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::get('/all_videos', ['uses' => 'ElearningController_sec@ftechAllVieosStudent','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
Route::get('/all_pdfs', ['uses' => 'ElearningController_sec@ftechAllpdfStudent','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');

//main routes
Route::post('/add_assignment', ['uses' => 'ElearningController_sec@submitAssignment','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::post('/deletealignment', ['uses' => 'ElearningController_sec@deleteAssignment','roles' => ['Admin', 'Teacher']])->middleware('roles');



// attendance routes
Route::get('/student_attendance_sec', ['uses' => 'StudentAttendance@index','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/fetchalluserbyclass_sec', ['uses' => 'StudentAttendance@fetchalluserbyclass_sec','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/student_att_main', ['uses' => 'StudentAttendance@studentattendanceMain','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/view_all_at_sec', ['uses' => 'StudentAttendance@check_att_sec','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::get('/view_all_at_route_sec', ['uses' => 'StudentAttendance@check_att_sec_route','roles' => ['Admin', 'Teacher']])->middleware('roles');


//add students marks secondary 
Route::get('/student_add_marks', ['uses' => 'AddstudentmakrsController_secs@index','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/fetch_students_marks', ['uses' => 'AddstudentmakrsController_secs@fetchstudentssubject','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/fetch_subject_details', ['uses' => 'AddstudentmakrsController_secs@fetchsubjectdetails','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/fetch_subject_student_details', ['uses' => 'AddstudentmakrsController_secs@getallstudentsandmarks','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/add_marks_main', ['uses' => 'AddstudentmakrsController_secs@addmarksmiain','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/marks_process_main', ['uses' => 'AddstudentmakrsController_secs@processPosition','roles' => ['Admin', 'Teacher']])->middleware('roles');


//teachers attendance
Route::get('/teacher_add_attendance', ['uses' => 'AttendanceTeachers@index','roles' => ['Admin']])->middleware('roles');
Route::POST('/fetch_teacher_add_attendance', ['uses' => 'AttendanceTeachers@fetchteachers','roles' => ['Admin']])->middleware('roles');
Route::POST('/teachers_att_main', ['uses' => 'AttendanceTeachers@teachersAttendance','roles' => ['Admin']])->middleware('roles');

//pdf upload
Route::get('/dowloads_pdf', ['uses' => 'PdfController@index','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
Route::POST('/file-upload', ['uses' => 'PdfController@fileUploadPost','roles' => ['Admin', 'Teacher']])->middleware('roles');


//secondary promotion route
Route::get('/promotion_student_sec', ['uses' => 'PromotionController_sec@index','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/promotion_student_ftech_sec', ['uses' => 'PromotionController_sec@fetchstudentforpromotion','roles' => ['Admin', 'Teacher']])->middleware('roles');
// Route::POST('/promotion_next_class_sec', ['uses' => 'PromotionController_sec@fetchnextclass','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/promotion_main_query', ['uses' => 'PromotionController_sec@promotionmain','roles' => ['Admin', 'Teacher']])->middleware('roles');
Route::POST('/promote_jss_ss', ['uses' => 'PromotionController_sec@promotejss3toss1','roles' => ['Admin', 'Teacher']])->middleware('roles');

// secondary school result computation
Route::get('/result_view_sec', ['uses' => 'ResultController_sec@index','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
Route::Post('/result_print_sec', ['uses' => 'ResultController_sec@viewResult','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');
Route::Post('/result_print_update_sec', ['uses' => 'ResultController_sec@fetchresultdetails','roles' => ['Admin', 'Teacher', 'Student']])->middleware('roles');


Route::get('/school_library', ['uses' => 'LibraryController@index','roles' => ['Admin', 'Teacher', 'Student', 'Librarian']])->middleware('roles');
Route::POST('/book-upload', ['uses' => 'LibraryController@addbooks','roles' => ['Admin', 'Librarian']])->middleware('roles');
Route::POST('/category_library', ['uses' => 'LibraryController@addcategory','roles' => ['Admin', 'Librarian']])->middleware('roles');
Route::get('/view_all_books', ['uses' => 'LibraryController@viewallbooks','roles' => ['Librarian']])->middleware('roles');
Route::get('/all_books', ['uses' => 'LibraryController@ftechAllbooks','roles' => ['Admin', 'Teacher', 'Student', 'Librarian']])->middleware('roles');
Route::POST('/delete_book', ['uses' => 'LibraryController@deletebook','roles' => ['Admin', 'Librarian']])->middleware('roles');
Route::get('/trackbook', ['uses' => 'LibraryController@trackbook','roles' => ['Admin', 'Teacher', 'Student', 'Librarian']])->middleware('roles');
Route::POST('/fetch_book_details', ['uses' => 'LibraryController@fetchbokdetailisbn','roles' => ['Admin', 'Librarian']])->middleware('roles');
Route::POST('/fetch_student_book', ['uses' => 'LibraryController@getstudentforbook','roles' => ['Admin', 'Librarian']])->middleware('roles');
Route::POST('/add_book_borrow_data', ['uses' => 'LibraryController@addBookBorrowData','roles' => ['Admin', 'Librarian']])->middleware('roles');
Route::get('/all_borrowed_books', ['uses' => 'LibraryController@allborrowedbook','roles' => ['Admin', 'Teacher', 'Student', 'Librarian']])->middleware('roles');
Route::POST('/delete_borrow_book', ['uses' => 'LibraryController@deletebookborrowrecord','roles' => ['Admin', 'Librarian']])->middleware('roles');
Route::POST('/return_borrow_book', ['uses' => 'LibraryController@approvereturnbook','roles' => ['Admin', 'Librarian']])->middleware('roles');


Route::Post('/cookie/set','CookieController@setCookie');
Route::get('/cookie/get','CookieController@getCookie');

//domitory management route
Route::get('/dom_index', ['uses'=>'DometoryController@index', 'roles'=> ['Admin']])->middleware('roles');
Route::POST('/add_hostel', ['uses' => 'DometoryController@addHostel','roles' => ['Admin']])->middleware('roles');
Route::get('/add_rooms/{id}', ['uses' => 'DometoryController@show','roles' => ['Admin']])->middleware('roles');
Route::POST('/add_room', ['uses' => 'DometoryController@addHostels','roles' => ['Admin']])->middleware('roles');
Route::POST('/add_student_hostel', ['uses' => 'DometoryController@addStudentToHostel','roles' => ['Admin']])->middleware('roles');
Route::POST('/fetch_students_in_room', ['uses' => 'DometoryController@fetchAllStudentInARoom','roles' => ['Admin']])->middleware('roles');
Route::POST('/delete_roommate', ['uses' => 'DometoryController@deleteRoomMate','roles' => ['Admin']])->middleware('roles');
Route::POST('/delete_room', ['uses' => 'DometoryController@deleteRoom','roles' => ['Admin']])->middleware('roles');
Route::POST('/delete_hostel', ['uses' => 'DometoryController@deleteHostel','roles' => ['Admin']])->middleware('roles');


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


