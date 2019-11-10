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


Route::get('/', 'InvoiceController@index')->name('item');
Route::get('/itemprice/{id}', 'InvoiceController@getPrice')->name('itemprice');
Route::post('/saveorder', 'InvoiceController@saveOrder')->name('saveorder');
Route::post('/addtocart', 'InvoiceController@addToCart')->name('addtocart');