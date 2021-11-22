<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Like extends Model
{
    /*
     *  MODELO DE LIKES
     *
     * */
    protected $fillable = ["id", "idUserLike","idMovieLike", "created_at", "updated_at"];

    //OBTIENE EL NUMERO DE LIKES QUE TIENE UNA PELICULA EN ESPECIFICO
    public static function getCountSpecificMovie($idMovie){
        $likes = DB::table('likes')
            ->select('likes.*')
            ->where('likes.idMovieLike','=',$idMovie)
            ->count();

        //RETORNA EL NUMERO DE LIKES QUE LA PELICULA POSEE
        return $likes;
    }

    //OBTIENE EL CONTEO DE LIKES POR USUARIO Y PELICULA ESPECIFICA
    public static function getCountSpecificUserAndMovie($idUser, $idMovie){
        $likes = DB::table('likes')
            ->select('likes.*')
            ->where('likes.idUserLike','=',$idUser)
            ->where('likes.idMovieLike','=',$idMovie)
            ->count();
        //RETORNA EL CONTEO
        return $likes;
    }

    //OBTIENE LOS LIKES CON USUARIOS Y NOMBRE DE PELICULAS GRACIAS AL JOIN DE LAS TABLAS
    public static function getLikesWithUserAndMovie()
    {
        $likes = DB::table('likes')
            ->join('users', 'likes.idUserLike', '=', 'users.id')
            ->join('movies', 'likes.idMovieLike', '=', 'movies.id')
            ->select('likes.*','users.firstNameUser','users.lastNameUser','movies.titleMovie')
            ->get();
        //RETORNA EL LISTADO DE LIKES
        return $likes;
    }
    //ELIMINA UN LIKE POR USUARIO Y PELICULA
    public static function deleteLikeByUserAndMovie($user, $movie)
    {
        $likes = DB::table('likes')
            ->where('idUserLike','=',$user)
            ->where('idMovieLike',"=",$movie)
            ->delete();
        return $likes;
    }
}
