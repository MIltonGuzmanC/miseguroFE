<?php
session_start();
    if (!isset($_SESSION['usuario']['id_de_usuario'])) {
        die("intento ilegal de acceder al sistema");
    } else {
        include_once '../cls/DatosDeOrganizacion.cls.php';
        $ibj = new DatosDeOrganizacion();
        $ibj->guardar_nueva_organizacion($_SESSION['usuario']['id_de_usuario'],$_POST['id_de_organizacion'],$_POST['nombre_de_organizacion'],$_POST['provincia'],$_POST['ciudad'],$_POST['direccion'],$_POST['telefono']);
    }
