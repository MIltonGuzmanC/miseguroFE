$(function(){
    generar_lista_de_reembolsos('*');
    Swal.close();
});
$("#btn_nuevo_reembolso").click(function(){
    Swal.fire({
        icon: 'info',
        title: 'Cargando..',
        text: 'Cargando formulario...',
        allowOutsideClick : false,
        allowEscapeKey : false,
        showConfirmButton : false
    });
    $.ajax({
        method : 'GET',
        url : '/controllers/mostrar_formulario_de_nuevo_reembolso.ctrl.php',

    }).done(function(response){
        $("#div_formulario_nuevo_reembolso").html(response);
        Swal.close();
    })
});

function generar_lista_de_cie10()
{
    var codigo_de_grupo_de_cie = $("#codigo_de_grupo_de_cie").val();


        $("#div_lista_de_cie10").html('<span>Generando lista de CIE 10....</span>')
        $.ajax({
            method: 'POST',
            url :'/controllers/generar_lista_de_cies_para_formulario_de_reembolso.ctrl.php',
            data : {'codigo_de_grupo_de_cie':codigo_de_grupo_de_cie}
        }).done(function(response){
            $("#div_lista_de_cie10").html(response);
        })

}

function generar_nuevo_reembolso()
{
    var numero_de_documento = $("#numero_de_documento").val();
    var id_de_usuario = $("#id_de_usuario").val();
    var enfermedad_preexistente = $("#enfermedad_preexistente").val();
    var tipo_de_reembolso = $("#tipo_de_reembolso").val();
    var codigo_de_grupo_de_cie = $("#codigo_de_grupo_de_cie").val();
    var cie10 = $("#cie10").val();
    if((numero_de_documento.length>0)&&(id_de_usuario.length>0)&&(tipo_de_reembolso!=='0')&&(codigo_de_grupo_de_cie!=='0')&&(cie10.length>0))
    {
        Swal.fire({
            icon: 'success',
            title: 'Generando...',
            text: 'Consultando informacion, espere un momento...',
            allowOutsideClick : false,
            allowEscapeKey : false,
            showConfirmButton : false
        });
        $.ajax({
            method : 'POST',
            url : '/controllers/generar_nuevo_reembolso.ctrl.php',
            data : {
                'numero_de_documento' : numero_de_documento,
                'id_de_usuario' : id_de_usuario,
                'enfermedad_preexistente' : enfermedad_preexistente,
                'tipo_de_reembolso' : tipo_de_reembolso,
                'codigo_de_grupo_de_cie' : codigo_de_grupo_de_cie,
                'cie10' : cie10
            }
        }).done(function(response){
            eval(response);
            Swal.close();

        })
    }
    else{
        Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Todos los campos son necesarios',
            allowOutsideClick : false,
            allowEscapeKey : false,
            showConfirmButton : true
        });
    }
}
function generar_formulario_de_detalles_de_reembolso(numero_de_documento)
{

    $.ajax({
        method : 'POST',
        data : {'numero_de_documento':numero_de_documento},
        url : '/controllers/generar_formulario_de_detalles_de_reembolso.ctrl.php'
    }).done(function(response){
        $("#div_formulario_nuevo_reembolso").html(response);
        generar_lista_de_detalles_de_reembolso(numero_de_documento);
    })
}

function generar_lista_de_reembolsos(filtro)
{
    $.ajax({
        method : 'POST',
        url : '/controllers/generar_lista_de_reembolsos.ctrl.php',
        data : {'filtro' : filtro}
    }).done(function(response){
        $("#div_formulario_nuevo_reembolso").html(response);
    })
}

$("#txt_filtro").keyup(function(){
    var filtro = $("#txt_filtro").val();
    generar_lista_de_reembolsos(filtro);
})

function f1_generar_campo_de_descuento()
{
    var id_de_establecimiento  = $("#indice_de_establecimiento").val();
    var id_servicio_medico = $("#indice_de_servicio_medico").val();
    if((id_de_establecimiento!=='0')&&(id_servicio_medico!=='0'))
    {
        $.ajax({
            method : 'POST',
            url : '/controllers/formulario1_generar_campo_de_descuento.ctrl.php',
            data : {'id_de_establecimiento' : id_de_establecimiento, 'id_de_servicio_medico' : id_servicio_medico}
        }).done(function(response){
                $("#seccion_de_valores").html(response);
        })
    }
}

function form1_guardar_nuevo_detalle_de_reembolso(){
    var numero_de_documento = $("#numero_de_documento").val();
    var indice_de_reembolso = $("#indice_de_reembolso").val();
    var numero_de_factura = $("#numero_de_factura").val();
    var fecha_de_factura = $("#fecha_de_factura").val();
    var indice_de_establecimiento = $("#indice_de_establecimiento").val();
    var indice_de_servicio_medico = $("#indice_de_servicio_medico").val();
    var valor_de_calculo = $("#valor_de_calculo").val();
    var subtotal = $("#subtotal").val();
    var valor_no_cubierto = $("#valor_no_cubierto").val();
    var tipo_de_operacion = $("#tipo_de_operacion").val();

    if((numero_de_documento.length>0)&&(numero_de_factura.length>0)&&(fecha_de_factura.length>0)&&(indice_de_establecimiento.length>0)&&(indice_de_servicio_medico.length>0)&&(valor_de_calculo.length>0)&&(subtotal>0)&&(valor_no_cubierto.length>0))
    {
        $("form").html("<div class=\"alert alert-collapse bgc-white text-dark-tp3 border-1 brc-secondary-l2 shadow-sm radius-0 py-3 d-flex align-items-start\">\n" +
            "                  <div class=\"position-tl w-102 m-n1px border-t-4 brc-primary\"></div>\n" +
            "                  <div class=\"bgc-primary px-4 py-25 radius-1px mr-4 shadow-sm\">\n" +
            "                    <i class=\"fa fa-exclamation text-180 text-white\"></i>\n" +
            "                  </div>\n" +
            "\n" +
            "                  <div class=\"text-dark-tp3\">\n" +
            "                    <h3 class=\"text-blue-d1 text-130\">Guardando</h3>\n" +
            "                    Agregando factura a reembolso...\n" +
            "                  </div>\n" +
            "\n" +
            "                </div>");
        $.ajax({

            method : 'POST',
            url : '/controllers/formulario1_agregar_nuevo_detalle_de_reembolso.ctrl.php',
            data : {
                'numero_de_documento' : numero_de_documento,
                'indice_de_reembolso' : indice_de_reembolso,
                'numero_de_factura' : numero_de_factura,
                'fecha_de_factura' : fecha_de_factura,
                'indice_de_establecimiento' : indice_de_establecimiento,
                'indice_de_servicio_medico' : indice_de_servicio_medico,
                'valor_de_calculo' : valor_de_calculo,
                'subtotal' : subtotal,
                'valor_no_cubierto' : valor_no_cubierto,
                'tipo_de_operacion' : tipo_de_operacion
            }

        }).done(function(response){
            eval(response);
            generar_formulario_de_detalles_de_reembolso(numero_de_documento);
        })
    }
    else
    {
        alert("Todos los campos son necesarios");
    }
}

function generar_lista_de_detalles_de_reembolso(numero_de_documento)
{
    $.ajax({
        method : 'POST',
        url : '/controllers/generar_lista_de_detalles_de_reembolso.ctrl.php',
        data : {'numero_de_documento':numero_de_documento}
    }).done(function(response){
        $("#div_detalles_de_reembolso").html(response);
    })
}