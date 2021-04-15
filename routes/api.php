<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('fetchallstudents/{userid}', 'ElearningController_sec@fetchAllStudents');

Route::get('fetchallsubjectsroom/{userid}', 'ElearningController_sec@fetchAllSubjectRoom');

Route::get('getallsubjects/{schoolid}', 'ElearningController_sec@getallsubjects');

Route::get('getallstudentsclass/{classid}', 'ElearningController_sec@getallStudentsClass');

Route::get('getsubjecteachclass/{classid}', 'ElearningController_sec@getsubjecteachclass');

Route::get('fetchchats/{loggeninuserid}/{receiver}/{chatype}', 'ElearningController_sec@getAllChats');

Route::POST('sendchat', 'ElearningController_sec@sendChat');

//mobile app links apis
Route::get('confirmstudentmobile', 'ElearningController_sec@ConfirmStudentMobile');

Route::get('notifications/{schoolid}', 'ElearningController_sec@notifications');

Route::get('getprofiles/{userid}', 'ElearningController_sec@getProfileDetailsStusent');