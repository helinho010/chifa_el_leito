@include('plantilla.cabecera')
@section('nombreIcono','funcionario.png')
@section('nombreDocumento',"Funcionario")
@isset($mensaje)
  @if ($mensaje == "ok")
    <div class="alert alert-success" role="alert">
      El <i style="font-size:30px">{{$codigo_producto}} {{$descripcion}} {{$precio}}</i> se resgistro exitosamente en la base de datos. 
   </div>
  @else
    <div class="alert alert-danger" role="alert">
      El <i style="font-size:30px">{{$codigo_producto}} {{$descripcion}} {{$precio}} </i> ya se encuentra en la base de datos.
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
            <td><img src="{{asset('img/iconos/icono_producto.png')}}" alt="codigo_producto">Codigo Producto: <i class="text-success">{{$codigo_producto}}</i></td>
          </tr>  
          <tr>
            <td><img src="{{asset('img/iconos/icono_descripcion.png')}}" alt="descripcion">Descripcion de Producto: <i class="text-success">{{$descripcion}}</i></td>
          </tr>
          <tr>
            <td><img src="{{asset('img/iconos/icono_precio.png')}}" alt="Precio">Precio Bs: <i class="text-success">{{$precio}}</i></td>
          </tr>
          <tr>
            <td><img src="{{asset('img/iconos/icono_imagen.png')}}" alt="imagen">Imagen del Producto: <i class="text-success">...</i></td>
          </tr>
        </tbody>
      </table>
      <a href="{{route('admin.plantilla')}}" class="btn btn-success">Volver</a>
    </div>
  </div>
@endisset
@include('plantilla.pie')



                