<?php

declare(strict_types=1);

/**
 * Contains the InvitationEvent interface.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-18
 *
 */

namespace Konekt\User\Contracts;

interface InvitationEvent
{
    public function getInvitation(): Invitation;
}
