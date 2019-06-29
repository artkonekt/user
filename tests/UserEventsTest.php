<?php
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

use Konekt\User\Events\UserWasCreated;
use Konekt\User\Events\UserWasDeleted;
use Konekt\User\Events\UserWasInactivated;
use Konekt\User\Models\User;

class UserEventsTest extends TestCase
{
    /**
     * Disabled since Eloquent lifecycle event detection is not working properly
     * @dont_test
     */
    public function creating_a_user_fires_user_was_created_event()
    {
        $this->expectsEvents(UserWasCreated::class);

        factory(User::class)->create();
    }

    /**
     * @test
     */
    public function inactivating_a_user_fires_user_was_inactivated_event()
    {
        $this->expectsEvents(UserWasInactivated::class);

        $user = factory(User::class)->create();

        $user->inactivate();
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

        $user = factory(User::class)->create();

        $user->delete();
    }
}
