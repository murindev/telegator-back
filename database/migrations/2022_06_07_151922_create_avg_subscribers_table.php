<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvgSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avg_subscribers', function (Blueprint $table) {
            $table->id();
            $table->integer('channel_id');
            $table->integer('total');
            $table->string('day', 10);
            $table->string('week',10);
            $table->string('month',10);
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
        Schema::dropIfExists('avg_subscribers');
    }
}
