<?php
session_start();
if(!isset($_SESSION['usuario']['id_de_usuario']))
{
    die("intento ilegal de acceder al sistema");
}
else{
    include_once '../cls/Cie10.cls.php';
    $cie = new Cie10();
    $cie->eliminar_cie($_SESSION['usuario']['id_de_usuario'],$_POST['codigo__de_cie']);
}
