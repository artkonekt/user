<?php
/**
 * Contains the UserWasInactivated event class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-29
 *
 */

namespace Konekt\User\Events;

use Konekt\User\Contracts\UserEvent;

class UserWasInactivated implements UserEvent
{
    use HasUser;
}
