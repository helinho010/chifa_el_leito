<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Persona;
use App\Models\Funcionario;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use PhpParser\Node\Expr\FuncCall;

class PlantillaAdminController extends Controller
{
    //Esta funcion reliza peticiones de la BD para actualizar el 
    //Dashboad del admin
    public function actualizacionDeDatos(Request $request)
    {
        
        $rankinProductosMasVendidos=DB::table('detalle_venta')
                                        ->select(DB::raw('id_cod_prod, sum(cantidad) as "CantVend"'))
                                        ->groupBy('id_cod_prod')
                                        ->orderByDesc('CantVend')
                                        ->limit(10)
                                        ->get();    
        if ($rankinProductosMasVendidos->count()>0) 
        {
            $labels=array();
            $datas=array();
            foreach ($rankinProductosMasVendidos as $key => $value) {
                array_push($labels,"Cod. ".$value->id_cod_prod);
                array_push($datas,$value->CantVend);
            }
        }

        $sumaVentaTotalDia=DB::table('venta')
                                ->select(DB::raw('sum(total) as "totalventa"'))
                                ->whereDate('fecha_venta',date("Y-m-d"))
                                ->get();
        if($sumaVentaTotalDia->count()>0)
        {
            foreach ($sumaVentaTotalDia as $key => $value) {
                if ($value->totalventa != Null) {
                    $resultadoDia=$value->totalventa;
                }else {
                    $resultadoDia=0;
                }
            }
        }
        else{
            $resultadoDia=0;
        }

        $sumaVentaTotalMes=DB::table('venta')
                                ->select(DB::raw('sum(total) as "totalventa"'))
                                ->whereMonth('fecha_venta',date("m"))
                                ->get();
        if($sumaVentaTotalDia->count()>0)
        {
            foreach ($sumaVentaTotalMes as $key => $value) {
                if ($value->totalventa != Null) {
                    $resultadoMes=$value->totalventa;
                }else {
                    $resultadoMes=0;
                }
            }
        }
        else{
            $resultadoMes=0;
        }

        return json_encode(array(
        "totalventaDia"=>$resultadoDia,
        "totalventaMes"=>$resultadoMes,    
        "labels"=>$labels,
        "data"=>$datas,
        "colores"=>array("#8e44ad","#2c3e50","#2980b9","#27ae60","#16a085","#f39c12","#d35400","#c0392b","#bdc3c7","#7f8c8d")
        ));
    }

    public function espaciosImprimirDetalleVentas2($texto, $espaciosImp)
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

    /*
    * Esta funcion imprime el reporte general de ventas realizadas por cajas
    *  (Todos los cajeros que realizaron transacciones)
    */
    public function reporteRangoFechasCajasAdmin(Request $request)
    {
        session_start();
        $mensaje="false";
        if(!(is_null($request["fecha_inicial"]) or is_null($request["fecha_final"])))
        {
            /* select id_cod_prod, detalle, sum(cantidad), precio
               from detalle_venta
               where id_vent in (select id_venta from venta where fecha_venta::date between '2023-03-01' and '2023-03-31')
               group by id_cod_prod, detalle, precio
               order by
		            case
    	            when substring(id_cod_prod from '^\d+$') is null then 9999
    	            else cast(id_cod_prod as integer)
  		            end, id_cod_prod 
            */
            $idsVentaGeneralRangoFechasAdmin=DB::table("venta")
                                                ->select("id_venta")
                                                ->whereRaw("fecha_venta::date between '".$request["fecha_inicial"]."' and '".$request["fecha_final"]."'")
                                                ->get();
            $idsRangoFechasTableVenta=array();
            foreach ($idsVentaGeneralRangoFechasAdmin as $key => $value) {
                array_push($idsRangoFechasTableVenta,$value->id_venta);
            }                                                
            $detalleVentaGeneralRangoFechasAdmin=DB::table('detalle_venta')
                                                     ->selectRaw("id_cod_prod, detalle, sum(cantidad), precio") 
                                                     ->whereIn("id_vent", $idsRangoFechasTableVenta)
                                                     ->groupByRaw("id_cod_prod, detalle, precio")
                                                     ->orderBy(DB::raw("case when substring(id_cod_prod from '^\d+$') is null then 9999 else cast(id_cod_prod as integer) end, id_cod_prod"))
                                                     //->limit(4) 
                                                     ->get();
            $nombreImpresora = "LEITO";
            $connector = new WindowsPrintConnector($nombreImpresora);
            $impresora = new Printer($connector);
            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->text("<< Reporte $_SESSION[cargo]>>\n");
            $impresora->setJustification(Printer::JUSTIFY_LEFT);
            $impresora->text("USUARIO: ".$_SESSION["nombre"]." ".$_SESSION["ap_pat"]." ".$_SESSION["ap_mat"]."\n");
            $impresora->text("CARGO: ".$_SESSION["cargo"]."\n");
            $impresora->text("FECHA INICIAL: ".$request["fecha_inicial"]."\n");
            $impresora->text("FECHA FINAL: ".$request["fecha_final"]."\n");
            $impresora->text("HORA REPORTE: ".date("H:i")."\n");
            $impresora->feed(1);
            $impresora->text("----------------------------------------\n");
            $impresora->text("Cod.      CntVend.    Total   \n");
            $impresora->text("----------------------------------------\n");
            $sumaTotalTablaDetalleVenta=0;
            foreach ($detalleVentaGeneralRangoFechasAdmin as $key => $value) {
                $sumaTotalTablaDetalleVenta=$sumaTotalTablaDetalleVenta+($value->sum*$value->precio); 
                $c=$this->espaciosImprimirDetalleVentas2($value->id_cod_prod, 9);
                $ca=$this->espaciosImprimirDetalleVentas2($value->sum, 9);
                $p=$value->precio;
                $tr=$this->espaciosImprimirDetalleVentas2(floatval($ca)*floatval($p), 9);
                $impresora->text("$c    $ca $tr"."\n");                    
            }
            $impresora->text("----------------------------------------\n");
            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->text("Total Bs.: ".$sumaTotalTablaDetalleVenta."\n");
            $impresora->feed(1);
            $impresora->cut();
            $impresora->close();
            $mensaje="true";
        }
        else{
            $mensaje="false";
        }
        
        return json_encode(array("mensaje"=>$mensaje));
    }

    public function listarFuncionariosProductos(Request $request)
    {
        $lista=array();
        if($request['reporte']== "listar-funcionarios")
        {
         /*
         * Sql para funcionario
         * select p.nombre||' '||p.ap_pat||' '||p.ap_mat as "NomComp", p.ci,p.fec_nac,p.tel_cel,p.domicilio,f.codigo_funcionario,f.cargo,f.email
         * from persona p, funcionario f
         * where p.id_persona = f.id_pers
         */
         $lista=Persona::select(DB::raw("persona.nombre||' '||persona.ap_pat||' '||persona.ap_mat as NomComp, persona.ci,persona.fec_nac,persona.tel_cel,persona.domicilio,funcionario.codigo_funcionario,funcionario.cargo,funcionario.email"))
                                            ->join('funcionario','funcionario.id_pers','=','persona.id_persona')
                                            ->get();          
        }
        elseif($request['reporte']== "listar-productos")
        {
            /**
             * Sql para los productos
             * select * from producto
             */
            $lista=Producto::select("id_codigo_producto","descripcion","precio")
                             ->get();   
        }
        else{
            array_push($listaArray,3);
        }
        return json_encode($lista);
    }

    public function datosFuncionarioActualizar(Request $request)
    {
        $datosPersona=Persona::where("ci",$request['ci'])->get();
        if($datosPersona->count()>0)
        {
            foreach ($datosPersona as $key => $value) 
            {
                $id_persona=$value->id_persona;
            }
            $datosFuncionario=Funcionario::where("id_pers",$id_persona)->get();
            return json_encode(array("mensaje"=>"true","datosPersona"=>$datosPersona,"datosFuncionario"=>$datosFuncionario));
        }else{
            return json_encode(array("mensaje"=>"false"));
        } 
    }

    public function datosFuncionarioActualizarBD(Request $request)
    {
        $mensaje="false";
        $datosPersonaActuaizar=Persona::find($request['codpers']);
        $datosFuncionarioActualizar=Funcionario::where("id_pers",$request["codpers"])->first();
        if ($datosPersonaActuaizar->count()>0 and $datosFuncionarioActualizar->count()>0) 
        {
          $datosPersonaActuaizar->nombre=trim(strtoupper($request['nombres']));
          $datosPersonaActuaizar->ap_pat=trim(strtoupper($request['appat']));
          $datosPersonaActuaizar->ap_mat=trim(strtoupper($request['apmat']));
          $datosPersonaActuaizar->ci=trim(strtoupper($request['ci']));
          $datosPersonaActuaizar->fec_nac=trim($request['fecnac']);
          $datosPersonaActuaizar->tel_cel=trim($request['telcel']);
          $datosPersonaActuaizar->domicilio=trim(strtoupper($request['domicilio']));
          $datosFuncionarioActualizar->cargo=trim(strtoupper($request['cargo']));  
          $datosFuncionarioActualizar->email=trim(strtoupper($request['email']));  
          $datosPersonaActuaizar->save();
          $datosFuncionarioActualizar->save();
          $mensaje="ok";
        }
        return redirect()->route('mostrar.funcionario', ['id' => $request["codpers"],'mensaje'=>$mensaje]);
    }

    public function buscarDatosProducto(Request $request)
    {
        $datosProducto=Producto::where("id_codigo_producto",trim(strtoupper($request['codprod'])))->get();
        if($datosProducto->count()>0)
        {
            return json_encode(array("mensaje"=>"true","datosProducto"=>$datosProducto));
        }else{
            return json_encode(array("mensaje"=>"false"));
        }
    }

    public function datosProductoActualizarBD(Request $request)
    {
        $mensaje="false";
        $datosProductoActuaizar=Producto::where('id_codigo_producto',$request['actidCodProd'])->first();
        if ($datosProductoActuaizar->count()>0) 
        {
          $datosProductoActuaizar->id_codigo_producto=trim(strtoupper($request["idCodProd"]));
          $datosProductoActuaizar->descripcion=trim(strtoupper($request["descripcion"]));
          $datosProductoActuaizar->precio=trim($request["precio"]);
          $datosProductoActuaizar->save();
          $mensaje="ok";
        }
        return redirect()->route('mostrar.producto', ['id' => $datosProductoActuaizar->id_codigo_producto,'mensaje'=>$mensaje]);
    }
}
