<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Service;
use App\Models\Product;
use App\Models\Category;

class NavigationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer(
            ['layouts.navigation', 'layouts.footer'], function ($view) {
                $services = Service::all(); 
                $view->with('services', $services);
            }
        );
        view()->composer(
            ['layouts.demo.navigation', 'layouts.demo.footer'], function ($view) {
                $products = Product::all();
                $categories = Category::all();
                $view->with([
                    'products' => $products,
                    'categories' => $categories,
                ]);
            }
        );
    }
}
