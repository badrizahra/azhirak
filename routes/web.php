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
use App\Http\Middleware\Admin;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Admin')->middleware([Admin::class])->prefix(env('APP_ADMIN_URL'))->group(function () {

    //authorization
    Route::get('authorization','PermissionController@index')->name('permission.index');
    Route::PUT('authorization','PermissionController@Update')->name('permission.update');

    //roles
    Route::get('package/destroy/{package}',  'RoleController@destroy')->name('role.destroy');
    Route::resource('role','RoleController')->except(['show','destroy']);

    //user
    Route::resource('user','UserController',['as' => 'admin']);

    Route::get('contact/','ContactController@index')->name('contact.index');

    //websamples
    // Route::resource('websamples', 'WebSamplesController')->except(['store']);
    Route::get('/websamples', 'WebSamplesController@index');
    Route::get('/websamples/create', 'WebSamplesController@create');
    Route::get('/websamples/{id}', 'WebSamplesController@show');
    // Route::post('users/{user}/websamples', 'WebSamplesController@store');
    Route::post('/websamples', 'WebSamplesController@store');
    Route::get('/websamples/{webSample}/edit', 'WebSamplesController@edit');
    Route::put('/websamples/{id}', 'WebSamplesController@update');
    Route::delete('/websamples/{id}', 'WebSamplesController@destroy');
});