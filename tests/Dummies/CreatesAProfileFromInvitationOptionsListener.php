<?php

declare(strict_types=1);

/**
 * Contains the CreatesAProfileFromInvitationOptionsListener class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-18
 *
 */

namespace Konekt\User\Tests\Dummies;

use Konekt\Address\Models\Person;
use Konekt\User\Events\UserInvitationUtilized;

class CreatesAProfileFromInvitationOptionsListener
{
    public function handle(UserInvitationUtilized $event)
    {
        $user = $event->getUser();
        $invitation = $event->getInvitation();
        $person = Person::create([
            'firstname' => $invitation->options['firstname'],
            'lastname' => $invitation->options['lastname'],
        ]);

        $user->profile()->create(['person_id' => $person->id]);
    }
}
