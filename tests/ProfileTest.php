<?php
/**
 * Contains the ProfileTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-11-18
 *
 */

namespace Konekt\User\Tests;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Konekt\Address\Models\Person;
use Konekt\User\Avatar\StorageAvatar;
use Konekt\User\AvatarTypes;
use Konekt\User\Contracts\Profile as ProfileContract;
use Konekt\User\Models\Profile;
use Konekt\User\Models\User;
use Konekt\User\Tests\Dummies\DummyAvatar;

class ProfileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        AvatarTypes::register('dummy', DummyAvatar::class);
    }

    /** @test */
    public function it_can_be_created()
    {
        $user   = factory(User::class)->create();
        $person = factory(Person::class)->create();

        $profile = Profile::create([
            'user_id'   => $user->id,
            'person_id' => $person->id
        ]);

        $this->assertInstanceOf(Profile::class, $profile);
        $this->assertInstanceOf(ProfileContract::class, $profile);
    }

    /** @test */
    public function arbitrary_avatar_type_can_be_assigned_to_it()
    {
        $profile = factory(Profile::class)->create();
        $profile->setAvatar(DummyAvatar::create('helloafrica'));

        $this->assertTrue($profile->hasAvatar());
        $this->assertEquals('dummy', $profile->avatar_type);
        $this->assertEquals('helloafrica', $profile->avatar_data);
        $this->assertEquals('http://localhost/helloafrica.jpg', $profile->avatarUrl());
        $this->assertEquals('http://localhost/dralban_helloafrica.jpg', $profile->avatarUrl('dralban'));
    }

    /** @test */
    public function avatar_can_be_removed()
    {
        $profile = factory(Profile::class)->create();
        $profile->setAvatar(DummyAvatar::create('hellomotherland'));
        $profile->save();

        $this->assertTrue($profile->hasAvatar());

        $profile->removeAvatar();
        $profile->save();

        $this->assertNull($profile->avatar_data);
        $this->assertNull($profile->avatar_type);
        $this->assertNull($profile->avatarUrl());
        $this->assertNull($profile->avatarUrl('tell_me_how_youre_doing'));
    }

    /** @test */
    public function removing_an_avatar_invokes_the_delete_function_of_the_avatar_type()
    {
        $profile      = factory(Profile::class)->create();
        $uploadedFile = UploadedFile::fake()->image('horse.jpg', 85, 85);
        $profile->setAvatar(StorageAvatar::upload($uploadedFile));
        $profile->save();

        $filename = $profile->getAvatar()->getFilename();

        $this->assertTrue($profile->hasAvatar());
        $this->assertTrue(Storage::exists($filename));

        $profile->removeAvatar();
        $profile->save();

        $this->assertFalse(Storage::exists($filename));
    }
}
