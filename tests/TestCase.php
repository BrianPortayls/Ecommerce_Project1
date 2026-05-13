<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected bool $createdHotFileForTests = false;

    protected function setUp(): void
    {
        parent::setUp();

        $hotFile = public_path('hot');

        if (! file_exists($hotFile)) {
            file_put_contents($hotFile, 'http://localhost');
            $this->createdHotFileForTests = true;
        }
    }

    protected function tearDown(): void
    {
        if ($this->createdHotFileForTests) {
            @unlink(public_path('hot'));
        }

        parent::tearDown();
    }
}
