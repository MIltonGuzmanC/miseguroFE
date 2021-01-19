<?php
include_once 'Conexion.cls.php';

class DatosDeOrganizacion
{
    private $data_de_organizaciones,$option,$organizacion;
    //GENERADOR DE UN OPTION CON TODAS LAS ORGANIZACIONES
    function generar_option_de_organizaciones(){
        $this->data_de_organizaciones=Conexion::conect()->select('datos_de_organizacion','*',["ORDER"=>'nombre_de_organizacion']);
        $this->option.="<select class=\"form-control form-control-sm\" id=\"indice_de_organizacion\">";
            foreach ($this->data_de_organizaciones as $this->organizacion)
            {
                $this->option.="<option value=\"".$this->organizacion['indice_de_organizacion']."\">".$this->organizacion['nombre_de_organizacion']."</option>";
            }
        $this->option.="</select>";
        return $this->option;
    }
}



