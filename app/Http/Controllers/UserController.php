<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //OBTIENE EL LISTADO COMPLETO DE USUARIOS CON LOS ROLES
    public function index()
    {
        //EJECUTA EL METODO DE OBTENER USUARIOS CON ROL DEL MODELO USER
        $response = User::getUsersWithRol();
        if ($response != null) {
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($response, 200);
        } else {
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($response, 204);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    //CREA UN NUEVO USUARIO
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->firstNameUser = $request->firstNameUser;
        $user->lastNameUser = $request->lastNameUser;
        $user->phoneUser = $request->phoneUser;
        $user->loginNameUser = $request->loginNameUser;
        $user->loginPasswordUser = password_hash($request->loginPasswordUser, PASSWORD_DEFAULT);
        $user->idRolUser = $request->idRolUser;
        //GUARDA EL NUEVO USUARIO
        $user->save();
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    //ACTUALIZA UN USUARIO
    public function update(UserRequest $request)
    {
        //PRIMERO BUSCA EL USUARIO EN LA BASE DE DATOS P[OR MEDIO DEL ID
        $user = User::findOrFail($request->idUser);
        $user->firstNameUser = $request->firstNameUser;
        $user->lastNameUser = $request->lastNameUser;
        $user->phoneUser = $request->phoneUser;
        $user->loginNameUser = $request->loginNameUser;
        //ENCRIPTA LA CONTRASENIA NUEVA si es diferente a la anterior
        if(!password_verify($request->loginPasswordUser, $user->loginPasswordUser)){
            $user->loginPasswordUser = password_hash($request->loginPasswordUser, PASSWORD_DEFAULT);
        }
        $user->idRolUser = $request->idRolUser;
        //GUARDA EL USUARIO ACTUALIZADO
        $user->save();
        return $user;
    }

    //METODO PARA CAMBIAR LA CONTRASENIA
    public function changePassword(Request $request)
    {
        //BUSCA EL USUARIO POR SU LOGINNAMEUSER
        $user = User::where('loginNameUser', "=", $request->loginNameUser)->firstOrFail();
        //SI NO ENCYUENTRA USUARIO
        //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
        if ($user == null) return response()->json($user, 400);
        //VERIFICA SI LA CONTRASNIA ANTERIOR ES IGUAL A LA ACTUAL PARA PODER PROSEGUIR
        if (password_verify($request->oldPassword, $user->loginPasswordUser)) {
            //SETEA LA NUEVA CONTRASENIA ENCRIPTADA
            $user->loginPasswordUser = password_hash($request->newPassword, PASSWORD_DEFAULT);
            //GUARDA EL USUARIO
            $user->save();
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($user, 200);
        } else {
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json("Contraseña anterior incorrecta", 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return int
     */

    //ELIMINA UN USUARIO POR ID
    public function destroy(Request $request)
    {
        //BUSCA EL USUARIO Y LO ELIMINA
        $user = User::destroy($request->idUser);
        if ($user == 1) {
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($user, 200);
        } else {
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($user, 400);
        }
    }

}
