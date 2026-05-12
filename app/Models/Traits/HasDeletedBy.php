<?php

use App\Models\User;

trait HasDeletedBy
{
    public static function bootHasDeletedBy()
    {
        static::deleting(function ($model) {
            if (auth()->check()) {
                $model->deleted_by = auth()->id();
                $model->save();
            }
        });
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}