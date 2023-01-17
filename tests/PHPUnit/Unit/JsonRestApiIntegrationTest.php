<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Inpsyde\JsonRestApiIntegration\Tests\Unit;

use Brain\Monkey\Functions;
use Inpsyde\JsonRestApiIntegration\BlocksManager;
use Inpsyde\JsonRestApiIntegration\JsonRestApiIntegration;
use Inpsyde\JsonRestApiIntegration\RestLayer\User\UserDetailRestCollector;
use Inpsyde\JsonRestApiIntegration\UserPageBuilder;

/**
 * @package Inpsyde\JsonRestApiIntegration\Tests\Unit\DataLayer\User
 */
class JsonRestApiIntegrationTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function testBasic(): void
    {
        Functions\stubs([
            'register_activation_hook',
            '__',
        ]);
        $testee = JsonRestApiIntegration::instance();
        static::assertInstanceOf(UserPageBuilder::class, $testee->userPageBuilder);
        static::assertInstanceOf(BlocksManager::class, $testee->block);
        static::assertInstanceOf(UserDetailRestCollector::class, $testee->userDetailRest);
        self::assertNotFalse(has_action('wp_enqueue_scripts', [ $testee, 'enqueueScripts' ]));
        self::assertNotFalse(has_action('wp_print_footer_scripts', [ $testee, 'loadsJSTemplate' ]));
    }

    /**
     * @test
     */
    public function testPathTo(): void
    {
        self::assertEquals(
            JSON_REST_API_INTEGRATION_DIR. '/blocks',
            JsonRestApiIntegration::pathTo('/blocks')
        );
    }
}
