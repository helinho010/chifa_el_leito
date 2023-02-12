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
            'password'=> 'required'
        ]);
        
        $usuarioprue=new Funcionario();
        $usuarioprue->codigo_funcionario="hmm926";
        $usuarioprue->cargo="Admin";
        $usuarioprue->email="mm_helio009@gmail.com";
        $usuarioprue->id_pers=1;
        $usuarioprue->save();
        return ($usuarioprue);
    }
}
