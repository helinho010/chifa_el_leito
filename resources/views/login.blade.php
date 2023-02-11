@extends('plantilla.principal')
@section('nombreIcono',"login.png")
@section('nombreDocumento',"Inicio Session")
@section('barraSuperior')

<div class="container" id="main-wrapper">
    <div class="row">
        <div class="col-12">
            <form action="/autenticacionLogin" method="POST" >
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Ingrese su Usuario:</label>
                  <input type="text" value="{{ old('usuario')}}" name="usuario" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingrese su Usuario">
                  @error('usuario')
                  <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                    {{$message}}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Contraseña:</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Ingrese su Contraseña">
                  @error('password')
                    <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                        {{$message}}
                      </div>
                  @enderror
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Enviar</button> 
                <br>
                <br>
                <small id="emailHelp" class="form-text text-muted"> <kbd>Nota muy importate:</kbd> No comparta con nadie sus credenciales de acceso al sistema</small>
            </form>            
        </div>
    </div>
</div>
