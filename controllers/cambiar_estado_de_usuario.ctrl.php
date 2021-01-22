<?php
session_start();
if(!isset($_SESSION['usuario']['id_de_usuario']))
{
    die("intento ilegal de acceder al sistema");
}
else{
    include_once '../cls/Beneficiarios.cls.php';
    $ben = new Beneficiarios();
    $ben->cambiar_estado_de_usuario($_SESSION['usuario']['id_de_usuario'],$_POST['id_de_usuario']);
}
