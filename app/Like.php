<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Like extends Model
{
    protected $fillable = ["id", "idUserLike","idMovieLike", "created_at", "updated_at"];
    public static function getCountSpecificMovie($idMovie){
        $likes = DB::table('likes')
            ->select('likes.*')
            ->where('likes.idMovieLike','=',$idMovie)
            ->count();
        return $likes;
    }

    public static function getCountSpecificUserAndMovie($idUser, $idMovie){
        $likes = DB::table('likes')
            ->select('likes.*')
            ->where('likes.idUserLike','=',$idUser)
            ->where('likes.idMovieLike','=',$idMovie)
            ->count();
        return $likes;
    }

    public static function getLikesWithUserAndMovie()
    {
        $likes = DB::table('likes')
            ->join('users', 'likes.idUserLike', '=', 'users.id')
            ->join('movies', 'likes.idMovieLike', '=', 'movies.id')
            ->select('likes.*','users.firstNameUser','users.lastNameUser','movies.titleMovie')
            ->get();
        return $likes;
    }
}
