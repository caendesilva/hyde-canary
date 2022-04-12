<?php

namespace Tests\Unit;

use Hyde\Framework\Actions\PublishesDefaultFrontendResourceFiles;
use Hyde\Framework\Hyde;
use tests\TestCase;

class PublishesDefaultFrontendResourceFilesTest extends TestCase
{
    /** Setup */
    public function setUp(): void
    {
        parent::setUp();

        backupDirectory(Hyde::path('resources/frontend'));
        deleteDirectory(Hyde::path('resources/frontend'));
    }

    /** @test */
    public function test_default_files_are_published()
    {
        $this->assertDirectoryDoesNotExist(Hyde::path('resources/frontend'));

        (new PublishesDefaultFrontendResourceFiles)->__invoke();

        $this->assertDirectoryExists(Hyde::path('resources/frontend'));

        $this->assertFileExists(Hyde::path('resources/frontend/app.css'));
        $this->assertFileExists(Hyde::path('resources/frontend/hyde.css'));
        $this->assertFileExists(Hyde::path('resources/frontend/hyde.js'));
    }

    /** Teardown */
    public function tearDown(): void
    {
        restoreDirectory(Hyde::path('resources/frontend'));

        parent::tearDown();
    }
}