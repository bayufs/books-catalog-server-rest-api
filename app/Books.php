<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(\App\Categories::class);
    }
}
