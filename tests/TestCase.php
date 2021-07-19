<?php

namespace Tests;

use App\Http\Middleware\RequestAnalyst;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(RequestAnalyst::class);
    }
}
