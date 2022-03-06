<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // トップページは非ログイン時でも閲覧可能
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all();
        // take() コレクションのメソッド 指定したアイテム数の新しいコレクションを返す
        $posts = Post::all()->sortByDesc('created_at')->take(6);
        
        // ユーザーがログインしていないときに Auth::user() は使えないため if 分岐させる
        if (\Auth::user() !== null) {
            // ログインユーザーがフォローしているユーザーのid を取得
            $follow_users_ids = \Auth::user()->follow_users->pluck('id');
            // potsテーブルの中から user_id カラム が $follow_user_ids と一致するもののみ 3件 取得
            $follow_users_posts = Post::all()->whereIn('user_id', $follow_users_ids)->sortByDesc('created_at')->take(6);
        } else {
            // ユーザーがログインしていないときの処理 view に渡す変数は定義されている必要がある
            $follow_users_posts = '';
        }
        return view('home', [
            'categories' => $categories,
            'posts' => $posts,
            'follow_users_posts' => $follow_users_posts,
        ]);
    }
}
