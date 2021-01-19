$(function(){
    Swal.close();
    generar_lista_de_provincias();
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