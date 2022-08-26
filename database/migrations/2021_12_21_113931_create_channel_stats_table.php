<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_stats', function (Blueprint $table) {
            $table->bigInteger('channel_id');
            $table->bigInteger('publication_count');
            $table->integer('avg_publication_count');
            $table->integer('avg_time_publication');
            $table->integer('avg_view_publication');
            $table->integer('avg_share_publication');
            $table->integer('avg_coverage');
            $table->integer('avg_iterations');
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
        Schema::dropIfExists('channel_stats');
    }
}
