<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Inpsyde\JsonRestApiIntegration\Tests\Unit\DataLayer\User;

use Exception;
use Brain\Monkey\Functions;
use Inpsyde\JsonRestApiIntegration\DataLayer\User\UserDataCollector;
use Inpsyde\JsonRestApiIntegration\Tests\Unit\AbstractTestCase;

/**
 * @package Inpsyde\JsonRestApiIntegration\Tests\Unit\DataLayer\User
 */
class UserDataCollectorTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function testBasic(): void
    {
        Functions\stubs([ '__' ]);
        $testee = new UserDataCollector(1);
        static::assertSame(1, $testee->__get('id'));
    }

    /**
     * @test
     */
    public function testGetSet(): void
    {
        $testee = new UserDataCollector(1);
        $testee->__set('name', 'WordPress');
        $testee->__set('phone', 1234567890);
        static::assertEquals('WordPress', $testee->__get('name'));
        static::assertNotEquals('Test', $testee->__get('name'));
        static::assertEquals(1234567890, $testee->__get('phone'));
        static::assertNotSame('1234567890', $testee->__get('phone'));
        static::expectException(Exception::class);
        $this->expectExceptionMessage('address attribute is not found in class.');
        $testee->__get('address');
    }
}
