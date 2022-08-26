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
            $table->integer('channel_id');
            $table->string('title')->nullable()->comment('Название');
            $table->text('content')->nullable()->comment('Содержание');
            $table->integer('views_cnt')->nullable()->comment('Кол-во просмотров');
            $table->integer('forwards_cnt')->nullable()->comment('Количество forward');
            $table->boolean('is_advert')->nullable()->comment('Количество forward');
            $table->integer('engagement_rate')->nullable()->comment('Engagement Rate, %');
            $table->integer('comments_cnt')->nullable()->comment('Комментарии');
            $table->integer('reactions_cnt')->nullable()->comment('Количество нестандартных реакций');
            $table->integer('duration')->nullable()->comment('Продолжительность публикации');
            $table->integer('purity_duration')->nullable()->comment('Продолжительность “чистоты” ленты после публикации рекламного поста');
            $table->boolean('is_faker')->nullable()->comment('Демо данные');
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
