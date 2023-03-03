<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Funcionario;
use App\Models\DetalleVenta;
use App\Models\Venta;
use App\Models\Persona;
use App\Models\Cliente;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Luecano\NumeroALetras\NumeroALetras;


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

    public function espaciosImprimirDetalleVentas($texto, $espaciosImp)
    {
        $textoConEspacions=$texto;

        if (strlen($textoConEspacions)>$espaciosImp) {
            $textoConEspacions=substr($textoConEspacions,0,$espaciosImp);
        }
        else{
            while (strlen($textoConEspacions)<$espaciosImp ) {
                $textoConEspacions=$textoConEspacions." ";
            }
        }

        return $textoConEspacions;
    }

    public function imprimirDetalleVenta(Request $request)
    {   
        session_start();
        $nit_ci_cliente=Cliente::where("nit",trim($request["nit_ci_cliente"]))->value('nit');
        if( $nit_ci_cliente == "" )
        {
            $cliente_nu=new Cliente();
            $cliente_nu->nit=trim($request->nit_ci_cliente);
            $cliente_nu->razon_social=trim($request->nombre_cliente);
        }   
        else{
            $cliente_nu=Cliente::find($nit_ci_cliente);
            $cliente_nu->razon_social=trim($request->nombre_cliente);
        }  
        $cliente_nu->save();


        $datos_venta_func_cli = new Venta();
        $datos_venta_func_cli->id_func=$_SESSION["id_funcionario"];
        $datos_venta_func_cli->nit_cli=$request->nit_ci_cliente;
        $datos_venta_func_cli->total=$request->total_venta;
        date_default_timezone_set('America/La_Paz');
        $datos_venta_func_cli->fecha_venta=date("Y-m-d H:i");
        $datos_venta_func_cli->save();
        $ultimoRegistroVenta=Venta::orderBy('id_venta','desc')->limit(1)->first();

        
        foreach ($request->detalle as $key => $value) {
            $datos_detalle_venta = new DetalleVenta();
            $datos_detalle_venta->id_vent=$ultimoRegistroVenta->id_venta;
            $datos_detalle_venta->id_cod_prod=$value[0];
            $datos_detalle_venta->detalle=$value[1];
            $datos_detalle_venta->cantidad=$value[2];
            $datos_detalle_venta->precio=$value[3];
            $datos_detalle_venta->save();
        }

        $nombreImpresora = "LEITO";
	    $connector = new WindowsPrintConnector($nombreImpresora);
	    $impresora = new Printer($connector);
	    $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setTextSize(5,5);
        $impresora->text("<< CHIFA EL LEITO >>\n");
        $impresora->feed(5);
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->setTextSize(1,1);
        $impresora->text("Señores: ".$cliente_nu->razon_social."\n");
        $impresora->text("Fecha: ".date("d/m/Y")."  Hora: ".date("H:i")."\n");
        $impresora->text("ID Venta: ".$ultimoRegistroVenta->id_venta."\n");
        $impresora->feed(1);
        $impresora->text("----------------------------------------\n");
        $impresora->text("Cod.    Producto     Cnt.  PU.   Total\n");
        $impresora->text("----------------------------------------\n");
        $suma=0;
        foreach ($request->detalle as $key => $value) {
           $c=$this->espaciosImprimirDetalleVentas($value[0], 4);
           $d=$this->espaciosImprimirDetalleVentas($value[1], 15);
           $ca=$this->espaciosImprimirDetalleVentas($value[2], 4);
           $p=$this->espaciosImprimirDetalleVentas($value[3], 4);
           $tv=$this->espaciosImprimirDetalleVentas(floatval($ca)*floatval($p), 6);
           $suma=$suma+floatval($tv);
           $impresora->text("$c $d  $ca $p  ".number_format($tv,2,",")."\n");
           $datos_detalle_venta->id_cod_prod=$value[0];
           $datos_detalle_venta->detalle=$value[1];
           $datos_detalle_venta->cantidad=$value[2];
           $datos_detalle_venta->precio=$value[3];
        }
        $impresora->text("----------------------------------------\n");
        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
        $impresora->text("Total Final Bs.: ".number_format($suma,2,",")."\n");
        $impresora->text("Efectivo Bs.: ".number_format(floatval($request->efectivo_venta),2,",")."\n");
        $suma=$request->efectivo_venta==0?0:$suma;
        $impresora->text("Cambio Bs.: ".number_format(floatval($request->efectivo_venta)-$suma,2,",")."\n");
        $impresora->text("----------------------------------------\n");
        $num_literal= new NumeroALetras();
        $num_literal->apocope = true;
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("Son: ".$num_literal->toInvoice($request->total_venta, 2, 'Bolivianos')."\n");
        $impresora->feed(1);
        $impresora->text("Funcionario: ".$_SESSION["codigo_funcionario"]."\n");
        $impresora->feed();
        $impresora->cut();
        $impresora->close();
        sleep(3);
        return json_encode(array("estado"=>1));
    }


    public function reporteArqueoFuncionario(Request $request)
    {
        session_start();
        $ids_ventas_realizadas=Venta::where("id_func",$_SESSION["id_funcionario"])->get();
        if($ids_ventas_realizadas->count()>0){
            $nombreImpresora = "LEITO";
            $connector = new WindowsPrintConnector($nombreImpresora);
            $impresora = new Printer($connector);
            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->text("<< Reporte >>\n");
            $impresora->setJustification(Printer::JUSTIFY_LEFT);
            $impresora->text("USUARIO: ".$_SESSION["nombre"]." ".$_SESSION["ap_pat"]." ".$_SESSION["ap_mat"]."\n");
            $impresora->text("CODIGO: ".$_SESSION["codigo_funcionario"]."\n");
            $impresora->text("FECHA: ".date("d/m/Y")."  Hora: ".date("H:i")."\n");
            $impresora->feed(1);
            $impresora->text("----------------------------------------\n");
            $impresora->text("Cod.      Cnt.      Total     \n");
            $impresora->text("----------------------------------------\n");
            $sumaTotalTablaVenta=0;
            $sumaTotalTablaDetalleVenta=0;
            foreach ($ids_ventas_realizadas as $key => $value) {
                $sumaTotalTablaVenta=$sumaTotalTablaDetalleVenta+$value->total;
                $detalleVentaDelId=DetalleVenta::where("id_vent",$value->id_venta)->get();
                foreach ($detalleVentaDelId as $key2 => $value2) {
                    $sumaTotalTablaDetalleVenta=$sumaTotalTablaDetalleVenta+($value2->cantidad*$value2->precio);
                    $c=$this->espaciosImprimirDetalleVentas($value2->id_cod_prod, 9);
                    $ca=$this->espaciosImprimirDetalleVentas($value2->cantidad, 9);
                    $p=$value2->precio;
                    $tr=$this->espaciosImprimirDetalleVentas(floatval($ca)*floatval($p), 9);
                    $impresora->text("$c $ca $tr"."\n");
                }
            }
            $impresora->text("----------------------------------------\n");
            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->text("Total Bs.: ".$sumaTotalTablaDetalleVenta."\n");
            $impresora->feed(1);
            $impresora->cut();
            $impresora->close();
            $mensaje="ok";
        }
        else{
          $mensaje="El usuario ".$_SESSION['codigo_funcionario']." no tiene ventas realizadas";
          $sumaTotalTablaVenta=0;
          $sumaTotalTablaDetalleVenta=0;  
        }
        sleep(3);
        return json_encode(array("suma1"=>$sumaTotalTablaVenta,"suma2"=>$sumaTotalTablaDetalleVenta,"importante"=>$mensaje));
    }

}
