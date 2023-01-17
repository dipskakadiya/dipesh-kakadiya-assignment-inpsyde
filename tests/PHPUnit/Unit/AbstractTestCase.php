<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Inpsyde\JsonRestApiIntegration\Tests\Unit;

use Brain\Monkey;
use PHPUnit\Framework\TestCase;

/**
 * @package Inpsyde\JsonRestApiIntegration\Tests\Unit
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * Sets up the environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
    }

    /**
     * Tears down the environment.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }
}
