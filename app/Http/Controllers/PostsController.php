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
use App\Http\Requests\PostEditRequest;
use App\Http\Requests\PostEditImageRequest;
use Image; // intervention/image ライブラリの読み込み


class PostsController extends Controller
{
    public function __construct()
    {
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
                ->withCount('likes')
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
            $posts = $query->withCount('likes')->latest()->paginate(5);
        }

        // dd($posts);
        return view('posts.index', [
            'posts' => $posts,
            'keyword' => $keyword
        ]);
    }

    public function create()
    {
        return view('posts.create', [
            'categories' => DB::table('categories')->get(),
        ]);
    }

    public function store(PostRequest $request, FileUploadService $service)
    {
        $path = $service->saveImage($request->file('image'));

        // サムネイル用画像を作成して保存するための処理
        // サムネイル用画像を保存するためのパス
        // public_path() publicディレクトリへの完全修飾パスを返す パラメタ指定しない場合、末尾にスラッシュは付与されない
        // パラメタ指定するとpublicディレクトリへの完全修飾パスに続いて指定した文字列を繋げたパスを返す
        $storage_path = public_path('storage/');
        // （完全修飾パス）/public/storage/

        $thumbnail = Image::make($storage_path . $path);

        // $path は photos/（文字列）のため、「photos/」を「thumbnail-」に置き換え
        $thumbnail_path = str_replace('photos/', 'thumbnail-', $path);

        // 画像をリサイズ 幅だけを設定して、高さは自動処理
        $thumbnail->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        // 元のファイル名の先頭に「thumbnail-」を付け加えたものを保存
        })->save($storage_path . 'photos/' . $thumbnail_path);


        // 花の名前欄に入力がなければ「''」を保存
        if (empty($request->flower_name)) {
            $request->flower_name = '';
        }

        Post::create([
            'user_id' => \Auth::user()->id,
            'title' => $request->title,
            'comment' => $request->comment,
            'category_id' => $request->category_id,
            'image' => $path, // ファイル名を保存
            'flower_name' => $request->flower_name,
        ]);
        session()->flash('status', '投稿しました!');
        return redirect()->route('home');
    }

    public function show($id)
    {
        $post = Post::withCount('likes')->find($id);
        $comments = $post->commentsToPost()->orderBy('created_at', 'desc')->paginate(3);
        return view('posts.show', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function edit($id)
    {
        $post = Post::find($id);
        // 投稿したユーザー以外がURL直打ちなどでアクセスしようとした場合は条件分岐でwarningページに遷移
        if ($post->user_id === \Auth::user()->id) {
            return view('posts.edit', [
                'post' => $post,
                'categories' => DB::table('categories')->get(),
            ]);
        } else {
            return view('posts.warning');
        };
    }

    public function update(PostEditRequest $request, $id)
    {
        $post = Post::find($id);
        $comments = $post->commentsToPost()->orderBy('created_at', 'desc')->paginate(3);
        $post->update([
            'title' => $request->title,
            'comment' => $request->comment,
            'category_id' => $request->category_id
        ]);
        session()->flash('status', '投稿を編集しました!');
        return redirect()->route('posts.show', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function editImage($id)
    {
        $post = Post::find($id);
        if ($post->user_id === \Auth::user()->id) {
            return view('posts.edit_image', [
                'post' => $post
            ]);
        } else {
            return view('posts.warning');
        };
    }

    public function updateImage(PostEditImageRequest $request, FileUploadService $service, $id)
    {
        // dd($request);
        $path = $service->saveImage($request->file('image'));

        $post = Post::find($id);
        $comments = $post->commentsToPost()->orderBy('created_at', 'desc')->paginate(3);

        $post->update([
            'image' => $path
        ]);
        session()->flash('status', '画像を変更しました!');
        return redirect()->route('posts.show', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        session()->flash('status', '投稿を削除しました');
        return redirect()->route('home');
    }

    public function search(){
        return view('posts.search');
    }

    public function warning(){
        return view('posts.warning');
    }
}
