<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    /*
     * MODELO DE VENTAS
     *
     * */

    //OBTIENE LA VENTA CON LOS NOMBRES DE USUARIO Y LOS NOMBRES DE LA PELICULA GRACIAS AL JOIN DE LAS TABLAS
    public static function getSaleWithNamesAndMovies()
    {
        $rent = DB::table('sales')
            ->join('users', 'sales.idUserSale', '=', 'users.id')
            ->join('movies', 'sales.idMovieSale', '=', 'movies.id')
            ->select('sales.*', 'users.firstNameUser', 'users.lastNameUser', "movies.titleMovie")
            ->get();
        //RETORNA LAS VENTAS
        return $rent;


    }

    //OBTIENE TODAS LAS VENTAS HECHAS EN EL SISTEMA
    public static function getAllActive()
    {
        $rent = DB::table('sales')
            ->join('users', 'sales.idUserSale', '=', 'users.id')
            ->join('movies', 'sales.idMovieSale', '=', 'movies.id')
            ->select('sales.*', 'users.firstNameUser', 'users.lastNameUser', "movies.titleMovie")
            ->where('statusSale','=','done')
            ->get();
        //RETORNA LA LISTA DE VENTAS
        return $rent;
    }
}
