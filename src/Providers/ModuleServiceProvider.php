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
use Konekt\User\Models\Profile;
use Konekt\User\Models\User;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    /** @var array */
    protected $models = [
        User::class,
        Profile::class
    ];


}