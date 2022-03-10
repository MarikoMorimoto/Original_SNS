<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserImageRequest;
use App\Services\FileUploadService;
use Image;

class UserController extends Controller
{
    public function __construct(){
        // only 指定したコントローラメソッドにミドルウェアを設定
        // except 指定したコントローラメソッドにはミドルウェアが設定されない
        $this->middleware('auth')
            ->only(['index', 'edit', 'update', 'editImage', 'updateImage']);
    }

    // ログインユーザー本人のみがアクセスできるマイページ
    public function index(){
        $user = \Auth::user();
        return view('users.index');
    }

    // 誰でもアクセスできるユーザープロフィールページ
    public function show($id){
        $show_user = User::find($id);
        $posts = Post::where('user_id', $id)->latest()->limit(1)->get();
        $count_posts = Post::where('user_id', $id)->count();
        return view('users.show', [
            'show_user' => $show_user,
            'posts' => $posts,
            'count_posts' => $count_posts 
        ]);
    }

    // マイページの編集ページ
    public function edit(){
        $user = \Auth::user();
        return view('users.edit');
    }

    // マイページの更新処理
    public function update(UserRequest $request){
        $user = \Auth::user();
        if (empty($request->profile)) {
            $request->profile = '';
        }
        $user->update([
            'name' => $request->name,
            'profile' => $request->profile,
        ]);
        session()->flash('status', 'プロフィールを更新しました!');
        return redirect()->route('users.index');
    }

    public function editImage(){
        $user = \Auth::user();
        return view('users.edit_image');
    }

    public function updateImage(UserImageRequest $request, FileUploadService $service){
        $user = \Auth::user();
        $path = $service->saveImage($request->file('image'));

        $storage_path = public_path('storage/');
        // （完全修飾パス）/public/storage/

        $thumbnail = Image::make($storage_path . $path);

        // $path は photos/（文字列）のため、「photos/」を「thumbnail-」に置き換え
        $thumbnail_path = str_replace('photos/', 'thumbnail-', $path);

        // 画像をリサイズ 幅だけを設定して、高さは自動処理
        $thumbnail->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        // 元のファイル名の先頭に「thumbnail-」を付け加えたものを保存
        })->save($storage_path . 'photos/' . $thumbnail_path);

        $user->update([
            'image' => $path,
        ]);
        session()->flash('status', 'プロフィール画像を更新しました!');
        return redirect()->route('users.index');
    }

    public function posts($id){
        $posts = Post::withCount('likes')->where('user_id', $id)->latest()->paginate(5);
        // dd(Post::find($id)->get()); NG すべてのid の posts が取得される
        $user_name = User::find($id)->name;
        return view('users.posts', [
            'posts' => $posts,
            'user_name' => $user_name,
        ]);
    }
}
