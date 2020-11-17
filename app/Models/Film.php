<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Film extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
        'image',
        'year'
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public static function allFilms()
    {
        $films = DB::table('films')
            ->join('film_genre', 'films.id', '=', 'film_genre.film_id')
            ->join('genres', 'genres.id', '=', 'film_genre.genre_id')
            ->select('films.*', 'genres.genre_name')
            ->paginate(5);
        return $films;
    }

    public static function filterFilms(string $criteria, string $value)
    {
        $films = DB::table('films')
            ->join('film_genre', 'films.id', '=', 'film_genre.film_id')
            ->join('genres', 'genres.id', '=', 'film_genre.genre_id')
            ->select('films.*', 'genres.genre_name')
            ->where($criteria, $value)
            ->paginate(5);
        return $films;
    }

    public static function sortFilms(string $sortColumn, string $direction)
    {
        $films = DB::table('films')
            ->join('film_genre', 'films.id', '=', 'film_genre.film_id')
            ->join('genres', 'genres.id', '=', 'film_genre.genre_id')
            ->select('films.*', 'genres.genre_name')
            ->orderBy($sortColumn, $direction)
            ->paginate(5);
        return $films;
    }
}
