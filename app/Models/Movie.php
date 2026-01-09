<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'poster_path',
        'release_date',
        'original_language',
        'genre',
        'vote_average',
        'overview',
    ];

    // Relação: filme tem muitos comentários
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
