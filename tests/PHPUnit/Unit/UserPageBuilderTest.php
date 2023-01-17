<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Inpsyde\JsonRestApiIntegration\Tests\Unit;

use Brain\Monkey\Functions;
use Inpsyde\JsonRestApiIntegration\UserPageBuilder;

/**
 * @package Inpsyde\JsonRestApiIntegration\Tests\Unit\DataLayer\User
 */
class UserPageBuilderTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function testInit(): void
    {
        $testee = new UserPageBuilder();
        $testee->init();
        self::assertNotFalse(has_action('init', [ $testee, 'registerPage' ]));
        self::assertNotFalse(
            has_filter('template_include', [ $testee, 'handlePageRequest' ])
        );
        self::assertNotFalse(
            has_filter('query_vars', [ $testee, 'updateQueryVars' ])
        );
    }

    /**
     * @test
     */
    public function testUpdateQueryVars(): void
    {
        $testee = new UserPageBuilder();
        $vars = $testee->updateQueryVars([]);
        self::assertIsArray($vars);
        self::assertEquals(['userspage'], $vars);
    }

    /**
     * @test
     */
    public function testHandlePageRequest(): void
    {
        $testee = new UserPageBuilder();

        // Template loaded from theme directory.
        Functions\stubs([
            'get_query_var'=> static function (): bool {
                return true;
            },
            'wp_is_block_theme'=> static function (): bool {
                return false;
            },
            'locate_template'=> static function (string|array $templateNames): string {
                return is_array($templateNames)?$templateNames[0] : $templateNames;
            },
            '__',
        ]);
        $template = $testee->handlePageRequest('test.php');
        self::assertEquals('template-users-table.php', $template);

        // Template loaded from plugin directory.
        Functions\stubs([
            'locate_template'=> static function (string|array $templateNames): string {
                return '';
            },
        ]);
        $template = $testee->handlePageRequest('test.php');
        self::assertEquals(
            JSON_REST_API_INTEGRATION_DIR. '/templates/template-users-table.php',
            $template
        );

        // Template not loaded because of get_query_var not find
        Functions\stubs([
            'get_query_var'=> static function (): bool {
                return false;
            },
        ]);
        $template = $testee->handlePageRequest('test.php');
        self::assertEquals('test.php', $template);

        // Template not loaded because of wp_is_block_theme is activated
        Functions\stubs([
            'wp_is_block_theme'=> static function (): bool {
                return true;
            },
        ]);
        $template = $testee->handlePageRequest('test.php');
        self::assertEquals('test.php', $template);
    }
}
