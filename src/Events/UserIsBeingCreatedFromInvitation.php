<?php

declare(strict_types=1);

/**
 * Contains the UserIsBeingCreatedFromInvitation class.
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
use Konekt\User\Contracts\User;
use Konekt\User\Contracts\UserEvent;

class UserIsBeingCreatedFromInvitation implements InvitationEvent, UserEvent
{
    use HasInvitation;

    /** @var User */
    public $user;

    public function __construct(Invitation $invitation, User $user)
    {
        $this->invitation = $invitation;
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
