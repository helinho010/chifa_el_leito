@include('plantilla.cabecera')
<div class="container detalleDeVentaFuncionario">
    <div class="row">
        <div class="col-md-12 nombreEntidad text-center">
            CHIFA EL LEITO 
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="datos-dia-responsable">
                <div class="fecha">
                    Fecha: {{date("d/m/Y")}}
                </div>
                
                <div class="nombre">
                    Nombre Cajero: Juan Salamanca Alvares
                </div>
                <div class="codcajero">
                    Codigo Cajero: JSA835
                </div>
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Cod.Pla.">
                        <label for="formGroupExampleInput">Codigo Plato</label>
                      </div>  
                      <div class="col-md-3">
                         <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Cantidad">
                         <label for="formGroupExampleInput2">Cantidad</label>    
                      </div> 
                      <div class="btn col-md-2 bg-success btn-ventas" id="btn-ventas-aceptar">
                        Aceptar
                      </div>
                      <div class="btn col-md-2 bg-info btn-ventas" id="btn-ventas-borrar">
                        Borrar
                      </div>
                </div>  
            </form>
        </div>
        <div class="col-md-3">
            <div class="imagenPlato">
                <img class="img-fluid" src="{{asset("img/platos/pollo.jpeg")}}" alt="">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="detalleVenta col-md-12">
            <table class="table table-hover">
                <thead class="thead-dark text-center">
                  <tr>
                    <th class="col-md-2 bg-success" scope="col">codigo</th>
                    <th class="col-md-6 bg-info" scope="col">Descripcion</th>
                    <th class="col-md-2 bg-warning" scope="col">Cantidad</th>
                    <th class="col-md-2 bg-danger" scope="col">Monto Bs</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <tr id="reg-ventas">
                    <th scope="row" class="text-uppercase">cod1</th>
                    <td class="text-uppercase">Arroz con chicharon de pollo</td>
                    <td id="cantidad-ventas-form">1</td>
                    <td id="monto-ventas-form">20</td>
                  </tr>
                  <tr id="filasDetalleVentas"></tr>
                  <tr>
                    <th colspan="2"></th>
                    <td>A Cobrar Bs:</td>
                    <td id="cobrar-ventas-form">60</td>
                  </tr>
                  <tr>
                    <th colspan="2"></th>
                    <td>Efectivo Bs:</td>
                    <td id="efectivo-ventas-form"><input type="number" placeholder="0" style="width: 50%"></td>
                  </tr>
                  <tr>
                    <th colspan="2"></th>
                    <td>Cambio Bs:</td>
                    <td id="cambio-ventas-form">0</td>
                  </tr>
                </tbody>
              </table>
        </div>
    </div>
</div>
@include('plantilla.pie')

