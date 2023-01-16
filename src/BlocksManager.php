<?php

/**
 * Block Manager Class.
 */

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace Inpsyde\JsonRestApiIntegration;

use WP_Block;

final class BlocksManager
{
    private array $blocksWithTemplate = [];

    public function init(): void
    {
        add_action('init', [ $this, 'registerBlocks' ]);
        add_filter('block_categories_all', [ $this, 'registerBlockCategory' ], 10);
    }

    /**
     * Adding a new (custom) block category.
     *
     * @param array $blockCategories Array of categories for block types.
     *
     * @return array
     */
    public function registerBlockCategory(array $blockCategories): array
    {
        return array_merge(
            $blockCategories,
            [
                [
                    'slug' => 'inpsyde-blocks',
                    'title' => __('Inpsyde Blocks', 'json-rest-api-integration'),
                ],
            ]
        );
    }

    /**
     * Find all blocks living in the "/blocks/" folder in the theme.
     */
    public function findAllBlocks(): array
    {
        $blocks = [];
        try {
            $folders = glob(JsonRestApiIntegration::pathTo('build/blocks/*'), GLOB_ONLYDIR);

            foreach ($folders as $folder) {
                $blocks[] = $folder;
            }
        } catch (\Exception $exception) {
            // handle Exception, maybe log?
        }

        return $blocks;
    }

    /**
     * Register all blocks living in the "/blocks/" folder in the theme.
     */
    public function registerBlocks(): void
    {
        $blocks = $this->findAllBlocks();
        if (! is_iterable($blocks)) {
            return;
        }
        foreach ($blocks as $block) {
            $this->registerBlock($block);
        }
    }

    /**
     * Register Block.
     *
     * @param string $block Block path.
     */
    public function registerBlock(string $block): void
    {
        $blockJsonFile = sprintf('%s/block.json', $block);
        $blockTemplateFile = JsonRestApiIntegration::pathTo(
            sprintf('blocks/%s/template.php', basename($block))
        );

        if (file_exists($blockJsonFile)) {
            $args = [];

            if (file_exists($blockTemplateFile)) {
                $args['render_callback'] = [ $this, 'render' ];
            }

            $type = register_block_type($blockJsonFile, $args);

            if (! empty($type->name)) {
                $this->blocksWithTemplate[ $type->name ] = $blockTemplateFile;
            }
        }
    }

    /**
     * Get the absolute file path to a block template file by its name.
     *
     * @param string $name Block ID.
     *
     * @return string|null
     */
    public function blockTemplateFile(string $name): ?string
    {
        if (isset($this->blocksWithTemplate[ $name ])) {
            return $this->blocksWithTemplate[ $name ];
        }

        return null;
    }

    /**
     * Render Dynamic blocks.
     *
     * @param array    $attributes Block attributes.
     * @param string   $content    Block content.
     * @param WP_Block $block      Block object.
     *
     * @return false|string
     */
    public function render(array $attributes, string $content, WP_Block $block): string|bool
    {
        $template = $this->blockTemplateFile($block->name);

        if (empty($template) || ! file_exists($template)) {
            return false;
        }

        ob_start();

        load_template(
            $template,
            false,
            [
                'attributes' => $attributes,
                'content' => $content,
                'block' => $block,
            ]
        );

        return ob_get_clean();
    }
}
