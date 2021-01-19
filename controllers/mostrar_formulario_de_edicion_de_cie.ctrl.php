<?php
    include_once '../cls/Cie10.cls.php';
    $obj = new Cie10();
    $obj->generar_formulario_de_edicion_de_cie($_GET['codigo_de_cie']);

