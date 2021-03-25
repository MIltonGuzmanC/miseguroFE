$(function(){
    generar_lista_de_beneficiarios('*');
    Swal.close();
});

function generar_lista_de_beneficiarios(filtro)
{
 $.ajax({
     method : 'POST',
     data : {'filtro' : filtro},
     url : '/controllers/generar_lista_de_beneficiarios.ctrl.php'
 }).done(function(response){
     $("#div_lista_de_beneficiarios").html(response);
 })
}

$("#txt_buscar_beneficiario").keyup(function(){
    var valor = $("#txt_buscar_beneficiario").val();
    generar_lista_de_beneficiarios(valor);
});

function actualizar_beneficiario(id_de_beneficiario){
    var act_nombres = $("#act_nombres").val();
    var act_apellidos = $("#act_apellidos").val();
    var act_fecha_de_nacimiento = $("#act_fecha_de_nacimiento").val();
    var act_fecha_de_alta = $("#act_fecha_de_alta").val();
    var act_cargo_ocupacion = $("#act_cargo_ocupacion").val();
    var act_telefono_de_contacto = $("#act_telefono_de_contacto").val();
    var act_direccion = $("#act_direccion").val();
    var act_email = $("#act_email").val();
    var act_es_titular_de_cuenta = $("#act_es_titular_de_cuenta").val();
    var act_rol_familiar = $("#act_rol_familiar").val();
    var act_tiene_acceso_al_sistema = $("#act_tiene_acceso_al_sistema").val();
    if((act_nombres.length>3)&&(act_apellidos.length>3)&&(act_fecha_de_nacimiento.toString().length>3)&&(act_fecha_de_alta.toString().length>3)&&(act_cargo_ocupacion.length>3)&&(act_telefono_de_contacto.length>5)&&(act_direccion.length>5)&&(act_email.length>5)&&(act_es_titular_de_cuenta.length>0)&&(act_rol_familiar.length>3)&&(act_tiene_acceso_al_sistema.length>0))
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
            url : '/controllers/actualizar_informacion_de_usuario.ctrl.php',
            data : {
                'numero_de_id_de_usuario' : id_de_beneficiario,
                'nombres' : act_nombres,
                'apellidos' : act_apellidos,
                'fecha_de_nacimiento' : act_fecha_de_nacimiento,
                'fecha_de_alta' : act_fecha_de_alta,
                'cargo_ocupacion' : act_cargo_ocupacion,
                'telefono_de_contacto' : act_telefono_de_contacto,
                'email' : act_email,
                'direccion' : act_direccion,
                'es_titular_de_cuenta' : act_es_titular_de_cuenta,
                'rol_familiar' : act_rol_familiar,
                'tiene_acceso_al_sistema' : act_tiene_acceso_al_sistema,
            }
        }).done(function(response){
            eval(response);
            generar_lista_de_beneficiarios(id_de_beneficiario);
        })
    }
    else
    {
        alert("No debe existir campos sin valor en le formulario, no se puede actualizar el registro");
    }
}

function guardar_nuevo_beneficiario()
{
    var id_de_dependiente = $("#id_de_dependiente").val();
    var numero_de_id_de_usuario = $("#id_usuario").val();
    var nombres = $("#nombres").val();
    var apellidos = $("#apellidos").val();
    var cargo_ocupacion = $("#cargo_ocupacion").val();
    var rol_familiar = $("#rol_familiar").val();
    var fecha_de_nacimiento = $("#fecha_nacimiento").val();
    var fecha_de_alta = $("#fecha_de_alta").val();
    var provincia = $("#provincia").val();
    var ciudad = $("#ciudad").val();
    var telefono_de_contacto = $("#telefono").val();
    var email = $("#correo").val();
    var direccion = $("#direccion").val();

    if((id_de_dependiente.length>0)&&(numero_de_id_de_usuario.length>0)&&(nombres.length>0)&&(apellidos.length>0)&&(cargo_ocupacion.length>0)&&(rol_familiar.length>0)&&(fecha_de_nacimiento.toString().length>0)&&(provincia.length>0)&&(ciudad.length>0)&&(telefono_de_contacto.length>0)&&(direccion.length>0))
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
            url : '/controllers/guardar_nuevo_usuario.ctrl.php',
            data : {
                'numero_de_id_de_usuario' : numero_de_id_de_usuario,
                'nombres' : nombres,
                'apellidos' : apellidos,
                'fecha_de_nacimiento' : fecha_de_nacimiento,
                'fecha_de_alta' : fecha_de_alta,
                'cargo_ocupacion' : cargo_ocupacion,
                'telefono_de_contacto' : telefono_de_contacto,
                'email' : email,
                'provincia' : provincia,
                'ciudad' : ciudad,
                'direccion' : direccion,
                'id_de_dependiente' : id_de_dependiente,
                'rol_familiar' : rol_familiar
            }
        }).done(function(response){
            eval(response);
            generar_lista_de_beneficiarios(numero_de_id_de_usuario);
        })
    }
    else
    {
        alert("Todos los campos son necesarios");
    }
}

function cambiar_estado_de_activacion_de_usuario(id_de_usuario)
{
    Swal.fire({
        icon: 'question',
        title: 'Actualizando...',
        text: 'Cambiando estado, espere por favor',
        allowOutsideClick : false,
        allowEscapeKey : false,
        showConfirmButton : false
    });
    $.ajax({
        method : 'POST',
        data : {'id_de_usuario':id_de_usuario},
        url : '/controllers/cambiar_estado_de_usuario.ctrl.php'
    }).done(function(response){
        Swal.close();
        generar_lista_de_beneficiarios(id_de_usuario);
        eval(response);
    })
}