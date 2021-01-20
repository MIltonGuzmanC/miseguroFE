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
        include_once '../cls/Beneficiarios.cls.php';
        $ben = new Beneficiarios();
        $ben->generar_lista_de_beneficiarios($_POST['filtro']);
    }
}