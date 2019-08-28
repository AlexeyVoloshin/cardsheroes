<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Superhero extends Model
{
    protected $fillable
    = [
        'nickname',
        'real_name',
        'original_description',
        'superpower',
        'catch_phrase',
        ];
}
