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
use App\Http\Controllers\ContactController;
use App\Models\Category;
use App\Models\Post;

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
    $posts = Post::all()->sortByDesc('created_at')->take(6);
    if (\Auth::user() !== null) {
        $follow_users_ids = \Auth::user()->follow_users->pluck('id');
        $follow_users_posts = Post::all()->whereIn('user_id', $follow_users_ids)->sortByDesc('created_at')->take(6);
    } else {
        $follow_users_posts = '';
    }
    return view('home', [
        'categories' => $categories,
        'posts' => $posts,
        'follow_users_posts' => $follow_users_posts
    ]);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();
// メール認証機能追加のため書き換え
Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function(){
    // メール確認済みのverifiedユーザー以外は
    // ここに記載した各ルートにアクセスできなくなる
    // posts.create を設定する予定
    // Route::resource('posts', PostsController::class)->only([
    //     'create'
    // ]);
});

Route::resource('about', AboutController::class)->only([
    'index'
]);

Route::get('/register/after', function () {
    return view('auth.after_register');
});

Route::get('/logout/after', function () {
    return view('auth.after_logout');
});


// 検索専用ページのルート Route::resource('posts')より上に記述しないと、優先度が下がるため、エラーになる
Route::get('/posts/search', [PostsController::class, 'search'])->name('posts.search');

// resource を用いると edit がGETメソッドでアクセスできるようになる。POSTメソッドでのアクセスにした方がよいと思ったため個別でルーティング
Route::post('/posts/edit/{id}', [PostsController::class, 'edit'])->name('posts.edit');

Route::post('/posts/edit_image/{id}', [PostsController::class, 'editImage'])->name('posts.edit_image');

Route::patch('/posts/edit_image/{id}', [PostsController::class, 'updateImage'])->name('posts.update_image');

Route::resource('posts', PostsController::class)->except([
    'edit'
]);

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

Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit');

Route::patch('/users/edit', [UserController::class, 'update'])->name('users.update');

Route::get('/users/edit_image', [UserController::class, 'editImage'])->name('users.edit_image');

Route::patch('/users/edit_image', [UserController::class, 'updateImage'])->name('users.update_image');

Route::resource('users', UserController::class)->only([
    'index', 'show',
]);

Route::get('/follow/posts', [FollowController::class, 'posts'])->name('follow.posts');

Route::post('/follow/ajax', [FollowController::class, 'ajaxFollows'])->name('follow.ajax');

Route::resource('follow', FollowController::class)->only([
    'index'
]);


// お問い合わせページ
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');

Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');

Route::post('/contact/thanks', [ContactController::class, 'send'])->name('contact.send');