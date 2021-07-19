<?php

use Illuminate\Database\Migrations\Migration;

class AddProcedureForExerciseGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement(
            'CREATE OR REPLACE FUNCTION calculate_assessments(exercise_groups)
                        RETURNS INTEGER AS $$
                    DECLARE assessment_sum INTEGER;
                    BEGIN
                        WITH root AS (SELECT _lft, _rgt FROM exercise_groups WHERE id = $1.id)

                        SELECT sum(assessment) into assessment_sum
                        FROM task_results
                        WHERE exercise_group_id IN (SELECT id
                                                    FROM exercise_groups
                                                    WHERE _lft >= (SELECT _lft FROM root)
                                                      AND _rgt <= (SELECT _rgt FROM root));

                        RETURN assessment_sum;
                    END;
                    $$  LANGUAGE plpgsql;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP FUNCTION calculate_assessments;');
    }
}
