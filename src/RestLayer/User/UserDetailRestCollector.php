<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Inpsyde\JsonRestApiIntegration\RestLayer\User;

use Inpsyde\JsonRestApiIntegration\DataLayer\User\UserDataCollector;
use Inpsyde\JsonRestApiIntegration\RestLayer\ExternalRestCollectorInterface;
use Inpsyde\JsonRestApiIntegration\RestLayer\RestCollectorInterface;
use WP_REST_Request;
use WP_REST_Server;
use WP_REST_Response;
use WP_Error;
use Exception;

/**
 * @package Inpsyde\JsonRestApiIntegration\RestLayer\User
 */
class UserDetailRestCollector implements RestCollectorInterface, ExternalRestCollectorInterface
{
    public const REST__ENDPOINT = 'https://jsonplaceholder.typicode.com/users';

    public function register(): void
    {
        add_action('rest_api_init', [ $this, 'registerRestRoute' ]);
    }

    public function registerRestRoute(): void
    {
        register_rest_route(self::NAMESPACE, '/user-detail/(?P<id>[\d]+)', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [ $this, 'userDetailItem' ],
            'permission_callback' => [ $this, 'userDetailPermissionsCheck' ],
            'args' => [
                'id' => [
                    'description' => __('Unique identifier for User.', 'json-rest-api-integration'),
                    'type' => 'integer',
                ],
            ],
        ]);
    }

    /**
     * Checks if a given request can perform post processing on an attachment.
     *
     * @param WP_REST_Request $request Full details about the request.
     *
     * @return bool True if the request has access to update the item.
     */
    public function userDetailPermissionsCheck(WP_REST_Request $request): bool
    {
        return true;
    }

    /**
     * Prepare User details request response.
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, WP_Error object on failure.
     */
    public function userDetailItem(WP_REST_Request $request): WP_REST_Response | WP_Error
    {
        $data = $this->data($request['id']);

        return rest_ensure_response($data);
    }

    /**
     * {@inheritdoc}
     */
    public function data(int $userId = 0): array
    {
        $data = [];

        if (empty($userId)) {
            return $data;
        }

        $request = wp_remote_get(self::REST__ENDPOINT . '/' . $userId);
        if (is_array($request) && ! is_wp_error($request)) {
            try {
                $user = json_decode(wp_remote_retrieve_body($request));
                $data = $this->preparedUser($user);
                $data = json_decode(json_encode($data), true);
            } catch (Exception $ex) {
            }
        }

        return $data;
    }

    /**
     * Prepare User data.
     *
     * @param object $user User details.
     *
     * @return UserDataCollector
     */
    public function preparedUser(object $user): UserDataCollector
    {
        $userData = new UserDataCollector($user->id);
        $userData->__set('name', $user->name);
        $userData->__set(
            'avatar',
            'https://avatars.dicebear.com/v2/avataaars/' . $user->username . '.svg'
        );
        $userData->__set('username', $user->username);
        $userData->__set('email', $user->email);
        $userData->__set(
            'address',
            $user->address->street . ', ' . $user->address->city .
            ', ' . $user->address->suite . ', ' . $user->address->zipcode
        );
        $userData->__set('phone', $user->phone);
        $userData->__set(
            'company',
            $user->company->name . ', ' . $user->company->catchPhrase .
            ', ' .  $user->company->bs
        );
        $userData->__set('website', $user->website);

        return $userData;
    }
}
