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

Route::middleware(['tenant'])->group(function () {

    Route::group(['middleware' => ['auth', 'role:Student']], function () { // assignment module
        Route::get('/assignment_student', 'AssignmentController@index')->name('assignment_student');
        Route::post('/assignment_submit', 'AssignmentController@submitAssignmentStudent')->name('assignment_submit');
        Route::get('/view_submission_student/{subjectid}/{classid}/{sectionid}/{assignment_id}', 'AssignmentController@viewSubmissions')->name('view_submission_student');
    });

    Route::group(['middleware' => ['auth', 'role:Teacher']], function () { // assignment module
        Route::get('/assignment_teachers', 'AssignmentController@assignment_teachers')->name('assignment_teachers');
        Route::get('/assignment_view/{id}/{classid}/{sectionid}', 'AssignmentController@assignment_view')->name('assignment_view');
        Route::get('/assignment_remark', 'AssignmentController@assignment_remark')->name('assignment_remark');
        Route::get('/assignment_subject', 'AssignmentController@assignment_subject')->name('assignment_subject');
        Route::post('/post_assignment', 'AssignmentController@post_assignment')->name('post_assignment');
        Route::delete('/deleteassignment/{id}', 'AssignmentController@delete')->name('deleteassignment');
        Route::get('/view_submission/{subjectid}/{classid}/{sectionid}/{assignment_id}', 'AssignmentController@viewSubmissions')->name('view_submission');
        Route::post('/remark_assignment', 'AssignmentController@remarkAssignment')->name('remark_assignment');
    });

});