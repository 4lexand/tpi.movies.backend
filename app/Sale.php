<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    public static function getSaleWithNamesAndMovies()
    {
        $rent = DB::table('sales')
            ->join('users', 'sales.idUserSale', '=', 'users.id')
            ->join('movies', 'sales.idMovieSale', '=', 'movies.id')
            ->select('sales.*', 'users.firstNameUser', 'users.lastNameUser', "movies.titleMovie")
            ->get();
        return $rent;


    }
    public static function getAllActive()
    {
        $rent = DB::table('sales')
            ->join('users', 'sales.idUserSale', '=', 'users.id')
            ->join('movies', 'sales.idMovieSale', '=', 'movies.id')
            ->select('sales.*', 'users.firstNameUser', 'users.lastNameUser', "movies.titleMovie")
            ->where('statusSale','=','done')
            ->get();
        return $rent;
    }
}
