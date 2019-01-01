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

//Route::get('/home', 'HomeController@index')->name('home');

Route::group( [ 'middleware' => 'auth' ], function () {

    Route::get('/', function () {
        return redirect('admin/schedules');
    });

    Route::get('/admin/settings','HomeController@showChangePasswordForm');
    Route::post('/changePassword','HomeController@changePassword')->name('changePassword');

    Route::resource('admin/bookings', 'Admin\\BookingsController');
    Route::resource('admin/projects', 'Admin\\ProjectsController');
    Route::resource('admin/resources', 'Admin\\ResourcesController');
    Route::post('admin/resources/order', 'Admin\\ResourcesController@storeOrder');
    Route::resource('admin/status', 'Admin\\StatusController');
    Route::resource('users', 'UsersController');
    Route::get('restore/{id}', [
        'uses' => 'UsersController@restore'
    ]);
    Route::post('usersE/{id}', [
        'uses' => 'UsersController@enableUser'
    ]);

    Route::get('/export-user', 'UsersController@exportCSV');


    Route::get('admin/schedules', 'Admin\\BookingsController@showSchedulesPage');
    Route::post('admin/schedules/create', 'Admin\\BookingsController@createSchedule');
    Route::post('admin/schedules/delete', 'Admin\\BookingsController@deleteSchedule');
    Route::resource('admin/schedules-management', 'Admin\\SchedulesServiceController');
    Route::get('admin/resourcesfind/find-resources-select2','Admin\\ResourcesController@findResourcesSelect2')->name('findSelect2');


});


Route::get('/sync-resources', 'SyncController@syncData');