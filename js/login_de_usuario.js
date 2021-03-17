$("#btn_login").click(function(e){
    e.preventDefault();
    var id_de_usuario = $("#login_id_de_usuario").val();
    var password = $("#login_password").val();
    if((password.length>0)&&(id_de_usuario.length>0))
    {
        Swal.fire({
            icon: 'success',
            title: 'Accediendo al sistema',
            text: 'Por favor, espere un momento.',
            allowOutsideClick : false,
            allowEscapeKey : false,
            showConfirmButton : false
        });
        $.ajax({
            method : 'POST',
            url : '/controllers/consultar_login_de_usuario.ctrl.php',
            data : {
                'id_de_usuario' : id_de_usuario,
                'password' : password
            }
        }).done(function(response){
            Swal.close();
            eval(response);
        })
    }
})

function cargar_main()
{
    $(function(){
        $("#contenedor_principal").load('reembolsos_y_creditos.view.php',function(status,response,xhr){
            if(xhr.status===404)
            {
                $("#contenedor_principal").html("<h1 class='h-1'>Error 404, p&aacute;gina no encontrada</h1>");
            }
        })
    })
}