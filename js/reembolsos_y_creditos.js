$(function(){
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
            Swal.close();
            eval(response);
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
