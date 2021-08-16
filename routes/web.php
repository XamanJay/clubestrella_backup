<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/','/es');

Route::group(['prefix' => '{locale}'],function(){

    
    Auth::routes();
    Route::post('/request-token','Auth\ResetPasswordController@requestToken')->name('request.token')->middleware('guest');
    Route::get('/reset-password/{token}','Auth\ResetPasswordController@showResetForm')->name('reset.password')->middleware('guest');
    Route::post('/reset-password','Auth\ResetPasswordController@resetEmail')->name('reset.password')->middleware('guest');

    Route::get('/', 'InicioController@index')->name('welcome');

    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::get('/perfil','Dashboard\Cliente\ClienteController@info')->name('perfil');
    Route::get('/update-perfil','Dashboard\Cliente\ClienteController@perfil')->name('update-perfil');
    Route::post('/perfil','Dashboard\Cliente\ClienteController@updatePerfil')->name('update.perfil');
    Route::get('/recompensas','Dashboard\Cliente\ClienteController@index')->name('recompensas');

    Route::get('/contacto','InicioController@contacto')->name('contacto');
    Route::post('/contacto', 'InicioController@storeContacto')->name('post.contacto');

    Route::get('/qr_factura','QR\QRController@index')->name('qr.factura');
    Route::post('/qr_factura','QR\QRController@store')->name('qr.factura');

    Route::get('/qr-login','Auth\LoginController@qr')->name('qr.login')->middleware('guest');
    Route::post('/qr-login','Auth\LoginController@qrLogin')->name('post.qr')->middleware('guest');

    Route::get('/estado_cuenta','Dashboard\Cliente\ClienteController@estadoCuenta')->name('estado_cuenta');
    Route::get('/checkout','Dashboard\Cliente\ClienteController@checkout')->name('checkout');
    Route::post('/checkout','Dashboard\Cliente\ClienteController@postCheckOut');
    Route::get('/payment','Dashboard\Cliente\ClienteController@payment')->name('payment');
    Route::post('/payment','Dashboard\Cliente\ClienteController@postPayment')->name('payment');

    Route::get('/admin','Admin\AdminController@login')->name('admin-login');
    Route::post('/admin','Admin\AdminController@postLogin')->name('login-admin');

    Route::get('/dashboard','Dashboard\DashboardController@index')->name('dashboard')->middleware('empleado');
    Route::get('/edit-cliente/{id}','Dashboard\DashboardController@cliente')->name('edit-cliente')->middleware('empleado');
    Route::post('/edit-cliente/{id}','Dashboard\DashboardController@update')->name('update-cliente')->middleware('empleado');
    Route::get('/detalles-puntos/{id}','Dashboard\DashboardController@puntos')->name('detalles-puntos')->middleware('empleado');
    Route::post('/detalles-puntos/{id}','Dashboard\DashboardController@updatePuntos')->name('detalles-puntos')->middleware('supervisor');
    Route::get('/devolucion/{id}','Dashboard\DashboardController@devolucion')->name('devolucion')->middleware('empleado');
    Route::post('/devolucion/{id}','Dashboard\DashboardController@updateDevolucion')->name('post.devolucion')->middleware('supervisor');
    Route::post('/restore-canje/{id}','Dashboard\DashboardController@restoreCanje')->name('restore.canje')->middleware('supervisor');
    Route::get('/carga-puntos/{id}','Dashboard\DashboardController@cargaPuntos')->name('carga.puntos')->middleware('supervisor');
    Route::post('/carga-puntos/{id}','Dashboard\DashboardController@storePuntos')->name('store.puntos')->middleware('supervisor');
    Route::get('/canje-premio/{id}','Dashboard\DashboardController@canje')->name('canje.premio')->middleware('supervisor');
    Route::post('/canje-premio/{id}','Dashboard\DashboardController@storeCanje')->name('store.premio')->middleware('supervisor');
    Route::get('/editar-rol/{id}','Dashboard\DashboardController@editRol')->name('edit.rol')->middleware('admin');
    Route::post('/update-rol/{id}','Dashboard\DashboardController@updateRol')->name('update.rol')->middleware('admin');
    Route::get('/puntos-dobles','Dashboard\DashboardController@puntosDobles')->name('puntos.dobles')->middleware('supervisor');
    Route::post('/puntos-dobles','Dashboard\DashboardController@updatePuntosDobles')->name('update.puntos.dobles')->middleware('supervisor');
    Route::get('/premios-club','Dashboard\DashboardController@premiosClub')->name('premios.club')->middleware('supervisor');
    Route::get('/edit-premio-club/{id}','Dashboard\DashboardController@editPremioClub')->name('premio.club')->middleware('supervisor');
    Route::post('/edit-premio-club/{id}','Dashboard\DashboardController@updatePremioClub')->name('update.premio.club')->middleware('supervisor');
    Route::post('/delete-premio-club','Dashboard\DashboardController@destroyRegalo')->name('destroy.premio.club')->middleware('supervisor');
    Route::get('/tarjetas-club','Dashboard\DashboardController@tarjetasClub')->name('tarjetas.club')->middleware('supervisor');


    Route::get('/stop-sale-comercial','Dashboard\StopSaleCuentaComercialController@index')->name('stop.sale.comercial')->middleware('supervisor');
    Route::get('/new-stop-sale-comercial','Dashboard\StopSaleCuentaComercialController@create')->name('create.stop.sale.comercial')->middleware('supervisor');
    Route::post('/new-stop-sale-comercial','Dashboard\StopSaleCuentaComercialController@store')->name('store.stop.sale.comercial')->middleware('supervisor');
    Route::get('/destroy-stop-sale-comercial/{id}','Dashboard\StopSaleCuentaComercialController@destroy')->name('destroy.stop.sale.comercial')->middleware('supervisor');

    Route::get('/stop-sale-clubestrella','Dashboard\StopSaleClubEstrellaController@index')->name('stop.sale.clubestrella')->middleware('supervisor');
    Route::get('/new-stop-sale-clubestrella','Dashboard\StopSaleClubEstrellaController@create')->name('create.stop.sale.clubestrella')->middleware('supervisor');
    Route::post('/new-stop-sale-clubestrella','Dashboard\StopSaleClubEstrellaController@store')->name('store.stop.sale.clubestrella')->middleware('supervisor');
    Route::get('/destroy-stop-sale-clubestrella/{id}','Dashboard\StopSaleClubEstrellaController@destroy')->name('destroy.stop.sale.clubestrella')->middleware('supervisor');


    Route::get('/cuenta-comercial', 'Cuenta_Comercial\CuentaComercialController@index')->name('cuenta.comercial')->middleware(['auth','empleado']);
    Route::get('import-excel', 'Cuenta_Comercial\CuentaComercialController@importExcel');
    Route::get('/import-arpon', 'Cuenta_Comercial\CuentaComercialController@importArpon');
    Route::get('/new-empresa','Cuenta_Comercial\CuentaComercialController@create')->name('new.empresa')->middleware('empleado');
    Route::post('/new-empresa','Cuenta_Comercial\CuentaComercialController@store')->name('store.empresa')->middleware('empleado');
    Route::get('/edit-empresa/{id}','Cuenta_Comercial\CuentaComercialController@show')->name('edit.empresa')->middleware('empleado');
    Route::post('/edit-empresa/{id}','Cuenta_Comercial\CuentaComercialController@update')->name('update-empresa')->middleware('empleado');
    Route::get('/delete-empresa/{id}','Cuenta_Comercial\CuentaComercialController@delete')->name('delete-empresa')->middleware('supervisor');

    Route::get('/temporadas-comerciales','Temporadas\TemporadaComercialController@index')->name('temporadas.comerciales')->middleware('supervisor');
    Route::get('/new-temporada','Temporadas\TemporadaComercialController@create')->name('create.temporada')->middleware('supervisor');
    Route::post('/new-temporada','Temporadas\TemporadaComercialController@store')->name('store.temporada')->middleware('supervisor');
    Route::get('/destroy-temporada/{id}','Temporadas\TemporadaComercialController@destroy')->name('destroy.temporada')->middleware('supervisor');

    Route::get('/not-authorized','InicioController@notAuthorized')->name('no-authorized');
    Route::get('/not-found','InicioController@notFound')->name('not-found');

    Route::get('/ramada-notify','RamadaController@index')->name('ramada.notify');
});






