<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('clientes/custom','Clientes\ClientesController@userBackUp')->name('clientes.custom');
Route::get('clientes/backup','Clientes\ClientesController@ClienteBackUp')->name('clientes.backup');
Route::get('clientes/puntos_cargados','Clientes\ClientesController@CargaPuntos')->name('clientes.registro_puntos');
Route::get('clientes/puntos_redimidos','Clientes\ClientesController@RedimirPuntos')->name('clientes.redimir_puntos');
Route::get('clientes/update_name','Clientes\ClientesController@LastName')->name('clientes.update_name');
Route::get('clientes/paises', 'Clientes\ClientesController@paises')->name('clientes.paises');
Route::get('sumPuntos/{id}', 'Puntos\PuntosController@sumPuntos')->name('test');
Route::get('okcloud', 'Clientes\ClientesController@okCloud')->name('okcloud');
Route::get('qr_code', 'Clientes\ClientesController@setQR')->name('qr.code');



Route::post('login','Clientes\ClientesController@login')->name('login.cliente');
Route::post('login-adhara','Clientes\ClientesController@loginAdhara')->name('login.adhara');
Route::get('email-login','Clientes\ClientesController@verify')->name('login.email');

Route::get('clientes','Clientes\ClientesController@index')->name('clientes');
Route::post('clientes','Clientes\ClientesController@store')->name('clientes.store');
Route::get('clientes/{id}','Clientes\ClientesController@show')->name('clientes.show');
Route::post('clientes/{id}','Clientes\ClientesController@update')->name('clientes.update');
Route::delete('clientes/{id}','Clientes\ClientesController@destroy')->name('clientes.destroy');
Route::put('clientes/{id}','Clientes\ClientesController@restore')->name('clientes.restore');

Route::get('premios','Premios\PremiosController@index')->name('premios');
Route::post('premios','Premios\PremiosController@store')->name('premios.store');
Route::get('premios/{id}','Premios\PremiosController@show')->name('premios.show');
Route::post('premios/{id}','Premios\PremiosController@update')->name('premios.update');
Route::delete('premios/{id}','Premios\PremiosController@destroy')->name('premios.destroy');
Route::put('premios/{id}','Premios\PremiosController@restore')->name('premios.restore');


Route::get('categorias','Categorias\CategoriaController@index')->name('categorias');
Route::post('categorias','Categorias\CategoriaController@store')->name('categorias.store');
Route::get('categorias/{id}','Categorias\CategoriaController@show')->name('categorias.show');
Route::post('categorias/{id}','Categorias\CategoriaController@update')->name('categorias.update');
Route::delete('categorias/{id}','Categorias\CategoriaController@destroy')->name('categorias.destroy');
Route::put('categorias/{id}','Categorias\CategoriaController@restore')->name('categorias.restore');

Route::get('puntos/{id}','Puntos\PuntosController@show')->name('puntos');
Route::get('show-puntos/{id}','Puntos\PuntosController@showPuntos')->name('show.puntos');
Route::post('puntos/{id}','Puntos\PuntosController@store')->name('puntos.store');
Route::post('puntos/update/{id}','Puntos\PuntosController@update')->name('puntos.update');
Route::get('puntos_cargados/{id}','Puntos\PuntosController@puntosCargados')->name('puntos.cargados');

Route::get('puntos_redimidos/{id}','Redencion_Puntos\RedencionPuntosController@index')->name('puntos.redimidos');
Route::post('redencion_puntos','Redencion_Puntos\RedencionPuntosController@store')->name('puntos.redencion');
Route::get('puntos_vencidos/{id}','Puntos\PuntosController@puntosVencidos')->name('puntos.vencidos');


Route::get('devoluciones/{id}','Devoluciones\DevolucionController@index')->name('devoluciones');
Route::get('devolucion/{id}','Devoluciones\DevolucionController@show')->name('devolucion');
Route::post('devolucion/{id}','Devoluciones\DevolucionController@store')->name('devolucion.store');
Route::post('restore-canje/{id}','Devoluciones\DevolucionController@restore')->name('canje.restore');

Route::post('verify-cuenta-comercial','Cuenta_Comercial\CuentaComercialController@verify');
Route::post('verify-stop-sale-comercial','StopSales\TarifaComercialController@verify');
Route::post('store-tarifa-comerial','StopSales\TarifaComercialController@store');
Route::post('tarifa-comercial','StopSales\TarifaComercialController@show');
Route::post('verify-stop-sale-clubestrella','StopSales\ClubEstrellaController@verify');


Route::get('conversion-puntos/{currency}/{amount}','ConversionPuntos\ConversionPuntosController@index');
Route::get('dinero-to-puntos/{currency}/{amount}','ConversionPuntos\ConversionPuntosController@moneyToPoints');
Route::post('cliente/request-token','Clientes\ClientesController@requestToken');
Route::post('cliente/reset-password','Clientes\ClientesController@resetEmail');


//REPORTEO OKTRIP
Route::get('reservas-oktrip','Oktrip\OktripController@index');





//Route::resource('clientes','Clientes\ClientesController',['only' => ['index','show','update']]);
