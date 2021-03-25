$(function()
    {
        Swal.close();
    }
)

function generar_reporte()
{
    var periodo = $("#txt_periodo").val();
    if(periodo.length>3)
    {
        Swal.fire({
            icon: 'question',
            title: 'Generando...',
            text: 'Generando reporte, espere por favor',
            allowOutsideClick : false,
            allowEscapeKey : false,
            showConfirmButton : false
        });
        $.ajax({
            method : 'POST',
            url : 'controllers/generar_reporte_por_periodo.ctrl.php',
            data : {'periodo': periodo}
        }).done(function(responseText){
            Swal.close();
            $("#div_formulario_nuevo_reembolso").html(responseText);
        })
    }
}

function generar_reporte_de_reembolso(numero_de_documento)
{
    Swal.fire({
        icon: 'info',
        title: 'Generando',
        text: 'Generando el reporte de reembolso, espere por favor...',
        allowOutsideClick : false,
        allowEscapeKey : false,
        showConfirmButton : false
    });
    $.ajax({
        method : 'POST',
        url : '/controllers/generar_reporte_de_reembolso.ctrl.php',
        data : {'numero_de_documento' : numero_de_documento}
    }).done(function(response){
        Swal.close();
        $("#div_formulario_nuevo_reembolso").html(response);
    })
}