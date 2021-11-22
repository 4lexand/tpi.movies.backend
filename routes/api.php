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


Route::post('/login', 'LoginController@onLogin'); //login donde verifica las credenciales
Route::get('/users', 'UserController@index'); //mostrar usuarios existentes
Route::post('/users', 'UserController@store'); //crear usuarios
Route::put('/users/{idUser}', 'UserController@update'); //actualiza usuarios
Route::put('/users-change-password', 'UserController@changePassword'); //cambiar la contrasena de un usuario
Route::delete('/users/{idUser}', 'UserController@destroy'); //elimina usuarios

Route::get('/movies-all', 'MovieController@getAll'); //muestra todas las peliculas
Route::get('/movies', 'MovieController@index'); //muestra solamente peliculas disponibles o con stock
Route::get('/movies-search/{idMovie}', 'MovieController@getSpecificMovie'); //muestra peliculas por id de pelicula
Route::get('/movies/{idUser}', 'MovieController@getAllByUser'); //muestra peliculas con caractreristicas filtradas por usuario
Route::post('/movies', 'MovieController@store'); //crear nueva pelicula
Route::put('/movies/{idMovie}', 'MovieController@update'); //actualizar pelicula
Route::delete('/movies/{idMovie}', 'MovieController@destroy'); //eliminar pelicula

Route::get('/likes', 'LikeController@index'); //ver lista de likes
Route::post('/likes', 'LikeController@store'); //crear nuevo like
Route::delete('/likes/{idLike}', 'LikeController@destroy'); //eliminar un like por id de like
Route::delete('/likes/', 'LikeController@deleteByUserAndMovie'); //eliminar like recibiendo el id de usuario y el id de pelicula


Route::get('/rents-all', 'RentController@getAll'); //ver todas las rentas
Route::get('/rents', 'RentController@index'); //ver lista rentas activas
Route::get('/rents/arrear/{idRent}', 'RentController@getArrearById'); //ver mora por id de renta
Route::post('/rents', 'RentController@store'); //crear renta
Route::put('/rents/done/{idRent}', 'RentController@returnRent'); //cerrar renta teniendo la devolucion de la pelicula
Route::put('/rents/cancel/{idRent}', 'RentController@cancelRent'); //cancela renta por algun error


Route::get('/sales-all', 'SaleController@getAll'); //ver todas las ventas
Route::get('/sales', 'SaleController@index'); //ver lista de ventas activas
Route::post('/sales', 'SaleController@store'); //crear venta
Route::put('/sales/cancel/{idSale}', 'SaleController@cancelSale'); //cambia el estado de la venta a cancelado
Route::put('/sales/done/{idSale}', 'SaleController@doneSale'); //cambia el estado de la venta a hecho
