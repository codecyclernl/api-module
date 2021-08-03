<?php namespace Api;

use October\Rain\Support\ModuleServiceProvider;

class ServiceProvider extends ModuleServiceProvider
{
    public function register()
    {
        parent::register('api');

        // Custom code
        $this->forgetSingletons();
        $this->registerSingletons();
    }

    public function boot()
    {
        // Custom code

        parent::boot('api');
    }

    protected function forgetSingletons()
    {
    }

    protected function registerSingletons()
    {
    }
}
