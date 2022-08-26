<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['deposit', 'withdraw', 'transfer']);
            $table->unsignedBigInteger('source_id')->nullable();
            $table->enum('source_type', ['balance', 'hold'])->nullable();
            $table->unsignedBigInteger('destination_id')->nullable();
            $table->enum('destination_type', ['balance', 'hold'])->nullable();
            $table->decimal('value');
            $table->json('reason');
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
        Schema::dropIfExists('transactions');
    }
}
