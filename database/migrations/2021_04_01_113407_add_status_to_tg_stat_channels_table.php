<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTgStatChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tg_stat_channels', function (Blueprint $table) {
            $table->boolean('status')->default(true)->after('channel_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('tg_stat_channels')) {
            Schema::table('tg_stat_channels', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
}
