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
    let formCodPlato = $("#codplato").val();
    let formCantPlato= parseInt($("#cantplato").val());
    
    if(formCantPlato>0)
    {
        var trstring='<tr id="reg-ventas"><th scope="row" class="text-uppercase">'+formCodPlato+'</th><td class="text-uppercase">Arroz con chicharon de pollo</td><td id="cantidad-ventas-form">'+formCantPlato+'</td><td id="punitario-ventas-form">20</td><td id="subtotal-ventas-form"></td></tr>'
        $("#filasDetalleVentas").before(trstring);

        $("tr").each(function(){
            if($(this).attr("id") == "reg-ventas")
            {
                if (!($(this).find('#cantidad-ventas-form').text()))
                {}
                else{  
                cantidad=parseInt($(this).find('#cantidad-ventas-form').text());
                precioPlato=parseInt($(this).find('#punitario-ventas-form').text());
                $(this).find("#subtotal-ventas-form").text(cantidad*precioPlato);
                subtotal.push(cantidad*precioPlato);
                }
            }
        });

        let totalCobrar=calcularMontoTotalCompra(subtotal);
        $("#cobrar-ventas-form").text(totalCobrar);
        let efectivoRecido=$("#efectivo-ventas-form").val();
        $("#cambio-ventas-form").text(efectivoRecido-totalCobrar);
    }
    else
    {
        $("#modalMensajesLabel").text("ERROR EN LA ** CANTIDAD **");
        $(".modal-body").text("El dato debe ser un NUMERO o mayor a 0 (cero)");
        $("#modalMensajes").modal("show");
    }
    
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
             $(this).find("#subtotal-ventas-form").text(cantidad*precioPlato);
             subtotal.push(cantidad*precioPlato);
           }
        }
    });
    let totalCobrar=calcularMontoTotalCompra(subtotal);
    $("#cobrar-ventas-form").text(totalCobrar);
    let efectivoRecido=$("#efectivo-ventas-form").val();
    $("#cambio-ventas-form").text(efectivoRecido-totalCobrar);
});

/*
* Captura la tecla enter en el input  efectivo-ventas-form y vuelve a calcular nuevos valores
*/
$("#efectivo-ventas-form").keypress(function(e) {
    if(e.which == 13) {
      e.preventDefault();
      let aCobrar=$("#cobrar-ventas-form").text();
      let efectivoRecido=$("#efectivo-ventas-form").val();
      $("#cambio-ventas-form").text(efectivoRecido-aCobrar);
    }
});



