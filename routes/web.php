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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    
    // Account
    Route::group(['prefix' => 'account'], function()
    {
        Route::get('/search', 'AccountController@search')->name('accountSearch');
        Route::get('/new', 'AccountController@new')->name('accountNew');
        Route::post('/save', 'AccountController@save')->name('accountSave');
        Route::get('/edit/{accountId}', 'AccountController@edit')->name('accountEdit');
        Route::get('/show/{accountId}', 'AccountController@show')->name('accountShow');
        Route::post('/update', 'AccountController@update')->name('accountUpdate');
        Route::post('/delete', 'AccountController@delete')->name('accountDelete');
        Route::post('/restore', 'AccountController@restore')->name('accountRestore');
        Route::post('/validate', 'AccountController@userValidate')->name('accountValidate');
        Route::get('/messages/{accountId}', 'AccountController@receivedMessages')->name('receivedMessages');
        Route::post('/batch/upload', 'AccountController@batchUpload')->name('batchUpload');
    });
});
