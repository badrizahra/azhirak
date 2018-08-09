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

    //contact us
    Route::get('contact/','ContactController@index')->name('contact.index');
    Route::get('contact/show/{id}','ContactController@show')->name('contact.show');
    Route::delete('contact/delete','ContactController@delete')->name('contact.delete');

    //websamples
    Route::get('/websamples', 'WebSamplesController@index')->name('websamples.index');
    Route::get('/websamples/create', 'WebSamplesController@create')->name('websamples.create');
    Route::get('/websamples/{id}', 'WebSamplesController@show')->name('websamples.show');
    Route::post('/websamples', 'WebSamplesController@store')->name('websamples.store');
    Route::get('/websamples/{webSample}/edit', 'WebSamplesController@edit')->name('websamples.edit');
    Route::put('/websamples/{id}', 'WebSamplesController@update')->name('websamples.update');
    Route::delete('/websamples/{id}', 'WebSamplesController@destroy')->name('websamples.destroy');
    Route::get('/websamples/deletewsimage/{id}', 'WebSamplesController@delete_image');
});