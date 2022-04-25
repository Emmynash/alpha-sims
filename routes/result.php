<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['tenant'])->group(function () {

    Route::group(['middleware' => ['auth']], function () {

        Route::post('/single_result', 'ResultGenerationController@generateSingleResult')->name('single_result');

        Route::post('/multiple_result', 'ResultGenerationController@bulkResultPrinting')->name('multiple_result');

        


    }); 


});