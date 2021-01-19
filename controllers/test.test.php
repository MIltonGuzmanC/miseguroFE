<?php
    include_once '../cls/Conexion.cls.php';
    $id_de_usuario = 1717003030;
if(Conexion::conect()->has('informacion_de_usuario',['numero_de_id_de_usuario'=>$id_de_usuario]))
{
    echo "va";
}