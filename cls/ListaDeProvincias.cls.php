<?php
include_once 'Conexion.cls.php';
class ListaDeProvincias
{
    private $data,$lista_de_provincias,$provincia;
    public function generar_lista_de_provincias()
    {
        $this->data = Conexion::conect()->select('lista_de_provincias','*',["ORDER"=>'nombre_de_provincia']);
        $this->lista_de_provincias.="<select class=\"form-control form-control-sm\" id=\"provincia\">";
            foreach ($this->data as $this->provincia)
            {
                $this->lista_de_provincias.="<option>".$this->provincia['nombre_de_provincia']."</option>";
            }
        $this->lista_de_provincias.="</select>";
        return $this->lista_de_provincias;
    }
}