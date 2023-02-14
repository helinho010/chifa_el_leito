<?php

namespace App\Http\Controllers;

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

    private function generarCodigoFuncionario($nombres=NULL, $ap_pat=NULL, $ap_mat=NULL, $ci=NULL)
    {   
        $cod="ZZZ";
        if (!isset($nombres,$ap_pat, $ap_mat, $ci)) {
            $cod="XXX";
        }
        return ($cod);
    }

    public function crearFuncionario(Request $request)
    {
        $request->validate([
            'nombres'=> 'required',
            'ci'=> 'required',
            'cargo'=> 'required'
        ]);

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
        $funcionario->codigo_funcionario="HMM8536";
        $funcionario->cargo=trim($request["cargo"]);
        $funcionario->email=trim($request["email"]);
        
        $id_persona_tabla_persona=Persona::where("ci",trim($request["ci"]))->value('id_persona');
        $funcionario->id_pers=$id_persona_tabla_persona;  
        $funcionario->save();
        return($request);
    }
}
