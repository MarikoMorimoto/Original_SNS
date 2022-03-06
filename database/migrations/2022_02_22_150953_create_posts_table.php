<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            // foreignId メソッドは bigIncrements で設定されるデータ型 unsignedBigInteger カラムを作成する
            // foreignIdメソッドとconstrainedメソッド を用いれば外部キー制約を設定できる
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title', 20);
            $table->string('comment', 150);
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('image', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
