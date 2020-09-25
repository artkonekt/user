<?php
/**
 * Contains the MyUserType class.
 *
 * @copyright   Copyright (c) 2019 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2019-06-30
 *
 */

namespace Konekt\User\Tests\Dummies;

use Konekt\Enum\Enum;
use Konekt\User\Contracts\UserType;

class MyUserType extends Enum implements UserType
{
    const __DEFAULT = self::SERVANT;

    const SERVANT = 'servant';
    const MASTER  = 'master';
}
