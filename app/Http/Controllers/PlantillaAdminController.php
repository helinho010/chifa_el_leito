<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PlantillaAdminController extends Controller
{
    //
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
}
