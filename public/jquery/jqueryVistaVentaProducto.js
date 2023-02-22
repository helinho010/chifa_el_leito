function calcularMontoTotalCompra(montosPlatos)
{
    let suma=0;
    for (let index = 0; index < montosPlatos.length; index++) 
    {
        suma = suma+montosPlatos[index];
    }
    return suma;
}


/*
* Funcion para seleccionar el producto por id y la cantidad y llenarlo 
* en la tabla de venta o detalle de venta de Productos
*/
$("#btn-ventas-aceptar").click(function (e) { 
    e.preventDefault();
    var trstring='<tr id="reg-ventas"><th scope="row" class="text-uppercase">cod1</th><td class="text-uppercase">Arroz con chicharon de pollo</td><td>1</td><td>20</td></tr>'
    $("#filasDetalleVentas").before(trstring);
});


/*
* Selecciona los tr's y les asigna css background red, para posteriormente ser eliminados.
*/

$("tbody").on('click',"tr",function(){
    if ($(this).attr("id") == "reg-ventas"){
        $(this).css("background","red");
    }
});


/*
* Boton para borrar los tr's seleccionados con rojo de la tabla de ventas
*/
$("#btn-ventas-borrar").on("click",function (e) { 
    e.preventDefault();
    $("tr").each(function(){
        if($(this).attr("style") == "background: red;")
        {
           $(this).remove();
        }
    });
    console.log(calcularMontoTotalCompra([10,20,30]));
});
