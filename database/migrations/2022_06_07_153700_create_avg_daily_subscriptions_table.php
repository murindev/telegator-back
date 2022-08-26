<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvgDailySubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avg_daily_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('channel_id');
            $table->string('total');
            $table->string('plus');
            $table->string('minus');
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
        Schema::dropIfExists('avg_daily_subscriptions');
    }
}
