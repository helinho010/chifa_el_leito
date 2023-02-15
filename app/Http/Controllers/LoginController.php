<?php

namespace App\Http\Controllers;

use App\Models\Credenciales;
use App\Models\Funcionario;
use App\Models\Persona;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //

    public function autenticacionLogin(Request $request)
    {
        $request->validate([
            'usuario'=> 'required',
            'password'=> 'required',
        ]);
        
        $usuarioprue=new Funcionario();
        $usuarioprue->codigo_funcionario="pop926";
        $usuarioprue->cargo="Cajero";
        $usuarioprue->email="masticar@gmail.com";
        $usuarioprue->id_pers=1;
        $usuarioprue->save();
        return ($usuarioprue);
    }
    /*
     *Funcion que determina el codigod de funcionario con las primeras siglas del nombre, apellido paterno, materno y Documento de identidad "CI"
     *Ej Nombre= Juan, ApPat= Salamanca, ApMat= Alvares, Ci= 454545456 => codigo funcionario= JSA456. 
     */

    private function generarCodigoFuncionario($nombres=NULL, $ap_pat=NULL, $ap_mat, $ci=NULL)
    {   
        $cod="ZZZ999";
        if (isset($nombres) and isset($ci)) 
        {
            if(isset($ap_pat) and $ap_pat!="")
            {
                if(isset($ap_mat) and $ap_mat!="")
                {
                    $cod=substr($nombres,0,1).substr($ap_pat,0,1).substr($ap_mat,0,1).substr($ci,-3);
                }
                else{
                    $cod=substr($nombres,0,1).substr($ap_pat,0,2).substr($ci,-3);
                }
            }
            else{
                if(isset($ap_mat))
                {
                    $cod=substr($nombres,0,1).substr($ap_mat,0,2).substr($ci,-3);
                }
                else{
                    $cod=substr($nombres,0,3).substr($ci,-3);
                }
            }
            
        }
        return (strtoupper($cod));
    }

    public function crearFuncionario(Request $request)
    {
        $request->validate([
            'nombres'=> 'required',
            'ci'=> 'required',
            'cargo'=> 'required'
        ]);
        $aux=Persona::where("ci",trim($request["ci"]))->value('ci');

        if($aux=="")
        {
            $persona =new Persona();
            $persona->nombre=trim($request["nombres"]);
            $persona->ap_pat=trim($request["appat"]);
            $persona->ap_mat=trim($request["apmat"]);
            $persona->ci=trim($request["ci"]);
            $persona->fec_nac=trim($request["fecnac"]);
            $persona->tel_cel=trim($request["telcel"]);
            $persona->domicilio=trim($request["domicilio"]);
            $persona->save();
    
            $funcionario=new Funcionario();
            $funcionario->codigo_funcionario=$this->generarCodigoFuncionario($persona->nombre,$persona->ap_pat,$persona->ap_mat,$persona->ci);
            $funcionario->cargo=trim($request["cargo"]);
            $funcionario->email=trim($request["email"]);        
            $id_persona_tabla_persona=Persona::where("ci",trim($request["ci"]))->value('id_persona');
            $funcionario->id_pers=$id_persona_tabla_persona;  
            $funcionario->save();
    
            $credenciales=new Credenciales();
            $credenciales->usuario=$persona->ci;
            $credenciales->contrasenia=$persona->ci;
            $id_funcionario_tabla_funcionario=Funcionario::where("id_pers",$id_persona_tabla_persona)->value('id_funcionario');
            $credenciales->id_func=$id_funcionario_tabla_funcionario;
            $credenciales->save();
            $mensaje="ok";  
        }
        else{
            $mensaje="error";
        }
        
        return view('infoFuncionario',["mensaje"=>$mensaje, "nombreCompleto"=>trim($request["nombres"])." ".trim($request["appat"])." ".trim($request["apmat"])]);
    }
}
