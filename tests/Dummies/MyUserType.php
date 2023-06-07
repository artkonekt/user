<?php

declare(strict_types=1);
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
    public const __DEFAULT = self::SERVANT;

    public const SERVANT = 'servant';
    public const MASTER = 'master';
}
