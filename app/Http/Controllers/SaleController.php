<?php

namespace App\Http\Controllers;

use App\Http\Models\StatusRent;
use App\Http\Models\StatusSale;
use App\Http\Requests\SaleRequest;
use App\Movie;
use App\Rent;
use App\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::getAllActive();
        return response()->json($sales, 200);
    }

    public function getAll()
    {
        $sales = Sale::getSaleWithNamesAndMovies();
        return response()->json($sales, 200);
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
    public function store(SaleRequest $request)
    {
        $movie = Movie::find($request->idMovieSale);
        if ($movie==null){
            return response()->json($movie,400);
        }
        $sale = new Sale();
        $sale->idUserSale = $request->idUserSale;
        $sale->idMovieSale = $request->idMovieSale;
        $sale->dateSale= $request->dateSale;
        $sale->statusSale = StatusSale::$done;
        $sale->totalSale = $movie->purchasePriceMovie;
        $sale->save();

        $movie->stockMovie -=1;
        $movie->save();
        return response()->json($sale,200);
    }


    public function cancelSale(Request $request){
        $sale = Sale::findOrFail($request->idSale);
        $sale->statusSale = StatusSale::$cancelled;
        $sale->save();
        $movie = Movie::find($sale->idMovieSale);
        $movie->stockMovie +=1;
        $movie->save();
        return $sale;
    }

    public function doneSale(Request $request){
        $sale = Sale::findOrFail($request->idSale);
        $sale->statusSale = StatusSale::$done;
        $sale->save();
        $movie = Movie::find($sale->idMovieSale);
        $movie->stockMovie -=1;
        $movie->save();
        return $sale;
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
