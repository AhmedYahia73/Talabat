<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MarketBranch extends Model
{
    use HasTranslations;
    public $translatable = ["name"];

    protected $fillable = [
        'name',
        'lat',
        'lng',
        'address',
        'market_id',
        'city_id',
        'zone_id',
        'status',
    ];
}
