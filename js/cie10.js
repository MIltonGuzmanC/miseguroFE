$(function ()
{
    Swal.close();
    cargar_select_de_categorias();
    generar_select_de_categorias_para_filtrar();

})

function guardar_categoria(){
    var codigo = $("#codigo_de_categoria").val();
    var nombre = $("#nombre_de_categoria").val();
    if((codigo.length>0)&&(nombre.length>0))
    {
        Swal.fire({
            icon: 'success',
            title: 'Guardando..',
            text: 'Aregando categoria a catalogo',
            allowOutsideClick : false,
            allowEscapeKey : false,
            showConfirmButton : false
        });
        $.ajax({
            method : 'POST',
            url : 'controllers/guardar_nueva_categoria.ctrl.php',
            data : {
                'codigo_de_categoria' : codigo,
                'nombre_de_categoria' : nombre
            }
        }).done(function(response){
            Swal.close();
            eval(response);
            $("#form_categoria")[0].reset();
            cargar_select_de_categorias();
            generar_select_de_categorias_para_filtrar();
        })
    }
}

function guardar_cie()
{
    var codigo_de_grupo = $("#codigo_de_grupo").val();
    var codigo_de_cie = $("#codigo_de_cie").val();
    var nombre_de_cie = $("#nombre_de_cie").val();

    if((codigo_de_grupo!=='0')&&(codigo_de_cie.length>0)&&(nombre_de_cie.length>0))
    {
        Swal.fire({
            icon: 'success',
            title: 'Guardando..',
            text: 'Aregando cie10 a catalogo',
            allowOutsideClick : false,
            allowEscapeKey : false,
            showConfirmButton : false
        });
        $.ajax({
            method : 'POST',
            url : 'controllers/guardar_nuevo_cie.ctrl.php',
            data : {
                'codigo_de_grupo' : codigo_de_grupo,
                'codigo_de_cie' : codigo_de_cie,
                'nombre_de_cie' : nombre_de_cie
            }
        }).done(function(response){
            Swal.close();
            eval(response);
            $("#form_cie")[0].reset();
            cargar_select_de_categorias();
            generar_tabla_de_cies();
        })
    }
}

function cargar_select_de_categorias()
{
    $.ajax({
        method : 'GET',
        url : 'controllers/generar_select_de_categorias.ctrl.php'
    }).done(function(response){
        $("#div_lista_de_categorias").html(response);
    })
}

function generar_select_de_categorias_para_filtrar()
{
    $.ajax({
        method : 'GET',
        url : 'controllers/generar_select_de_categorias_para_busqueda.ctrl.php'
    }).done(function(response){
        $("#div_select_grupo").html(response);
    })
}

function generar_tabla_de_cies()
{
    var codigo_de_grupo = $("#codigo_de_grupo_cie").val();
    $.ajax({
        method : 'POST',
        url : 'controllers/generar_tabla_de_cies.ctrl.php',
        data : {
            'codigo_de_grupo_de_cie':codigo_de_grupo
        }
    }).done(function(response){
        $("#div_lista_de_cies").html(response);
    })
}

function eliminar_cie(codigo_cie)
{
    var codigo_de_cie = codigo_cie;
    Swal.fire({
        title: '¿Estamos seguros?',
        text: "Una vez eliminado el CIE, no hay manera de recuperarlo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar CIE',
        cancelButtonText : 'No, no eliminar CIE'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'info',
                title: 'Gestionando',
                text: 'Eliminando CIE...',
                allowOutsideClick : false,
                allowEscapeKey : false,
                showConfirmButton : false
            });
            $.ajax({
                method : 'POST',
                url : 'controllers/eliminar_cie.ctrl.php',
                data :{'codigo__de_cie' : codigo_de_cie}
            }).done(function(response){
                eval(response);
                Swal.close();
                generar_tabla_de_cies();
            })
        }
    })
}

function actualizar_cie(cod_cie){
var codigo_cie = cod_cie;
var descripcion =$("#act_descripcion_de_cie").val();
    if(descripcion.length>0)
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
            method: 'POST',
            url : '/controllers/actualizar_cie.ctrl.php',
            data : {'codigo_cie':codigo_cie, 'descripcion_cie' : descripcion}
        }).done(function(response){
            generar_tabla_de_cies();
            eval(response);
        })
    }
}
