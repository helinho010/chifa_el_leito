@php
  session_start();
  date_default_timezone_set('America/La_Paz');  
@endphp
@if (!empty($_SESSION) and strtoupper($_SESSION['cargo']) == 'ADMINISTRADOR')
@include('plantilla.cabecera')
@section('nombreIcono','login.png')
@section('nombreDocumento',"Inicio Session")
@section('barraSuperior')


<!-- Main Content -->
<div class="container-fluid">
  <div class="row main-content bg-success text-center">
    <div class="col-md-2 text-center company__info">
      <span class="company__logo"><h2><span class="fa fa-android"></span></h2></span>
      <h4 class="company_title">Chifa El Leito</h4>
    </div>
    <div class="col-md-10 col-xs-12 col-sm-12 login_form ">
      <div class="container-fluid">
        <div class="row">
          <h2>Actualizar Datos de un Producto</h2>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form>
                    <div class="form-group">
                      <label for="buscar-datos-funcionario">Intro. Cod. de Producto.</label>
                      <input type="text" class="form-control" id="buscar-datos-producto" aria-describedby="emailHelp" placeholder="Buscar ...">
                      <button class="btn btn-primary" id="btn-buscar-datos-producto">Buscar</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row info-req">
            <h6>Los campos con (*) son obligatorios</h6>
          </div>
        <div class="row">
          <form control="" class="form-group" action="{{ route('update.producto') }}" method="POST">
            @csrf
            <div class="row">
                <input type="hidden" value="" name="actidCodProd" id="actidCodProd" class="form__input" >
            </div>
            <div class="row">(*)
              <small>Id. Producto</small>
              <input type="text" value="{{ old('id_cod_producto')}}" name="idCodProd" id="idCodProd" class="form__input" placeholder="Codigo de Producto">
              @error('idCodProd')
                  <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                    {{$message}}
                  </div>
              @enderror
            </div>
            <div class="row">
              <small>Descripcion</small>
                <input type="text" value="{{ old('descripcion')}}" name="descripcion" id="descripcion" class="form__input" placeholder="Descripcion del Producto">
                @error('descripcion')
                    <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                      {{$message}}
                    </div>
                @enderror
              </div>
            <div class="row">
              <small>Precio</small>
                <input type="text" value="{{ old('precio')}}" name="precio" id="precio" class="form__input" placeholder="Precio del Producto">
                @error('precio')
                    <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                      {{$message}}
                    </div>
                @enderror
            </div>
            <!--div class="row">
              <input type="checkbox" name="remember_me" id="remember_me" class="">
              <label for="remember_me">Remember Me!</label>
            </div-->
            <div class="row">
              <input type="submit" value="Actualizar Datos" class="btn-create">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Footer -->
<div class="container-fluid text-center footer">
  Yo &hearts; la Chifa El Leito !
</div>

<!-- Modal de Mensajes-->
<div class="modal fade" id="mensajes-buscar-funcionario" tabindex="-1" aria-labelledby="mensajes-buscar-funcionarioLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title-buscar-funcionarioLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="mensaje-body-datos-funcionario">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <!--button type="button" class="btn btn-primary">Save changes</button-->
        </div>
      </div>
    </div>
  </div>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('jquery/jqueryVistaActualizacionProducto.js')}}"></script>    
</body>
</html>

@else
<script>
  window.location.href='{{url("/")}}';
</script>
@endif
<script>
    var url_buscar_datos_producto = '{{url("/buscarDatosProducto")}}';
</script>