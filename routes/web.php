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
    return view('auth.login');
});

Auth::routes();


Route::get('/chat', 'HomeController@chat');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('admin')->group(function () {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    // Password reset routes
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');

    Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');

    Route::group(array('namespace' => 'Admin'), function () {
        // User routes
        // Route::resource('user', 'UserController');
        Route::get('user', 'UserController@index')->name('user.index');
        Route::post('user/search', 'UserController@search')->name('user.search');
        Route::get('user/import', 'UserController@import')->name('user.import');
        Route::post('user/doImport', 'UserController@doImport')->name('user.doImport');
        Route::post('user/store', 'UserController@store')->name('user.store');
        Route::post('user/update/{id}', 'UserController@update')->name('user.update');
        Route::get('user/destroy/{id}', 'UserController@destroy')->name('user.destroy');
        // Event days routes
        Route::get('event-days', 'EventDaysController@index')->name('event-days.index');
        Route::post('event-days/search', 'EventDaysController@search')->name('event-days.search');
        Route::get('event-days/create', 'EventDaysController@create')->name('event-days.create');
        Route::post('event-days/store', 'EventDaysController@store')->name('event-days.store');
        Route::get('event-days/edit/{id}', 'EventDaysController@edit')->name('event-days.edit');
        Route::post('event-days/update/{id}', 'EventDaysController@update')->name('event-days.update');
        Route::get('event-days/destroy/{id}', 'EventDaysController@destroy')->name('event-days.destroy');
        // Event times routes
        Route::get('event-times', 'EventTimesController@index')->name('event-times.index');
        Route::post('event-times/search', 'EventTimesController@search')->name('event-times.search');
        Route::get('event-times/create', 'EventTimesController@create')->name('event-times.create');
        Route::post('event-times/store', 'EventTimesController@store')->name('event-times.store');
        Route::get('event-times/edit/{id}', 'EventTimesController@edit')->name('event-times.edit');
        Route::post('event-times/update/{id}', 'EventTimesController@update')->name('event-times.update');
        Route::get('event-times/destroy/{id}', 'EventTimesController@destroy')->name('event-times.destroy');
        Route::get('event-times/getByEventDay', 'EventTimesController@getByEventDay')->name('event-times.getByEventDay');
        // Seminars routes
        Route::get('seminars', 'SeminarsController@index')->name('seminars.index');
        Route::post('seminars/search', 'SeminarsController@search')->name('seminars.search');
        Route::get('seminars/create', 'SeminarsController@create')->name('seminars.create');
        Route::post('seminars/store', 'SeminarsController@store')->name('seminars.store');
        Route::get('seminars/edit/{id}', 'SeminarsController@edit')->name('seminars.edit');
        Route::post('seminars/update/{id}', 'SeminarsController@update')->name('seminars.update');
        Route::get('seminars/destroy/{id}', 'SeminarsController@destroy')->name('seminars.destroy');
    });
});
