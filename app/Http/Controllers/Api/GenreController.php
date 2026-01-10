<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // GET http://localhost:8000/api/genres
    // Retorna lista de todos os géneros disponíveis
    public function index()
    {
        $genres = Genre::orderBy('name')->get();
        return response()->json($genres);
    }
}
