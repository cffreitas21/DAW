<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'movie_id',
        'comment',
        'approved',
    ];

    protected $casts = [
        'approved' => 'boolean',
    ];

    // Relação: comentário pertence a um utilizador
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relação: comentário pertence a um filme
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
