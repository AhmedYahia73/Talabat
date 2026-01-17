<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasTranslations;
    public $translatable = ['name', "details", "short_description"];

    protected $fillable = [
        'name',
        'details',
        "short_description",
        'slug',
        'image',
        'status',
        'discount_id',
        'tax_id',
        'category_id',
        'market_place_id',
    ];


    protected $casts = [
        'name' => 'array',
        'details' => 'array',
        'short_description' => 'array',
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function market_place(){
        return $this->belongsTo(MarketPlace::class, 'market_place_id');
    }
}
