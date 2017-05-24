<?php
/**
 * Contains the UserType enum class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-18
 *
 */


namespace Konekt\User\Models;


use Konekt\Enum\Enum;
use Konekt\User\Contracts\UserType as UserTypeContract;

class UserType extends Enum implements UserTypeContract
{
    const __default = self::CLIENT;

    const ADMIN     = 'admin';
    const CLIENT    = 'client';

}