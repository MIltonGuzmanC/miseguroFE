<?php

    include_once '../cls/DarDeAlta.cls.php';
    $obj = new DarDeAlta();
    $obj->dar_de_alta($_POST['alta_id_de_usuario'],$_POST['alta_apellidos'],$_POST['alta_nombres'],$_POST['alta_email'],$_POST['alta_password']);