<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace Inpsyde\JsonRestApiIntegration;

/**
 * Class JsonRestApiIntegration
 *
 * @package Inpsyde\JsonRestApiIntegration
 */
final class JsonRestApiIntegration
{
    /**
     * WpStash constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return JsonRestApiIntegration
     */
    public static function instance(): self
    {
        static $instance;
        if (! $instance) {
            $instance = new self();
            $instance->init();
        }

        return $instance;
    }

    /**
     * @return void
     */
    public function init(): void
    {
    }

    /**
     * Get the absolute path to the asset file.
     *
     * @param string $pathRelative Path relative to this plugin directory root.
     *
     * @return string Absolute path to the file.
     */
    public static function pathTo(string $pathRelative): string
    {
        return sprintf('%s/%s', JSON_REST_API_INTEGRATION_DIR, ltrim($pathRelative, '/\\'));
    }
}
