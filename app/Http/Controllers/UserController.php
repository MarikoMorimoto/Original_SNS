<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class UserController extends Controller
{
    public function exhibition($id){
        $posts = Post::where('user_id', $id)->paginate(5);
        // dd(Post::find($id)->get()); NG すべてのid の posts が取得される
        $user_name = User::find($id)->name;
        return view('user.exhibition', [
            'posts' => $posts,
            'user_name' => $user_name,
        ]);
    }
}
