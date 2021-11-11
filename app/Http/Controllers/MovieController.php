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
        if (isset($request->idUser)) {
            $movies = $this->getMoviesAndCountLikes();
            foreach ($movies as $item) {

                $likes = Like::getCountSpecificUserAndMovie($request->idUser, $item->id);
                if($likes == 0 ){
                    $item->likeUserMovie = false;
                } else{
                    $item->likeUserMovie = true;
                }

            }
            return $movies;
        } else {
            $movies = $this->getMoviesAndCountLikes();
            return $movies;
        }

    }

    private function getMoviesAndCountLikes()
    {
        $movies = Movie::all();
        foreach ($movies as $item) {

            $likes = Like::getCountSpecificMovie($item->id);
            $item->likesMovie = $likes;
        }
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
    public function store(MovieRequest $request)
    {
        $movie = new Movie();
        $movie->titleMovie = $request->titleMovie;
        $movie->descriptionMovie = $request->descriptionMovie;
        $movie->urlImageMovie = $request->urlImageMovie;
        $movie->urlTrailerMovie = $request->urlTrailerMovie;
        $movie->stockMovie = $request->stockMovie;
        $movie->rentalPriceMovie =$request->rentalPriceMovie;
        $movie->purchasePriceMovie = $request->purchasePriceMovie;
        $movie->availabilityMovie = $request->availabilityMovie;
        $movie->save();
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
    public function update(MovieRequest $request)
    {
        $movie = Movie::findOrFail($request->idMovie);
        $movie->titleMovie = $request->titleMovie;
        $movie->descriptionMovie = $request->descriptionMovie;
        $movie->urlImageMovie = $request->urlImageMovie;
        $movie->urlTrailerMovie = $request->urlTrailerMovie;
        $movie->stockMovie = $request->stockMovie;
        $movie->rentalPriceMovie =$request->rentalPriceMovie;
        $movie->purchasePriceMovie = $request->purchasePriceMovie;
        $movie->availabilityMovie = $request->availabilityMovie;
        $movie->save();
        return $movie;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $movie = Movie::destroy($request->idMovie);
        if($movie==1){
            return response()->json($movie, 200);
        } else{
            return response()->json($movie, 400);
        }
    }
}
