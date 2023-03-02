@include('plantilla.cabecera')
@section('nombreIcono','funcionario.png')
@section('nombreDocumento',"Funcionario")
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
  <div class="container">
    <div class="row">
      <h4>Datos del funcionario:</h4>
    </div>
    <div class="row">
      <table class="table">
        <tbody>
          <tr>
            <td><img src="{{asset('img/iconos/icono_persona.png')}}" alt="persona"> Nombre completo: <i class="text-success">{{$nombreCompleto}}</i> </td>
          </tr>
          <tr>
            <td><img src="{{asset('img/iconos/icono_ci.png')}}" alt="ci">Carnet de Identidad: <i class="text-success">{{$ci}}</i></td>
          </tr>
          <tr>
            <td><img src="{{asset('img/iconos/icono_codigo_funcionario.png')}}" alt="codfun">Codigo Funcionario: <i class="text-success">{{$cod_funcionario}}</i></td>
          </tr>
          <tr>
            <td><img src="{{asset('img/iconos/icono_calendario.png')}}" alt="fechaNacimiento">Fecha de Nacimiento: <i class="text-success">{{$fec_nac}}</i></td>
          </tr>
          <tr>
            <td><img src="{{asset('img/iconos/icono_celular.png')}}" alt="celular">Telefono o Celular: <i class="text-success">{{$tel_cel}}</i></td>
          </tr>
          <tr>
            <td><img src="{{asset('img/iconos/icono_cargo.png')}}" alt="cargo">Cargo: <i class="text-success">{{$cargo}}</i></td>
          </tr>
          <tr>
            <td><img src="{{asset('img/iconos/icono_email.png')}}" alt="email">Correo Electronico: <i class="text-success">{{$email}}</i></td>
          </tr>
          <tr>
            <td><img src="{{asset('img/iconos/icono_domicilio.png')}}" alt="domicilio">Domicilio: <i class="text-success">{{$domicilio}}</i></td>
          </tr>
        </tbody>
      </table>
      <a href="{{route('bienvenido')}}" class="btn btn-success">Volver</a>
    </div>
  </div>
@endisset
@include('plantilla.pie')



                