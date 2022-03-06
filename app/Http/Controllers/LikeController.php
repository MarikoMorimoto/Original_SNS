<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AjaxLikeRequest;
use App\Models\Post;
use App\Models\Like;

class LikeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = \Auth::user();
        $posts = $user->likePosts()->paginate(5);
        return view('likes.index', [
            'posts' => $posts,
        ]);
    }

    public function ajaxLikes(AjaxLikeRequest $request){
        $user = \Auth::user();
        $post = Post::find($request->post_id);
        // すでにいいねされている場合はいいねの取り消し where(引数1, 引数2)で 引数1 = 引数2 という意味
        if ($post->isLikedBy($user)) {
            $post->likes->where('user_id', $user->id)->first()->delete();
        } else {
            // まだいいねされていない場合 いいねテーブルにレコードを追加
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
        };
    }
}
