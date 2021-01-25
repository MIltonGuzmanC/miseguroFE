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
        include_once '../cls/ServiciosMedicos.cls.php';
        $ben = new ServiciosMedicos();
        $ben->agregar_nuevo_servicio_medico($_SESSION['usuario']['id_de_usuario'],$_POST['servicio'],$_POST['valor1'],$_POST['valor2'],$_POST['tipo']);
    }
}