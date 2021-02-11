<?php
date_default_timezone_set('America/Lima');
include_once 'Conexion.cls.php';
class MovimientoDeUsuario
{
    static function nuevo_movimiento($id_de_usuario,$descripcion_de_movimiento,$id_de_documento,$debe,$haber){
        $datos_de_usuario = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$id_de_usuario]);
        if($datos_de_usuario['es_titular_de_cuenta'] ==1)
        {
            $datos_de_titular_de_cuenta = $datos_de_usuario;
        }
        else
        {
            $datos_de_titular_de_cuenta = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$datos_de_usuario['id_de_dependiente']]);
        }
        Conexion::conect()->insert('movimientos_de_usuario',[
            'fecha_de_movimiento'=>date('Y-m-d'),
            'periodo'=>date('Y'),
            'descripcion_de_movimiento'=>utf8_encode($descripcion_de_movimiento),
            'id_de_documento'=>$id_de_documento,
            'debe'=>$debe,
            'haber'=>$haber,
            'numero_de_id_de_usuario_fk'=>$datos_de_titular_de_cuenta['numero_de_id_de_usuario']
        ]);
    }

    static function retornar_saldo_de_usuario($id_de_usuario)
    {
        $total_debe  = 0;
        $total_haber = 0;
        $saldo_total = 0;
        $datos_de_usuario = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$id_de_usuario]);
        if($datos_de_usuario['es_titular_de_cuenta'] ==1)
        {
            $datos_de_titular_de_cuenta = $datos_de_usuario;
        }
        else
        {
            $datos_de_titular_de_cuenta = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$datos_de_usuario['id_de_dependiente']]);
        }
        $movimientos_de_usuario = Conexion::conect()->select('movimientos_de_usuario','*',['AND'=>['periodo'=>date('Y'),'numero_de_id_de_usuario_fk'=>$datos_de_titular_de_cuenta['numero_de_id_de_usuario']]]);

        foreach ($movimientos_de_usuario as $movimientos)
        {

            $total_debe = $total_debe+$movimientos['debe'];
            $total_haber = $total_haber+$movimientos['haber'];
        }
        $saldo_total = $total_debe - $total_haber;
        return $saldo_total;
    }
}

//$prueba = MovimientoDeUsuario::retornar_saldo_de_usuario(1717003030);
//echo $prueba;