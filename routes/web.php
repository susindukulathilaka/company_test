<?php

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


Route::get('/', function () {
    return view('welcome');
});

    Route::get('/itemprice/{id}', 'InvoiceController@getPrice')->name('itemprice');
    Route::post('/saveorder', 'InvoiceController@saveOrder')->name('saveorder');
    Route::post('/addtocart', 'InvoiceController@addToCart')->name('addtocart');
    Route::get('ajax-form-submit-validation', 'ajaxFormSubmitWithValidation\ContactController@index');
    Route::post('ajax-form-submit-validation', 'ajaxFormSubmitWithValidation\ContactController@store');

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

