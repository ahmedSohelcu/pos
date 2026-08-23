<?php

namespace Modules\Inventory\App\Providers;

use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;
use Modules\Inventory\App\Providers\RouteServiceProvider;

class InventoryServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Inventory';

    protected string $nameLower = 'inventory';

    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function provides(): array
    {
        return [];
    }
}
