<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_contents', function (Blueprint $table) {
            $table->bigInteger('campaign_id');
            $table->string('message', 6000)->default('');
            $table->string('message_raw', 4100)->default('');
            $table->boolean('with_video')->default(false);
            $table->boolean('with_image')->default(false);
            $table->string('link', 1022)->nullable();
            $table->timestamps();

            $table->primary('campaign_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_contents');
    }
}
