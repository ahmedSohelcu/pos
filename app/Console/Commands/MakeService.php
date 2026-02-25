<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeService extends Command
{
    protected $signature = 'make:service 
                            {name : The service class name}
                            {--module= : Optional module name}';

    protected $description = 'Create a service class in main app or module, extends BaseService, injects model automatically';

    public function handle(): int
    {
        $name = Str::studly($this->argument('name'));

        // Automatically add "Service" suffix if missing
        if (!Str::endsWith($name, 'Service')) {
            $name .= 'Service';
        }

        $module = $this->option('module');

        if ($module) {
            $module = Str::studly($module);
            $modulePath = base_path("Modules/{$module}");

            if (!File::exists($modulePath)) {
                $this->error("Module [{$module}] does not exist.");
                return Command::FAILURE;
            }

            $path = "{$modulePath}/app/Services";
            $namespace = "Modules\\{$module}\\Services";

            // Guess model class: if service = TenantService, model = Tenant
            $modelName = str_replace('Service', '', $name);
            $modelNamespace = "Modules\\{$module}\\App\\Models\\{$modelName}";

        } else {
            $path = app_path('Services');
            $namespace = "App\\Services";

            $modelName = str_replace('Service', '', $name);
            $modelNamespace = "App\\Models\\{$modelName}";
        }

        // Ensure directory exists
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }

        $filePath = "{$path}/{$name}.php";

        if (File::exists($filePath)) {
            $this->error("Service [{$name}] already exists.");
            return Command::FAILURE;
        }

        $stub = $this->buildClass($namespace, $name, $modelNamespace, $modelName);

        File::put($filePath, $stub);

        $this->info("✔ Service created successfully.");
        $this->line("📁 Path: {$filePath}");

        return Command::SUCCESS;
    }

    protected function buildClass(string $namespace, string $name, string $modelNamespace, string $modelName): string
    {
        return <<<PHP
<?php

namespace {$namespace};

use App\Services\Core\BaseService;
use {$modelNamespace};

class {$name} extends BaseService
{
    public function __construct({$modelName} \${$this->camelCase($modelName)})
    {
        \$this->model = \${$this->camelCase($modelName)};
    }
}

PHP;
    }

    protected function camelCase(string $string): string
    {
        return lcfirst($string);
    }
}