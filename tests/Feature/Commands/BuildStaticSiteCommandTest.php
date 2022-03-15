<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;

class BuildStaticSiteCommandTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_command_returns_zero_exit_code()
    {
        $this->artisan('build')
             ->assertExitCode(0);
    }
}