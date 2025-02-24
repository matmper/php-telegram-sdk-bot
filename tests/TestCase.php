<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as TestCaseParent;

class TestCase extends TestCaseParent
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Set up tests
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->createApplication();
    }

    /**
     * Create test application
     * @return void
     */
    protected function createApplication(): void
    {
        $this->faker = \Faker\Factory::create();
    }
}
