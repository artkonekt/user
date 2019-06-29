<?php
/**
 * Contains the HasUser trait.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-11-18
 *
 */

namespace Konekt\User\Events;

use Konekt\User\Contracts\User;

trait HasUser
{
    /** @var  User */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @inheritDoc
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
