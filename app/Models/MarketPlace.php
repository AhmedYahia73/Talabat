<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MarketPlace extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasTranslations;

    public $translatable = ['name', "details", "short_description"];
    protected $fillable = [
        'name',
        'details',
        'image',
        'slug',
        'status',
    ];

    protected $casts = [
        'name' => 'array',
        'details' => 'array',
    ]; 
}
