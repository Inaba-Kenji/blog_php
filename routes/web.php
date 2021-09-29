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

// ブログ一覧を表示
Route::get('/', 'BlogController@showList')->name('blogs');
// ブログ登録画面を表示
Route::get('/blog/create', 'BlogController@showCreate')->name('create');
// ブログ登録
Route::post('/blog/store', 'BlogController@exeStore')->name('store');
// ブログ詳細を表示
Route::get('/blog/{id}', 'BlogController@showDetail')->name('show');
// ブログ編集画面を表示
Route::get('/blog/edit/{id}', 'BlogController@showEdit')->name('edit');
// 編集内容の更新
Route::post('/blog/update', 'BlogController@exeUpdate')->name('update');
// ブログ削除
Route::post('/blog/delete/{id}', 'BlogController@exeDelete')->name('delete');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// コメントを投稿
Route::post('/comment/store', 'CommentsController@commentStore')->name('commentStore');

//ログイン中のユーザーのみアクセス可能
Route::group(['middleware' => ['auth']], function () {
  //「ajaxlike.jsファイルのurl:'ルーティング'」に書くものと合わせる。
  Route::post('/ajaxlike', 'BlogController@ajaxlike')->name('blogs.ajaxlike');
});
