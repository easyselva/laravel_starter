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
//general settings
Auth::routes();
Route::get('send', 'DashboardController@sendNotification');
Route::get('/', 'DashboardController@index')->name('home');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('change_password', 'DashboardController@change_password');
Route::post('update_password', 'DashboardController@update_password');


Route::prefix('admin')->group(function () {
    //General settings
    Route::resource('settings/preferences', 'PreferenceController');
    Route::resource('settings/preference_categories', 'PreferenceCategoryController');
    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::post('settings/update', 'SettingsController@Update')->name('update_settings');
    Route::resource('users', 'UserController');
    Route::get('list_users/{id}', 'UserController@list_users')->name('list_users');
    Route::resource('roles', 'RoleController');
    Route::get('{type}/permissions/{id}', 'RoleController@permissions')->name('permissions');
    Route::post('{type}/permissions/{id}', 'RoleController@update_permissions')->name('update_permissions');
    //End general settings
});


//Route::get('/', 'DashboardController@index')->name('home');
//Route::get('/{any}', 'FrontController@index')->name('front');
//Route::view('/{path?}', 'front');