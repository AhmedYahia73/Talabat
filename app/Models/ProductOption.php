<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductOption extends Model
{
    use HasTranslations;
    public $translatable = ["name"];

    protected $fillable = [
        'name',
        'price',
        'product_id',
        'variation_id',
        'status',
    ];
}
