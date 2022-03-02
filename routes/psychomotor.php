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

Route::middleware(['tenant'])->group(function () {

    Route::group(['middleware' => ['auth', 'can:psychomotor module']], function () {

        //phycomoto secondary
        Route::get('/student_moto', 'MotoController_sec@index', 'roles')->name('student_moto');
        Route::get('/setting_moto', 'MotoController_sec@settingsmoto')->name('setting_moto')->middleware('can:add moto settings');
        Route::post('/edit_setting_moto', 'MotoController_sec@editSettingsmoto')->name('edit_setting_moto')->middleware('can:add moto settings');
        Route::post('/add_setting_moto', 'MotoController_sec@addSettingsMoto')->name('add_setting_moto');
        Route::POST('/get_students_for_pyco', 'MotoController_sec@get_students_for_psyco')->name('get_students_for_pyco');
        Route::POST('/addmoto_main', 'MotoController_sec@addmotomain', 'roles')->name('addmoto_main');
        Route::get('/view_student/{id}', 'MotoController_sec@addFunNowMain')->name('view_student');
        Route::POST('/add_student_moto', 'MotoController_sec@addmotomain')->name('add_student_moto');
    });

    Route::group(['middleware' => ['auth', 'can:add psychomotor']], function () { // 
        Route::get('/moto', 'MotoController_sec@index')->name('moto');
        Route::get('/motosettings', 'PysoController@motosettings')->name('motosettings');
        Route::POST('/fetchstudentdata', 'PysoController@fetchStudentData')->name('fetchstudentdata');
        Route::POST('/addmoto', ['uses' => 'PysoController@addmoto', 'roles' => ['Admin', 'Teacher']])->middleware('roles');
        Route::get('/addmotopage', ['uses' => 'PysoController@addmotopage', 'roles' => ['Admin', 'Teacher']])->middleware('roles');
        Route::POST('/addmotopri', 'PysoController@addMotoPri')->name('addmotopri');
        Route::get('/addmotomain/{id}', 'PysoController@addmotomain')->name('addmotomain');
        Route::POST('/addmoto_post/{id}', 'PysoController@addmotoPost')->name('addmoto_post');
    });

});