$(function (){

    var id_de_usuario = $.urlParam('id_de_usuario');
    Swal.fire({
        icon: 'success',
        title: 'Cargando...',
        text: 'Por favor, espere un momento.',
        allowOutsideClick : false,
        allowEscapeKey : false,
        showConfirmButton : false
    });
    $.ajax({
        method : 'POST',
        url : './controllers/generar_formulario_de_registro.ctrl.php',
        data : {'id_de_usuario': id_de_usuario}
    }).done(function(response){
        $("#contenedor_principal").html(response);
        Swal.close();
    });
});

function enviar_formulario(){

    var fecha_de_nacimiento = $("#fecha_de_nacimiento").val();
    var indice_de_organizacion = $("#indice_de_organizacion").val();
    var telefono_de_contacto = $("#telefono_de_contacto").val();
    var cargo_ocupacional = $("#cargo_ocupacional").val();
    var provincia = $("#provincia").val();
    var ciudad = $("#ciudad").val();
    var direccion = $("#direccion").val();
    var id_de_usuario = $("#id_de_usuario").val();

    if((fecha_de_nacimiento.length<5)||(indice_de_organizacion.length<0)||(cargo_ocupacional.length<5)||(provincia.length<5)||(ciudad.length<5)||(direccion.length<5)||(telefono_de_contacto.length<5))
    {
        Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Por favor, llene todos los datos del formulario',
            allowOutsideClick : false,
            allowEscapeKey : false,
            showConfirmButton : true
        });
    }
    else
    {
        Swal.fire({
            icon: 'success',
            title: 'Cargando...',
            text: 'Por favor, espere un momento.',
            allowOutsideClick : false,
            allowEscapeKey : false,
            showConfirmButton : false
        });
        $.ajax({
            method : 'POST',
            url : './controllers/completar_registro_de_usuario.ctrl.php',
            data : {
                'numero_de_id_de_usuario':id_de_usuario,
                'fecha_de_nacimiento' : fecha_de_nacimiento,
                'indice_de_organizacion': indice_de_organizacion,
                'cargo_ocupacion' : cargo_ocupacional,
                'telefono_de_contacto':telefono_de_contacto,
                'provincia' : provincia,
                'ciudad' : ciudad,
                'direccion' : direccion
            }
        }).done(function(response){
            Swal.close();
            eval(response);
        })
    }
}