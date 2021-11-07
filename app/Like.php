<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Like extends Model
{
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
}
