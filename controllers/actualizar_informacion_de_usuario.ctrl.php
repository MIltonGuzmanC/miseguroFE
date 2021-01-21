<?php
session_start();
if(!isset($_SESSION['usuario']['id_de_usuario']))
{
    die("intento ilegal de acceder al sistema");
}
else{
    if($_SESSION['usuario']['indice_de_perfil_de_usuario']!='1')
    {
        die("intento ilegal de acceder al sistema, no tiene permisos suficientes");
    }
    else{
        include_once '../cls/Beneficiarios.cls.php';
        $ben = new Beneficiarios();
        $ben->actualizar_datos_de_beneficiario($_SESSION['usuario']['id_de_usuario'],$_POST['numero_de_id_de_usuario'],$_POST['nombres'],$_POST['apellidos'],$_POST['fecha_de_nacimiento'],$_POST['fecha_de_alta'],$_POST['cargo_ocupacion'],$_POST['telefono_de_contacto'],$_POST['email'],$_POST['direccion'],$_POST['es_titular_de_cuenta'],$_POST['rol_familiar'],$_POST['tiene_acceso_al_sistema']);
    }
}