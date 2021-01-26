$("#btn_servicios_medicos").click(function(){
    Swal.fire({
        icon: 'question',
        title: 'Cargando...',
        text: 'Espere por favor',
        allowOutsideClick : false,
        allowEscapeKey : false,
        showConfirmButton : false
    });
    $("#contenedor_principal").load('servicios_medicos.view.php',function(status,response,xhr){
        Swal.close();
        if(xhr.status===404)
        {
            $("#contenedor_principal").html("<h1 class='h-1'>Error 404, p&aacute;gina no encontrada</h1>");
        }
        else {
            Swal.close();
        }
    })
})

$("#btn_servicios_medicos_especiales").click(function(){
    Swal.fire({
        icon: 'question',
        title: 'Cargando...',
        text: 'Espere por favor',
        allowOutsideClick : false,
        allowEscapeKey : false,
        showConfirmButton : false
    });
    $("#contenedor_principal").load('servicios_medicos_especiales.view.php',function(status,response,xhr){
        Swal.close();
        if(xhr.status===404)
        {
            $("#contenedor_principal").html("<h1 class='h-1'>Error 404, p&aacute;gina no encontrada</h1>");
        }
        else {
            Swal.close();
        }
    })
})

$("#btn_cie10").click(function(){
    Swal.fire({
        icon: 'question',
        title: 'Cargando...',
        text: 'Espere por favor',
        allowOutsideClick : false,
        allowEscapeKey : false,
        showConfirmButton : false
    });
    $("#contenedor_principal").load('cie10.view.php',function(status,response,xhr){
        if(xhr.status===404)
        {
            $("#contenedor_principal").html("<h1 class='h-1'>Error 404, p&aacute;gina no encontrada</h1>");
        }
    })
})

$("#btn_establecimientos").click(function(){
    Swal.fire({
        icon: 'question',
        title: 'Cargando...',
        text: 'Espere por favor',
        allowOutsideClick : false,
        allowEscapeKey : false,
        showConfirmButton : false
    });
    $("#contenedor_principal").load('establecimientos.view.php',function(status,response,xhr){
        if(xhr.status===404)
        {
            $("#contenedor_principal").html("<h1 class='h-1'>Error 404, p&aacute;gina no encontrada</h1>");
        }
    })
})

$("#btn_empresas_afiliadas").click(function(){
    Swal.fire({
        icon: 'question',
        title: 'Cargando...',
        text: 'Espere por favor',
        allowOutsideClick : false,
        allowEscapeKey : false,
        showConfirmButton : false
    });
    $("#contenedor_principal").load('empresas_afiliadas.view.php',function(status,response,xhr){
        if(xhr.status===404)
        {
            $("#contenedor_principal").html("<h1 class='h-1'>Error 404, p&aacute;gina no encontrada</h1>");
        }
    })
})

$("#btn_beneficiarios_y_afiliados").click(function(){
    Swal.fire({
        icon: 'question',
        title: 'Cargando...',
        text: 'Espere por favor',
        allowOutsideClick : false,
        allowEscapeKey : false,
        showConfirmButton : false
    });
    $("#contenedor_principal").load('beneficiarios_y_afiliados.view.php',function(status,response,xhr){
        if(xhr.status===404)
        {
            $("#contenedor_principal").html("<h1 class='h-1'>Error 404, p&aacute;gina no encontrada</h1>");
        }
    })
})
