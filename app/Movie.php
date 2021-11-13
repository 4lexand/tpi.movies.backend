<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{
    protected $fillable = ["id", "titleMovie", "descriptionMovie", "urlImageMovie", "urlTrailerMovie", "stockMovie", "rentalPriceMovie", "purchasePriceMovie", "availabilityMovie", "created_at", "updated_at"];

    public static function getSpecificMovie($idMovie)
    {
        $movie = DB::table("movies")
            ->where('id',"=",$idMovie)
            ->first();

        if($movie!=null){
            return $movie;
        } else{
            return NULL;
        }
    }
}
