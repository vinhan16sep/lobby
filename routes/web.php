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

Route::get('/home', 'HomeController@index');
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('admin')->group(function() {
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

  // Password reset routes
  Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
  Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
  Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
  
  Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
  
  Route::group(array('namespace' => 'Admin'), function() {
    // Blog Category routes
    Route::resource('event-days', 'EventDaysController');
    Route::post('event-days/search', 'EventDaysController@search')->name('event-days.search');
    Route::post('event-days/create', 'EventDaysController@create')->name('event-days.create');
    Route::post('event-days/store', 'EventDaysController@store')->name('event-days.store');
    Route::post('event-days/update/{id}', 'EventDaysController@update')->name('event-days.update');
  });
});
