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
        $ben = new Reembolso();
        $ben->generar_nuevo_reembolso($_SESSION['usuario']['id_de_usuario'],$_POST['numero_de_documento'],$_POST['id_de_usuario'],$_POST['enfermedad_preexistente'],$_POST['tipo_de_reembolso'],$_POST['codigo_de_grupo_de_cie'],$_POST['cie10']);
    }
}