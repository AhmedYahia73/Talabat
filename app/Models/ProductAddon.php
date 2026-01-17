<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductAddon extends Model
{
    use HasTranslations;
    public $translatable = ["name"];

    protected $fillable = [
        'name',
        'price',
        'product_id',
        'category_id',
        'status',
    ];
}
