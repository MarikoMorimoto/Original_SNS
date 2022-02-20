<?php

use Illuminate\Support\Facades\Route;
// Laravel8 からルーティングの書き方が変わっているため注意
// use でコントローラを呼び出し、アクション構文でルーティングを記載
use App\Http\Controllers\PostsController;
use App\Http\Controllers\LikeController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('posts', PostsController::class);

Route::resource('likes', LikeController::class)->only([
    'index'
]);

// 非同期でのいいねデータ追加用ルート
Route::post('/ajax/likes', 'LikeController@ajaxLikes')->name('ajax.likes');
