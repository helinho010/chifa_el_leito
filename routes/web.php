<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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


Route::get('/', function () {
    return view('welcome');
})->name('bienvenido');

Route::get('/ventaProductos', function () {
    return view('ventaProductos');
})->name('venta.Productos');

Route::get('/login', function () {
    return view('login');
});

Route::post('/autenticacionLogin',[LoginController::class, 'autenticacionLogin'])->name('auth.login');

Route::get('/crearFuncionario', function () {
    return view('formFuncionario');

})->name('get.crear.funcionario') ;

Route::post('/registroFuncionario',[LoginController::class, 'crearFuncionario'])->name('crear.funcionario');

Route::get('/mostrarFuncionario/{id}/{mensaje}',[LoginController::class, 'mostrarFuncionario'])->name('mostrar.funcionario');
