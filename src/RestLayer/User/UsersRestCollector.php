<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Inpsyde\JsonRestApiIntegration\RestLayer\User;

use Inpsyde\JsonRestApiIntegration\CacheManager;
use Inpsyde\JsonRestApiIntegration\DataLayer\User\UserDataCollector;
use Inpsyde\JsonRestApiIntegration\RestLayer\ExternalRestCollectorInterface;
use Exception;

/**
 * @package Inpsyde\JsonRestApiIntegration\RestLayer\User
 */
class UsersRestCollector implements ExternalRestCollectorInterface
{
    public const REST__ENDPOINT = 'https://jsonplaceholder.typicode.com/users';

    /**
     * {@inheritdoc}
     */
    public function data(): array
    {
        $data = CacheManager::get('all');
        if (false !== $data) {
            return [ 'users' => $data ];
        }

        $data = [];
        $request = wp_remote_get(self::REST__ENDPOINT);
        if (is_array($request) && ! is_wp_error($request)) {
            try {
                $users = json_decode(wp_remote_retrieve_body($request));
                $data = $this->preparedUsers($users);
            } catch (Exception $ex) {
            }
        }

        CacheManager::set('all', $data, 1800);

        return [ 'users' => $data ];
    }

    /**
     * Prepare Users data.
     *
     * @param array $users Users details.
     *
     * @return array
     */
    public function preparedUsers(array $users): array
    {
        $data = [];
        foreach ($users as $user) {
            $userData = new UserDataCollector($user->id);
            $userData->__set('name', $user->name);
            $userData->__set(
                'avatar',
                'https://avatars.dicebear.com/v2/avataaars/' . $user->username . '.svg'
            );
            $userData->__set('username', $user->username);
            $userData->__set('email', $user->email);
            $data[] = $userData;
        }

        return $data;
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => __('ID', 'json-rest-api-integration'),
            'avatar' => __('Avatar', 'json-rest-api-integration'),
            'name' => __('Name', 'json-rest-api-integration'),
            'username' => __('Username', 'json-rest-api-integration'),
            'email' => __('Email', 'json-rest-api-integration'),
        ];
    }
}
