<?php

namespace Viviniko\User;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Viviniko\User\Console\Commands\UserTableCommand;

class UserServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../config/user.php' => config_path('user.php'),
        ]);

        // Register commands
        $this->commands('command.user.table');

        $config = $this->app['config'];

        Relation::morphMap([
            'user.user' => $config->get('user.user'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/user.php', 'user');

        $this->registerRepositories();

        $this->registerUserService();

        $this->registerCommands();
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function registerCommands()
    {
        $this->app->singleton('command.user.table', function ($app) {
            return new UserTableCommand($app['files'], $app['composer']);
        });
    }

    protected function registerRepositories()
    {
        $this->app->singleton(
            \Viviniko\User\Repositories\User\UserRepository::class,
            \Viviniko\User\Repositories\User\EloquentUser::class
        );
    }

    /**
     * Register the user service provider.
     *
     * @return void
     */
    protected function registerUserService()
    {
        $this->app->singleton(
            \Viviniko\User\Contracts\UserService::class,
            \Viviniko\User\Services\User\UserServiceImpl::class
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            \Viviniko\User\Repositories\User\UserRepository::class,
            \Viviniko\User\Contracts\UserService::class
        ];
    }
}