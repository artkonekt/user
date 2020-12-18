<?php

declare(strict_types=1);

/**
 * Contains the PrependsPizzaToUserNameListener class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-18
 *
 */

namespace Konekt\User\Tests\Dummies;

use Konekt\User\Events\UserIsBeingCreatedFromInvitation;

class PrependsPizzaToUserNameListener
{
    public function handle(UserIsBeingCreatedFromInvitation $event)
    {
        $user = $event->getUser();
        $user->name = 'Pizza ' . $user->name;
    }
}
