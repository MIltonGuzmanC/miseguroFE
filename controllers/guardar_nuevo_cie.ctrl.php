<?php
    session_start();
    include_once '../cls/Cie10.cls.php';
    $cie = new Cie10();
    $cie->agregar_nuevo_cie($_SESSION['usuario']['id_de_usuario'],$_POST['codigo_de_cie'],$_POST['nombre_de_cie'],$_POST['codigo_de_grupo']);
