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
Route::get('/profile', 'UserController@profile')->name('profile');
Route::post('/avatar', 'UserController@updateAvatar');
Route::post('/profile', 'UserController@updateProfile');

Route::get('/users/index', 'UserController@index');
Route::get('/users/view/{userId}', 'UserController@view');

Route::get('/globshoppers', 'GlobshoppersController@index');
Route::post('/globshoppers/search', 'GlobshoppersController@search');
Route::get('/globshoppers/view/{globshopperId}', 'GlobshoppersController@view');
Route::get('/globshoppers/edit-portfolio', 'GlobshoppersController@editPortfolio');
Route::post('/globshoppers/save-portfolio/{globshopperId}', 'GlobshoppersController@savePortfolio');

Route::get('/requests/index', 'RequestsController@index');
Route::get('/requests/create/{id}', 'RequestsController@create');
Route::post('/requests/create/{id}', 'RequestsController@create');
Route::get('/requests/edit/{id}', 'RequestsController@edit');
Route::get('/requests/view/{id}', 'RequestsController@view');
Route::post('/requests/save-request/{id}', 'RequestsController@saveRequest');
Route::get('/requests/accept-request/{id}', 'RequestsController@acceptRequest');
Route::get('/requests/cancel-request/{id}', 'RequestsController@cancelRequest');
Route::get('/requests/set-delivered/{id}', 'RequestsController@setDelivered');
Route::post('/requests/create-rating/{id}', 'RatingsController@create');

Route::post('/offers/create/{id}', 'OffersController@create');
Route::post('/offers/update/{id}', 'OffersController@update');

Route::post('/complaints/create-complaint/{requestId}', 'ComplaintsController@createComplaint');
Route::post('/complaints/create-comment/{complaintId}', 'ComplaintsController@createComment');
Route::post('/complaints/resolve/{complaintId}/{userType}', 'ComplaintsController@resolve');

Route::get('/charges/pay/{id}', 'ChargesController@pay');
Route::post('/charges/create/{id}', 'ChargesController@createCharge');

Route::get('/notifications', 'NotificationsController@index');


