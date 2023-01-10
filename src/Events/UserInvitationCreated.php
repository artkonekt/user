<?php

declare(strict_types=1);

/**
 * Contains the UserInvitationCreated class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-18
 *
 */

namespace Konekt\User\Events;

use Konekt\User\Contracts\Invitation;
use Konekt\User\Contracts\InvitationEvent;

class UserInvitationCreated implements InvitationEvent
{
    use HasInvitation;

    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }
}
