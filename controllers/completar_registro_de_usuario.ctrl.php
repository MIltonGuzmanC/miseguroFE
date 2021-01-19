<?php
    include_once '../cls/DarDeAlta.cls.php';
    $obj = new DarDeAlta();
    $obj->completar_registro_de_usuario($_POST['numero_de_id_de_usuario'],$_POST['fecha_de_nacimiento'],$_POST['indice_de_organizacion'],$_POST['cargo_ocupacion'],$_POST['telefono_de_contacto'],$_POST['provincia'],$_POST['ciudad'],$_POST['direccion']);