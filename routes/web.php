<?php

use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/','PostController@postList')->name('post.postList');
Auth::routes();

Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['can:admin'])->group(function(){
  Route::get('/logout','UserController@getLogout')->name('logout');
  Route::get('post/newPost','PostController@newPost')->name('post.newPost');
  Route::post('post/postKeep','PostController@postKeep')->name('post.postKeep');
  Route::get('post/{post}/postEdit','PostController@postEdit')->name('post.postEdit');
  Route::put('post/postUpdate/{post}','PostController@postUpdate')->name('post.postUpdate');
  Route::delete('post/postDelete/{post}','PostController@postDelete')->name('post.postDelete');
  Route::delete('category/categoryDelete/{category}','CategoryController@categoryDelete')->name('category.categoryDelete');
});

Route::get('post/postList','PostController@postList')->name('post.postList');
Route::get('post/postShow/{post}','PostController@postShow')->name('post.postShow');
Route::get('category/{category}','CategoryController@categoryPosts')->name('category.categoryPosts');
//コメント
// Route::post('/post/comment/store','CommentController@store')->name('post.store');

//お問い合わせ
Route::get('contact/newContact','ContactController@newContact')->name('contact.newContact');
Route::post('contact/contactConfirm','ContactController@contactConfirm')->name('contact.contactConfirm');
Route::post('contact/contactSend','ContactController@contactSend')->name('contact.contactSend');

//管理者情報ページ
Route::get('about/aboutShow','AboutController@aboutShow')->name('about.aboutShow');
