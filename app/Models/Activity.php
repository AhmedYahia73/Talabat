<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Activity extends Model
{
    use HasTranslations;
    public $translatable = ["name"];

    protected $fillable = [
        'name',
        'status',
    ];
}
