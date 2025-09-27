<?php

declare(strict_types=1);

namespace Mortezaa97\Shop;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Mortezaa97\Shop\Models\Attribute;
use Mortezaa97\Shop\Models\AttributeCategory;
use Mortezaa97\Shop\Models\AttributeProduct;
use Mortezaa97\Shop\Models\AttributeValue;
use Mortezaa97\Shop\Models\Product;
use Mortezaa97\Shop\Models\Specification;
use Mortezaa97\Shop\Policies\AttributeCategoryPolicy;
use Mortezaa97\Shop\Policies\AttributePolicy;
use Mortezaa97\Shop\Policies\AttributeProductPolicy;
use Mortezaa97\Shop\Policies\AttributeValuePolicy;
use Mortezaa97\Shop\Policies\ProductPolicy;
use Mortezaa97\Shop\Policies\SpecificationPolicy;

class ShopServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $factories = glob(__DIR__ . '/../database/factories/*.php');
        foreach ($factories as $factory) {
            $factoryClass = 'Mortezaa97\\Shop\\Database\\Factories\\' . basename($factory, '.php');
            $this->app->make($factoryClass);
        }

        // Register policies
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Attribute::class, AttributePolicy::class);
        Gate::policy(AttributeCategory::class, AttributeCategoryPolicy::class);
        Gate::policy(AttributeProduct::class, AttributeProductPolicy::class);
        Gate::policy(AttributeValue::class, AttributeValuePolicy::class);
        Gate::policy(Specification::class, SpecificationPolicy::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('shop.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'migrations');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'shop');

        // Register the main class to use with the facade
        $this->app->singleton('shop', function () {
            return new Shop;
        });
    }
}
