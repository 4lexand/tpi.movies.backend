<?php

//use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::post('/login', 'LoginController@onLogin'); //login
Route::get('/users', 'UserController@index'); //mostrar usuarios
Route::post('/users', 'UserController@store'); //crear usuarios
Route::put('/users/{idUser}', 'UserController@update'); //actualiza usuarios
Route::delete('/users/{idUser}', 'UserController@destroy'); //elimina usuarios

Route::get('/movies-all', 'MovieController@getAll'); //muestra peliculas
Route::get('/movies', 'MovieController@index'); //muestra peliculas
Route::get('/movies/{idMovie}', 'MovieController@index'); //muestra peliculas por id de pelicula
Route::get('/movies/{idUser}', 'MovieController@index'); //muestra peliculas
Route::post('/movies', 'MovieController@store'); //crear pelicula
Route::put('/movies/{idMovie}', 'MovieController@update'); //actualizar pelicula
Route::delete('/movies/{idMovie}', 'MovieController@destroy'); //eliminar pelicula

Route::get('/likes', 'LikeController@index'); //ver lista like
Route::post('/likes', 'LikeController@store'); //crear like
Route::delete('/likes/{idLike}', 'LikeController@destroy'); //eliminar like
Route::delete('/likes/', 'LikeController@deleteByUserAndMovie'); //eliminar like


Route::get('/rents', 'RentController@index'); //ver lista rentas
Route::get('/rents/arrear/{idRent}', 'RentController@getArrearById'); //ver mora p[or id de renta
Route::post('/rents', 'RentController@store'); //crear renta
Route::put('/rents/{idRent}', 'RentController@returnRent'); //cerrar renta teniendo la devolucion de la pelicula
