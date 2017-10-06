<?php
/**
 * Contains the FieldsTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-06
 *
 */


namespace Konekt\User\Tests;


use Konekt\User\Contracts\UserType as UserTypeContract;
use Konekt\User\Models\User;
use Konekt\User\Models\UserType;

class FieldsTest extends TestCase
{
    /**
     * @test
     */
    public function type_field_should_be_an_enum()
    {
        $admin = User::create([
            'name'     => 'The Big Dick',
            'email'    => 'really@big.dick',
            'password' => bcrypt('123456_is_the_best_password'),
            'type'     => UserType::ADMIN
        ]);

        $this->assertInstanceOf(UserTypeContract::class, $admin->type);
    }

}