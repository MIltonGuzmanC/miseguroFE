<?php
    include_once '../cls/DatosDeOrganizacion.cls.php';
    $obj = new DatosDeOrganizacion();
    $obj->generar_tabla_de_organizaciones($_POST['filtro']);