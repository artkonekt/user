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


use Konekt\Concord\AbstractModuleServiceProvider;
use Konekt\User\Models\Profile;
use Konekt\User\Models\ProfileRepository;
use Konekt\User\Models\User;
use Konekt\User\Models\UserRepository;

class ModuleServiceProvider extends AbstractModuleServiceProvider
{
    public function register()
    {
        parent::register();

        UserRepository::useModelClass(User::class);
        ProfileRepository::useModelClass(Profile::class);
    }


}