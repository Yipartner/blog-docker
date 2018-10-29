<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table){
          $table->increments('id');
          $table->string('title');
          $table->longText('content');
          $table->string('user_id');
          // 文章分类
          $table->integer('type_id');
          // 封面头图
          $table->integer('picture_id')->default(1);
          // 状态 0:草稿 1:公开发布 2:指定人可见 3:仅自己可见
          $table->integer('status');
          $table->dateTime('created_at');
          $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
