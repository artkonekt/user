<?php
/**
 * Contains the TestCase class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-30
 *
 */

namespace Konekt\User\Tests;

use Faker\Generator;
use Konekt\Address\Providers\ModuleServiceProvider as AddressModule;
use Konekt\User\Providers\ModuleServiceProvider as UserModule;
use Konekt\Concord\ConcordServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /** @var Generator */
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/factories');
        $this->setUpDatabase($this->app);
        $this->faker = \Faker\Factory::create();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ConcordServiceProvider::class
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {

//        $app['config']->set('database.default', 'sqlite');
//        $app['config']->set('database.connections.sqlite', [
//            'driver'   => 'sqlite',
//            'database' => ':memory:',
//            'prefix'   => '',
//        ]);
        $app['config']->set('database.default', 'mysql');
        $app['config']->set('database.connections.mysql', [
            'driver'   => 'mysql',
            'database' => 'user_test',
            'host' => 'localhost',
            'username'   => env('TEST_DB_USERNAME', 'root'),
            'password'   => env('TEST_DB_PASSWORD', ''),
        ]);
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        \Artisan::call('migrate:reset');
        $this->loadLaravelMigrations();
        \Artisan::call('migrate', ['--force' => true]);
    }

    /**
     * @inheritdoc
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);
        $app['config']->set('concord.modules', [
            AddressModule::class,
            UserModule::class
        ]);
    }
}
