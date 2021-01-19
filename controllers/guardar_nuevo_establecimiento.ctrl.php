<?php
    session_start();
    if(!isset($_SESSION['usuario']['id_de_usuario']))
    {
        die("intento ilegal de acceder al sistema");
    }
    else
    {
        include_once '../cls/Establecimiento.cls.php';
        $obj = new Establecimiento();
        $obj->guardar_nuevo_establecimiento($_SESSION['usuario']['id_de_usuario'],$_POST['id_de_establecimiento'],$_POST['nombre_de_establecimiento'],$_POST['provincia'],$_POST['ciudad'],$_POST['direccion'],$_POST['telefono1'],$_POST['telefono2'],$_POST['email'],$_POST['porcentaje'],$_POST['convenio']);
    }
