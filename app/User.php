<?php

namespace App;

use App\Http\Models\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    protected $fillable = ["idUser", "firstNameUser", "lastNameUser", "phoneUser", "loginNameUser", "loginPasswordUser", "idRolUser", "created_at", "updated_at"];

    public static function onLogin($username, $password)
    {
        $user = DB::table('users')
            ->join('roles', 'users.idRolUser', '=', 'roles.idRol')
            ->select('users.*', 'roles.titleRol')
            ->where('users.loginNameUser', '=', $username)
            ->first();
        if(password_verify($password, $user->loginPasswordUser)){

            return $user;
        } else {
            return NULL;
        }
    }
    public static function getUsersWithRol()
    {
        $users = DB::table('users')
            ->join('roles', 'users.idRolUser', '=', 'roles.idRol')
            ->select('users.*','roles.titleRol')
            ->get();
        return $users;
    }


}
