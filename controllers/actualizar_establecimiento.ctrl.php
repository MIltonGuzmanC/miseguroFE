<?php
session_start();
    if(!isset($_SESSION['usuario']['id_de_usuario']))
    {
        die("intento ilegal de acceder al sistema");
    }
    else{
        include_once '../cls/Establecimiento.cls.php';
        $obj = new Establecimiento();
        $obj->actualizar_establecimiento($_SESSION['usuario']['id_de_usuario'],$_POST['indice_de_establecimiento'],$_POST['id_de_establecimiento'],$_POST['nombre_de_establecimiento'],$_POST['ciudad'],$_POST['direccion'],$_POST['fono1'],$_POST['fono2'],$_POST['correo_electronico'],$_POST['porcentaje_de_cobertura'],$_POST['convenio_vigente']);

    }
