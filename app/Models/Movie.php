<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'poster',
        'name',
        'overview',
        'release_date',
        'popularity',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
