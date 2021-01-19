<?php
session_start();
    if(!isset($_SESSION['usuario']['id_de_usuario']))
    {
        die("intento ilegal de acceder al sistema");
    }
    else {
        include_once '../cls/Establecimiento.cls.php';
        $est = new Establecimiento();
        $est->generar_formulario_de_edicion($_SESSION['usuario']['id_de_usuario'],$_GET['indice_de_establecimiento']);
    }