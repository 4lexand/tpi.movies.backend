<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Like;
use App\Movie;
use App\User;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Movie[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        //DEVUELVE TODAS LAS PELICULAS CON SU CANTIDAD DE LIKES
        $movies = $this->getMoviesAndCountLikes();

        //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
        return response()->json($movies,200) ;

    }

    //OBTIENE UNA PELICULA EN ESPECIFICO
    public function getSpecificMovie(Request $request)
    {
        //EJECUTA EL METODO DEL MODELO MOVIE
        $movie = Movie::getSpecificMovie($request->idMovie);
        if ($movie != null) {
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($movie, 200);
        } else {
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($movie, 400);
        }
    }
    //OBTIENE TODAS LAS PELICULAS
    public function getAll()
    {
        //obtiene todas las movies
        $movies = Movie::all();
        //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
        return response()->json($movies,200);
    }
    //OBTIENE TODAS LAS PELICULAS QUE UN USUARIO HA LIKEADO Y DEVUELVE TRUE OR FALSE DEPENDIENDO
    //SI SE ENCUENTRA UN LIKE DE ESE USUARIO A ESA PELICULA EN ESPECIFICO
    public function getAllByUser(Request $request)
    {
        //OBTIENE TODO EL LISTADO DE PELICULAS CON SU CANTIDAD DE LIKES
        $movies = $this->getMoviesAndCountLikes();
        //RECORRE CADA PELICULA
        foreach ($movies as $item) {
            //SE OBTIENE ESTADO SI EL USUARIO LE HA DADO LIKE A ESA PELICULA EN ESPECIFICO
            $likes = Like::getCountSpecificUserAndMovie($request->idUser, $item->id);
            if ($likes == 0) {
                //SE SETEA LA VARIABLE PARA SABER SI EL USUARIO LE HA DADO LIKE O NO
                $item->likeUserMovie = false;
            } else {
                $item->likeUserMovie = true;
            }

        }
        //RETORNA EL LISTADO DE LAS PELICULAS
        return $movies;
    }

    //OBTIENE TODAS LAS PELICULAS DISPONIBLES Y CON SU CANTIDAD DE LIKES
    private function getMoviesAndCountLikes()
    {
        //OBTIENE TODAS LAS PELICULAS DISPLONBLES
        $movies = Movie::getAvailableMovies();
        //RECORRE CADA ELEMENTO
        foreach ($movies as $item) {
            //CUENTA LA CANTIDAD DE LIKES QUE ESTA POSEE
            $likes = Like::getCountSpecificMovie($item->id);
            $item->likesMovie = $likes;
        }
        //RETORNA EL LISTADO DE PELICULAS CON LA CANTIDAD DE LIKES
        return $movies;
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
    //CREA UNA NUEVA PELICULA
    public function store(MovieRequest $request)
    {
        $movie = new Movie();
        $movie->titleMovie = $request->titleMovie;
        $movie->descriptionMovie = $request->descriptionMovie;
        $movie->urlImageMovie = $request->urlImageMovie;
        $movie->urlTrailerMovie = $request->urlTrailerMovie;
        $movie->stockMovie = $request->stockMovie;
        $movie->rentalPriceMovie = $request->rentalPriceMovie;
        $movie->purchasePriceMovie = $request->purchasePriceMovie;
        $movie->availabilityMovie = $request->availabilityMovie;
        //GUARDA LA PELICULA
        $movie->save();
        //RETORNA LA PELICYULA GUARDADA
        return $movie;
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

    //ACTUALIZA UNA PELICULA
    public function update(MovieRequest $request)
    {
        //PRIMERO REVISA SI EXISTE Y SINO FALLARA LA PETICION
        $movie = Movie::findOrFail($request->idMovie);
        $movie->titleMovie = $request->titleMovie;
        $movie->descriptionMovie = $request->descriptionMovie;
        $movie->urlImageMovie = $request->urlImageMovie;
        $movie->urlTrailerMovie = $request->urlTrailerMovie;
        $movie->stockMovie = $request->stockMovie;
        $movie->rentalPriceMovie = $request->rentalPriceMovie;
        $movie->purchasePriceMovie = $request->purchasePriceMovie;
        $movie->availabilityMovie = $request->availabilityMovie;
        //LA GUARDA
        $movie->save();
        //RETORNA LA PELICULA GUARDADA
        return $movie;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    //ELIMINA UNA PELICULA POR EL ID DE MOVIE
    public function destroy(Request $request)
    {
        //EJECUTA EL METODOD E DESTRUCCION POR EL ID DE LA PELICULA
        $movie = Movie::destroy($request->idMovie);
        if ($movie == 1) {

            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($movie, 200);
        } else {
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($movie, 400);
        }
    }
}
