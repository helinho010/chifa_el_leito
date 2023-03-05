@php
  session_start();
  date_default_timezone_set('America/La_Paz');  
@endphp
@if (!empty($_SESSION) and strtoupper($_SESSION['cargo']) == 'CAJERO')
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
          <h2>Crear Nuevo Producto</h2>
        </div>
        <div class="row info-req">
            <h6>Los campos con (*) son obligatorios</h6>
          </div>
        <div class="row">
          <form control="" class="form-group" action="{{ route('crear.producto') }}" method="POST">
            @csrf
            <div class="row">(*)
              <input type="text" value="{{ old('codigo_producto')}}" name="codigo_producto" id="codigo_producto" class="form__input" placeholder="Codigo de Producto">
              @error('codigo_producto')
                  <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                    {{$message}}
                  </div>
              @enderror
            </div>
            <div class="row">
                <input type="text" value="{{ old('descripcion')}}" name="descripcion" id="descripcione" class="form__input" placeholder="Descripcion del Producto">
                @error('descripcion')
                    <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                      {{$message}}
                    </div>
                @enderror
              </div>
            <div class="row">
                <input type="number" value="{{ old('precio')}}" name="precio" id="precio" class="form__input" placeholder="Precio del Producto">
                @error('precio')
                    <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                      {{$message}}
                    </div>
                @enderror
            </div>
            <div class="row">
                <input type="file" value="{{ old('imagen')}}" name="imagen" id="imagen" class="form__input" placeholder="Precio del Producto">
                @error('imagen')
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
              <input type="submit" value="Crear Producto" class="btn-create">
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
@include('plantilla.pie')
@else
<script>
  window.location.href='{{url("/login")}}';
</script>
@endif