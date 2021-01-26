$(function(){
    generar_lista_de_servicios_medicos('*');
})
function generar_lista_de_servicios_medicos(filtro)
{
    $.ajax({
        method :'POST',
        url : '/controllers/generar_lista_de_servicios_medicos_especiales.ctrl.php',
        data : {'filtro':filtro}
    }).done(function(response){
        $("#main_servicios_medicos").html(response);
    })
}

function guardar_nuevo_servicio_medico_especial()
{
    var servicio = $("#servicio_medico").val();
    var valor_de_servicio = $("#valor_de_servicio").val();

    if((servicio.length>4)&&(valor_de_servicio>0))
    {
        $(".card_main").html("<div class=\"alert alert-collapse bgc-white text-dark-tp3 border-1 brc-secondary-l2 shadow-sm radius-0 py-3 d-flex align-items-start\">\n" +
            "                  <div class=\"position-tl w-102 m-n1px border-t-4 brc-primary\"></div>\n" +
            "                  <div class=\"bgc-primary px-4 py-25 radius-1px mr-4 shadow-sm\">\n" +
            "                    <i class=\"fa fa-exclamation text-180 text-white\"></i>\n" +
            "                  </div>\n" +
            "\n" +
            "                  <div class=\"text-dark-tp3\">\n" +
            "                    <h3 class=\"text-blue-d1 text-130\">Agregando registro</h3>\n" +
            "                    Un momento por favor....\n" +
            "                  </div>\n" +
            "\n" +
            "                </div>");
        $.ajax({
            method : 'POST',
            url : '/controllers/agregar_nuevo_servicio_medico_especial.ctrl.php',
            data : {
                'servicio':servicio,
                'valor':valor_de_servicio
            }
        }).done(function(response){
            eval(response);
            generar_lista_de_servicios_medicos('*');
        })
    }
    else
    {
        alert("Todos los campos son necesario");
    }
}
function actualizar_servicio_medico_especial()
{
    var indice_de_servicio = $("#indice_de_servicio_medico").val();
    var servicio = $("#servicio_medico").val();
    var valor= $("#valor_de_servicio").val();
    if((servicio.length>4)&&(valor>0))
    {
        $(".card_main").html("<div class=\"alert alert-collapse bgc-white text-dark-tp3 border-1 brc-secondary-l2 shadow-sm radius-0 py-3 d-flex align-items-start\">\n" +
            "                  <div class=\"position-tl w-102 m-n1px border-t-4 brc-primary\"></div>\n" +
            "                  <div class=\"bgc-primary px-4 py-25 radius-1px mr-4 shadow-sm\">\n" +
            "                    <i class=\"fa fa-exclamation text-180 text-white\"></i>\n" +
            "                  </div>\n" +
            "\n" +
            "                  <div class=\"text-dark-tp3\">\n" +
            "                    <h3 class=\"text-blue-d1 text-130\">Actualizando registro</h3>\n" +
            "                    Un momento por favor....\n" +
            "                  </div>\n" +
            "\n" +
            "                </div>");
        $.ajax({
            method : 'POST',
            url : '/controllers/actualizar_servicio_medico_especial.ctrl.php',
            data : {
                'indice_de_servicio':indice_de_servicio,
                'servicio':servicio,
                'valor':valor
            }
        }).done(function(response){
            eval(response);
            generar_lista_de_servicios_medicos(servicio);
        })
    }
    else
    {
        alert("Todos los campos son necesario");
    }
}

$("#filtro").keyup(function(){
    var filtro = $("#filtro").val();
    generar_lista_de_servicios_medicos(filtro);
})

