<?php
date_default_timezone_set('America/Lima');
include_once 'Conexion.cls.php';

class Historial
{
    static function nueva_actividad($id_de_usuario,$seccion,$accion)
    {
        Conexion::conect()->insert('historial_de_uso_del_sistema',[
            'fecha_de_historial'=>date('Y-m-d'),
            'hora_de_historial'=>date('H:i:s'),
            'id_de_usuario_fk'=>$id_de_usuario,
            'seccion'=>strtoupper($seccion),
            'accion'=>utf8_encode(strtoupper($accion))
        ]);
    }
}
