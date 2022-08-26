<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTgStatsPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tg_stat_posts', function (Blueprint $table) {
            $table->engine    = 'InnoDB';
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';

            $table->unsignedBigInteger('channel_id');
            $table->unsignedBigInteger('post_id');
            $table->string('text', 4096)->nullable();
            $table->string('stat_link', 255)->nullable();
            $table->boolean('with_video')->nullable();
            $table->boolean('with_image')->nullable();
            $table->timestamp('parsed_at')->nullable()->nullable();
            $table->string('parsed_dt_string')->nullable();
            $table->unsignedInteger('views')->nullable();
            $table->string('views_raw')->nullable();
            $table->unsignedInteger('reposts')->nullable();
            $table->string('reposts_raw')->nullable();
            $table->timestamps();

            $table->primary(['channel_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tg_stat_posts');
    }
}
