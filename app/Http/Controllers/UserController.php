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
    public function index()
    {
        $response = User::getUsersWithRol();
        if ($response != null) {
            return response()->json($response, 200);
        } else {
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
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->firstNameUser = $request->firstNameUser;
        $user->lastNameUser = $request->lastNameUser;
        $user->phoneUser = $request->phoneUser;
        $user->loginNameUser = $request->loginNameUser;
        $user->loginPasswordUser = password_hash($request->loginPasswordUser, PASSWORD_DEFAULT);
        $user->idRolUser = $request->idRolUser;

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
    public function update(UserRequest $request)
    {
        $user = User::findOrFail($request->idUser);
        $user->firstNameUser = $request->firstNameUser;
        $user->lastNameUser = $request->lastNameUser;
        $user->phoneUser = $request->phoneUser;
        $user->loginNameUser = $request->loginNameUser;
        $user->loginPasswordUser = password_hash($request->loginPasswordUser, PASSWORD_DEFAULT);
        $user->idRolUser = $request->idRolUser;
        $user->save();
        return $user;
    }

    public function changePassword(Request $request)
    {
        $user = User::where('loginNameUser',"=",$request->loginNameUser)->firstOrFail();
        //$user = User::findSpecificUserByLoginNameUser($request->loginNameUser);
        if ($user == null) return response()->json($user, 400);
        if (password_verify($request->oldPassword, $user->loginPasswordUser)) {
            $user->loginPasswordUser = password_hash($request->newPassword, PASSWORD_DEFAULT);
            $user->save();
            return response()->json($user, 200);
        } else {
            return response()->json("Contraseña anterior incorrecta", 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return int
     */
    public function destroy(Request $request)
    {
        $user = User::destroy($request->idUser);
        if ($user == 1) {
            return response()->json($user, 200);
        } else {
            return response()->json($user, 400);
        }
    }

}
