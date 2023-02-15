@extends('plantilla.cabecera')
@section('nombreIcono','login.png')
@section('nombreDocumento',"Info Funcionario")
@isset($mensaje)
  @if ($mensaje == "ok")
    <div class="alert alert-success" role="alert">
      El Usuario <i style="font-size:30px">{{$nombreCompleto}}</i> se resgistro exitosamente en la base de datos. 
   </div>
  @else
    <div class="alert alert-danger" role="alert">
      El Usuario <i style="font-size:30px">{{$nombreCompleto}}</i> ya se encuentra en la base de datos.
    </div>
  @endif
@endisset
@extends('plantilla.pie')