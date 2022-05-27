<?php

namespace Tests\Feature;

use App\Jobs\AnimalLifeCycleJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        (new AnimalLifeCycleJob(1, 1, 1))->handle();
    }
}
