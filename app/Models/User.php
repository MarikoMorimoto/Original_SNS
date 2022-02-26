<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// 名前空間で定義しているから以下の記述はいらない
// use App\Models\Post;
// use App\Models\Category;
// use App\Models\Comment;
// use App\Models\Like;
// use App\Models\Follow;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        // hasMany メソッドは「1対n」と呼ばれるタイプのリレーションを設定するメソッド
        // 「1対n」の「1」の側が設定するのが、hasMany のリレーション
        // posts というメソッドで、複数所有しているPostインスタンスにアクセスできるという定義
        return $this->hasMany(Post::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    // 中間テーブルを介したn対mのリレーションを設定
    public function likePosts(){
        // belongsToMany(モデルクラス名, 中間テーブル名)
        return $this->belongsToMany(Post::class, 'likes')
        // 中間テーブルに追加した時間で降順に並べ替え
                    ->withPivot('created_at')
                    ->orderBy('pivot_created_at', 'desc');
    }

    public function follows(){
        return $this->hasMany(Follow::class);
    }

    // belongsToMany(モデルクラス名, 中間テーブル名, リレーションを設定する側のカラム名, リレーションを設定される側のカラム名);
    public function follow_users(){
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id');
    }

    public function followers(){
        return $this->belongsToMany(User::class, 'follows', 'follow_id', 'user_id');
    }

    // 該当のユーザーが特定のユーザーをフォローしているかどうかをチェック
    public function isFollowing($user){
        // フォローしていたら true を返す
        $result = $this->follow_users->pluck('id')->contains($user->id);
        return $result;
    }

}
