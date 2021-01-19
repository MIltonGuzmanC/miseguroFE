$(function(){
    Swal.close();
    generar_lista_de_provincias();
    generar_lista_de_organizaciones('*')
})
function generar_lista_de_provincias()
{
    $.ajax({
        method : 'GET',
        url : '/controllers/generar_lista_de_provincias.ctrl.php'
    }).done(function(response){
        $("#div_lista_de_provincias").html(response);
    });
}

function generar_lista_de_organizaciones(filtro){

    $.ajax({
        method : 'POST',
        url :'/controllers/generar_lista_de_organizaciones.ctrl.php',
        data : {'filtro':filtro}
    }).done(function(response){
        $("#div_lista_de_organizaciones").html(response);
    });
}

$("#txt_buscador").keypress(function(){

    var filtro = $("#txt_buscador").val();
    if((filtro==='')||(filtro.length===0))
    {
        filtro = '*';
    }
    generar_lista_de_organizaciones(filtro);
});

$("#btn_guardar_organizacion").click(function(e){
    e.preventDefault();
    var id_de_organizacion = $("#id_de_organizacion").val();
    var nombre_de_organizacion = $("#nombre_de_organizacion").val();
    var provincia = $("#provincia").val();
    var ciudad = $("#ciudad").val();
    var direccion = $("#direccion").val();
    var telefono = $("#telefono1").val();

    if((id_de_organizacion.length>4)&&(nombre_de_organizacion.length>0)&&(provincia!==0)&&(ciudad.length>0)&&(direccion.length>0)&&(telefono.length>0)){
        Swal.fire({
            icon: 'success',
            title: 'Guardando Establecimiento',
            text: 'Espere un momento por favor...',
            allowOutsideClick : false,
            allowEscapeKey : false,
            showConfirmButton : false
        });
        $.ajax({
            method : 'POST',
            url : '/controllers/guardar_nueva_organizacion.ctrl.php',
            data : {
                'id_de_organizacion' : id_de_organizacion,
                'nombre_de_organizacion' : nombre_de_organizacion,
                'provincia' : provincia,
                'ciudad' : ciudad,
                'direccion' : direccion,
                'telefono' : telefono
            }
        }).done(function(response){
            Swal.close();
            generar_lista_de_organizaciones('*');
            eval(response);
        })
    }
    else
    {
        Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Todos los campos con  son necesarios',
            allowOutsideClick : false,
            allowEscapeKey : false,
            showConfirmButton : true
        });
    }
})

function actualizar_organizacion(ind_de_establecimiento){
    var indice_de_establecimiento = ind_de_establecimiento;
    var id_de_establecimiento = $("#act_id_de_establecimiento").val();
    var nombre_de_establecimiento = $("#act_nombre_de_establecimiento").val();
    var ciudad = $("#act_ciudad").val();
    var direccion = $("#act_direccion").val();
    var fono1 = $("#act_fono1").val();
    var fono2 = $("#act_fono2").val();
    var correo_electronico = $("#act_correo_electronico").val();
    var porcentaje_de_cobertura = $("#act_porcentaje_de_cobertura").val();
    var convenio_vigente = $("#act_convenio_vigente").val();
    console.log(convenio_vigente.length);

    if((indice_de_establecimiento.toString().length>0)&&(id_de_establecimiento.length>0)&&(nombre_de_establecimiento.length>0)&&(ciudad.length>0)&&(direccion.length>0)&&(fono1.length>0)&&(fono2.length>0)&&(correo_electronico.length>0)&&(convenio_vigente.length>0))
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
            url : '/controllers/actualizar_establecimiento.ctrl.php',
            data : {
                'indice_de_establecimiento':indice_de_establecimiento,
                'id_de_establecimiento' : id_de_establecimiento,
                'nombre_de_establecimiento' : nombre_de_establecimiento,
                'ciudad' : ciudad,
                'direccion' : direccion,
                'fono1' : fono1,
                'fono2' : fono2,
                'correo_electronico' : correo_electronico,
                'porcentaje_de_cobertura' : porcentaje_de_cobertura,
                'convenio_vigente' : convenio_vigente
            }
        }).done(function(response){
            eval(response);
            generar_lista_de_establecimientos(nombre_de_establecimiento);
        })
    }

}