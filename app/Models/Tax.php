<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Tax extends Model
{
    use HasTranslations;
    public $translatable = ['name'];
    
    protected $fillable = [
        'name',
        'type',
        'amount', 
    ];
}
