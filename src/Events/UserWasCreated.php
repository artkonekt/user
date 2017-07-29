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
use Konekt\User\Contracts\User;

class UserWasCreated implements UserEvent
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