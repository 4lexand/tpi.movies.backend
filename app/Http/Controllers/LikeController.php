<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //OBTIENE LA LISTA DE LIKES CON USUARIOS Y TITULO DE PELICULAS
        $response = Like::getLikesWithUserAndMovie();
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            //CREA UN NUEVO LIKE
            $like = new Like();
            $like->idUserLike = $request->idUserLike;
            $like->idMovieLike = $request->idMovieLike;
            //LO GUARDA
            $like->save();
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($like, 200);
        }catch (Exception $e){
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //ELIMINA UN LIKE POR ID DE LIKE
        $like = Like::destroy($request->idLike);
        if($like ==1){
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($like,200);
        } else{
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($like,400);
        }
    }

    //ELIMINA UN LIKE POR MEDIO DEL ID DE USUARIO Y EL ID DE MOVIE
    public function deleteByUserAndMovie(Request $request)
    {
        //EJECUTA EL METODO DE ELIMINAR LIKE
        $like = Like::deleteLikeByUserAndMovie($request->idUserLike, $request->idMovieLike);
        if($like ==1){
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($like,200);
        } else{
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($like,400);
        }
    }
}
