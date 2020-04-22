<?php


namespace Modules\Ifeeds\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Ifeeds\Support\Rss;

class RssServiceProvider extends ServiceProvider
{

  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->app->singleton('rss',function(){
      return new Rss();
    });
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return [];
  }
}