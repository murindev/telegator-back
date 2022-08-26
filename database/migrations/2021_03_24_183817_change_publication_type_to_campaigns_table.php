<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePublicationTypeToCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->integer('publication')->nullable()->change();
            $table->integer('silence')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->smallInteger('publication')->tinyInteger('publication')->nullable()->change();
            $table->smallInteger('silence')->tinyInteger('silence')->nullable()->change();
        });
    }
}
