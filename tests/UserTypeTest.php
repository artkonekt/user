<?php

declare(strict_types=1);
/**
 * Contains the UserTypeTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-06
 *
 */

namespace Konekt\User\Tests;

use Konekt\Enum\Enum;
use Konekt\User\Contracts\UserType as UserTypeContract;
use Konekt\User\Models\User;
use Konekt\User\Models\UserType;
use Konekt\User\Tests\Dummies\MyUserType;
use Konekt\User\Tests\Factories\UserFactory;
use UnexpectedValueException;

class UserTypeTest extends TestCase
{
    /** @test */
    public function type_field_is_an_enum()
    {
        $admin = UserFactory::new()->create(['type' => UserType::ADMIN]);

        $this->assertInstanceOf(UserTypeContract::class, $admin->type);
        $this->assertInstanceOf(Enum::class, $admin->type);
    }

    /** @test */
    public function type_can_be_client()
    {
        $client = UserFactory::new()->create(['type' => 'client']);

        $this->assertTrue($client->type->equals(UserType::CLIENT()));
    }

    /** @test */
    public function type_can_be_admin()
    {
        $client = UserFactory::new()->create(['type' => 'admin']);

        $this->assertTrue($client->type->equals(UserType::ADMIN()));
    }

    /** @test */
    public function type_can_be_api()
    {
        $client = UserFactory::new()->create(['type' => 'api']);

        $this->assertTrue($client->type->equals(UserType::API()));
    }

    /** @test */
    public function type_can_not_be_a_non_enum()
    {
        $this->expectException(UnexpectedValueException::class);

        UserFactory::new()->create(['type' => 'mastergetzi']);
    }

    /** @test */
    public function custom_user_type_class_can_be_used()
    {
        $this->app['concord']->registerEnum(
            UserTypeContract::class,
            MyUserType::class
        );

        $default = UserFactory::new()->create();
        $master = UserFactory::new()->create(['type' => 'master']);
        $servant = UserFactory::new()->create(['type' => 'servant']);

        $this->assertEquals(MyUserType::defaultValue(), $default->type->value());
        $this->assertTrue($master->type->equals(MyUserType::MASTER()));
        $this->assertTrue($servant->type->equals(MyUserType::SERVANT()));
    }

    /** @test */
    public function custom_user_type_does_not_accept_values_outside_of_their_range()
    {
        $this->expectException(UnexpectedValueException::class);

        $this->app['concord']->registerEnum(
            UserTypeContract::class,
            MyUserType::class
        );

        UserFactory::new()->create(['type' => 'client']);
    }
}
