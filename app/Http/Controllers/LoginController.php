<?php

namespace App\Http\Controllers;

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
        
        return view('welcome');
    }
}
