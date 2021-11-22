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
    //OBTIENE TODAS LAS VENTAS REALIZADAS
    public function index()
    {
        //OBTIENE TODAS LAS REALIZADAS
        $sales = Sale::getAllActive();
        //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
        return response()->json($sales, 200);
    }

    //OBTIENE TODO EL LISTADO DE VENTAS
    public function getAll()
    {
        //EJECUTA EL METODO DE OBTENER LAS VENTAS CON LOS NOMBRES DE USUARIO Y PELICULAS DEL MODELO SALE
        $sales = Sale::getSaleWithNamesAndMovies();
        //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
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
    //GUARDA UNA NUEVA VENTA
    public function store(SaleRequest $request)
    {
        //BYUSCA LA PELICULA POR EL ID
        $movie = Movie::find($request->idMovieSale);
        //SI NO ENCUENTRA NINGUNA PELICULA DEVIUELVE NULL
        if ($movie == null) {
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($movie, 400);
        }
        //CREA NUEVA VENTA
        $sale = new Sale();
        $sale->idUserSale = $request->idUserSale;
        $sale->idMovieSale = $request->idMovieSale;
        $sale->dateSale = $request->dateSale;
        $sale->statusSale = StatusSale::$done;
        $sale->totalSale = $movie->purchasePriceMovie;
        //GUARDA L;A VENTA
        $sale->save();
        //REDUCE EL STOCK DE LA PELICULA EN UNA UNIDAD
        $movie->stockMovie -= 1;
        //ACTUALIZA LA PELICULA
        $movie->save();
        //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
        return response()->json($sale, 200);
    }

//CANCELA UNA VENTA
    public function cancelSale(Request $request)
    {
        //ENCUENTRA LA VENTA POR MEDIO DEL ID
        $sale = Sale::findOrFail($request->idSale);
        //CAMBIA EL ESTADO A CANCELADO
        $sale->statusSale = StatusSale::$cancelled;
        //ACTUALIZA
        $sale->save();
        //BUSCA LA PELICULA Y AUMENTA ENB UNA UNIDAD EL STOCK
        $movie = Movie::find($sale->idMovieSale);
        $movie->stockMovie += 1;
        //ACTUALIZA LOS DATOS
        $movie->save();
        return $sale;
    }

    //MARCA UNA VENTA COMO REALIZADA
    public function doneSale(Request $request)
    {
        //BUSCA LA VENTA POR ID
        $sale = Sale::findOrFail($request->idSale);
        //CAMBIA EL ESTADO A DONE
        $sale->statusSale = StatusSale::$done;
        //ACTUALIZA ESTADO
        $sale->save();
        //BUSCA LA PELICULA Y REDUCE EN UNA UNIDAD EL STOCK DE LA PELICYULA
        $movie = Movie::find($sale->idMovieSale);
        $movie->stockMovie -= 1;
        //ACTUALIZA LOS DATOS
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
