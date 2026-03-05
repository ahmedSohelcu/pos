<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Core\Status;
use Illuminate\Support\Facades\Schema;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Status::query()->truncate();

        $statuses = [            
            //======================================        
            //common  use
            [
                'name' => 'status_active',
                'type' => 'common',
                'class' => 'success'
            ],
            [
                'name' => 'status_pending',
                'type' => 'common',
                'class' => 'warning'
            ],
            [
                'name' => 'status_inactive',
                'type' => 'common',
                'class' => 'danger'
            ],          

            //======================================
            // subscription_status
            //======================================
            [
                'name' => 'status_trial',
                'type' => 'subscription',
                'class' => 'warning'
            ],
            [
                'name' => 'status_active',
                'type' => 'subscription',
                'class' => 'success'
            ],             
            [
                'name' => 'status_expired',
                'type' => 'subscription',
                'class' => 'danger'
            ],   
            [
                'name' => 'status_cancelled',
                'type' => 'subscription',
                'class' => 'danger'
            ],
            [
                'name' => 'status_pending',
                'type' => 'subscription',
                'class' => 'secondary'
            ],   

            //======================================
            //order status
            //======================================
            [
                'name' => 'status_pending',
                'type' => 'order',
                'class' => 'warning'
            ],
            [
                'name' => 'status_active',
                'type' => 'order',
                'class' => 'success'
            ],
            [
                'name' => 'status_cancelled',
                'type' => 'order',
                'class' => 'danger'
            ],
            [
                'name' => 'status_inprogress',
                'type' => 'order',
                'class' => 'info'
            ],
            [
                'name' => 'status_delivered',
                'type' => 'order',
                'class' => 'info'
            ],
            [
                'name' => 'status_revision',
                'type' => 'order',
                'class' => 'success'
            ],
            [
                'name' => 'status_completed',
                'type' => 'order',
                'class' => 'success'
            ],
            [
                'name' => 'status_pending',
                'type' => 'transaction',
                'class' => 'warning'
            ],
            [
                'name' => 'status_processing',
                'type' => 'transaction',
                'class' => 'info'
            ],
            [
                'name' => 'status_declined',
                'type' => 'transaction',
                'class' => 'danger'
            ],
            [
                'name' => 'status_transferred',
                'type' => 'transaction',
                'class' => 'success'
            ],
            [
                'name' => 'status_refunded',
                'type' => 'order',
                'class' => 'warning'
            ],
        ];
        Schema::enableForeignKeyConstraints();

        Status::query()->insert($statuses);
    }
}
