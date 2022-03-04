<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function addComment($post_id, CommentRequest $request,){
        Comment::create([
            'post_id' => $post_id,
            'user_id' => \Auth::user()->id,
            'comment' => $request->comment,
        ]);
        $post = Post::find($post_id);
        $comments = $post->commentsToPost()->orderBy('created_at', 'desc')->paginate(3);
        session()->flash('status', 'コメントを追加しました!');
        return redirect()->route('posts.show', [
        'post' => $post,
        'comments' => $comments
        ]);
    }

    public function destroy($id){
        $comment = Comment::find($id);
        $post = Post::find($comment->post_id);
        $comment->delete();
        $comments = $post->commentsToPost()->orderBy('created_at', 'desc')->paginate(3);
        session()->flash('status', 'コメントを削除しました');
        return redirect()->route('posts.show', [
            'post' => $post,
            'comments' => $comments
        ]);
    }
}
