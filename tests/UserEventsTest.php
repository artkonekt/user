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
use Konekt\User\Models\UserProxy;

class UserEventsTest extends TestCase
{

    /**
     * Disabled since Eloquent lifecycle event detection is not working properly
     */
    public function notestCreateEvent()
    {
        $this->expectsEvents(UserWasCreated::class);

        UserProxy::create([
            'email'    => 'whatever@vanilo.io',
            'name'     => 'Miny Moe',
            'password' => bcrypt('easy')
        ]);
    }

    public function testInactivateEvent()
    {
        $this->expectsEvents(UserWasInactivated::class);

        $user = UserProxy::create([
            'email'    => 'whatever@vanilo.io',
            'name'     => 'Miny Moe',
            'password' => bcrypt('easy')
        ]);

        $user->inactivate();
    }

    /**
     * Disabled since Eloquent lifecycle event detection is not working properly
     */
    public function notestDeletedEvent()
    {
        $this->expectsEvents([
            UserWasCreated::class,
            UserWasDeleted::class
        ]);

        $user = UserProxy::create([
            'email'    => 'whatever@vanilo.io',
            'name'     => 'Miny Moe',
            'password' => bcrypt('easy')
        ])->fresh();

        $user->delete();
    }

}