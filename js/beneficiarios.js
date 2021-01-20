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