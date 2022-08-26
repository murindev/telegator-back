<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddVersionToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedInteger('version')->default(1)->after('execution_status');
        });

        DB::update('UPDATE `tasks` SET `publication` = `publication` * 60, `silence` = `silence` * 60 WHERE 1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('version');
        });

        DB::update('UPDATE `tasks` SET `publication` = `publication` / 60, `silence` = `silence` / 60 WHERE 1');
    }
}
