<?php
session_start();
if(!isset($_SESSION['usuario']['id_de_usuario']))
{
    die("intento ilegal de acceder al sistema");
}
else{
    include_once '../cls/DatosDeOrganizacion.cls.php';
    $obj = new DatosDeOrganizacion();
    $obj->actualizar_organizacion($_SESSION['usuario']['id_de_usuario'],$_POST['indice_de_organizacion'],$_POST['id_de_organizacion'],$_POST['nombre_de_organizacion'],$_POST['ciudad'],$_POST['direccion'],$_POST['fono']);

}
