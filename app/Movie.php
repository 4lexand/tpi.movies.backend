<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{

    /*
     * MODELO DE PELICULAS
     *
     * */

    //COLUMNAS A RELLENAR
    protected $fillable = ["id", "titleMovie", "descriptionMovie", "urlImageMovie", "urlTrailerMovie", "stockMovie", "rentalPriceMovie", "purchasePriceMovie", "availabilityMovie", "created_at", "updated_at"];

    //OBTIENE UNA PELICULA EN ESPECIFICO POR MEDIO DEL ID
    public static function getSpecificMovie($idMovie)
    {
        $movie = DB::table("movies")
            ->where('id', "=", $idMovie)
            ->first();
        //SI NO ENCUENTRA LA PELICULA RETORNARA NULL
        if ($movie != null) {
            return $movie;
        } else {
            return NULL;
        }
    }

    //OBTIENE TODAS LAS PELICULAS QUE ESTEN DISPONIBLES
    public static function getAvailableMovies()
    {
        $movies = DB::table('movies')
            ->where('availabilityMovie', '=', 1)
            ->get();
        return $movies;
    }

}
