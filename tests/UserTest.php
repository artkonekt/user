<?php
/**
 * Contains the UserTest class.
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

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function type_field_is_an_enum()
    {
        $admin = factory(User::class)->create(['type' => UserType::ADMIN]);

        $this->assertInstanceOf(UserTypeContract::class, $admin->type);
        $this->assertInstanceOf(Enum::class, $admin->type);
    }
}
