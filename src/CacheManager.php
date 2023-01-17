<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace Inpsyde\JsonRestApiIntegration;

/**
 * Class CacheManager
 *
 * @package Inpsyde\JsonRestApiIntegration
 */
final class CacheManager
{
    private static string $prefix = 'user-data-';
    private static string $group = 'userdata';
    private static int $defaultExpireTime = 300;

    /**
     * Get Cache.
     *
     * @param string $name Cache name.
     *
     * @return mixed
     */
    public static function get(string $name): mixed
    {
        return wp_cache_get(self::$prefix . $name, self::$group);
    }

    /**
     * Set Cache.
     *
     * @param string   $name   Cache name.
     * @param mixed    $data   Cache data.
     * @param int|null $expire Cache Time.
     *
     * @return bool
     */
    public static function set(string $name, mixed $data, int $expire = null): bool
    {
        return wp_cache_set(self::$prefix . $name, $data, self::$group, $expire??self::$defaultExpireTime);
    }
}
