<?php
    session_start();
    include_once '../cls/Cie10.cls.php';
    $cie = new Cie10();
    $cie->actualizar_cie($_SESSION['usuario']['id_de_usuario'],$_POST['codigo_cie'],$_POST['descripcion_cie']);
