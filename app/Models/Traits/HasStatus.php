<?php

namespace App\Models\Traits;

use App\Models\Core\Status;

trait HasStatus
{
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}