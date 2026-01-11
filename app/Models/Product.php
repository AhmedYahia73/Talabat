<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasTranslations;
    public $translatable = ['name', "details", "short_description"];
    
    protected $fillable = [
        'name',
        'details',
        'short_description',
        'slug',
        'category_id', 
        'image',
        'status',

        'gallery',
        "price",
        'offer_price',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'gallery' => 'array',
        'name' => 'array',
        'details' => 'array',
        'short_description' => 'array',
    ]; 

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function sub_category(){
        return $this->belongsTo(Category::class, 'sub_category_id');
    }
}
