<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function addComment($post, CommentRequest $request,){
        Comment::create([
            'post_id' => $post,
            'user_id' => \Auth::user()->id,
            'comment' => $request->comment,
        ]);
        session()->flash('status', 'コメントを追加しました!');
        return redirect()->route('posts.show', [
        'post' => $post
        ]);
    }

    public function destroy($id){
        $comment = Comment::find($id);
        $post = Post::find($comment->post_id);
        $comment->delete();
        session()->flash('status', 'コメントを削除しました');
        return redirect()->route('posts.show', [
            'post' => $post
        ]);
    }
}
