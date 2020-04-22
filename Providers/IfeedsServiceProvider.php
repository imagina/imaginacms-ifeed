<?php

namespace Modules\Ifeeds\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Ifeeds\Events\Handlers\RegisterIfeedsSidebar;

class IfeedsServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
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
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIfeedsSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {

            $event->load('sources', array_dot(trans('ifeeds::sources')));
            // append translations


        });
    }

    public function boot()
    {
        $this->publishConfig('ifeeds', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Ifeeds\Repositories\SourceRepository',
            function () {
                $repository = new \Modules\Ifeeds\Repositories\Eloquent\EloquentSourceRepository(new \Modules\Ifeeds\Entities\Source());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ifeeds\Repositories\Cache\CacheSourceDecorator($repository);
            }
        );
// add bindings


    }
}
