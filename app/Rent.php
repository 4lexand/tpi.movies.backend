<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class Rent extends Model
{
    /*
     *  MODELO DE RENTAS
     *
     * */

    //DATOS A LLENAR AL REALIZAR UN ALL()
    protected $fillable = ["idUserRent", "idMovieRent", "dateRent", "returnDateRent", "subtotalRent", "returnValidDateRent", "totalRent"];

    // OBTIENE LA LISTA DE RENTAS CON LOS NOMBRES DE USUARIO Y DE PELICULAS GRACIAS AL JOIN EN LAS TABLAS
    public static function getRentWithNamesAndMovies()
    {
        $rent = DB::table('rents')
            ->join('users', 'rents.idUserRent', '=', 'users.id')
            ->join('movies', 'rents.idMovieRent', '=', 'movies.id')
            ->select('rents.*', 'users.firstNameUser', 'users.lastNameUser', "movies.titleMovie")
            ->get();
        //DEVUELVE EL LISTADO
        return $rent;


    }

    //OBTIENE TODAS LAS RENTAS QUE ESTAN EN PROGRESO
    public static function getAllActive()
    {
        $rent = DB::table('rents')
            ->join('users', 'rents.idUserRent', '=', 'users.id')
            ->join('movies', 'rents.idMovieRent', '=', 'movies.id')
            ->select('rents.*', 'users.firstNameUser', 'users.lastNameUser', "movies.titleMovie")
            ->where('statusRent','=','in-progress')
            ->get();
        //RETORNA EL LISTADO
        return $rent;
    }
}
