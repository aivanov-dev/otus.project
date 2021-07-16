<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExerciseGroupIdToTaskResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_results', function (Blueprint $table) {
            $table->foreignId('exercise_group_id')
                ->after('user_id')
                ->constrained('exercise_groups')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_results', function (Blueprint $table) {
            $table->dropForeign(['exercise_group_id']);
            $table->dropColumn('exercise_group_id');
        });
    }
}
