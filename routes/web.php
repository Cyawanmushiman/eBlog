<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('post/create','PostController@create')->name('post.create');
Route::post('post/store','PostController@store')->name('post.store');
Route::get('post/index','PostController@index')->name('post.index');
Route::get('post/show/{post}','PostController@show')->name('post.show');
Route::get('post/{post}/edit','PostController@edit')->name('post.edit');
Route::put('post/update/{post}','PostController@update')->name('post.update');
Route::delete('post/delete/{post}','PostController@delete')->name('post.delete');

//コメント
// Route::post('/post/comment/store','CommentController@store')->name('post.store');
