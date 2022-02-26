<?php

// AAA::class とすると、App\Http\Controllers（名前空間）\AAA が示される
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
// 継承していれば、名前空間よりも優先されるため
// Post::class とすると、App\Models\Post が示される。
use App\Models\Post;
use App\Models\User;
use App\Services\FileUploadService;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // ->input() ビュー側の <input name="keyword"> と紐づけ
        $keyword = $request->keyword;
        // dd($keyword);
        $query = Post::query();
        // dd($query->category);

        if (!empty($keyword)) {
            // like検索、第3引数の両側に%で部分一致検索、orWhere でタイトル・コメント・カテゴリから検索
            // あいまい検索
            // 下記のコードだと失敗した！Posts テーブルの中にはcategory というカラムは無い。
            // category も検索したいなら、Catagories テーブルと結合する必要がある。
            // $posts = Post::where('title', 'like', '%'.$keyword.'%')
            //     ->orWhere
            //     ->orWhere('comment', 'like', '%'.$keyword.'%')
            //     ->orWhere('category', 'like', '%'.$keyword.'%')
            //     ->latest()->paginate(5);
            $posts = $query->where('title', 'like', '%'.$keyword.'%')
                ->orWhere('comment', 'like', '%'.$keyword.'%')
                // ->orWhere('name')
                ->latest()->paginate(5);

        } else {
            $posts = $query->latest()->paginate(5);
        }

        // dd($posts);
        return view('posts.index', [
            'posts' => $posts,
            'keyword' => $keyword
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', [
            'categories' => DB::table('categories')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, FileUploadService $service)
    {
        $path = $service->saveImage($request->file('image'));

        Post::create([
            'user_id' => \Auth::user()->id,
            'title' => $request->title,
            'comment' => $request->comment,
            'category_id' => $request->category_id,
            'image' => $path, // ファイル名を保存
        ]);
        session()->flash('status', '投稿しました!');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $comments = $post->commentsToPost()->orderBy('created_at', 'desc')->paginate(3);
        return view('posts.show', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(){
        return view('posts.search');
    }
}
