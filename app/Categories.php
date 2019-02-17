<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $guarded = [];

    public function books()
    {
        return $this->hasMany(\App\Books::class);
    }
}
