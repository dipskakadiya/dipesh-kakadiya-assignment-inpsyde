<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Inpsyde\JsonRestApiIntegration\DataLayer\User;

/**
 * @package Inpsyde\JsonRestApiIntegration\DataLayer\User
 */
class UserDataCollector
{
    private int $id;

    /**
     * @param int $id
     */
    public function __construct(int $id = 0)
    {
        $this->id = $id;
    }

    public function __get(mixed $name)
    {
        return $this->$name;
    }

    public function __set(string $name, mixed $value)
    {
        $this->$name = $value;
    }
}
