<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductPriceBranch extends Model
{
    use HasTranslations;
    public $translatable = ["name"];

    protected $fillable = [
        'product_id',
        'branch_id',
        'price',
    ];
}
