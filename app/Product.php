<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;
    public function get_variations()
    {
        return $this->hasMany(PVariation::class);
    }
}
