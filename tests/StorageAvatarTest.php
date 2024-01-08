<?php

declare(strict_types=1);
/**
 * Contains the StorageAvatarTest class.
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
use Konekt\User\Avatar\StorageAvatar;
use Konekt\User\Contracts\Avatar;
use Konekt\User\Models\Profile;
use Konekt\User\Tests\Factories\ProfileFactory;

class StorageAvatarTest extends TestCase
{
    /** @test */
    public function can_be_created_via_upload()
    {
        $uploadedFile = UploadedFile::fake()->image('test_avatar.jpg', 85, 85);
        $avatar = StorageAvatar::upload($uploadedFile);

        $this->assertInstanceOf(Avatar::class, $avatar);
        $this->assertInstanceOf(StorageAvatar::class, $avatar);
        $this->assertStringStartsWith('avatars/', $avatar->getData());
        $this->assertStringStartsWith('/storage/avatars/', $avatar->getUrl());
        $this->assertStringEndsWith('.jpg', $avatar->getUrl());
    }

    /** @test */
    public function can_be_deleted_and_the_file_disappears()
    {
        $uploadedFile = UploadedFile::fake()->image('willbedeleted.jpg', 100, 100);
        $avatar = StorageAvatar::upload($uploadedFile);
        $fileName = $avatar->getFilename();

        $this->assertTrue(Storage::exists($fileName));

        $avatar->delete();

        $this->assertFalse(Storage::exists($fileName));
    }

    /** @test */
    public function path_can_be_defined_via_config()
    {
        config([StorageAvatar::CONFIG_ROOT_KEY . 'path' => 'profile_pictures']);

        $uploadedFile = UploadedFile::fake()->image('sammy.jpg', 120, 120);
        $avatar = StorageAvatar::upload($uploadedFile);

        $this->assertStringStartsWith('profile_pictures/', $avatar->getData());
        $this->assertStringStartsWith('/storage/profile_pictures/', $avatar->getUrl());
    }

    /** @test */
    public function works_with_the_profile_model()
    {
        /** @var Profile $profile */
        $profile = ProfileFactory::new()->create();
        $uploadedFile = UploadedFile::fake()->image('test_avatar.jpg', 85, 85);
        $avatar = StorageAvatar::upload($uploadedFile);

        $profile->setAvatar($avatar);
        $profile->save();

        $this->assertStringStartsWith('/storage/avatars/', $profile->avatarUrl());
        $this->assertStringEndsWith('.jpg', $profile->avatarUrl());
    }
}
