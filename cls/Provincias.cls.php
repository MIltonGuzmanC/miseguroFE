<?php
include_once 'Conexion.cls.php';

class Provincias
{
    static function generar_lista_de_provincias(){
        $lista = '';
        $data = Conexion::conect()->select('lista_de_provincias','*',["ORDER"=>'nombre_de_provincia']);
        $lista.="<select class=\"px-5 mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down\" id=\"provincia\">
                               <option value=\"0\">SELECCIONA UNA PROVINCIA</option>";

        foreach ($data as $provincia)
        {
            $lista.="<option value='".$provincia['nombre_de_provincia']."'>".$provincia['nombre_de_provincia']."</option>";
        }
        $lista.="</select>";
        echo $lista;
    }
}