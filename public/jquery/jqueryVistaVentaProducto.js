$("#btn-ventas-aceptar").click(function (e) { 
    e.preventDefault();
    var trstring='<tr><th scope="row" class="text-uppercase">cod1</th><td class="text-uppercase">Arroz con chicharon de pollo</td><td>1</td><td>20</td></tr>'
    $("#filasDetalleVentas").before(trstring);
});

$("tbody").on('click',"tr",function(){
    $(this).css("background","red");
    console.log($(this).html());
});

