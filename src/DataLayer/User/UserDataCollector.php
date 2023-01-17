<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Inpsyde\JsonRestApiIntegration\DataLayer\User;

use Exception;

/**
 * @package Inpsyde\JsonRestApiIntegration\DataLayer\User
 */
class UserDataCollector
{
    public int $id;
    public string $name;
    public string $avatar;
    public string $username;
    public string $email;
    public string $address;
    public mixed $phone;
    public string $company;
    public string $website;

    /**
     * @param int $id
     */
    public function __construct(int $id = 0)
    {
        $this->id = $id;
    }

    /**
     * @throws Exception
     */
    public function __get(mixed $name): mixed
    {
        if (! isset($this->$name)) {
            throw new Exception("$name attribute is not found in class.");
        }

        return $this->$name;
    }

    public function __set(string $name, mixed $value)
    {
        $this->$name = $value;
    }
}
