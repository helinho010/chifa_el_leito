function calcularMontoTotalCompra(montosPlatos)
{
    let suma=0;
    for (let index = 0; index < montosPlatos.length; index++)
    {
        suma = suma+parseInt(montosPlatos[index]);
    }
    return suma;
}
function autofocus()
{
    $("#codplato").focus();
    $("#cantplato").val("");
    // El select selecciona el contenido del input 
    //$("#codplato").select();
    $("#codplato").val("");
}

function imp_detalle_ventas()
{
        if(/*$("#efectivo-ventas-form").val() > 0 && parseInt($("#cambio-ventas-form").text())>=0 &&*/ $('tr').length > 5)
        {
            let csrf=$("input[name=_token]").val();
            let cliente_nombre_razonsocial=$("#cliente_nombre_razonsocial").val();
            cliente_nombre_razonsocial=cliente_nombre_razonsocial == "" ? "Sin Nombre":cliente_nombre_razonsocial;
            let total_venta=parseInt(($("#cobrar-ventas-form").text()).trim());
            let cliente_nit_ci=$("#cliente_nit_ci").val();
            cliente_nit_ci=cliente_nit_ci == "" ?"0": cliente_nit_ci;
            let efectivo_venta=parseInt($("#efectivo-ventas-form").val());
            let tr_productos=[];
            const detalle_productos=[];        
            
            $("tr").each(function(){
                if($(this).attr("id") == "reg-ventas")
                {
                   tr_productos.push($(this).find("#cod_prod").text());
                   tr_productos.push($(this).find("#descrp_prod").text());
                   tr_productos.push($(this).find("#cantidad-ventas-form").text());
                   tr_productos.push($(this).find("#punitario-ventas-form").text());
                   tr_productos.push($(this).find("#subtotal-ventas-form").text());
                   detalle_productos.push(tr_productos);
                   tr_productos=[];
                }
            });
            let datosJsonVentaDetalleFuncionario={
                "_token":csrf,
                "nombre_cliente":cliente_nombre_razonsocial.trim(),
                "nit_ci_cliente":cliente_nit_ci.trim(),
                "total_venta":total_venta,
                "efectivo_venta":efectivo_venta,
                "detalle":detalle_productos
            };
    
            $.ajax({
                type: "POST",
                url: url_imprimir,
                data: datosJsonVentaDetalleFuncionario,
                beforeSend: function(){
                    $("#modalMensajesLabel").text("Procesando...");
                    $("#modal-body-mensajes").html('Espere un momento por favor, Cargando datos a la base de datos');
                    $("#btn-cerrar-modal").hide();
                    $("#modalMensajes").modal("show");
                },
                success: function (response) {
                    $("#cliente_nombre_razonsocial").val("Sin Nombre");
                    $("#cliente_nit_ci").val("0");
                    $("#efectivo-ventas-form").val("0");
                    $("#codplato").val("");
                    $("#cantplato").val("");
                    $("#modalMensajes").modal("hide");
                    location.reload();
                    console.log(response);
                },
                error: function (error) {
                    $("#modalMensajes").modal("hide");
                    $("#btn-cerrar-modal").show();
                    $("#modalMensajesLabel").text("HUBO UN ERROR");
                    $("#modal-body-mensajes").text("Error en la respuesta del servidor, por favor contactese con el tecnico");
                    $("#modalMensajes").modal("show");
                    console.log(error);
                }
            });
        }
        else{
            let mensajeErrorCabecera="";
            let mensajeErrorCuerpo="";
            if($('tr').length > 5)
            {
                mensajeErrorCabecera="Error al momento de cobrar el efectivo"
                mensajeErrorCuerpo= "Esta seguro que cobro bien el efectivo? </br>Efectivo: "+ ($("#efectivo-ventas-form").val() > 0 ? $("#efectivo-ventas-form").val():0 )  +"</br>Cambio: "+$('#cambio-ventas-form').text();
            }
            else{
                mensajeErrorCabecera="Error Detalle de Ventas";
                mensajeErrorCuerpo="No existe registros para ser procesados";
            }
            $("#btn-cerrar-modal").show();
            $("#modalMensajesLabel").text(mensajeErrorCabecera);
            $("#modal-body-mensajes").html(mensajeErrorCuerpo);
            $("#modalMensajes").modal("show");
        }
}


$(document).ready(function(){
    autofocus();
});



/*
* Funcion para seleccionar el producto por id y la cantidad y llenarlo
* en la tabla de venta o detalle de venta de Productos
*/
$("#btn-ventas-aceptar").on("click", function (e) {
    e.preventDefault();
    const subtotal=[];
    let codigoDeProductoBuscar=($("#codplato").val()).toUpperCase();
    let formCantPlato= parseInt($("#cantplato").val());
    let csrf=$("input[name=_token]").val();
    $.ajax({
        type: 'POST',
        url: url_aceptar,
        data: {"_token":csrf,
            "codigoProducto":codigoDeProductoBuscar},

        success: function (response) {
            let respuestaConvertida = $.parseJSON(response);
            if(respuestaConvertida.descripcion === null && respuestaConvertida.precio === null )
            {
                $("#btn-cerrar-modal").show();
                $("#modalMensajesLabel").text("El CODIGO DE PLATO introducido es invalido");
                $("#modal-body-mensajes").text("El "+codigoDeProductoBuscar+" no se encontro en la Base de Datos");
                $("#modalMensajes").modal("show");
            }
            else{
                if(formCantPlato>0)
                    {

                        var trstring='<tr id="reg-ventas"><th scope="row" class="text-uppercase" id="cod_prod">'+codigoDeProductoBuscar+'</th><td class="text-uppercase" id="descrp_prod">'+respuestaConvertida.descripcion+'</td><td id="cantidad-ventas-form">'+formCantPlato+'</td><td id="punitario-ventas-form">'+(respuestaConvertida.precio).substring(0,(respuestaConvertida.precio).length-1)+'</td><td id="subtotal-ventas-form"></td></tr>'
                        $("#filasDetalleVentas").before(trstring);

                        $("tr").each(function(){
                            if($(this).attr("id") == "reg-ventas")
                            {
                                if (!($(this).find('#cantidad-ventas-form').text()))
                                {}
                                else{
                                cantidad=parseInt($(this).find('#cantidad-ventas-form').text());
                                precioPlato=parseFloat($(this).find('#punitario-ventas-form').text());
                                $(this).find("#subtotal-ventas-form").text((cantidad*precioPlato).toFixed(2));
                                subtotal.push((cantidad*precioPlato).toFixed(2));
                                }
                            }
                        });

                        let totalCobrar=calcularMontoTotalCompra(subtotal);
                        $("#cobrar-ventas-form").text(totalCobrar.toFixed(2));
                        let efectivoRecido=$("#efectivo-ventas-form").val();
                        $("#cambio-ventas-form").text((efectivoRecido-totalCobrar).toFixed(2));
                    }
                    else
                    {
                        $("#btn-cerrar-modal").show();
                        $("#modalMensajesLabel").text("ERROR EN LA ** CANTIDAD **");
                        $("#modal-body-mensajes").text("El dato debe ser un NUMERO o mayor a 0 (cero)");
                        $("#modalMensajes").modal("show");
                    }
            }
        },
        error: function (error) {
            console.log("error: ");
        }
    });
    autofocus();
});


/*
* Selecciona los tr's y les asigna css background red, para posteriormente ser eliminados.
*/

$("tbody").on('click',"tr",function(){
    if ($(this).attr("id") == "reg-ventas"){
        if($(this).attr("style") == "background: red;")
        {
            $(this).removeAttr("style");
        }
        else{
            $(this).css("background","red");
        }
    }
});


/*
* Boton para borrar los tr's seleccionados con rojo de la tabla de ventas
*/
$("#btn-ventas-borrar").on("click",function (e) {
    e.preventDefault();
    const subtotal=[];
    $("tr").each(function(){
        if($(this).attr("style") == "background: red;")
        {
           $(this).remove();
        }
        else{
           if (!($(this).find('#cantidad-ventas-form').text()))
           {}
           else{
             cantidad=parseInt($(this).find('#cantidad-ventas-form').text());
             precioPlato=parseInt($(this).find('#punitario-ventas-form').text());
             $(this).find("#subtotal-ventas-form").text((cantidad*precioPlato).toFixed(2));
             subtotal.push(cantidad*precioPlato);
           }
        }
    });
    let totalCobrar=calcularMontoTotalCompra(subtotal);
    $("#cobrar-ventas-form").text(totalCobrar.toFixed(2));
    let efectivoRecido=$("#efectivo-ventas-form").val();
    $("#cambio-ventas-form").text((efectivoRecido-totalCobrar).toFixed(2));
    autofocus();
});

/*
* Captura la tecla enter en el input  efectivo-ventas-form y vuelve a calcular nuevos valores
*/
$("#efectivo-ventas-form").keypress(function(e) {
    if(e.which == 13) {
      e.preventDefault();
      let aCobrar=parseInt($("#cobrar-ventas-form").text());
      let efectivoRecido=$("#efectivo-ventas-form").val();
      $("#cambio-ventas-form").text((efectivoRecido-aCobrar).toFixed(2));
      autofocus();  
    }
});


/*
* Captura la tecla enter en el input codigo plato y el cursor se mueve automaticamente al input cantplato
*/
$("#codplato").keypress(function(e) {
    if(e.which == 13) {
      e.preventDefault();
      if($("#codplato").val()=="")
      {}
      else{
        $("#cantplato").focus();  
      }  
    }
});


/*
* Captura la tecla enter en el input cantplato e inserta el registro al detalle de ventas
*/
$("#cantplato").keypress(function(e) {
    if(e.which == 13) {
      e.preventDefault();
      if($("#cantplato").val()=="")
      {}
      else
      {
        e.preventDefault();
        const subtotal=[];
        let codigoDeProductoBuscar=($("#codplato").val()).toUpperCase();
        let formCantPlato= parseInt($("#cantplato").val());
        let csrf=$("input[name=_token]").val();
        $.ajax({
            type: 'POST',
            url: url_aceptar,
            data: {"_token":csrf,
                "codigoProducto":codigoDeProductoBuscar},

            success: function (response) {
                let respuestaConvertida = $.parseJSON(response);
                if(respuestaConvertida.descripcion === null && respuestaConvertida.precio === null )
                {
                    $("#btn-cerrar-modal").show();
                    $("#modalMensajesLabel").text("El CODIGO DE PLATO introducido es invalido");
                    $("#modal-body-mensajes").text("El "+codigoDeProductoBuscar+" no se encontro en la Base de Datos");
                    $("#modalMensajes").modal("show");
                }
                else{
                    if(formCantPlato>0)
                        {

                            var trstring='<tr id="reg-ventas"><th scope="row" class="text-uppercase" id="cod_prod">'+codigoDeProductoBuscar+'</th><td class="text-uppercase" id="descrp_prod">'+respuestaConvertida.descripcion+'</td><td id="cantidad-ventas-form">'+formCantPlato+'</td><td id="punitario-ventas-form">'+(respuestaConvertida.precio).substring(0,(respuestaConvertida.precio).length-1)+'</td><td id="subtotal-ventas-form"></td></tr>'
                            $("#filasDetalleVentas").before(trstring);

                            $("tr").each(function(){
                                if($(this).attr("id") == "reg-ventas")
                                {
                                    if (!($(this).find('#cantidad-ventas-form').text()))
                                    {}
                                    else{
                                    cantidad=parseInt($(this).find('#cantidad-ventas-form').text());
                                    precioPlato=parseFloat($(this).find('#punitario-ventas-form').text());
                                    $(this).find("#subtotal-ventas-form").text((cantidad*precioPlato).toFixed(2));
                                    subtotal.push((cantidad*precioPlato).toFixed(2));
                                    }
                                }
                            });

                            let totalCobrar=calcularMontoTotalCompra(subtotal);
                            $("#cobrar-ventas-form").text(totalCobrar.toFixed(2));
                            let efectivoRecido=$("#efectivo-ventas-form").val();
                            $("#cambio-ventas-form").text((efectivoRecido-totalCobrar).toFixed(2));
                        }
                        else
                        {
                            $("#btn-cerrar-modal").show();
                            $("#modalMensajesLabel").text("ERROR EN LA ** CANTIDAD **");
                            $("#modal-body-mensajes").text("El dato debe ser un NUMERO o mayor a 0 (cero)");
                            $("#modalMensajes").modal("show");
                        }
                }
            },
            error: function (error) {
                console.log("error: ");
            }
        });
        autofocus();
      }  
    }
});



/*
* Captura el boton de la modal que muestra mensajes
*/
$('#modalMensajes').on('hidden.bs.modal', function (event) {
    event.preventDefault();
    $("#codplato").val("");
    $("#codplato").focus();
});



/*
* Funcion para imprimir el detalle de ventas
*/
$("#imprimirDetalleVentaProducto").on("click",function(){
    imp_detalle_ventas();
});

/*
* Imprirmir con F2 del teclado
*/
$(document).keydown(function(e) {
    if(e.which == 113) {
        e.preventDefault();
        imp_detalle_ventas();
    }
});

/*
* Borrar la session del usuario
*
*/
$('#cerrar-session-funcionario').on('click',function(){
    let id_funcionario=parseInt($("#id_funcionario").text());
    let csrf=$("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: url_cerrar_session,
        data: {"_token":csrf},
        success: function (response) {
            if(response == 1)
            {
                $(location).prop('href', url_login);
            }
            else{
                console.log("Error al momento de cerrar la session: "+response);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
});

/**
 * Reporte diario del funcionario (vista previa)
 */
$("#reporte-arqueo-funcionario").click(function(){
    let csrf=$("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: url_reporte_arqueo_funcionario,
        data: {"_token":csrf},
        beforeSend: function(){
            $("#modalMensajesLabel").text("Procesando...");
            $("#modal-body-mensajes").html('Espere un momento por favor, solicitud en proceso');
            $("#btn-cerrar-modal").hide();
            $("#modalMensajes").modal("show");
        },
        success: function (response) {
            let respuestaConvertida = $.parseJSON(response);
            let cabeceraTablaReporte='<table class="table">\
            <thead>\
              <tr>\
                <th scope="col">#</th>\
                <th scope="col">Cod.</th>\
                <th scope="col">Cnt.</th>\
                <th scope="col">P.U.</th>\
                <th scope="col">Total</th>\
              </tr>\
            </thead>\
            <tbody>';
            let cuerpoTablaReporte="";
            let pieTablaReporte="";
            if(respuestaConvertida.mensaje)
            {
                $("#modalMensajes").modal('hide');
                $("#modalReporteCajeroLabel").text("Reporte Diario Cajero");
                $.each(respuestaConvertida.data, function(i, item) {
                    cuerpoTablaReporte=cuerpoTablaReporte+'<tr>\
                    <th scope="row">'+(i+1)+'</th>\
                    <td>'+item.id_cod_prod+'</td>\
                    <td>'+item.sum+'</td>\
                    <td>'+item.precio+'</td>\
                    <td>'+item.sum*item.precio+'</td>\
                  </tr>';
                });
                pieTablaReporte='</tbody>\
                </table>';
                $("#modal-body-reporte-cajero").html(cabeceraTablaReporte+cuerpoTablaReporte+pieTablaReporte);
                $("#modalReporteCajero").modal("show");
            }else{
                $("#modalMensajes").modal('hide');
                $("#modalReporteCajeroLabel").text("Reporte Diario Cajero");
                $("#modal-body-reporte-cajero").html("El cajero no tiene transacciones...");
                $("#modalReporteCajero").modal("show");
            }
            console.log(respuestaConvertida.data);
        },
        error: function (error) {
            console.log(error);
        }
    });
});

/**
 * Codigo para mandar a imprimir (impresora) el reporte diario del funcionario
 * Modal de vista previa
 */
$("#btn-imprimir-reporte-cajero").on("click",function(){
    let csrf=$("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: url_imprimir_reporte_arqueo_funcionario_modal,
        data: {"_token":csrf},
        beforeSend: function(){
            $("#modalReporteCajero").modal('hide');
            $("#modalMensajesLabel").text("Procesando...");
            $("#modal-body-mensajes").html('Espere un momento por favor, solicitud en proceso');
            $("#btn-cerrar-modal").hide();
            $("#modalMensajes").modal("show");
        },
        success: function (response) {
            let respuestaConvertida = $.parseJSON(response);
            $("#modalReporteCajero").modal('hide');
            $("#modalMensajes").modal("hide");
            console.log(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
});

$("#cambiar-password-funcionario").on("click",function(){
    $("#ant-passwd").val("");
    $("#new-passwd").val("");
    $("#conf-passwd").val("");
    $("#modalCambioPasswd").modal("show");
});

//$('#modalCambioPasswd').on('hidden.bs.modal', function (event) {
$('#guardar-cabio-passwd').on("click",function(e){
    let csrf=$("input[name=_token]").val();
    let antContrasenia=$('#ant-passwd').val();
    let newContrasenia=$('#new-passwd').val();
    let confContrasenia=$('#conf-passwd').val();
    let idFuncionario=($('#id_funcionario').text()).trim();
    let mensaje="";
    if(antContrasenia!="" && newContrasenia!="" && confContrasenia!="")
    {
        if(newContrasenia==confContrasenia)
        {
            $.ajax({
                type: "POST",
                url: url_cambio_password,
                data: {"_token":csrf,
                       "antContrasenia":antContrasenia,
                        "newContrasenia":newContrasenia,
                        "confContrasenia":confContrasenia,
                        "idfuncionario":idFuncionario
                      },
                success: function (response) {
                    if(response==1)
                    {
                        $("#modalCambioPasswd").modal('hide');
                        $("#modalMensajesLabel").text("CAMBIO DE CONTRASEÑA CORRECTAMENTE");
                        $("#modal-body-mensajes").html('Su contraseña ha sido actulizada correctamente');
                        $("#modalMensajes").modal("show");
                    }else{
                        $("#modalCambioPasswd").modal('hide');
                        $("#modalMensajesLabel").text("ERROR EN LA CONTRASEÑA ACTUAL");
                        $("#modal-body-mensajes").html('La contraseña actual incorrecta, vuelva a intentar por favor');
                        $("#modalMensajes").modal("show");
                    }
                    console.log(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
        else{
            $("#modalCambioPasswd").modal('hide');
            $("#modalMensajesLabel").text("Error al confirmar la contraseña!");
            $("#modal-body-mensajes").html('El Campo nuevo Password y Confirme Password deben ser iguales, por favor intente de nuevo.');
            $("#modalMensajes").modal("show");
            mensaje="El campo Nuevo Password no es igual al campo Confirme Password, estos deben ser iguales!";
        }

    }
    else{
            $("#modalCambioPasswd").modal('hide');
            $("#modalMensajesLabel").text("Llene todos los campos del formulario!");
            $("#modal-body-mensajes").html('Para que se pueda actulizar la contraseña, todos los campos del formulario deben tener informacion.');
            $("#modalMensajes").modal("show");
            mensaje="Por favor introduzca datos en todos los campos";
    }
    console.log(mensaje);
});


