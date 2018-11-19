<?php
/**
 * Contains the Profile interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-04-08
 *
 */

namespace Konekt\User\Contracts;

interface Profile extends HasAvatar
{
    public function getUser(): User;
}
