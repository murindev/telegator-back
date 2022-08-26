<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTgStatsChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tg_stat_channels', function (Blueprint $table) {
            $table->engine    = 'InnoDB';
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';

            $table->unsignedBigInteger('channel_id');
            $table->string('avatar', 1023)->nullable();
            $table->string('title', 1023)->nullable();
            $table->string('description', 4096)->nullable();
            $table->unsignedInteger('members')->nullable();
            $table->unsignedBigInteger('last_post_id')->nullable();
            $table->unsignedInteger('avg_post_reach')->nullable();
            $table->string('avg_post_reach_raw', 15)->nullable();
            $table->unsignedInteger('avg_daily_reach')->nullable();
            $table->string('avg_daily_reach_raw', 15)->nullable();
            $table->unsignedInteger('avg_posts_per_day')->nullable();
            $table->string('avg_posts_per_day_raw', 15)->nullable();
            $table->decimal('err_percent')->nullable();
            $table->string('err_percent_raw', 15)->nullable();
            $table->decimal('citation_index')->nullable();
            $table->string('citation_index_raw', 15)->nullable();
            $table->timestamps();

            $table->primary('channel_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tg_stat_channels');
    }
}
