<?php

namespace App;

use App\Http\Models\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $fillable = ["idUser", "firstNameUser", "lastNameUser"];

    public static function onLogin($username, $password)
    {
        $user = DB::select("SELECT u.idUser, u.firstNameUser, u.lastNameUser, u.phoneUser, u.loginNameUser, r.titleRol
                            as roleUser from users u INNER JOIN roles r ON u.idRolUser = r.idRol
                            WHERE loginNameUser = '".$username."' AND loginPasswordUser = '".$password."'");
        if (count($user) == 1) {
            $response = new Response();
            $response->setData($user[0]);
            $response->setMessage("Exito al loguearse.");
            return $response;
        } else{
            $response = new Response();
            $response->setData(null);
            $response->setMessage("Error al loguearse.");
            return $response;
        }
    }
}
