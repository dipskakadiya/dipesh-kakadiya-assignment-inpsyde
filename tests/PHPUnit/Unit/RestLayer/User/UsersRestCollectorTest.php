<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

namespace Inpsyde\JsonRestApiIntegration\Tests\Unit\RestLayer\User;

use Brain\Monkey\Functions;
use Inpsyde\JsonRestApiIntegration\DataLayer\User\UserDataCollector;
use Inpsyde\JsonRestApiIntegration\RestLayer\ExternalRestCollectorInterface;
use Inpsyde\JsonRestApiIntegration\RestLayer\User\UsersRestCollector;
use Inpsyde\JsonRestApiIntegration\Tests\Unit\AbstractTestCase;

/**
 * @package Inpsyde\JsonRestApiIntegration\Tests\Unit\RestLayer\User
 */
class UsersRestCollectorTest extends AbstractTestCase
{
    /**
     * User Json data for testing.
     *
     * @return string
     */
    public static function usersJsonData(): string
    {
        return '[{"id":1,"name":"Leanne Graham","username":"Bret","email":"Sincere@april.biz",
                "address":{"street":"Kulas Light","suite":"Apt. 556","city":"Gwenborough",
                "zipcode":"92998-3874","geo":{"lat":"-37.3159","lng":"81.1496"}},
                "phone":"1-770-736-8031 x56442","website":"hildegard.org","company":
                {"name":"Romaguera-Crona","catchPhrase":"Multi-layered client-server neural-net",
                "bs":"harness real-time e-markets"}},{"id":2,"name":"Ervin Howell","username":
                "Antonette","email":"Shanna@melissa.tv","address":{"street":"Victor Plains",
                "suite":"Suite 879","city":"Wisokyburgh","zipcode":"90566-7771",
                "geo":{"lat":"-43.9509","lng":"-34.4618"}},"phone":"010-692-6593 x09125",
                "website":"anastasia.net","company":{"name":"Deckow-Crist","catchPhrase":
                "Proactive didactic contingency","bs":"synergize scalable supply-chains"}}]';
    }

    /**
     * @test
     */
    public function testBasic(): void
    {
        Functions\stubs([ '__' ]);
        $testee = new UsersRestCollector();

        static::assertInstanceOf(ExternalRestCollectorInterface::class, $testee);
        static::assertSame(UsersRestCollector::REST__ENDPOINT, $testee::REST__ENDPOINT);
        static::assertIsArray($testee->fields());
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
            'wp_remote_retrieve_body'=> self::usersJsonData(),
            '__',
        ]);
        $testee = new UsersRestCollector();
        $usersData = $testee->data();
        static::assertIsArray($usersData);
        static::assertArrayHasKey('users', $usersData);
        static::assertInstanceOf(UserDataCollector::class, $usersData['users'][0]);
        static::assertEquals(1, $usersData['users'][0]->__get('id'));
        static::assertEquals('Leanne Graham', $usersData['users'][0]->__get('name'));
        static::assertEquals('Bret', $usersData['users'][0]->__get('username'));
        static::assertEquals('Sincere@april.biz', $usersData['users'][0]->__get('email'));
        static::assertEquals(
            'https://avatars.dicebear.com/v2/avataaars/Bret.svg',
            $usersData['users'][0]->__get('avatar')
        );

        // Cache result test case.
        Functions\stubs([
            'wp_cache_get'=> static function (): mixed {
                $user = new UserDataCollector(1);
                $user->__set('name', 'Loren Stash');
                $user->__set('username', 'Lorn');
                return [
                    $user,
                ];
            },
        ]);
        $usersData = $testee->data();
        static::assertIsArray($usersData);
        static::assertInstanceOf(UserDataCollector::class, $usersData['users'][0]);
        static::assertEquals('Loren Stash', $usersData['users'][0]->__get('name'));
        static::assertEquals('Lorn', $usersData['users'][0]->__get('username'));
    }

    /**
     * @test
     */
    public function testPreparedUsers(): void
    {
        $testee = new UsersRestCollector();
        $users = json_decode(self::usersJsonData());
        $usersData = $testee->preparedUsers($users);
        static::assertIsArray($usersData);
        static::assertInstanceOf(UserDataCollector::class, $usersData[0]);
        static::assertEquals(1, $usersData[0]->__get('id'));
        static::assertEquals('Leanne Graham', $usersData[0]->__get('name'));
        static::assertEquals('Bret', $usersData[0]->__get('username'));
        static::assertEquals('Sincere@april.biz', $usersData[0]->__get('email'));
        static::assertEquals(
            'https://avatars.dicebear.com/v2/avataaars/Bret.svg',
            $usersData[0]->__get('avatar')
        );
    }

    /**
     * @test
     */
    public function testFields(): void
    {
        Functions\stubs([ '__' ]);
        $testee = new UsersRestCollector();
        $fields = $testee->fields();
        static::assertIsArray($fields);
        static::assertArrayHasKey('id', $fields);
        static::assertArrayHasKey('name', $fields);
        static::assertArrayHasKey('username', $fields);
    }
}
