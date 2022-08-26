<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_data', function (Blueprint $table) {
            $table->engine    = 'InnoDB';
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';

            $table->foreignId('channel_id');
            $table->string('title', 127);
			$table->string('image_url', 511)->nullable();
			$table->string('description', 511)->default('');
			$table->unsignedInteger('subscribers')->default(0);
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
        Schema::dropIfExists('channel_data');
    }
}
