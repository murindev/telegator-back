<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_views', function (Blueprint $table) {
            $table->id();
            $table->integer('channel_id')->comment('id канала tgator');
            $table->integer('post_id')->comment('id поста tgator');
            $table->integer('post_nr')->nullable()->comment('Номер поста в тг');
            $table->integer('hour')->comment('Номер часа от 1 до 24');
            $table->decimal('percentage',3,1)->default(0);
            $table->integer('views_cnt')->default(0);
            $table->dateTime('tg_stat_created_at')->nullable();
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
        Schema::dropIfExists('post_views');
    }
}
