function actualizacionVentasHastaElMomento()
{
    let csrf=$("input[name=_token]").val();
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
            var ctx1 = $("#worldwide-sales").get(0).getContext("2d");
            var myChart1 = new Chart(ctx1, {
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

setInterval(actualizacionVentasHastaElMomento,60000);



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
