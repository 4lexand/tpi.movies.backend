<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Login;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $login = User::all();
        return $login;
    }

    private function ok($response)
    {
        if ($response->getData() != null) {
            return response()->json([
                'data' => $response->getData(),
                "message" => $response->getMessage(),
            ], 200);
        } else {
            return response()->json([
                "message" => $response->getMessage(),
                "data" => $response->getData()
            ], 401);
        }

    }

    private function error($response)
    {
        return response()->json([
            "message" => $response->getMessage(),
            "status" => false,
            "element" => null
        ]);
    }

    public function onLogin(Request $request)
    {
        return $this->ok(User::onLogin($request->username, $request->password));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
