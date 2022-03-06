<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 名前空間で定義しているから以下の記述はいらない
// use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment'
    ];

    public function user(){
        // 1対多の「多」側の設定 ひとりのUserがたくさんのcomments
        return $this->belongsTo(User::class);
    }

}
