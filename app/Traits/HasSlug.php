<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        static::creating(function ($model) {
            $model->slug = static::generateUniqueSlug(
                $model->{static::slugSourceField()}
            );
        });

        static::updating(function ($model) {
            if ($model->isDirty(static::slugSourceField())) {
                $model->slug = static::generateUniqueSlug(
                    $model->{static::slugSourceField()},
                    $model->id
                );
            }
        });
    }

    protected static function slugSourceField()
    {
        return property_exists(static::class, 'slugFrom')
            ? static::$slugFrom
            : 'name'; // default
    }

    protected static function generateUniqueSlug($value, $ignoreId = null)
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;

        $query = static::where('slug', 'LIKE', "{$slug}%");

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $count = $query->count();

        return $count ? "{$originalSlug}-{$count}" : $originalSlug;
    }
}


// How to use
/*
    1. add trait in model
        HasSlug;

    2. add slugFrom in model if want to sluf from other field
        by default slug from name

    protected static $slugFrom = 'field_name';

    ** slug will return after store
    
    3. add in migration
        $table->string('slug')->unique()->nullable();

    4. add in route
        Route::resource('brands', BrandController::class);



        */