$(function(){
    $("#chk_terminos").change(function(){
        if($("#chk_terminos:checked").val()==='true')
        {
            $("#btn_dar_de_alta").prop("disabled",false);
        }
        else
        {
            $("#btn_dar_de_alta").prop("disabled",true);
        }
    })

})
$("#btn_dar_de_alta").click(function(e){
    e.preventDefault();
    id_de_usuario = $("#alta_id_de_usuario").val();
    apellidos_de_usuario = $("#alta_apellidos").val();
    nombres_de_usuario = $("#alta_nombres").val();
    email_de_usuario = $("#alta_email").val();
    clave_de_usuario = $("#alta_password").val();
    clave_de_usuario_com = $("#alta_password_confirm").val();
    var flag = 0;
    if(id_de_usuario.length<5)
    {
        $("#msg_alta_id").empty();
        $("#msg_alta_id").append("<div class=\"alert alert-collapse alert-success bg-white brc-success-m3 rounded border-2 d-inline-flex\" role=\"alert\">\n" +
            "                      <span class=\"mr-4 d-inline-block\">\n" +
            "              ID no v&aacute;lido, este campo no puede contener menos de 5 caracteres\n" +
            "            </span>\n" +
            "\n" +
            "                      <button type=\"button\" class=\"close align-self-center ml-auto text-danger text-150\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
            "                        <span aria-hidden=\"true\">×</span>\n" +
            "                      </button>\n" +
            "                    </div>")
        flag =0;
    }
    else {
        $("#msg_alta_id").empty();
        flag = 1;
    }

    if(apellidos_de_usuario.length===0)
    {
        $("#msg_alta_apellidos").empty();
        $("#msg_alta_apellidos").append("<div class=\"alert alert-collapse alert-success bg-white brc-success-m3 rounded border-2 d-inline-flex\" role=\"alert\">\n" +
            "                      <span class=\"mr-4 d-inline-block\">\n" +
            "              Campo Apellidos no puede estar vac&iacute;o\n" +
            "            </span>\n" +
            "\n" +
            "                      <button type=\"button\" class=\"close align-self-center ml-auto text-danger text-150\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
            "                        <span aria-hidden=\"true\">×</span>\n" +
            "                      </button>\n" +
            "                    </div>")
        flag =0;
    }
    else {
        $("#msg_alta_apellidos").empty();
        flag = 1;
    }
    if(nombres_de_usuario.length===0)
    {
        $("#msg_alta_nombres").empty();
        $("#msg_alta_nombres").append("<div class=\"alert alert-collapse alert-success bg-white brc-success-m3 rounded border-2 d-inline-flex\" role=\"alert\">\n" +
            "                      <span class=\"mr-4 d-inline-block\">\n" +
            "              Campo Nombres no puede estar vac&iacute;o\n" +
            "            </span>\n" +
            "\n" +
            "                      <button type=\"button\" class=\"close align-self-center ml-auto text-danger text-150\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
            "                        <span aria-hidden=\"true\">×</span>\n" +
            "                      </button>\n" +
            "                    </div>")
        flag =0;
    }
    else {
        $("#msg_alta_nombres").empty();
        flag = 1;
    }
    if(email_de_usuario.length===0)
    {
        $("#msg_alta_email").empty();
        $("#msg_alta_email").append("<div class=\"alert alert-collapse alert-success bg-white brc-success-m3 rounded border-2 d-inline-flex\" role=\"alert\">\n" +
            "                      <span class=\"mr-4 d-inline-block\">\n" +
            "              Campo email no puede estar vac&iacute;o\n" +
            "            </span>\n" +
            "\n" +
            "                      <button type=\"button\" class=\"close align-self-center ml-auto text-danger text-150\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
            "                        <span aria-hidden=\"true\">×</span>\n" +
            "                      </button>\n" +
            "                    </div>")
        flag =0;
    }
    else {
        $("#msg_alta_email").empty();
        flag = 1;
    }
    if(clave_de_usuario.length<8)
    {
        $("#msg_alta_clave").empty();
        $("#msg_alta_clave").append("<div class=\"alert alert-collapse alert-success bg-white brc-success-m3 rounded border-2 d-inline-flex\" role=\"alert\">\n" +
            "                      <span class=\"mr-4 d-inline-block\">\n" +
            "              Campo clave no puede estar vac&iacute;o o conetener menos de 8 caracteres\n" +
            "            </span>\n" +
            "\n" +
            "                      <button type=\"button\" class=\"close align-self-center ml-auto text-danger text-150\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
            "                        <span aria-hidden=\"true\">×</span>\n" +
            "                      </button>\n" +
            "                    </div>")
        flag =0;
    }
    else {
        $("#msg_alta_clave").empty();
        flag = 1;
    }
    if(clave_de_usuario!==clave_de_usuario_com)
    {
        $("#msg_alta_clave_com").empty();
        $("#msg_alta_clave_com").append("<div class=\"alert alert-collapse alert-success bg-white brc-success-m3 rounded border-2 d-inline-flex\" role=\"alert\">\n" +
            "                      <span class=\"mr-4 d-inline-block\">\n" +
            "              Los campos de clave no coinciden\n" +
            "            </span>\n" +
            "\n" +
            "                      <button type=\"button\" class=\"close align-self-center ml-auto text-danger text-150\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
            "                        <span aria-hidden=\"true\">×</span>\n" +
            "                      </button>\n" +
            "                    </div>")
        flag =0;
    }
    else {
        $("#msg_alta_clave_com").empty();
        flag = 1;
    }
    if(flag===1)
    {
        Swal.fire({
            icon: 'success',
            title: 'Formulario completado',
            text: 'Consultando en la base de datos, espere por favor...',
            allowOutsideClick : false,
            allowEscapeKey : false,
            showConfirmButton : false
        });
        $.ajax({
            type : 'POST',
            url : '/controllers/dar_de_alta_a_usuario.ctrl.php',
            data : $("#frm_dar_de_alta").serialize()
        }).done(function(response){
            Swal.close();
            eval(response);
            $("#frm_dar_de_alta")[0].reset();
        })
    }
})
