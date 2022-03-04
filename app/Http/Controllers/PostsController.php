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
    public function __construct(){
        $this->middleware('auth')
            ->only(['create','store', 'edit', 'update', 'destroy']);
    }

    public function index(Request $request)
    {
        // ->input() ビュー側の <input name="keyword"> と紐づけ
        $keyword = $request->keyword;
        // dd($keyword);
        // dd(Post::query()); // Illuminate\Database\Eloquent\Builder
        // dd(DB::table('posts')); // Illuminate\Database\Query\Builder
        $query = Post::query();
        // dd($query->category); // posts テーブルにcategory カラムは無い。当該カラムはcategoriesテーブルにある。
        
        // dd(DB::table('posts')->rightJoin('categories', 'posts.category_id', '=', 'categories.id')
        // ->select('posts.*', 'categories.name')->where('title', 'like', '%'.$keyword.'%')->orWhere('comment', 'like', '%'.$keyword.'%')
        // ->orWhere('name', 'like', '%'.$keyword.'%')->orderByDesc('posts.created_at')->get());
        // 上記コードでソートをlatest() にすると、posts のcreated_at でのソートかcategories のcreated_at でのソートが判別ができずエラーになる 
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

            // $posts = DB::table('posts')だと下記エラー
            // Object of class stdClass could not be converted to string 
            
            // $posts = Post::query()-> OK
            // $posts = Post::rightJoind() OK
            
            $posts = $query
                ->rightJoin('categories', 'posts.category_id', '=', 'categories.id')
                ->select('posts.*', 'categories.name')
                ->where('title', 'like', '%'.$keyword.'%')
                ->orWhere('comment', 'like', '%'.$keyword.'%')
                ->orWhere('name', 'like', '%'.$keyword.'%')
                ->orderByDesc('posts.created_at')->paginate(5);

            // 下記の方法でもできる 
            // $in_category = DB::table('categories')
            //     ->where('name', 'like', '%'.$keyword.'%')
            //     ->get(); // コレクション
            // $posts = $query
            //     ->whereIn('category_id', $in_category->pluck('id'))
            //     ->orWhere('title', 'like', '%'.$keyword.'%')
            //     ->orWhere('comment', 'like', '%'.$keyword.'%')
            //     ->latest()->paginate(5);

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

    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', [
            'post' => $post,
            'categories' => DB::table('categories')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function search(){
        return view('posts.search');
    }
}
