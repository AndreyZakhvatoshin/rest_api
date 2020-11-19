<?php

namespace App\Http\Controllers\Film;

use App\Models\Film;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilmRequest;

class FilmController extends Controller
{

    public function index(FilmRequest $request)
    {
        if (request()->filled('filter')) {
            [$criteria, $value] = explode(':', request('filter'));
            return Film::filterFilms($criteria, $value);
        }

        $sortColumn = $request->input('sort', 'title');
        if ($sortColumn) {
            $sortDirection = Str::startsWith($sortColumn, '-') ? 'desc' : 'asc';
            $sortColumn = ltrim($sortColumn, '-');
            return Film::sortFilms($sortColumn, $sortDirection);
        }

        return Film::allFilms();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FilmRequest $request)
    {
        return Film::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Film::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FilmRequest $request, $id)
    {
        $film = Film::findOrFail($id);
        $film->update($request->all());
        return $film;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Film::findOrFail($id)->delete();
    }
}
