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
        'lng',
        'lat',
        'status',
    ];

    protected $casts = [
        'name' => 'array',
        'details' => 'array',
    ]; 
    
    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'latitude',
            'lng' => 'longitude',
        ];
    }
}
