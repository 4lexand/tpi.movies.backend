<?php

namespace App;

use App\Http\Models\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    /*
     * MODELO DE USUARIO
     *
     *
     * CAMPOS QUE SE LLENAN AL HACER UN All()
     * */

    //CAMPOS QUE SE LLENAN AL HACER UN All()
    protected $fillable = ["id", "firstNameUser", "lastNameUser", "phoneUser", "loginNameUser", "loginPasswordUser", "idRolUser", "created_at", "updated_at"];


    //LOGUEARSE, RECIBE EL USERNAME Y LA PASSWORD
    public static function onLogin($username, $password)
    {
        //CONSULTA LA BASE DE DATOS Y SI ENCUENTRA QUE COINCIDE UN USERNAME CON EL RECIBIDO LO EVALUA
        $user = DB::table('users')
            ->join('roles', 'users.idRolUser', '=', 'roles.id')
            ->select('users.*', 'roles.titleRol')
            ->where('users.loginNameUser', '=', $username)
            ->first();
        if ($user != null) {
            //SI EXISTE UN USUARIO CON ESE USERNAME, VERIFICA SI LA CONTRASENA ENCRIPTADA DE LA BASE
            //DE DATOS COINCIDE CON LA QUE RECIBIO DEL CLIENTE
            if (password_verify($password, $user->loginPasswordUser)) {
                return $user;
            } else {
                //RETORNA NULL SI NO COINCIDE LA CONTRASENIA
                return NULL;
            }
        } else {
            //RETORNA NULL SI NO ENCUENTRA NINGUYN USUARIO CON ESE USERNAME
            return NULL;
        }

    }

    //BUSCA EN LA BASE DE DATOS UN USUARIO EN ESPECIFICO POR ,EDIO DEL LOGINNAMEUSER
    public static function findSpecificUserByLoginNameUser($loginNameUser)
    {
        $user = DB::table('users')
            ->where('loginNameUser', "=", $loginNameUser)
            ->first();
        //RETORNA EL USUARIO
        return $user;
    }

    //OBTIENE TODOS LOS USUARIOS AGREGANDO LA COLUMNA DE LOS ROLES (TITLEROL)
    public static function getUsersWithRol()
    {
        $users = DB::table('users')
            ->join('roles', 'users.idRolUser', '=', 'roles.id')
            ->select('users.*', 'roles.titleRol')
            ->get();
        //RETORNA LA LISTA DE USUARIOS
        return $users;
    }

    //ELIMINA UN USUARIO POR EL ID DE USUARIO
    public static function deleteUser($idUser)
    {
        $user = DB::table('users')->where('idUser', '=', $idUser)->delete();
        return $user;
    }


}
