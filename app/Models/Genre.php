<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = ['name'];

    // Relação: género tem muitos filmes
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
}
