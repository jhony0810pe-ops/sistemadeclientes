<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\MikroTikController;

/*
|--------------------------------------------------------------------------
| PÁGINA PRINCIPAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| FACTURAS
|--------------------------------------------------------------------------
*/
Route::resource('facturas', FacturaController::class);

/*
|--------------------------------------------------------------------------
| CONTROL DE INTERNET
|--------------------------------------------------------------------------
*/
Route::get('/mikrotik/wifi', [MikroTikController::class, 'wifi'])
    ->name('mikrotik.wifi');

Route::post('/mikrotik/wifi/agregar-ip', [MikroTikController::class, 'agregarIp'])
    ->name('mikrotik.wifi.agregar');

Route::post('/mikrotik/wifi/{id}/habilitar', [MikroTikController::class, 'enableWifi'])
    ->name('mikrotik.wifi.enable');

Route::post('/mikrotik/wifi/{id}/cortar', [MikroTikController::class, 'disableWifi'])
    ->name('mikrotik.wifi.disable');

Route::post('/mikrotik/wifi/{id}/deshabilitar', [MikroTikController::class, 'deshabilitarWifi'])
    ->name('mikrotik.wifi.deshabilitar');

/*
|--------------------------------------------------------------------------
| USUARIOS PPPoE
|--------------------------------------------------------------------------
*/
Route::get('/mikrotik', [MikroTikController::class, 'ppp'])
    ->name('mikrotik.ppp');

Route::post('/mikrotik/ppp/habilitar/{id}', [MikroTikController::class, 'habilitarPPP'])
    ->name('mikrotik.ppp.habilitar');

Route::post('/mikrotik/ppp/deshabilitar/{id}', [MikroTikController::class, 'deshabilitarPPP'])
    ->name('mikrotik.ppp.deshabilitar');

/*
|--------------------------------------------------------------------------
| MOROSOS
|--------------------------------------------------------------------------
*/
Route::get('/morosos', [MikroTikController::class, 'morosos'])
    ->name('mikrotik.morosos');

Route::post('/morosos/agregar', [MikroTikController::class, 'agregarMoroso'])
    ->name('mikrotik.morosos.agregar');

Route::post('/morosos/habilitar/{id}', [MikroTikController::class, 'habilitarMoroso'])
    ->name('mikrotik.morosos.habilitar');

Route::post('/morosos/deshabilitar/{id}', [MikroTikController::class, 'deshabilitarMoroso'])
    ->name('mikrotik.morosos.deshabilitar');

Route::delete('/morosos/eliminar/{id}', [MikroTikController::class, 'eliminarMoroso'])
    ->name('mikrotik.morosos.eliminar');

/*
|--------------------------------------------------------------------------
| CREAR Y LISTAR CLIENTES PPPoE
|--------------------------------------------------------------------------
*/
Route::get('/mikrotik/listarPPoe', [MikroTikController::class, 'listarPPoe']);
Route::get('/mikrotik/crearPPoe', [MikroTikController::class, 'mostrarCrearPPoe']);
Route::post('/mikrotik/crearPPoe', [MikroTikController::class, 'crearPPoe']);
