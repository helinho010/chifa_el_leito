<?php

namespace App\Http\Controllers;

use App\Models\Credenciales;
use App\Models\Funcionario;
use App\Models\Persona;
use Faker\Provider\ar_EG\Person;
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
        $identificadorPersonaBD= Persona::where("ci",$request["usuario"])->value("id_persona");
        $identificadorFuncionarioDB= Funcionario::where("id_pers",$identificadorPersonaBD)->value("id_funcionario");
        $contraseniaFuncionarioDBCredenciales= Credenciales::where("id_func",$identificadorFuncionarioDB)->value("contrasenia");
        if ($request["usuario"] == Credenciales::where("id_func",$identificadorFuncionarioDB)->value("usuario") and password_verify($request["password"],$contraseniaFuncionarioDBCredenciales))
        {
            session_start();
            $datosPersonaLogin=Persona::where("id_persona",$identificadorPersonaBD)->first();
            $datosfuncionarioLogin=Funcionario::where("id_pers",$datosPersonaLogin->id_persona)->first();
            
            $_SESSION["id_persona"] = $datosPersonaLogin->id_persona;
            $_SESSION["nombre"] = $datosPersonaLogin->nombre;
            $_SESSION["ap_pat"] = $datosPersonaLogin->ap_pat;
            $_SESSION["ap_mat"] = $datosPersonaLogin->ap_mat;
            //$_SESSION["ci"] = "Pepito Conejo";
            //$_SESSION["fec_nac"] = "Pepito Conejo";
            //$_SESSION["tel_cel"] = "Pepito Conejo";
            //$_SESSION["domicilio"] = "Pepito Conejo";
            $_SESSION["id_funcionario"] = $datosfuncionarioLogin->id_funcionario;
            $_SESSION["codigo_funcionario"] = $datosfuncionarioLogin->codigo_funcionario;
            $_SESSION["cargo"] = $datosfuncionarioLogin->cargo;
            //$_SESSION["email"] = "Pepito Conejo";
            if (strtoupper($datosfuncionarioLogin->cargo) == "CAJERO")
            {
                return redirect()->route('venta.Productos');    
            }
            else{
                /*return view('venta.Productos',[
                    "idpersona"=>$datosPersonaLogin->id_persona,
                    "nombre"=>$datosPersonaLogin->nombre,
                    "appat"=>$datosPersonaLogin->ap_pat,
                    "apmat"=>$datosPersonaLogin->ap_mat,
                    "codfuncionario"=>$datosfuncionarioLogin->codigo_funcionario,
                    "cargo"=>$datosfuncionarioLogin->cargo
                ]);*/
                return redirect()->route('admin.plantilla');    
            }
        }
        else{
            return redirect('/login');
        }
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
            $persona->nombre=strtoupper(trim($request["nombres"]));
            $persona->ap_pat=strtoupper(trim($request["appat"]));
            $persona->ap_mat=strtoupper(trim($request["apmat"]));
            $persona->ci=strtoupper(trim($request["ci"]));
            $persona->fec_nac=trim($request["fecnac"]);
            $persona->tel_cel=strtoupper(trim($request["telcel"]));
            $persona->domicilio=strtoupper(trim($request["domicilio"]));
            $persona->save();
    
            $funcionario=new Funcionario();
            $funcionario->codigo_funcionario=$this->generarCodigoFuncionario($persona->nombre,$persona->ap_pat,$persona->ap_mat,$persona->ci);
            $funcionario->cargo=strtoupper(trim($request["cargo"]));
            $funcionario->email=strtoupper(trim($request["email"]));
            $id_persona_tabla_persona=Persona::where("ci",trim($request["ci"]))->value('id_persona');
            $funcionario->id_pers=$id_persona_tabla_persona;  
            $funcionario->save();
    
            $credenciales=new Credenciales();
            $credenciales->usuario=$persona->ci;
            /*
            * Cifrado de password
            */
            $hash_contrasenia=password_hash($persona->ci,PASSWORD_DEFAULT);
            $credenciales->contrasenia=$hash_contrasenia;
            $id_funcionario_tabla_funcionario=Funcionario::where("id_pers",$id_persona_tabla_persona)->value('id_funcionario');
            $credenciales->id_func=$id_funcionario_tabla_funcionario;
            $credenciales->save();
            $mensaje="ok";  
        }
        else{
            $mensaje="error";
            $id_persona_tabla_persona=Persona::where("ci",trim($request["ci"]))->value('id_persona');
        }
        
        return redirect()->route('mostrar.funcionario', ['id' => $id_persona_tabla_persona,'mensaje'=>$mensaje]);
    }

    public function mostrarFuncionario($id,$mensaje)
    {
        $persona=Persona::find($id);
        $funcionario=Funcionario::where("id_pers",$id)->first();       
        return view('infoFuncionario',[
            "mensaje"=>$mensaje, 
            "nombreCompleto"=>$persona->nombre." ".$persona->ap_pat." ".$persona->ap_mat,
            "ci"=>$persona->ci,
            "cod_funcionario"=>$funcionario->codigo_funcionario,
            "fec_nac"=>$persona->fec_nac,
            "tel_cel"=>$persona->tel_cel,
            "cargo"=>$funcionario->cargo,
            "email"=>$funcionario->email,
            "domicilio"=>$persona->domicilio
        ]);   
    }

    public function borrarSession(Request $request)
    {
        session_start();
        $_SESSION = array();
        return (session_destroy());
    }
}
