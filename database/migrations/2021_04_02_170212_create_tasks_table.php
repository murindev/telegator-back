<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->engine    = 'InnoDB';
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';

            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('channel_id');
            $table->enum('status', ['new', 'rejected', 'confirmed', 'finished']);
            $table->string('execution_status')->nullable();
            $table->timestamp('range_start_at')->nullable();
            $table->timestamp('range_end_at')->nullable();
            $table->integer('publication')->nullable();
            $table->integer('silence')->nullable();
            $table->decimal('cost')->nullable();
            $table->decimal('fine')->nullable();
            $table->timestamps();

            $table->unique(['campaign_id', 'channel_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
