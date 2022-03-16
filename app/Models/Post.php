<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 名前空間で定義しているから以下の記述はいらない
// use App\Models\User;
// use App\Models\Category;
// use App\Models\Comment;
// use App\Models\Like;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'comment',
        'category_id',
        'image',
        'flower_name',
    ];

    public function user(){
        // 1対多の「多」側の設定 ひとりのUserがたくさんのPosts
        return $this->belongsTo(User::class);
    }

    public function category(){
        // ひとつのCategoryにたくさんのPosts
        return $this->belongsTo(Category::class);
    }

    public function catagoryWithPost(){
        // ひとつのPostにひとつのCategory
        return $this->hasOne(Category::class);
    }

    public function commentsToPost(){
        // toSql には () を必ずつけないとエラーになる！
        // dd($this->hasMany(Comment::class)->orderBy('created_at')->toSql);
        // 1対多の「1」側の設定 ひとつのPostにたくさんのComments
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        // ひとつのPostにたくさんのLikes
        return $this->hasMany(Like::class);
    }

    // 中間テーブルを介したn対mのリレーションを設定
    // この場合は中間テーブル名を記載
    public function likedUsers(){
        return $this->belongsToMany(User::class, 'likes');
    }

    // 投稿が特定のユーザーにいいねされているかどうかをチェックするメソッドを作成
    public function isLikedBy($user){
        // likedUsers() とメソッドの形で呼び出した場合には「クエリビルダ」になる
        // likedUsers とプロパティの形で呼び出した場合には「コレクション（Postインスタンス）」になる
        // pluck はlikedUsersコレクションのメソッド
        $liked_users_ids = $this->likedUsers->pluck('id');
        // $liked_users_ids の中に、
        // 引数で渡されたユーザーのid が含まれているかどうかをチェック
        $result = $liked_users_ids->contains($user->id);
        // 該当のユーザーがいいねをしていれば true していなければ false を返す
        return $result;
    }

    // 引数で指定された画像のサムネイル画像のパスを返す
    public function thumbnail($path){
        $thumbnail_path = str_replace('photos/', 'thumbnail-', $path);
        $result_path = 'photos/' . $thumbnail_path;
        return $result_path;
    }
}
