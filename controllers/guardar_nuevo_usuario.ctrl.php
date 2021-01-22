<?php
session_start();
if (!isset($_SESSION['usuario']['id_de_usuario'])) {
    die("intento ilegal de acceder al sistema");
} else {
    if ($_SESSION['usuario']['indice_de_perfil_de_usuario'] != '1') {
        die("intento ilegal de acceder al sistema, no tiene permisos suficientes");
    } else {
        include_once '../cls/Beneficiarios.cls.php';
        $ben = new Beneficiarios();
        $ben->guardar_nuevo_usuario($_SESSION['usuario']['id_de_usuario'],$_POST['numero_de_id_de_usuario'],$_POST['nombres'],$_POST['apellidos'],$_POST['fecha_de_nacimiento'],$_POST['cargo_ocupacion'],$_POST['telefono_de_contacto'],$_POST['email'],$_POST['provincia'],$_POST['ciudad'],$_POST['direccion'],$_POST['id_de_dependiente'],$_POST['rol_familiar']);
    }
}