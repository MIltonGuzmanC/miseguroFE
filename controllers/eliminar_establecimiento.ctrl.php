<?php
session_start();
if(!isset($_SESSION['usuario']['id_de_usuario']))
{
    die("intento ilegal de acceder al sistema");
}
else{
    include_once '../cls/Establecimiento.cls.php';
    $est = new Establecimiento();
    $est->eliminar_establecimiento($_SESSION['usuario']['id_de_usuario'],$_POST['indice_de_establecimiento']);


}
