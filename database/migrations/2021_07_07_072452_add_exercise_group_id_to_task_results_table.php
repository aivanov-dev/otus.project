<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExerciseGroupIdToTaskResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('task_results', function (Blueprint $table) {
            $table->foreignId('exercise_group_id')
                ->after('user_id')
                ->constrained('exercise_groups')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->float('assessment')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('task_results', function (Blueprint $table) {
            $table->integer('assessment', false, true)->change();
            $table->dropColumn('exercise_group_id');
        });
        Schema::enableForeignKeyConstraints();
    }
}
