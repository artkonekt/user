<?php

declare(strict_types=1);
/**
 * Contains the UserWasDeleted event class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-30
 *
 */

namespace Konekt\User\Events;

use Konekt\User\Contracts\UserEvent;

class UserWasDeleted implements UserEvent
{
    use HasUser;
}
