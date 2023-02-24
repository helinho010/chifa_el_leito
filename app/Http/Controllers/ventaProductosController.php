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

    public function crearProducto(Request $request)
    {
        $request->validate([
            'codigo_producto'=> 'required',
            'descripcion'=> 'required',
            'precio'=> 'required'
        ]);
        $aux=Producto::where("id_codigo_producto",trim($request["codigo_producto"]))->value('id_codigo_producto');
        
        if($aux == "")
        {
            $addProducto=new Producto();
            $addProducto->id_codigo_producto=strtoupper(trim($request["codigo_producto"]));
            $addProducto->descripcion=strtoupper(trim($request["descripcion"]));
            $addProducto->precio=trim($request["precio"]);
            if($addProducto->save())
            {
                $mensaje="ok";
                $codprod=$addProducto->id_codigo_producto;
            }
            else{
                $mensaje="error";
            }    
        }
        else{
            $mensaje="error";
            $codprod=strtoupper(trim($request["codigo_producto"]));
        }
        return redirect()->route('mostrar.producto', ['id' => $codprod,'mensaje'=>$mensaje]);
    }


    public function mostrarProducto($id,$mensaje)
    {
        $producto=Producto::where("id_codigo_producto",$id)->first();   
        return view('infoProducto',[
            "mensaje"=>$mensaje, 
            "codigo_producto"=>$producto->id_codigo_producto,
            "descripcion"=>$producto->descripcion,
            "precio"=>$producto->precio
            //"imagen"=>$producto->imagen
        ]);   
    }
}
