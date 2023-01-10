<?php
/**
 * Contains the ModuleServiceProvider class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-11-30
 *
 */

namespace Konekt\User\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use Konekt\User\Models\Invitation;
use Konekt\User\Models\Profile;
use Konekt\User\Models\User;
use Konekt\User\Models\UserType;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    /** @var array */
    protected $models = [
        User::class,
        Profile::class,
        Invitation::class,
    ];

    /** @var array */
    protected $enums = [
        UserType::class
    ];
}
