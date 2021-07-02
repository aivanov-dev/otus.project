<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_id')
                ->constrained('skills')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->foreignId('task_id')
                ->constrained('tasks')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->tinyInteger('influence');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_skills');
    }
}
