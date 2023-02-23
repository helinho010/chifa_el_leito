<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Credenciales;
use App\Models\Funcionario;
use App\Models\Persona;

class ventaProductosController extends Controller
{
    //
    public function buscarProducto(Request $request)
    {
        
        $descripcionProducto=Producto::where("id_codigo_producto",$request->codigoProducto)->value('descripcion');
        $precioProducto=Producto::where("id_codigo_producto",$request->codigoProducto)->value('precio');
        $datosParaDevolver=array('descripcion'=>$descripcionProducto,'precio'=>$precioProducto);
        return json_encode($datosParaDevolver);
    }
}
