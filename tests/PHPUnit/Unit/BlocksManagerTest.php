<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Inpsyde\JsonRestApiIntegration\Tests\Unit;

use Brain\Monkey\Functions;
use Inpsyde\JsonRestApiIntegration\BlocksManager;

/**
 * @package Inpsyde\JsonRestApiIntegration\Tests\Unit\DataLayer\User
 */
class BlocksManagerTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function testInit(): void
    {
        $testee = new BlocksManager();
        $testee->init();
        self::assertNotFalse(has_action('init', [ $testee, 'registerBlocks' ]));
        self::assertNotFalse(
            has_filter('block_categories_all', [ $testee, 'registerBlockCategory' ])
        );
    }

    /**
     * @test
     */
    public function testRegisterBlockCategory(): void
    {
        Functions\stubs([ '__' ]);
        $testee = new BlocksManager();
        $blockCategories = $testee->registerBlockCategory([]);
        self::assertIsArray($blockCategories);
        self::assertEquals('inpsyde-blocks', $blockCategories[0]['slug']);
    }

    /**
     * @test
     */
    public function testFindAllBlocks(): void
    {
        $testee = new BlocksManager();
        $blocks = $testee->findAllBlocks();
        self::assertIsArray($blocks);
        self::assertContains(
            JSON_REST_API_INTEGRATION_DIR. '/build/blocks/user-list-block',
            $blocks
        );
    }

    /**
     * @test
     */
    public function testRegisterBlock(): void
    {
        Functions\stubs([
            'register_block_type' =>static function (): object {
                return (object) [
                    'name' => 'user-list-block',
                ];
            },
            '__',
        ]);
        $testee = new BlocksManager();
        $testee->registerBlock(JSON_REST_API_INTEGRATION_DIR. '/build/blocks/user-list-block');
        self::assertEquals(
            JSON_REST_API_INTEGRATION_DIR. '/blocks/user-list-block/template.php',
            $testee->blockTemplateFile('user-list-block')
        );
        self::assertNull($testee->blockTemplateFile('user-block'));
    }
}
