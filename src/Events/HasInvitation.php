<?php

declare(strict_types=1);

/**
 * Contains the HasInvitation trait.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-18
 *
 */

namespace Konekt\User\Events;

use Konekt\User\Contracts\Invitation;

trait HasInvitation
{
    /** @var Invitation */
    public $invitation;

    public function getInvitation(): Invitation
    {
        return $this->invitation;
    }
}
