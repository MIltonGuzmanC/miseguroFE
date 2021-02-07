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
        Reembolso::generar_input_de_descuento($_POST['id_de_establecimiento'],$_POST['id_de_servicio_medico']);
    }
}