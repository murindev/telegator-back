<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvgCitingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avg_citings', function (Blueprint $table) {
            $table->id();
            $table->integer('channel_id');
            $table->string('total',10);
            $table->integer('channel_mentions');
            $table->integer('mentions');
            $table->integer('reposts');
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
        Schema::dropIfExists('avg_citings');
    }
}
