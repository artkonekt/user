<?php

declare(strict_types=1);

/**
 * Contains the UserTest class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-18
 *
 */

namespace Konekt\User\Tests;

use Konekt\User\Models\Profile;
use Konekt\User\Models\User;
use Konekt\User\Tests\Factories\PersonFactory;
use Konekt\User\Tests\Factories\UserFactory;

class UserTest extends TestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $user = User::create([
            'email' => 'zodiac@signs.oh',
            'name' => 'Taurus',
            'password' => 'meow'
        ]);

        $this->assertInstanceOf(User::class, $user);
    }

    /** @test */
    public function it_can_have_a_profile()
    {
        $user = UserFactory::new()->create();
        $person = PersonFactory::new()->create([
            'firstname' => 'Fritz',
            'lastname' => 'Teufel',
        ]);

        $user->profile()->create([
            'user_id' => $user->id,
            'person_id' => $person->id
        ]);

        $this->assertInstanceOf(Profile::class, $user->profile);
        $this->assertEquals('Fritz', $user->profile->person->firstname);
        $this->assertEquals('Teufel', $user->profile->person->lastname);
    }
}
