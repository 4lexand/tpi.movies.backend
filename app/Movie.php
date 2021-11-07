<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ["id", "titleMovie", "descriptionMovie", "urlImageMovie", "stockMovie", "rentalPriceMovie", "purchasePriceMovie", "availabilityMovie", "created_at", "updated_at"];


}
