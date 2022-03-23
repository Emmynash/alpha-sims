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

    Route::group(['prefix' => 'account', 'middleware' => ['auth', 'role_or_permission:Bursar|Serve as temporary Bursar']], function () {
        Route::get('/account_index', 'AccountController@index')->name('account_index');
        Route::get('/account_dash', 'AccountController@account_dash')->name('account_dash');
        Route::post('/add_category', 'AccountController@addPaymentCategory')->name('add_category');
        Route::post('/update_category/{id}', 'AccountController@updatePaymentCategory')->name('update_category');
        Route::post('/add_category_amount', 'AccountController@addCategoryAmount')->name('add_category_amount');
        Route::post('/deletepaymentcategory/{id}', 'AccountController@deletePaymentCategory')->name('deletepaymentcategory');
        Route::post('/updatepaymentamount/{id}', 'AccountController@updateCategoryAmount')->name('updatepaymentamount');
    });


    Route::get('/index_fees', 'AccountController@index_fees')->name('index_fees');
    Route::get('/summary', 'AccountController@summary')->name('summary')->middleware(['auth', 'can:view account summary']);
    Route::get('/invoices', 'AccountController@invoices')->name('invoices')->middleware(['auth', 'can:invoice management']);
    Route::get('/viewinvoices/{id}', 'AccountController@viewinvoices')->name('viewinvoices')->middleware(['auth', 'can:invoice management']);
    Route::get('/printinvoice/{id}', 'AccountController@printInvoice')->name('printinvoice')->middleware(['auth', 'can:invoice management']);
    Route::get('/invoicepaymenthis/{id}', 'AccountController@invoicePaymentHistory')->name('invoicepaymenthis')->middleware(['auth', 'can:invoice management']);
    Route::get('/unpaid_fees', 'AccountController@unpaid_fees')->name('unpaid_fees')->middleware(['auth', 'can:invoice management']);
    Route::get('/order_request', 'AccountController@orderRequest')->name('order_request')->middleware(['auth', 'can:can send or receive request']);

    Route::get('/student_dicount', 'AccountController@student_dicount')->name('student_dicount')->middleware(['auth', 'can:can send or receive request']);

    Route::post('/request_response', 'AccountController@request_response')->name('request_response')->middleware(['auth', 'can:can send or receive request']);
    Route::get('/feecollection', 'AccountController@feecollection')->name('feecollection')->middleware(['auth', 'can:fee collection']);
    Route::post('/fetchstudentdataforfee', 'AccountController@fetchStudentDataForFee')->name('fetchstudentdataforfee');
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

});