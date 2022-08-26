<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvgAdvertViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avg_advert_views', function (Blueprint $table) {
            $table->id();
            $table->integer('channel_id');
            $table->integer('total');
            $table->string('half_day');
            $table->string('day');
            $table->string('two_day');
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
        Schema::dropIfExists('avg_advert_views');
    }
}
