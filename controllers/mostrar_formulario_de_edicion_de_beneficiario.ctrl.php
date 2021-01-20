<?php
    include_once '../cls/Beneficiarios.cls.php';
    $obj = new Beneficiarios();
    $obj->generar_formulario_de_edicion($_GET['numero_de_id_de_usuario']);