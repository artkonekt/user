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

/**
 * @method static UserType ADMIN()
 * @method static UserType CLIENT()
 * @method static UserType API()
 *
 * @method bool isAdmin()
 * @method bool isClient()
 * @method bool isApi()
 *
 * @property-read bool $is_admin
 * @property-read bool $is_client
 * @property-read bool $is_api
 */
class UserType extends Enum implements UserTypeContract
{
    const __DEFAULT = self::CLIENT;

    const ADMIN     = 'admin';
    const CLIENT    = 'client';
    const API       = 'api';
}
