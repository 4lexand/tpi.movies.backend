<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class Rent extends Model
{
    protected $fillable = ["idUserRent", "idMovieRent", "dateRent", "returnDateRent", "subtotalRent", "returnValidDateRent", "totalRent"];

    public static function getRentWithNamesAndMovies()
    {
        $rent = DB::table('rents')
            ->join('users', 'rents.idUserRent', '=', 'users.id')
            ->join('movies', 'rents.idMovieRent', '=', 'movies.id')
            ->select('rents.*', 'users.firstNameUser', 'users.lastNameUser', "movies.titleMovie")
            ->get();
        return $rent;


    }

    public static function getAllActive()
    {
        $rent = DB::table('rents')
            ->join('users', 'rents.idUserRent', '=', 'users.id')
            ->join('movies', 'rents.idMovieRent', '=', 'movies.id')
            ->select('rents.*', 'users.firstNameUser', 'users.lastNameUser', "movies.titleMovie")
            ->where('statusRent','=','in-progress')
            ->get();
        return $rent;
    }
}
