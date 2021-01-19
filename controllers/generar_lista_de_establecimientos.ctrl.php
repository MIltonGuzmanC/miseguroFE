<?php
    include_once '../cls/Establecimiento.cls.php';
    $obj = new Establecimiento();
    $obj->generar_tabla_de_establecimientos($_POST['filtro']);