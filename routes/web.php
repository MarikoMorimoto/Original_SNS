<?php

use Illuminate\Support\Facades\Route;
// Laravel8 からルーティングの書き方が変わっているため注意
// use でコントローラを呼び出し、アクション構文でルーティングを記載
use App\Http\Controllers\PostsController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CommentController;

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
    return view('home');
});

// Auth::routes();
// メール認証機能追加のため書き換え
Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function(){
    // メール確認済みのverifiedユーザー以外は
    // ここに記載した各ルートにアクセスできなくなる
    Route::resource('about', AboutController::class)->only([
        'index'
    ]);

});

Route::get('/register/after', function () {
    return view('auth.after_register');
});

Route::get('/logout/after', function () {
    return view('auth.after_logout');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('posts', PostsController::class);

Route::resource('likes', LikeController::class)->only([
    'index'
]);

// 非同期でのいいねデータ追加用ルート
Route::post('/likes/ajax', [App\Http\Controllers\LikeController::class, 'ajaxLikes'])->name('likes.ajax');

Route::resource('comments', CommentController::class)->only([
    'destroy'
]);

Route::post('/comments/{id}', [CommentController::class, 'addComment'])->name('comments.add');