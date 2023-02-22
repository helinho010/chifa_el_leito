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
                        <input type="text" class="form-control" id="codplato" placeholder="Cod.Pla.">
                        <label for="codplato">Cod. Plato</label>
                      </div>  
                      <div class="col-md-3">
                         <input type="text" class="form-control" id="cantplato" placeholder="Cantidad">
                         <label for="cantplato">Cantidad</label>    
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
                    <th class="col-md-1 bg-success" scope="col">codigo</th>
                    <th class="col-md-5 bg-info" scope="col">Descripcion</th>
                    <th class="col-md-2 bg-warning" scope="col">Cantidad</th>
                    <th class="col-md-2 bg-danger" scope="col">P. Unitario Bs</th>
                    <th class="col-md-2 bg-danger" scope="col">Sub Total Bs</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <!--tr id="reg-ventas">
                    <th scope="row" class="text-uppercase">cod1</th>
                    <td class="text-uppercase">Arroz con chicharon de pollo</td>
                    <td id="cantidad-ventas-form">2</td>
                    <td id="punitario-ventas-form">20</td>
                    <td id="subtotal-ventas-form">40</td>
                  </tr-->
                  <tr id="filasDetalleVentas"></tr>
                  <tr>
                    <th colspan="3"></th>
                    <td>A Cobrar Bs:</td>
                    <td id="cobrar-ventas-form">0</td>
                  </tr>
                  <tr>
                    <th colspan="3"></th>
                    <td>Efectivo Bs:</td>
                    <td><input id="efectivo-ventas-form" value=0 type="number" placeholder="0" style="width: 80%"></td>
                  </tr>
                  <tr>
                    <th colspan="3"></th>
                    <td>Cambio Bs:</td>
                    <td id="cambio-ventas-form">0</td>
                  </tr>
                </tbody>
              </table>
        </div>
    </div>
</div>

<!--Modal de mensajes-->
<div class="modal fade" id="modalMensajes" tabindex="-1" aria-labelledby="modalMensajesLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalMensajesLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin modal de mensajes-->
@include('plantilla.pie')

