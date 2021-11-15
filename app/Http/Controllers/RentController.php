<?php

namespace App\Http\Controllers;

use App\Http\Models\StatusRent;
use App\Http\Requests\RentRequest;
use App\Movie;
use App\Rent;
use Illuminate\Http\Request;

class RentController extends Controller
{
    private $daysToRent = 7;
    private $arrear = 0.20;

    private function calcSubTotalRent($price)
    {
        return round(($price * $this->daysToRent), 2);
    }

    private function calcReturnDateRent($dateRent)
    {
        return date("Y-m-d", strtotime($dateRent . "+" . $this->daysToRent . "days"));
    }

    private function calcArrearRent($returnDateRent, $rentalPrice)
    {
        $currentDate = strtotime(date("Y-m-d"));
        $returnDate = strtotime($returnDateRent);
        if ($currentDate > $returnDate) {
            return round($rentalPrice * $this->arrear,2) ;
        } else {
             return round(0.0,2);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rent = Rent::getAllActive();
        return response()->json($rent,200);

    }

    public function getAll(){
        $rent = Rent::getRentWithNamesAndMovies();
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
    public function store(RentRequest $request)
    {
        $movie = Movie::find($request->idMovieRent);
        if ($movie==null){
            return response()->json($movie,400);
        }
        $rent = new Rent();
        $rent->idUserRent = $request->idUserRent;
        $rent->idMovieRent = $request->idMovieRent;
        $rent->dateRent = $request->dateRent;
        $rent->returnDateRent = $this->calcReturnDateRent($request->dateRent);
        $rent->subtotalRent = $this->calcSubTotalRent($request->subtotalRent);
        $rent->statusRent = StatusRent::$inProgress;
        $rent->save();

        $movie->stockMovie -=1;
        $movie->save();
        return response()->json($rent,200);
    }

    public function returnRent(Request $request){

        $rent = Rent::findOrFail($request->idRent);
        $movie = Movie::find($rent->idMovieRent);
        if ($movie==null){
            return response()->json($movie,400);
        }
        $rent->arrearRent = $this->calcArrearRent($rent->returnDateRent, $rent->subtotalRent);
        $rent->totalRent = round($rent->subtotalRent + $rent->arrearRent,2);
        $rent->returnValidDateRent = date('Y-m-d');
        $rent->statusRent = StatusRent::$done;
        $rent->save();
        $movie->stockMovie +=1;
        $movie->save();
        return response()->json($rent,200);
    }

    public function cancelRent(Request $request){
        $rent = Rent::findOrFail($request->idRent);
        $rent->statusRent = StatusRent::$cancelled;
        $rent->save();
        return $rent;
    }

    public function getArrearById(Request $request){
            $rent = Rent::find($request->idRent);
            if($rent != null){
                return response()->json($this->calcArrearRent($rent->returnDateRent, $rent->subtotalRent),200);
            } else{
                return response()->json($rent,400);
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
