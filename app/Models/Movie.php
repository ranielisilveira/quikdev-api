<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'id',
        'poster',
        'name',
        'overview',
        'release_date',
        'popularity',
    ];

    protected $appends = [
        'releaseDateFormat'
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function getReleaseDateFormatAttribute()
    {
        return $this->release_date ? Carbon::parse($this->release_date)->format('d/m/Y') : '-';
    }

    public function getPosterAttribute($value)
    {
        return env("TMDB_IMAGES") . "original" . $value;
    }
}
