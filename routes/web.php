<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlantillaAdminController;
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


/*Route::get('/', function () {
    return view('welcome');
})->name('bienvenido');
*/


Route::get('/', function () {
    return view('login');
})->name('inicio.session');
Route::post('/autenticacionLogin',[LoginController::class, 'autenticacionLogin'])->name('auth.login');
Route::post('/cerrarSession',[LoginController::class, 'borrarSession'])->name('cerrar.session');



Route::get('/ventaProductos', function () {
    return view('ventaProductos');
})->name('venta.Productos');
Route::post('/imprimirDetalleVentaFuncionario',[ventaProductosController::class, 'imprimirDetalleVenta'])->name('imprimir.detalleVenta');
Route::post('/imprimirDetalleVentaFuncionarioModal',[ventaProductosController::class, 'imprimirDetalleVentaModal'])->name('imprimir.modal.detalleVenta');
Route::post('/reporteArqueoFuncionario',[ventaProductosController::class, 'reporteArqueoFuncionario']);



Route::get('/crearFuncionario', function () {
    return view('formFuncionario');
})->name('get.crear.funcionario') ;

Route::post('/registroFuncionario',[LoginController::class, 'crearFuncionario'])->name('crear.funcionario');
Route::get('/mostrarFuncionario/{id}/{mensaje}',[LoginController::class, 'mostrarFuncionario'])->name('mostrar.funcionario');
Route::post('/cambioPassword',[LoginController::class, 'cambioPassword'])->name('cambio.password');




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
// Ruta que actualiza los datos del dashboar del administrador
Route::post('/actualizacionDeDatos',[PlantillaAdminController::class,'actualizacionDeDatos']);
//Ruta que maneja el reporte general de cajas (desde el administrador)
Route::post('/reporteRangoFechasCajasAdmin',[PlantillaAdminController::class,'reporteRangoFechasCajasAdmin']);
// Ruta para listar los funcionarios y Productos de la Base de datos
Route::post('/listarFuncionariosProductos',[PlantillaAdminController::class,'listarFuncionariosProductos']);
// Vista para actualizar a un Funcionario
Route::get('/actualizarFuncionarioProducto',function(){
    return view('admin-plantilla.updateFuncionarioProducto');
});
//Ruta para consultar a la BD sobre un funcionario
Route::post('/datosFuncionarioActualizar',[PlantillaAdminController::class,'datosFuncionarioActualizar']);
//Ruta para actulizar los datos del funcionario seleccionado
Route::post("/datosFuncionarioActualizarBD",[PlantillaAdminController::class,'datosFuncionarioActualizarBD'])->name('update.funcionario');
//Vista para actualizar un Producto
Route::get('/actualizarProducto',function(){
    return view('admin-plantilla.updateProducto');
});
//Ruta para la consulta a la Base de Datos sobre algun producto
Route::post('/buscarDatosProducto',[PlantillaAdminController::class,'buscarDatosProducto']);
Route::post('/datosProductoActualizarBD',[PlantillaAdminController::class,'datosProductoActualizarBD'])->name('update.producto');