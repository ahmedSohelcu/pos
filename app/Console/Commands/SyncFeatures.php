<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Feature\app\Models\Feature;
use Spatie\Permission\Models\Permission;

class SyncFeatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'features:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $permissions = Permission::all();

        foreach ($permissions as $permission) {

            Feature::updateOrCreate(
                ['name'=>$permission->name],
                [
                    'label'=>ucwords(str_replace('.',' ',$permission->name)),
                    'description' => 'Feature for ' . $permission->name,
                    'is_active'=>true
                ]
            );
        }

        $this->info('Features synced successfully.');
    }
}
