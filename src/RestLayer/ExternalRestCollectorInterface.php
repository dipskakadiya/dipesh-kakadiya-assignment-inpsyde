<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Inpsyde\JsonRestApiIntegration\RestLayer;

/**
 * @package Inpsyde\JsonRestApiIntegration\RestLayer
 */
interface ExternalRestCollectorInterface
{
    /**
     * Returns an array with all data fetch from external endpoint into the dataLayer.
     *
     * @return array
     */
    public function data(): array;
}
