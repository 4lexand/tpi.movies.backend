<?php

namespace App\Http\Controllers;

use App\Http\Models\StatusRent;
use App\Http\Requests\RentRequest;
use App\Movie;
use App\Rent;
use Illuminate\Http\Request;

class RentController extends Controller
{
    // SE SETEA LAS VARIABLES POR DEFECTO QUE SE USARAN
    private $daysToRent = 7; //PARA LA CANTIDAD OPOR DEFECTO DE DIAS QUE SE RENTARA UNA PELICULA
    private $arrear = 0.20; //EL PORCENTAJE DE MORA QUE TENDRA

    //CALCULA EL SUBTOTAL DE LA RENTA
    private function calcSubTotalRent($price)
    {
        //MULTIPLICA EL PRECIO POR LOS DIAS A RENTAR
        return round(($price * $this->daysToRent), 2);
    }

    //CALCULA LA FECHA ESPERADA DE DEVOLUCION DE LA RENTA
    private function calcReturnDateRent($dateRent)
    {
        //CALCULA LA FECCHA ACTUAL Y LE SUMA 7 DIAS
        return date("Y-m-d", strtotime($dateRent . "+" . $this->daysToRent . "days"));
    }

    //CALCULA LA MORA DE UNA RENTA
    private function calcArrearRent($returnDateRent, $rentalPrice)
    {
        //OBTIENE LA FECHA ACTUAL
        $currentDate = strtotime(date("Y-m-d"));
        //FORMATEA LA FECHA ESPERADA DE DEVOLUCION DE LA PELICULA
        $returnDate = strtotime($returnDateRent);
        //VERIFICA SI LA FECHA ACTUAL ES MAYOR QUE LA DE DEVOLUCION
        if ($currentDate > $returnDate) {
            //CALCULA EL TOTAL DE LA RENTA MULTIPLICADO POR EL PORCENTAJE ANTES DEFINIDO
            return round($rentalPrice * $this->arrear, 2);
        } else {
            //RETORNA EL VALOR DE 0 QUE ES LA MORA SI NO SE HA PASADO LAS FECHAS
            return round(0.0, 2);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // OBTIENE TODAS LAS RENTAS EN PROGRESO
    public function index()
    {
        $rent = Rent::getAllActive();
        //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
        return response()->json($rent, 200);

    }

    //OBTIENE TODAS LAS RENTAS SIN IMPORTAR SU ESTADO
    public function getAll()
    {
        //OBTIENE TODAS LAS RETNAS CON LOS NOMBRES DE USUARIOS Y LOS TITULOS DE PELICULAS
        $rent = Rent::getRentWithNamesAndMovies();
        //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
        return response()->json($rent, 200);
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
    //GUARDA UNA NUEVA RENTA
    public function store(RentRequest $request)
    {
        //BUSCA LA PELICULA A RENTAR
        $movie = Movie::find($request->idMovieRent);

        //SI NO ENCUENTRA ESA PELICULA RETORNA STATUS 400
        if ($movie == null) {
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($movie, 400);
        }
        //CREA NUEVA RENTA
        $rent = new Rent();
        $rent->idUserRent = $request->idUserRent;
        $rent->idMovieRent = $request->idMovieRent;
        $rent->dateRent = $request->dateRent;
        //CALCULA LA FECHA DE DEVOLUCION ESPERADA
        $rent->returnDateRent = $this->calcReturnDateRent($request->dateRent);
        //CALCULA EL SUBTOTAL DE LA RENTA
        $rent->subtotalRent = $this->calcSubTotalRent($request->subtotalRent);
        //SETEA EL ESTADO DE LA RENTA EN PROGRESO
        $rent->statusRent = StatusRent::$inProgress;
        //GUARDA LA RENTA
        $rent->save();
        //REDUCE EL STOCK DE LA PELICULA EN UNA UNIDAD
        $movie->stockMovie -= 1;
        //ACTUALIZA LOS DATOS DE LA PELICULA
        $movie->save();
        //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
        return response()->json($rent, 200);
    }

    //METODO DE RETORNO DE LA RENTA CUANDO EL CLIENTE YA REGRESA CON LA PELICULA
    public function returnRent(Request $request)
    {
        //ENCUENTRA LA RENTA POR MEDIO DEL ID
        $rent = Rent::findOrFail($request->idRent);
        //ENCUENTRA LA PELICULA POR MEDIO DEL ID QUE SE ENCONTRO EN EL REGISTRO ANTERIOR
        $movie = Movie::find($rent->idMovieRent);
        //SI NO ENCYUENTRA LA PELICULA
        if ($movie == null) {
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($movie, 400);
        }
        //CALCULA LA MORA DE LA RENTA
        $rent->arrearRent = $this->calcArrearRent($rent->returnDateRent, $rent->subtotalRent);
        //CALCULA EL TOTAL DE LA RENTA QUE ES EL SUBTOTAL CON LA MORA
        $rent->totalRent = round($rent->subtotalRent + $rent->arrearRent, 2);
        //GUARDA LA FECHA REAL DE LA DEVOLUCION
        $rent->returnValidDateRent = date('Y-m-d');
        //SETEA EL ESTADO EN HECHO
        $rent->statusRent = StatusRent::$done;
        //ACTUALIZA EL REGISTRO DE LA RENTA
        $rent->save();
        //AUMENTA EL STOCK DE LAS PELICULAS EN UNA UNIDAD
        $movie->stockMovie += 1;
        //ACTUALIZA LA PELICULA
        $movie->save();
        //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
        return response()->json($rent, 200);
    }

    //SETEAR EL ESTADO DE LA RENTA EN CANCELADA
    public function cancelRent(Request $request)
    {
        //BUSCA LA RENTA POR ID
        $rent = Rent::findOrFail($request->idRent);
        //SETEA EL ESTADO EN CANCELADA
        $rent->statusRent = StatusRent::$cancelled;
        //ACTUALIZA DATOS
        $rent->save();
        return $rent;
    }

    //CALCULA LA MORA QUE DEBE DE PAGAR EL USUARIO POR MEDIO DEL ID DE LA RENTA
    public function getArrearById(Request $request)
    {
        //ENCUENTRA LA RENTA
        $rent = Rent::find($request->idRent);
        //SI  ENCUENTRA EL ID DE LA RENTA
        if ($rent != null) {
            //RETORNA LA RESPUESTA DEL CALCULO TOTAL DE MORA CON SU CORRESPONDIENTE STATUS
            return response()->json($this->calcArrearRent($rent->returnDateRent, $rent->subtotalRent), 200);
        } else {
            //RETORNA LA RESPUESTA CON SU CORRESPONDIENTE STATUS
            return response()->json($rent, 400);
        }

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
