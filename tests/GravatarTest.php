<?php

declare(strict_types=1);
/**
 * Contains the GravatarTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-11-18
 *
 */

namespace Konekt\User\Tests;

use Konekt\User\Avatar\Gravatar;
use Konekt\User\Contracts\Avatar;
use Konekt\User\Models\Profile;
use Konekt\User\Tests\Factories\ProfileFactory;

class GravatarTest extends TestCase
{
    /** @test */
    public function can_be_created_with_email_address()
    {
        $avatar = Gravatar::create('user@example.com');

        $this->assertInstanceOf(Avatar::class, $avatar);
        $this->assertInstanceOf(Gravatar::class, $avatar);
        $this->assertEquals('user@example.com', $avatar->getData());
        $this->assertStringStartsWith('https://www.gravatar.com/', $avatar->getUrl());
        $this->assertStringContainsString(md5('user@example.com'), $avatar->getUrl());
    }

    /** @test */
    public function works_with_the_profile_model()
    {
        /** @var Profile $profile */
        $profile = ProfileFactory::new()->create();
        // This sucks like hell, email should be taken from user/profile and not hardcoded like this
        $avatar = Gravatar::create('user@example.com');

        $profile->setAvatar($avatar);
        $profile->save();

        $this->assertEquals('user@example.com', $profile->avatar_data);
        $this->assertEquals('gravatar', $profile->avatar_type);
        $this->assertStringStartsWith('https://www.gravatar.com/', $profile->avatarUrl());
        $this->assertStringContainsString(md5('user@example.com'), $profile->avatarUrl());
    }
}
