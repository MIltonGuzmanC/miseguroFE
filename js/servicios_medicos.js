$(function(){
    
    generar_lista_de_servicios_medicos('*');
})
function generar_lista_de_servicios_medicos(filtro)
{
    $.ajax({
        method :'POST',
        url : '/controllers/generar_lista_de_servicios.ctrl.php',
        data : {'filtro':filtro}
    }).done(function(response){
        $("#main_servicios_medicos").html(response);
    })
}

function guardar_nuevo_servicio_medico()
{
    var servicio = $("#servico_medico").val();
    var valor1 = $("#valor_dentro_de_cobertura").val();
    var valor2 = $("#valor_fuera_de_cobertura").val();
    var tipo = $("#tipo_de_valor").val();
    if((servicio.length>4)&&(valor1>=0)&&(valor2>=0)&&(tipo!=='0'))
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
            url : '/controllers/agregar_nuevo_servicio_medico.ctrl.php',
            data : {
                'servicio':servicio,
                'valor1':valor1,
                'valor2':valor2,
                'tipo':tipo
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

function actualizar_servicio_medico()
{
    var indice_de_servicio = $("#indice_de_servicio_medico").val();
    var servicio = $("#servico_medico").val();
    var valor1 = $("#valor_dentro_de_cobertura").val();
    var valor2 = $("#valor_fuera_de_cobertura").val();
    var tipo = $("#tipo_de_valor").val();
    if((servicio.length>4)&&(valor1>=0)&&(valor2>=0)&&(tipo!=='0'))
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
            url : '/controllers/actualizar_servicio_medico.ctrl.php',
            data : {
                'indice_de_servicio':indice_de_servicio,
                'servicio':servicio,
                'valor1':valor1,
                'valor2':valor2,
                'tipo':tipo
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