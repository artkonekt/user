<?php
/**
 * Contains the UserWasCreated event class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-29
 *
 */

namespace Konekt\User\Events;

use Konekt\User\Contracts\UserEvent;

class UserWasCreated implements UserEvent
{
    use HasUser;
}
