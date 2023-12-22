<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Funcionario;
use App\Models\DetalleVenta;
use App\Models\Venta;
use App\Models\Persona;
use App\Models\Cliente;
use App\Models\VistaVentaFuncionario;
use Illuminate\Support\Facades\DB;
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
        //$impresora->setTextSize(5,5);
        $impresora->text("<< CHIFA EL LEITO >>\n");
        $impresora->feed(2);
        $impresora->text("Mesa:..................."."\n");
        $impresora->feed(2);
        $impresora->text("Nombre:   ");
        $impresora->setTextSize(3,3);
        $impresora->text($request->nombre_cliente."\n");
        $impresora->setTextSize(1,1);
        $impresora->feed(2);
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->setTextSize(1,1);
        //$impresora->text("Señores: ".$cliente_nu->razon_social."\n");
        $impresora->text("Fecha: ".date("d/m/Y")."  Hora: ".date("H:i:s")."\n");
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
        /**
        ********* Sql para la consulta **********
        * select id_cod_prod,detalle,sum(cantidad),precio 
        * from detalleVentasFuncionario
        * where id_funcionario = 1
        *	  and fecha_venta::date = '2023-03-07'
        * group by id_cod_prod,detalle,precio 
        * order by
        *		case
        *    	when substring(id_cod_prod from '^\d+$') is null then 9999
        *    	else cast(id_cod_prod as integer)
        *  		end, id_cod_prod
        */
        $ids_ventas_realizadas=VistaVentaFuncionario::selectRaw("id_cod_prod,detalle,sum(cantidad),precio")
                                   ->whereRaw('id_funcionario='.$_SESSION["id_funcionario"])
                                   ->where(DB::raw('fecha_venta::date'),"=",date("Y-m-d"))
                                   ->groupBy(DB::raw('id_cod_prod,detalle,precio'))
                                   ->orderBy(DB::raw("case when substring(id_cod_prod from '^\d+$') is null then 9999 else cast(id_cod_prod as integer) end, id_cod_prod"))
                                   ->get();
        if($ids_ventas_realizadas->count()>0)
        {
          $mensaje=true;
        }
        else{
          $mensaje=false;  
        }
        sleep(3);
        return json_encode(array("mensaje"=>$mensaje,"data"=>$ids_ventas_realizadas));
    }

    public function imprimirDetalleVentaModal(Request $request)
    {
        $datoReporteAImpirmirFuncionario=json_decode($this->reporteArqueoFuncionario($request),true);
        $nombreImpresora = "LEITO";
        $connector = new WindowsPrintConnector($nombreImpresora);
        $impresora = new Printer($connector);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->text("<< Reporte $_SESSION[cargo]>>\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("USUARIO: ".$_SESSION["nombre"]." ".$_SESSION["ap_pat"]." ".$_SESSION["ap_mat"]."\n");
        $impresora->text("CODIGO: ".$_SESSION["codigo_funcionario"]."\n");
        $impresora->text("FECHA: ".date("d/m/Y")."  Hora: ".date("H:i")."\n");
        $impresora->feed(1);
        $impresora->text("----------------------------------------\n");
        $impresora->text("Cod.      Cnt.      Total     \n");
        $impresora->text("----------------------------------------\n");
        if(count($datoReporteAImpirmirFuncionario["data"])>0)
        {
            $sumaTotalTablaDetalleVenta=0;
            foreach ($datoReporteAImpirmirFuncionario["data"] as $key => $value) {
                $sumaTotalTablaDetalleVenta=$sumaTotalTablaDetalleVenta+($value["sum"]*$value["precio"]);
                $tr=floatval($value["sum"]*$value["precio"]);
                $c=$this->espaciosImprimirDetalleVentas($value ["id_cod_prod"], 9);
                $ca=$this->espaciosImprimirDetalleVentas($value["sum"], 9);
                $p=$value["precio"];
                $tr=$this->espaciosImprimirDetalleVentas($tr, 9);
                $impresora->text("$c $ca $tr"."\n");
            }
        }
        else
        {
            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->text("SIN REGISTROS DE VENTAS\n");    
            $sumaTotalTablaDetalleVenta=0;
        }
        $impresora->text("----------------------------------------\n");
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->text("Total Bs.: ".$sumaTotalTablaDetalleVenta."\n");
        $impresora->feed(1);
        $impresora->cut();
        $impresora->close();
        return json_encode(array("mensaje"=>'ok'));
    }

}


            