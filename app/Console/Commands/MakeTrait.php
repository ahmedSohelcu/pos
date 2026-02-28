<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeTrait extends Command
{
    protected $signature = 'make:trait {name}';
    protected $description = 'Create a new trait';

    public function handle()
    {
        $name = $this->argument('name');

        // Support nested folders
        $path = app_path("Traits/{$name}.php");

        $directory = dirname($path);

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (File::exists($path)) {
            $this->error('Trait already exists!');
            return;
        }

        // Convert folder structure to namespace
        $namespace = 'App\\Traits\\' . str_replace('/', '\\', dirname($name));
        $traitName = class_basename($name);

        File::put($path, "<?php

namespace {$namespace};

trait {$traitName}
{
    //
}
");

        $this->info("Trait {$traitName} created successfully.");
    }
}