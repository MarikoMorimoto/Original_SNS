<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follow;
use App\Models\Post;
use App\Http\Requests\AjaxFollowRequest;

class FollowController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = \Auth::user();
        $follow_users = $user->follow_users()->paginate(10);
        return view('follow.index', [
            'follow_users' => $follow_users,
        ]);
    }

    public function posts(){
        $user = \Auth::user();
        // $follow_users_posts = Follow::query()
        // イコールの順番についても意識 どのテーブルに何をくっつけるのか
            // ->join('posts', 'follows.follow_id', '=', 'posts.user_id')
            // ->select('posts.*', 'follows.follow_id', 'follows.user_id')
            // ->where('follows.user_id', $user->id)
        // ->toSql(); SQL文は、各所で toSql()で確認すべし！ toSql() の結果をDBのSQLに貼り付けてデバッグ（? 部分は適宜入力）
            // ->orderByDesc('posts.created_at')
            // ->paginate(5);

        // Post:: から書き始めなければPost モデル内で定義したメソッドが使えない
        $follow_users_posts = Post::query()
            ->join('follows', 'posts.user_id', '=', 'follows.follow_id')
            // テーブルに同名カラム（id created_at など）があるとview側で処理ができない場合もあるため絞り込む
            ->select('posts.*', 'follows.user_id', 'follows.follow_id')
            ->where('follows.user_id', $user->id)
            ->orderByDesc('posts.created_at')
            ->withCount('likes')
            ->paginate(5);
        // dd($follow_users_posts);

        return view('follow.posts', [
            'posts' => $follow_users_posts
        ]);
    }

    public function ajaxFollows(AjaxFollowRequest $request){
        $user = \Auth::user();
        $follow_user = User::find($request->follow_id);
        // ログインユーザーがすでに投稿者をフォローしている場合はフォローの取り消し
        if ($user->isFollowing($follow_user)) {
            $user->follows->where('follow_id', $follow_user->id)->first()->delete();
        } else {
            // まだフォローしていない場合はフォローテーブルにレコードを追加
            Follow::create([
                'user_id' => $user->id,
                'follow_id'=> $follow_user->id,
            ]);
        };
    }
}
