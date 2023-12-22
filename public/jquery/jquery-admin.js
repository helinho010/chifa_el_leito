function actualizacionVentasHastaElMomento()
{
    let csrf=$("input[name=_token]").val();
    let myChart1;
    $.ajax({
        type: "POST",
        url: url_actualizacionDeDatos,
        data: {"_token":csrf},
        success: function (response) {
            let respuestaConvertida = $.parseJSON(response);
            /*
            * Total Ventas
            */
            $('#totalVentaHoy').text("Bs. "+respuestaConvertida.totalventaDia);
            
            /*
            * Total Ventas Mes
            */
            $('#totalVentaMes').text("Bs. "+respuestaConvertida.totalventaMes);

            /*
            * Grafico de rosca
            */
            $('canvas#worldwide-sales').remove();
            $("div#dona-reporte-venta-producto").append('<canvas id="worldwide-sales" ></canvas>');
            var ctx1 = $("#worldwide-sales").get(0).getContext("2d");
            myChart1 = new Chart(ctx1, {
            type: "doughnut",
            data: {
                labels: respuestaConvertida.labels,
                datasets: [{
                        label: 'My First Dataset',
                        data: respuestaConvertida.data,
                        backgroundColor: respuestaConvertida.colores,
                        hoverOffset: 15
                    }
                ]
                },
            options: {
                responsive: true
            }
            }); 
            myChart1.update();     
            console.log(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

$(document).ready(function(){
   actualizacionVentasHastaElMomento(); 
});
//cada 30 segundos
setInterval(actualizacionVentasHastaElMomento,30000);
//cada 3 segundos
//setInterval(actualizacionVentasHastaElMomento,3000);


/*
* Reporte Admin x Rango de fechas
*/
$("#generar-reporte-rango-adim").on("click",function(){
    fec_ini=$("#rango-fecha-inicial").val();
    fec_fin=$("#rango-fecha-final").val();
    let csrf=$("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: url_reporte_rango_cajas_admin,
        data: {"_token":csrf, 
               "fecha_inicial":fec_ini,
               "fecha_final":fec_fin},
        success: function (response) {
            console.log("Esta es la respuesta: ");
            console.log(response);
        },
        error: function (error) {
            console.log(error);
        }
    });

    console.log(fec_ini+" "+fec_fin);
    $("#cerrar-modal-reporte-rango-admin").click();
});



/*
* Inserta una tabla con informacion de la lista de funcionarios o productos
*/
$("a").on("click",function(){
    let opcion=$(this).attr("id");
    if(opcion == "listar-funcionarios" || opcion == "listar-productos")
    {
        let csrf=$("input[name=_token]").val();
        $.ajax({
            type: "POST",
            url: url_listar_funcionario_productos,
            data: {"_token":csrf, 
                   "reporte":$(this).attr("id")},
            success: function (response) {
                let respuestaConvertida = $.parseJSON(response);
                if (opcion == "listar-funcionarios") {
                    $("#cabecera-lista-funcionario-producto").text("");
                    $("#cuerpo-lista-funcionario-producto").text("");
                    $("#titulo-lista-funcionario-producto").text("Lista de Funcionarios");
                    $("#cabecera-lista-funcionario-producto").append('<tr class="text-dark">\
                    <th scope="col">No.</th>\
                    <th scope="col">Nombre Completo</th>\
                    <th scope="col">CI</th>\
                    <th scope="col">Fec Nac.</th>\
                    <th scope="col">Tel/Cel</th>\
                    <th scope="col">Domicilio</th>\
                    <th scope="col">Cod. Funcionario</th>\
                    <th scope="col">Cargo</th>\
                    <th scope="col">Email</th>\
                    <!--th scope="col">Action</th-->\
                    </tr>');
                    $.each(respuestaConvertida, function(i, item) {
                        $("#cuerpo-lista-funcionario-producto").append('<tr>\
                        <td>'+(i+1)+'</td>\
                        <td>'+respuestaConvertida[i].nomcomp+'</td>\
                        <td>'+respuestaConvertida[i].ci+'</td>\
                        <td>'+respuestaConvertida[i].fec_nac+'</td>\
                        <td>'+respuestaConvertida[i].tel_cel+'</td>\
                        <td>'+respuestaConvertida[i].domicilio+'</td>\
                        <td>'+respuestaConvertida[i].codigo_funcionario+'</td>\
                        <td>'+respuestaConvertida[i].cargo+'</td>\
                        <td>'+respuestaConvertida[i].email+'</td>\
                        <!--td><a class="btn btn-sm btn-primary" href="">Detail</a></td-->\
                        </tr>');
                    });
                }else{
                    $("#cabecera-lista-funcionario-producto").text("");
                    $("#cuerpo-lista-funcionario-producto").text("");
                    $("#titulo-lista-funcionario-producto").text("Lista de Productos");
                    $("#cabecera-lista-funcionario-producto").append('<tr class="text-dark">\
                    <th scope="col">No.</th>\
                    <th scope="col">Cod. Prod.</th>\
                    <th scope="col">Descripcion</th>\
                    <th scope="col">Precio</th>\
                    <!--th scope="col">Action</th-->\
                    </tr>');
                    $.each(respuestaConvertida, function(i, item) {
                        $("#cuerpo-lista-funcionario-producto").append('<tr>\
                        <td>'+(i+1)+'</td>\
                        <td>'+respuestaConvertida[i].id_codigo_producto+'</td>\
                        <td>'+respuestaConvertida[i].descripcion+'</td>\
                        <td>'+respuestaConvertida[i].precio+'</td>\
                        <!--td><a class="btn btn-sm btn-primary" href="">Detail</a></td-->\
                        </tr>');
                    });
                }
                console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }    
});




/*
* Cerrar Session admin
*/
$('#cerrar-session-admin').on('click',function(e){
    e.preventDefault();
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


