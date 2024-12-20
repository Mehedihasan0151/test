<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [ 
        'chapter',
        'subject',
        'image',
    ];

    protected $casts = [
        'subject' => 'string',
        'image' => 'array',
    ];

    protected static function booted()
    {
        parent::boot();

        // static::deleted(function (Banner $banner) {
        //     if ($banner->image) {
        //         Storage::disk('public')->delete($banner->image);
        //     }
        // });
    }
}
    