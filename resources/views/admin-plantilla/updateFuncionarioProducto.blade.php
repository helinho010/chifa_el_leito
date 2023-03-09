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
          <h2>Actualizar Datos del Funcionario</h2>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form>
                    <div class="form-group">
                      <label for="buscar-datos-funcionario">Introduzca CI.</label>
                      <input type="text" class="form-control" id="buscar-datos-funcionario" aria-describedby="emailHelp" placeholder="Buscar ...">
                      <button class="btn btn-primary" id="btn-buscar-datos-funcionario">Buscar</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row info-req">
            <h6>Los campos con (*) son obligatorios</h6>
          </div>
        <div class="row">
          <form control="" class="form-group" action="{{ route('update.funcionario') }}" method="POST">
            @csrf
            <div class="row bloque">(*)
              <small>Nomb.</small>
              <input type="text" value="{{ old('nombres')}}" name="nombres" id="nombres" class="form__input" placeholder="Nombre del Funcionario">
              @error('nombres')
                  <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                    {{$message}}
                  </div>
              @enderror
            </div>
            <div class="row bloque">
              <small>Ap. Pat.</small>
                <input type="text" value="{{ old('appat')}}" name="appat" id="appate" class="form__input" placeholder="Apellido Paterno">
                @error('appat')
                    <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                      {{$message}}
                    </div>
                @enderror
              </div>
            <div class="row bloque">
              <small>Ap. Pat.</small>
                <input type="text" value="{{ old('apmat')}}" name="apmat" id="apmat" class="form__input" placeholder="Apellido Materno">
                @error('apmat')
                    <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                      {{$message}}
                    </div>
                @enderror
            </div>
            
            <div class="row bloque">(*)
              <small>CI.</small>
                <input type="text" value="{{ old('ci')}}" name="ci" id="ci" class="form__input" placeholder="Doc. Identidad">
                @error('ci')
                    <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                      {{$message}}
                    </div>
                @enderror
            </div>

            <div class="row bloque">
              <small>Fec. Nac.</small>
                <input type="date" value="{{ old('fecnac')}}" name="fecnac" id="fecnac" class="form__input" placeholder="Fecha de Nacimiento">
                @error('fecnac')
                    <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                      {{$message}}
                    </div>
                @enderror
            </div>

            <div class="row bloque">
              <small>Tel/Cel</small>
                <input type="text" value="{{ old('telcel')}}" name="telcel" id="telcel" class="form__input" placeholder="Tel/Cel">
                @error('telcel')
                    <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                      {{$message}}
                    </div>
                @enderror
            </div>


            <div class="row bloque">
                <label for="cars">(*) Cargo:</label>
                <select id="cargo" name="cargo" class="form__input__select">
                    <option value="cajero">Cajero</option>
                    <option value="administrador">Administrador</option>
                </select>
            </div>

            <div class="row bloque">
              <small>Cod. Func.</small>
                <input type="text" value="{{ old('codfunc')}}" name="codfunc" id="codfunc" class="form__input" placeholder="Cod Funcionario" readonly>
                @error('codfunc')
                    <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                      {{$message}}
                    </div>
                @enderror
            </div>

            <div class="row bloque">
              <small>Cod. Func.</small>
              <input type="text" value="{{ old('codfunc')}}" name="codpers" id="codpers" class="form__input" placeholder="Cod Persona" readonly>
              @error('codpers')
                  <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                    {{$message}}
                  </div>
              @enderror
            </div>

            <div class="row bloque">
              <small>Email</small>
                <input type="text" value="{{ old('email')}}" name="email" id="email" class="form__input" placeholder="Correo Electronico">
                @error('email')
                    <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                      {{$message}}
                    </div>
                @enderror
            </div>

            <div class="row inp-dom">
              <small>Domicilio</small>
                <input type="text" value="{{ old('domicilio')}}" name="domicilio" id="domicilio" class="form__input" placeholder="Domicilio">
                @error('domicilio')
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
<script src="{{asset('jquery/jqueryVistaActualizacionFuncionario.js')}}"></script>    
</body>
</html>

@else
<script>
  window.location.href='{{url("/")}}';
</script>
@endif
<script>
    var url_actualizar_datos_funcionario= '{{url("/datosFuncionarioActualizar")}}';
</script>