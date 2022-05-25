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

//お問い合わせ
// Route::get('contact/create','ContactController@create')->name('contact.create');
// Route::post('contact/check','ContactController@check')->name('contact.check');
Route::get('/form','ContactController@show')->name('form.show');//お問い合わせフォームを表示
Route::post('/form','ContactController@post')->name('form.post');//セッションに入力値を登録
Route::get('/form/confirm','ContactController@confirm')->name('form.confirm');//確認画面
Route::post('/form/confirm','ContactController@send')->name('form.send');//確認画面からフォーム遷移先
Route::get('form/thanks','ContactController@complete')->name('form.complete');//完了画面

