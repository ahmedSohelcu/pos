<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeVue extends Command
{
    protected $signature = 'make:vue 
                            {path : Full path including folders and component name, e.g., admin/pages/Dashboard}';

    protected $description = 'Create a Vue 3 component in js folder preserving folder casing';

    public function handle(): int
    {
        $fullPath = $this->argument('path');

        // Split path into segments
        $segments = explode('/', $fullPath);

        // Last segment is the file name
        $name = Str::studly(array_pop($segments));

        // Remaining segments are folders (preserve casing exactly)
        $folders = $segments;

        // Base path always resource/js
        $basePath = resource_path('js');

        if (!empty($folders)) {
            $basePath .= '/' . implode('/', $folders);
        }

        // Create directories if they don't exist
        if (!File::isDirectory($basePath)) {
            File::makeDirectory($basePath, 0755, true, true);
        }

        $filePath = "{$basePath}/{$name}.vue";

        if (File::exists($filePath)) {
            $this->error("Vue component [{$name}] already exists at {$filePath}.");
            return Command::FAILURE;
        }

        File::put($filePath, $this->buildVueComponent($name));

        $this->info("✔ Vue component created successfully.");
        $this->line("📁 Path: {$filePath}");

        return Command::SUCCESS;
    }

    protected function buildVueComponent(string $name): string
    {
        return <<<VUE
<script setup>
    import { ref, reactive, computed, onMounted } from 'vue'

    // Define props
    defineProps({

    })

    defineEmits(['submit'])

    const loading = ref(false)

    onMounted(() => {
        console.log('Component', componentName, 'mounted')
    })
</script>

<template>
    <div class="">
        Test..
    </div>
</template>

<style scoped>

</style>
VUE;
    }
}