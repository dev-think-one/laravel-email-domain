<?php

namespace EmailDomain\Tests;

use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        array_map('unlink', glob(__DIR__ . '/../vendor/orchestra/testbench-core/laravel/database/migrations/*.php'));
        array_map(function ($f) {
            File::copy($f, __DIR__ . '/../vendor/orchestra/testbench-core/laravel/database/migrations/' . basename($f));
        }, glob(__DIR__ . '/Fixtures/migrations/*.php'));


        $this->artisan('migrate', [ '--database' => 'testbench' ]);

        $this->artisan('vendor:publish', [
            '--provider' => "EmailDomain\ServiceProvider",
            '--force'    => true,
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            \EmailDomain\ServiceProvider::class,
        ];
    }

    public function defineEnvironment($app)
    {
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // $app['config']->set('email-domain.some_key', 'some_value');
    }
}
