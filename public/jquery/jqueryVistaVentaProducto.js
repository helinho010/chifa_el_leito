$("#btn-ventas-aceptar").click(function (e) { 
    e.preventDefault();
    var trstring='<tr id="reg-ventas"><th scope="row" class="text-uppercase">cod1</th><td class="text-uppercase">Arroz con chicharon de pollo</td><td>1</td><td>20</td></tr>'
    $("#filasDetalleVentas").before(trstring);
});

$("tbody").on('click',"tr",function(){
    if ($(this).attr("id") == "reg-ventas"){
        $(this).css("background","red");
    }
    else{
        
    }
});

