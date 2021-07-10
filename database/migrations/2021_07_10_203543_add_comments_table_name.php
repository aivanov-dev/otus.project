<?php

use Illuminate\Database\Migrations\Migration;

class AddCommentsTableName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("COMMENT ON TABLE exercise_groups IS 'Курсы и модули'");
        \DB::statement("COMMENT ON TABLE users IS 'Студенты'");
        \DB::statement("COMMENT ON TABLE exercises IS 'Занятия'");
        \DB::statement("COMMENT ON TABLE tasks IS 'Задания'");
        \DB::statement("COMMENT ON TABLE task_results IS 'Результаты заданий'");
        \DB::statement("COMMENT ON TABLE skills IS 'Навыки'");
        \DB::statement("COMMENT ON TABLE influences IS 'Влияния заданий на навыки'");
        \DB::statement("COMMENT ON TABLE achievements IS 'Ачивки'");
        \DB::statement("COMMENT ON TABLE exercises_to_groups IS 'Связь занятий с курсами и модулями'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("COMMENT ON TABLE exercise_groups IS ''");
        \DB::statement("COMMENT ON TABLE user IS ''");
        \DB::statement("COMMENT ON TABLE exercises IS ''");
        \DB::statement("COMMENT ON TABLE tasks IS ''");
        \DB::statement("COMMENT ON TABLE task_results IS ''");
        \DB::statement("COMMENT ON TABLE skills IS ''");
        \DB::statement("COMMENT ON TABLE influences IS ''");
        \DB::statement("COMMENT ON TABLE achievements IS ''");
        \DB::statement("COMMENT ON TABLE exercises_to_groups IS ''");
    }
}
