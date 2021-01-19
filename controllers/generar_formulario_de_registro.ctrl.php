<?php
    include_once '../cls/DarDeAlta.cls.php';
    $obj = new DarDeAlta();
    $form = $obj->generar_formulario_de_inscripcion($_POST['id_de_usuario']);
    echo $form;
