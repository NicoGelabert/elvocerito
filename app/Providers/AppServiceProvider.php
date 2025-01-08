<?php

namespace App\Providers;

use Dotenv\Dotenv;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $host = $_SERVER['HTTP_HOST'] ?? '';
        if ($host === 'demo.chimicreativo.es' || $host === 'demo.chimicreativo.local') {
            $dotenv = Dotenv::createImmutable(base_path(), '.env.demo');
            $dotenv->load();
            config(['app.url' => env('APP_URL', 'http://demo.chimicreativo.local:8001')]);
        }
        Blade::component('layouts.demo.app-demo', 'app-demo');
    }
}
