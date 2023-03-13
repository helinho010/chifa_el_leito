$("#btn-buscar-datos-producto").on("click",function(e){
    e.preventDefault();
    let codprod=$("#buscar-datos-producto").val();
    if (!codprod.trim()) {
        $("#title-buscar-funcionarioLabel").text("El campo buscar no tiene datos");
        $("#mensaje-body-datos-funcionario").text("Por favor introduzca datos en el cuadro de buscar");
        $("#mensajes-buscar-funcionario").modal('show');
    }
    else{
        let csrf=$("input[name=_token]").val();
        $.ajax({
            type: "POST",
            url: url_buscar_datos_producto,
            data: {"_token":csrf,
                   "codprod":codprod},
            success: function (response) {
                let respuestaConvertida = $.parseJSON(response);
                if(respuestaConvertida.mensaje == "true")
                {
                    $.each(respuestaConvertida.datosProducto, function (i, value) 
                    { 
                        $("#actidCodProd").val(value.id_codigo_producto)
                        $("#idCodProd").val(value.id_codigo_producto);
                        $("#descripcion").val(value.descripcion);
                        $("#precio").val(value.precio);     
                    });
                }else{
                    $("#title-buscar-funcionarioLabel").text("No se encontraron Registros con el Dato de busqueda");
                    $("#mensaje-body-datos-funcionario").text("El numero de CI: "+codprod+" no se encontro en la Base de Datos");
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