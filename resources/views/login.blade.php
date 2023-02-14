@extends('plantilla.cabecera')
@section('nombreIcono','login.png')
@section('nombreDocumento',"Inicio Session")
@section('barraSuperior')


<!-- Main Content -->
<div class="container-fluid">
  <div class="row main-content bg-success text-center">
    <div class="col-md-4 text-center company__info">
      <span class="company__logo"><h2><span class="fa fa-android"></span></h2></span>
      <h4 class="company_title">Chifa El Leito</h4>
    </div>
    <div class="col-md-8 col-xs-12 col-sm-12 login_form ">
      <div class="container-fluid">
        <div class="row">
          <h2>Inicio de Session</h2>
        </div>
        <div class="row">
          <form control="" class="form-group" action="{{ route('auth.login') }}" method="POST">
            @csrf
            <div class="row">
              <input type="text" value="{{ old('usuario')}}" name="usuario" id="username" class="form__input" placeholder="Nombre de Usuario">
              @error('usuario')
                  <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                    {{$message}}
                  </div>
              @enderror
            </div>
            <div class="row">
              <!-- <span class="fa fa-lock"></span> -->
              <input type="password" name="password" id="password" class="form__input" placeholder="Contraseña de Usuario">
              @error('password')
                    <div style="color: red; font-size: 13px; margin-top:5px; margin-left:10px">
                        {{$message}}
                      </div>
              @enderror
            </div>
            <!--div class="row">
              <input type="checkbox" name="remember_me" id="remember_me" class="">
              <label for="remember_me">Remember Me!</label>
            </div-->
            <div class="row btn-acceder">
              <input type="submit" value="Acceder" class="btn">
            </div>
          </form>
        </div>
        <div class="row">
          <p>Se olvido su contraseña <a href="#">presione aqui!</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Footer -->
<div class="container-fluid text-center footer">
  Yo &hearts; la Chifa El Leito !
</div>



@extends('plantilla.pie');
