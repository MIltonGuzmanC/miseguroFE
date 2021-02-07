<?php
session_start();
if(!isset($_SESSION['usuario']['id_de_usuario']))
{
    die("intento ilegal de acceder al sistema");
}
else{
    if($_SESSION['usuario']['indice_de_perfil_de_usuario']!='1')
    {
        die("intento ilegal de acceder al sistema, no tiene permisos suficientes");
    }
    else{
        include_once '../cls/Reembolso.cls.php';
        Reembolso::formulario1_agregar_nuevo_detalle_de_reembolso($_SESSION['usuario']['id_de_usuario'],$_POST['numero_de_documento'],$_POST['indice_de_reembolso'],$_POST['numero_de_factura'],$_POST['fecha_de_factura'],$_POST['indice_de_establecimiento'],$_POST['indice_de_servicio_medico'],$_POST['valor_de_calculo'],$_POST['subtotal'],$_POST['valor_no_cubierto'],$_POST['tipo_de_operacion']);

    }
}