<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Inpsyde\JsonRestApiIntegration\RestLayer;

/**
 * @package Inpsyde\JsonRestApiIntegration\RestLayer
 */
interface RestCollectorInterface
{
    public const NAMESPACE = 'json_rest/v1';

    /**
     * Returns an array with all data fetch from external endpoint into the dataLayer.
     */
    public function register(): void;
}
