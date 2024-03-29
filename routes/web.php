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

Auth::routes();


// -------------------------
// ----- ホーム -----
// -------------------------
Route::get('/', 'DisplayParrotsController@display');

Route::get('/test', 'IndexController@display');

// -------------------------
// ----- お問い合わせ -----
// -------------------------
Route::group(['prefix' => 'contact'], function () {
  // 入力画面
  Route::get('/', 'ContactController@getIndex');
  // 確認画面
  Route::post('/confirm', 'ContactController@confirm');
  // 完了画面
  Route::post('/finish', 'ContactController@finish');
});

// -------------------------
// ----- 掲示板 -----
// -------------------------
Route::group(['prefix' => 'bbs/1'], function () {
  Route::get('/', 'PostsController@index')->name('top');
  // CRUD
  Route::resource('/posts', 'PostsController', ['only' => ['create', 'store', 'show', 'edit', 'update', 'destroy']]);
  // コメント
  Route::resource('/comments', 'CommentsController', ['only' => ['store']]);
  // コメント削除
  Route::delete('/posts/destroy/{id}', 'PostsController@destroyComment')->name('destroyComment');
});

// -------------------------
// ----- ユーザー登録 -----
// -------------------------
Route::get('/regist', 'RegistController@index')->name('register');



// 全ユーザ
Route::group(['middleware' => ['auth', 'can:user-higher']], function () { });

// 管理者以上
Route::group(['middleware' => ['auth', 'can:admin-higher']], function () { });

// システム管理者のみ
Route::group(['middleware' => ['auth', 'can:system-only']], function () {

  // -------------------------
  // ----- クローリング -----
  // -------------------------
  Route::get('getparrotsdelete', 'GetParrotsController@getParrotsDelete');
  Route::get('getparrotstohoku', 'GetParrotsController@getParrotsTohoku');
  Route::get('getparrotskanto', 'GetParrotsController@getParrotsKanto');
  Route::get('getparrotschubu', 'GetParrotsController@getParrotsChubu');

  // -------------------------
  // ----- ユーザー一覧 -----
  // -------------------------
  Route::group(['prefix' => 'users'], function () {
    // 一覧
    Route::get('list', 'UsersController@getIndex');
    // 入力
    Route::get('new', 'UsersController@newIndex');
    // 確認
    Route::post('new/confirm', 'UsersController@newConfirm');
    // 完了
    Route::post('new/finish', 'UsersController@newFinish');
  });
});
