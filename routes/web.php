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

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/create/book','BookController@create');
Route::post('/create/book','BookController@store');
Route::get('/books', 'BookController@index');
Route::get('/delete/book/{id}','BookController@destroy');

Route::get('/edit/book/{id}','BookController@edit');
Route::post('/edit/book/{id}','BookController@update');

Route::get('/create/isbn','BookController@createISBN');
Route::post('/create/isbn','BookController@storeISBN');


Route::get('/create/lease/{id}','LeaseController@create');
Route::post('/create/lease/{id}','LeaseController@store');
Route::get('/leases','LeaseController@index');
Route::get('/delete/lease/{id}','LeaseController@destroy');

Route::get('/leases/my','LeaseController@myLeases');
