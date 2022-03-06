<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 名前空間で定義しているから以下の記述はいらない
// use App\Models\Post;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name'];

    public function categories(){
        return $this->hasMany(Post::class);
    }
}
