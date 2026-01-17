<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BusinessSetup extends Model
{
    use HasTranslations;
    public $translatable = ["name"];

    protected $fillable = [
        'name',
        'brand_image',
        'brand_cover',
        'slider_imgs',
        'ads_imgs',
        'currency',
        'time_zone',
        'coverage',
        'km_price',
        'low_distance_price',
        'low_resturant_order',
        'android_link',
        'apple_link',
        'website_link',
    ];
}
