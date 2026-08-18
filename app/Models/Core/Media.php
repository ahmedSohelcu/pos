<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends BaseModel
{
    protected $fillable = [
        'file',
        'disk', //directory
        'collection', // like avatar, gallery, thumbnail, banner etc
        'type', // like image, video, pdf
        'mime_type', // like image/jpeg, video/mp4
        'sort_order',
    ];

    protected $appends = [
        'url'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function mediable()
    {
        return $this->morphTo();
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->file);
    }
}
