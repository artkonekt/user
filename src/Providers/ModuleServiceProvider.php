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
use Konekt\User\Contracts\UserInterface;
use Konekt\User\Models\Entities\User;

class ModuleServiceProvider extends AbstractModuleServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->concord->useModel(UserInterface::class, User::class);
    }


}