$("#btn-buscar-datos-funcionario").on("click",function(e){
    e.preventDefault();
    let ciABuscar=$("#buscar-datos-funcionario").val();
    if (!ciABuscar.trim()) {
        $("#title-buscar-funcionarioLabel").text("El campo buscar no tiene datos");
        $("#mensaje-body-datos-funcionario").text("Por favor introduzca datos en el cuadro de buscar");
        $("#mensajes-buscar-funcionario").modal('show');
        console.log("True");
    }
    else{
        let csrf=$("input[name=_token]").val();
        $.ajax({
            type: "POST",
            url: url_actualizar_datos_funcionario,
            data: {"_token":csrf,
                   "ci":ciABuscar},
            success: function (response) {
                let respuestaConvertida = $.parseJSON(response);
                if(respuestaConvertida.mensaje == "true")
                {
                    $.each(respuestaConvertida.datosPersona, function (i, value) 
                    { 
                        $("#nombres").val(value.nombre);
                        $("#appate").val(value.ap_pat);
                        $("#apmat").val(value.ap_mat);
                        $("#ci").val(value.ci);
                        $("#fecnac").val(value.fec_nac);
                        $("#telcel").val(value.tel_cel);
                        $("#domicilio").val(value.domicilio);
                        $("#codpers").val(value.id_persona);     
                    });
                    $.each(respuestaConvertida.datosFuncionario, function (i, value) 
                    { 
                        if(value.cargo=="CAJERO")
                        {
                            $("#cargo > option[value=cajero]").prop("selected",true);
                        }else{
                            $("#cargo > option[value=administrador]").prop("selected",true);
                        }
                        $("#email").val(value.email);
                        $("#codfunc").val(value.codigo_funcionario);
                    });
                }else{
                    $("#title-buscar-funcionarioLabel").text("No se encontraron Registros con el Dato de busqueda");
                    $("#mensaje-body-datos-funcionario").text("El numero de CI: "+ciABuscar+" no se encontro en la Base de Datos");
                    $("#mensajes-buscar-funcionario").modal('show');
                }
                
                console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
        //console.log("False");       
    }
});