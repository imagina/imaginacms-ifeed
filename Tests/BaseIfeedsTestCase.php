<?php

namespace Modules\Ifeeds\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Ifeeds\Providers\IfeedsServiceProvider;
use Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider;

abstract class BaseIfeedsTestCase extends TestCase
{

  public function setUp()
  {
    parent::setUp();
    //$this->resetDatabase();
  }
  
  protected function getPackageProviders($app)
  {
    return [
      LaravelLocalizationServiceProvider::class,
      IfeedsServiceProvider::class
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    $app['path.base'] = __DIR__ . '/..';
    $app['config']->set('database.default', 'sqlite');
    $app['config']->set('database.connections.sqlite', array(
      'driver' => 'sqlite',
      'database' => ':memory:',
      'prefix' => '',
    ));
    $app['config']->set('translatable.locales', ['en', 'es']);
  }

  private function resetDatabase()
  {
    // Makes sure the migrations table is created
    $this->artisan('migrate', [
      '--database' => 'sqlite',
    ]);
    // We empty all tables
    $this->artisan('migrate:reset', [
      '--database' => 'sqlite',
    ]);
    // Migrate
    $this->artisan('migrate', [
      '--database' => 'sqlite',
    ]);
    $this->artisan('migrate', [
      '--database' => 'sqlite',
      '--path'     => 'Modules/Media/Database/Migrations',
    ]);
  }

}
