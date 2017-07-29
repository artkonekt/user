<?php
/**
 * Contains the UserEvent interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-29
 *
 */


namespace Konekt\User\Contracts;

interface UserEvent
{
    /**
     * Return the user associated with the event
     *
     * @return User
     */
    public function getUser() : User;

}