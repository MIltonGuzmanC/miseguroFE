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
        $ben->generar_lista_de_servicios_medicos_especiales($_POST['filtro']);
    }
}