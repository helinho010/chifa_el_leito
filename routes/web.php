<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ventaProductosController;

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



Route::get('/login', function () {
    return view('login');
})->name('inicio.session');
Route::post('/autenticacionLogin',[LoginController::class, 'autenticacionLogin'])->name('auth.login');
Route::post('/cerrarSession',[LoginController::class, 'borrarSession'])->name('cerrar.session');



Route::get('/ventaProductos', function () {
    return view('ventaProductos');
})->name('venta.Productos');
Route::post('/imprimirDetalleVentaFuncionario',[ventaProductosController::class, 'imprimirDetalleVenta'])->name('imprimir.detalleVenta');
Route::post('/reporteArqueoFuncionario',[ventaProductosController::class, 'reporteArqueoFuncionario']);



Route::get('/crearFuncionario', function () {
    return view('formFuncionario');
})->name('get.crear.funcionario') ;



Route::post('/registroFuncionario',[LoginController::class, 'crearFuncionario'])->name('crear.funcionario');
Route::get('/mostrarFuncionario/{id}/{mensaje}',[LoginController::class, 'mostrarFuncionario'])->name('mostrar.funcionario');




Route::post('/buscarProductos',[ventaProductosController::class, 'buscarProducto'])->name('buscar.producto');


/*
* Rutas para insertar y mostrar el producto creado
*/
Route::post('/registroProducto',[ventaProductosController::class, 'crearProducto'])->name('crear.producto');
Route::get('/mostrarProducto/{id}/{mensaje}',[ventaProductosController::class, 'mostrarProducto'])->name('mostrar.producto');
Route::get('/registroProducto', function () {
    return view('formAddProducto');
})->name('form.add.producto');



/*
* Ruta de Prueba de impresion
*/
//Route::get('/imp',[ventaProductosController::class, 'imprimirDetalleVenta'])->name('imprimir');






/*
* Admin - Plantilla
*/
Route::get('/admin',function(){
    return view('admin-plantilla.index');
})->name('admin.plantilla');