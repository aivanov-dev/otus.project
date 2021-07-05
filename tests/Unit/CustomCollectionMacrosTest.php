<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TaskResult;

class CustomCollectionMacrosTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function test_count_with_conditions_method(): void
    {
        $testedCollection = collect([
            TaskResult::make(['assessment' => 10]),
            TaskResult::make(['assessment' => 10]),
            TaskResult::make(['assessment' => 9]),
            TaskResult::make(['assessment' => 9]),
            TaskResult::make(['assessment' => 9]),
            TaskResult::make(['assessment' => 8]),
        ]);

        //if third argument is omitted, default operator '==' will be used
        $this->assertEquals(2, $testedCollection->countWithCondition('assessment', 10));
        $this->assertEquals(5, $testedCollection->countWithCondition('assessment', 9, '>='));
        $this->assertEquals(1, $testedCollection->countWithCondition('assessment', 8, '<='));
    }
}
