<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStatusToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::raw("ALTER TABLE `tasks` CHANGE `status` `status` ENUM('new','invited','rejected','confirmed','finished') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::raw("ALTER TABLE `tasks` CHANGE `status` `status` ENUM('new','rejected','confirmed','finished') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;");
    }
}
