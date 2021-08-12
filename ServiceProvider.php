<?php namespace Api;

use App;
use Event;
use BackendAuth;
use Api\Classes\ApiManager;
use Laravel\Passport\Passport;
use Api\Console\InstallApiModule;
use Api\Http\Middleware\Authenticate;
use October\Rain\Support\ModuleServiceProvider;
use Api\Extend\BackendUser as ExtendBackendUser;

class ServiceProvider extends ModuleServiceProvider
{
    protected array $middlewareAliases = [
        'auth' => Authenticate::class,
    ];

    public function register()
    {
        parent::register('api');

        // Custom code
        $this->forgetSingletons();
        $this->registerSingletons();
        $this->registerProviders();
        $this->registerMiddleware();
        $this->registerConsole();
    }

    public function boot()
    {
        // Custom code
        $this->bindAuthManager();
        $this->registerConfig();

        //
        Passport::ignoreMigrations();
        Passport::routes();

        // Extend models
        Event::subscribe(ExtendBackendUser::class);

        parent::boot('api');
    }

    protected function forgetSingletons()
    {
    }

    protected function registerSingletons()
    {
        App::singleton('api.manager', function () {
            return ApiManager::instance();
        });
    }

    protected function registerMiddleware(): void
    {
        $router = $this->app['router'];

        $method = method_exists($router, 'aliasMiddleware') ? 'aliasMiddleware' : 'middleware';

        foreach ($this->middlewareAliases as $alias => $middleware) {
            $router->$method($alias, $middleware);
        }
    }

    protected function bindAuthManager(): void
    {
        $authManager = null;

        if (App::runningInBackend()) {
            $authManager = BackendAuth::instance();
        }

        if ($authManager) {
            $this->app->bind('Illuminate\Contracts\Auth\Factory', function () use ($authManager) {
                return $authManager;
            });
        }
    }

    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/config/auth.php' => config_path('auth.php'),
            __DIR__.'/config/passport.php' => config_path('passport.php'),
        ], 'october.api');
    }

    protected function registerProviders()
    {
        $this->app->register('\Laravel\Passport\PassportServiceProvider');
        $this->app->register('\Illuminate\Auth\AuthServiceProvider');
    }

    protected function registerConsole()
    {
        $this->registerConsoleCommand('api.install', InstallApiModule::class);
    }
}
