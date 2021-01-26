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
        include_once '../cls/ServiciosMedicosEspeciales.cls.php';
        $ben = new ServiciosMedicosEspeciales();
        $ben->actualizar_servicio_medico_especial($_SESSION['usuario']['id_de_usuario'],$_POST['indice_de_servicio'],$_POST['servicio'],$_POST['valor']);
    }
}