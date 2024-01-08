<?php

declare(strict_types=1);
/**
 * Contains the UserEventsTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-31
 *
 */

namespace Konekt\User\Tests;

use Illuminate\Support\Facades\Event;
use Konekt\User\Events\UserWasCreated;
use Konekt\User\Events\UserWasDeleted;
use Konekt\User\Events\UserWasInactivated;
use Konekt\User\Tests\Factories\UserFactory;

class UserEventsTest extends TestCase
{
    /**
     * Disabled since Eloquent lifecycle event detection is not working properly
     * @dont_test
     */
    public function creating_a_user_fires_user_was_created_event()
    {
        $this->expectsEvents(UserWasCreated::class);

        UserFactory::new()->create();
    }

    /**
     * @test
     */
    public function inactivating_a_user_fires_user_was_inactivated_event()
    {
        Event::fake();

        $user = UserFactory::new()->create();
        $user->inactivate();

        Event::assertDispatched(UserWasInactivated::class);
    }

    /**
     * Disabled since Eloquent lifecycle event detection is not working properly
     *
     * @dont_test
     */
    public function deleting_a_user_fires_user_was_deleted_event()
    {
        $this->expectsEvents([
            UserWasCreated::class,
            UserWasDeleted::class
        ]);

        $user = UserFactory::new()->create();

        $user->delete();
    }
}
