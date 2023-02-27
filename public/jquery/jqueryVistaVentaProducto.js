function calcularMontoTotalCompra(montosPlatos)
{
    let suma=0;
    for (let index = 0; index < montosPlatos.length; index++) 
    {
        suma = suma+parseInt(montosPlatos[index]);
    }
    return suma;
}


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
        type: "POST",
        url: '/buscarProductos',
        data: {"_token":csrf,
            "codigoProducto":codigoDeProductoBuscar},
        
        success: function (response) {
            let respuestaConvertida = $.parseJSON(response);
            if(respuestaConvertida.descripcion === null && respuestaConvertida.precio === null )
            {
                $("#btn-cerrar-modal").show();
                $("#modalMensajesLabel").text("El CODIGO DE PLATO introducido es invalido");
                $(".modal-body").text("El "+codigoDeProductoBuscar+" no se encontro en la Base de Datos");
                $("#modalMensajes").modal("show");
            }
            else{
                if(formCantPlato>0)
                    {
                        
                        var trstring='<tr id="reg-ventas"><th scope="row" class="text-uppercase">'+codigoDeProductoBuscar+'</th><td class="text-uppercase">'+respuestaConvertida.descripcion+'</td><td id="cantidad-ventas-form">'+formCantPlato+'</td><td id="punitario-ventas-form">'+(respuestaConvertida.precio).substring(1)+'</td><td id="subtotal-ventas-form"></td></tr>'
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
                        $(".modal-body").text("El dato debe ser un NUMERO o mayor a 0 (cero)");
                        $("#modalMensajes").modal("show");
                    }
            }
        },
        error: function (error) { 
            console.log("error"); 
        }
    });

    
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
             cantidad=$(this).find('#cantidad-ventas-form').text();
             precioPlato=$(this).find('#punitario-ventas-form').text();
             $(this).find("#subtotal-ventas-form").text((cantidad*precioPlato).toFixed(2));
             subtotal.push(cantidad*precioPlato);
           }
        }
    });
    let totalCobrar=calcularMontoTotalCompra(subtotal);
    $("#cobrar-ventas-form").text(totalCobrar.toFixed(2));
    let efectivoRecido=$("#efectivo-ventas-form").val();
    $("#cambio-ventas-form").text((efectivoRecido-totalCobrar).toFixed(2));
});

/*
* Captura la tecla enter en el input  efectivo-ventas-form y vuelve a calcular nuevos valores
*/
$("#efectivo-ventas-form").keypress(function(e) {
    if(e.which == 13) {
      e.preventDefault();
      let aCobrar=$("#cobrar-ventas-form").text();
      let efectivoRecido=$("#efectivo-ventas-form").val();
      $("#cambio-ventas-form").text((efectivoRecido-aCobrar).toFixed(2));
    }
});






/*
* Funcion para imprimir el detalle de ventas 
*/
$("#imprimirDetalleVentaProducto").on("click",function(){
    if($("#efectivo-ventas-form").val() > 0 && parseInt($("#cambio-ventas-form").text())>=0)
    {
        let codigoDeProductoBuscar=$("#codplato").val();
        let csrf=$("input[name=_token]").val();
        $.ajax({
            type: "POST",
            url: '/imprimirDetalleVentaFuncionario',
            data: {"_token":csrf,
                "codigoProducto":codigoDeProductoBuscar},
            
            beforeSend: function(){
                $("#modalMensajesLabel").text("Procesando...");
                $(".modal-body").html('Espere un momento por favor, Cargando datos a la base de datos');
                $("#btn-cerrar-modal").hide();
                $("#modalMensajes").modal("show");
            },
            success: function (response) {
                $("#modalMensajes").modal("hide");
                $("#efectivo-ventas-form").val("");
                $("#codplato").val("");
                $("#cantplato").val("");
                location.reload();
            },
            error: function (error) { 
                console.log("error"); 
            }
        });
    }
    else{
        $("#btn-cerrar-modal").show();
        $("#modalMensajesLabel").text("Error al momento de cobrar el efectivo");
        $(".modal-body").html("Esta seguro que cobro bien el efectivo? </br>Efectivo: "+ ($("#efectivo-ventas-form").val() > 0 ? $("#efectivo-ventas-form").val():0 )  +"</br>Cambio: "+$('#cambio-ventas-form').text());
        $("#modalMensajes").modal("show");
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
        url: '/cerrarSession',
        data: {"_token":csrf},
        success: function (response) {
            if(response == 1)
            {
                $(location).prop('href', 'http://localhost:8000/login')
            }
            else{
                console.log("Error al momento de cerrar la session");
            }
        },
        error: function (error) { 
            console.log("error"); 
        }
    });
});