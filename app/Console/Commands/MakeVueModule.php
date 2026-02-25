<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeVueModule extends Command
{
    protected $signature = 'make:vue-module {name}';
    protected $description = 'Generate a new Vue module structure in js/admin/modules/';

    protected Filesystem $files;

    public function __construct()
    {
        parent::__construct();
        $this->files = new Filesystem();
    }

    public function handle()
    {
        $name = strtolower($this->argument('name'));   // folder name / route prefix
        $className = ucfirst($name);                   // PascalCase for components

        $modulePath = resource_path("js/admin/modules/{$name}");
        $viewsPath = "{$modulePath}/views";

        if ($this->files->exists($modulePath)) {
            $this->error("Module '{$name}' already exists!");
            return;
        }

        // 1️⃣ Create folders
        $this->files->makeDirectory($viewsPath, 0755, true);

        // 2️⃣ Create api.js
        $this->files->put("{$modulePath}/api.js", <<<JS
import axios from '@/js/plugins/axios'

export const {$className}Api = {
  all() { return axios.get('/{$name}') },
  create(data) { return axios.post('/{$name}', data) },
  update(id, data) { return axios.put('/{$name}/' + id, data) },
  delete(id) { return axios.delete('/{$name}/' + id) }
}
JS
        );

        // 3️⃣ Create router.js
        $this->files->put("{$modulePath}/router.js", <<<JS
import {$className}Index from './views/{$className}Index.vue'
import {$className}Create from './views/{$className}Create.vue'
import {$className}Edit from './views/{$className}Edit.vue'

export default [
  { path: '/{$name}', name: '{$name}.index', meta: { breadcrumb: 'All {$className}', requiresAuth: true, permission: '{$name}_view' }, component: {$className}Index },
  { path: '/{$name}/create', name: '{$name}.create', meta: { breadcrumb: 'Add {$className}', requiresAuth: true, permission: '{$name}_create' }, component: {$className}Create },
  { path: '/{$name}/:id/edit', name: '{$name}.edit', meta: { breadcrumb: 'Edit {$className}', requiresAuth: true, permission: '{$name}_edit' }, component: {$className}Edit }
]
JS
        );

        // 4️⃣ Create sidebar.js
        $this->files->put("{$modulePath}/sidebar.js", <<<JS
export const {$className}Menus = [
  {
    key: '{$name}',
    label: '{$className}',
    icon: 'bi bi-people-fill',
    permission: '{$name}_access',
    items: [
      { name: '{$name}.index', label: 'All {$className}', permission: '{$name}_view' },
      { name: '{$name}.create', label: 'Add {$className}', permission: '{$name}_create' }
    ]
  }
]
JS
        );

        // 5️⃣ Create store.js (optional, Pinia)
        $this->files->put("{$modulePath}/store.js", <<<JS
import { defineStore } from 'pinia'
import { {$className}Api } from './api.js'

export const use{$className}Store = defineStore('{$name}', {
  state: () => ({
    items: [],
    loading: false,
    selectedItem: null
  }),
  actions: {
    async fetchItems() {
      this.loading = true
      const { data } = await {$className}Api.all()
      this.items = data
      this.loading = false
    },
    setSelectedItem(item) {
      this.selectedItem = item
    }
  },
  getters: {
    totalItems: state => state.items.length
  }
})
JS
        );

        // 6️⃣ Create views (Index, Create, Edit) with preferred template
        $viewFiles = ['Index', 'Create', 'Edit'];
        foreach ($viewFiles as $view) {
            $componentTemplate = <<<VUE
<script setup>
import { ref, reactive, computed, onMounted } from 'vue'

onMounted(() => {
    // TODO: fetch data or initialize state
})
</script>

<template>
    <div class="container-fluid">
        <!-- {$className} {$view} content -->
    </div>
</template>

<style scoped>

</style>
VUE;
            $this->files->put("{$viewsPath}/{$className}{$view}.vue", $componentTemplate);
        }

        $this->info("Vue module '{$name}' created successfully at {$modulePath}");
    }
}