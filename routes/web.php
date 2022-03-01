<?php

use Illuminate\Support\Facades\Route;
// Laravel8 からルーティングの書き方が変わっているため注意
// use でコントローラを呼び出し、アクション構文でルーティングを記載
use App\Http\Controllers\PostsController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Models\Category;

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
    $categories = Category::all();
    // dd($categories);
    return view('home', [
        'categories' => $categories
    ]);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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


// 検索専用ページのルート Route::resource('posts')より上に記述しないと、優先度が下がるため、エラーになる
Route::get('/posts/search', [PostsController::class, 'search'])->name('posts.search');

Route::resource('posts', PostsController::class);

Route::resource('likes', LikeController::class)->only([
    'index'
]);

// 非同期でのいいねデータ追加用ルート
Route::post('/likes/ajax', [LikeController::class, 'ajaxLikes'])->name('likes.ajax');

Route::resource('comments', CommentController::class)->only([
    'destroy'
]);

Route::post('/comments/{id}', [CommentController::class, 'addComment'])->name('comments.add');


Route::get('/users/posts/{id}', [UserController::class, 'posts'])->name('users.posts');

Route::get('/users/profile', [UserController::class, 'exhibitions'])->name('users.profile');

Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit');

Route::patch('/users/edit', [UserController::class, 'update'])->name('users.update');

Route::get('/users/edit_image', [UserController::class, 'editImage'])->name('users.edit_image');

Route::patch('/users/edit_image', [UserController::class, 'updateImage'])->name('users.update_image');

Route::resource('users', UserController::class)->only([
    'index', 'show',
]);


Route::post('/follow/ajax', [FollowController::class, 'ajaxFollows'])->name('follow.ajax');