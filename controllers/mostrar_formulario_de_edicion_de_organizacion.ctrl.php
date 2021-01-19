<?php
session_start();
if(!isset($_SESSION['usuario']['id_de_usuario']))
{
    die("intento ilegal de acceder al sistema");
}
else {
    include_once '../cls/DatosDeOrganizacion.cls.php';
    $est = new DatosDeOrganizacion();
    $est->generar_formulario_de_edicion($_SESSION['usuario']['id_de_usuario'],$_GET['indice_de_organizacion']);
}