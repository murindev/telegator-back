<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels_list', function (Blueprint $table) {
            $table->engine    = 'InnoDB';
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';

            $table->id();
            $table->string('slug', 63)->unique();
            $table->string('name', 63);
            $table->string('tg_link', 255);
            $table->boolean('is_public');
            $table->string('contact', 127);
            $table->string('contact2', 255);
            $table->string('subjects', 511);
            $table->unsignedInteger('subscribers_count');
            $table->unsignedInteger('reach_avg');
            $table->unsignedDecimal('post_price', 8, $scale = 2);
            $table->unsignedDecimal('post_price_additional', 8, $scale = 2);

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
        Schema::dropIfExists('channels_list');
    }
}
