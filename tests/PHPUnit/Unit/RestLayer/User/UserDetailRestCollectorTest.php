<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Inpsyde\JsonRestApiIntegration\Tests\Unit\RestLayer\User;

use Brain\Monkey\Functions;
use Inpsyde\JsonRestApiIntegration\DataLayer\User\UserDataCollector;
use Inpsyde\JsonRestApiIntegration\RestLayer\RestCollectorInterface;
use Inpsyde\JsonRestApiIntegration\RestLayer\ExternalRestCollectorInterface;
use Inpsyde\JsonRestApiIntegration\RestLayer\User\UserDetailRestCollector;
use Inpsyde\JsonRestApiIntegration\Tests\Unit\AbstractTestCase;

/**
 * @package Inpsyde\JsonRestApiIntegration\Tests\Unit\RestLayer\User
 */
class UserDetailRestCollectorTest extends AbstractTestCase
{
    /**
     * User Json data for testing.
     *
     * @return string
     */
    public static function userJsonData(): string
    {
        return '{"id":1,"name":"Leanne Graham","username":"Bret","email":"Sincere@april.biz",
                "address":{"street":"Kulas Light","suite":"Apt. 556","city":"Gwenborough",
                "zipcode":"92998-3874","geo":{"lat":"-37.3159","lng":"81.1496"}},
                "phone":"1-770-736-8031 x56442","website":"hildegard.org","company":
                {"name":"Romaguera-Crona","catchPhrase":"Multi-layered client-server neural-net",
                "bs":"harness real-time e-markets"}}';
    }

    /**
     * @test
     */
    public function testBasic(): void
    {
        Functions\stubs([ '__' ]);
        $testee = new UserDetailRestCollector();

        static::assertInstanceOf(RestCollectorInterface::class, $testee);
        static::assertInstanceOf(ExternalRestCollectorInterface::class, $testee);
        static::assertSame(UserDetailRestCollector::REST__ENDPOINT, $testee::REST__ENDPOINT);
    }

    /**
     * @test
     */
    public function testRegister(): void
    {
        $testee = new UserDetailRestCollector();
        $testee->register();
        self::assertNotFalse(has_action('rest_api_init', [ $testee, 'registerRestRoute' ]));
    }

    /**
     * @test
     */
    public function testData(): void
    {
        Functions\stubs([
            'wp_remote_get'=> static function (): array {
                return [
                    'method' => 'GET',
                    'httpversion' => '1.0',
                    'user-agent' => 'WordPress',
                    'headers' => [],
                    'body' => null,
                ];
            },
            'wp_cache_get'=> static function (): mixed {
                return false;
            },
            'wp_cache_set'=> static function (): bool {
                return true;
            },
            'wp_remote_retrieve_body'=> self::userJsonData(),
            '__',
        ]);
        $testee = new UserDetailRestCollector();
        $userData = $testee->data(1);
        static::assertIsArray($userData);
        static::assertEquals(1, $userData['id']);
        static::assertEquals('Leanne Graham', $userData['name']);
        static::assertEquals('Bret', $userData['username']);
        static::assertEquals('Sincere@april.biz', $userData['email']);
        static::assertEquals('1-770-736-8031 x56442', $userData['phone']);
        static::assertEquals('hildegard.org', $userData['website']);
        static::assertEquals(
            'Kulas Light, Gwenborough, Apt. 556, 92998-3874',
            $userData['address']
        );
        static::assertEquals(
            'Romaguera-Crona, Multi-layered client-server neural-net, harness real-time e-markets',
            $userData['company']
        );
        static::assertEquals(
            'https://avatars.dicebear.com/v2/avataaars/Bret.svg',
            $userData['avatar']
        );

        // Cache result test case.
        Functions\stubs([
            'wp_cache_get'=> static function (): mixed {
                return [
                    'name' => 'Loren Stash',
                    'username' => 'Lorn',
                ];
            },
        ]);
        $userData = $testee->data(1);
        static::assertIsArray($userData);
        static::assertEquals('Loren Stash', $userData['name']);
        static::assertEquals('Lorn', $userData['username']);
    }

    /**
     * @test
     */
    public function testPreparedUser(): void
    {
        $testee = new UserDetailRestCollector();
        $user = json_decode(self::userJsonData());
        $userData = $testee->preparedUser($user);
        static::assertInstanceOf(UserDataCollector::class, $userData);
        static::assertEquals(1, $userData->__get('id'));
        static::assertEquals('Leanne Graham', $userData->__get('name'));
        static::assertEquals('Bret', $userData->__get('username'));
        static::assertEquals('Sincere@april.biz', $userData->__get('email'));
        static::assertEquals('1-770-736-8031 x56442', $userData->__get('phone'));
        static::assertEquals('hildegard.org', $userData->__get('website'));
        static::assertEquals(
            'Kulas Light, Gwenborough, Apt. 556, 92998-3874',
            $userData->__get('address')
        );
        static::assertEquals(
            'Romaguera-Crona, Multi-layered client-server neural-net, harness real-time e-markets',
            $userData->__get('company')
        );
        static::assertEquals(
            'https://avatars.dicebear.com/v2/avataaars/Bret.svg',
            $userData->__get('avatar')
        );
    }
}
