$(document).ready(function(){
    $('#totalVentaHoy').text("Bs. Infinito");
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
