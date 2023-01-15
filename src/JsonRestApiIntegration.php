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
    private UserPageBuilder $userPageBuilder;

    /**
     * WpStash constructor.
     */
    private function __construct()
    {
        $this->userPageBuilder = new UserPageBuilder();
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
        register_activation_hook(__DIR__ . 'json-rest-api-integration.php', function () {
            $this->userPageBuilder->registerPage();
            flush_rewrite_rules();
        });

        $this->userPageBuilder->init();
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
