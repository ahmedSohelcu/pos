<?php

namespace Modules\Sales\App\Providers;

use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;
use Modules\Sales\App\Providers\RouteServiceProvider;

class SalesServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Sales';

    protected string $nameLower = 'sales';

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
