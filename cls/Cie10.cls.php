<?php

include_once 'Conexion.cls.php';
include_once 'Historial.cls.php';

class Cie10
{
    private $id_de_usuario,$codigo_de_cie,$nombre_de_cie,$codigo_de_grupo;
    private $cie,$formulario_edicion,$id_de_cie,$descripcion_de_cie;
    public function agregar_nuevo_cie($id_de_usuario,$codigo_de_cie,$nombre_de_cie,$codigo_de_grupo)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->codigo_de_cie = $codigo_de_cie;
        $this->nombre_de_cie = utf8_encode(strtoupper($nombre_de_cie));
        $this->codigo_de_grupo = $codigo_de_grupo;

        if(Conexion::conect()->has('cie',['codigo_de_cie'=>$this->codigo_de_cie]))
        {
            echo "Swal.fire({
                icon: 'error',
                title: 'Codigo CIE ya existente',
                text: 'Este codigo ya existe en la base de datos',
                allowOutsideClick : false,
                allowEscapeKey : false,
                showConfirmButton : true
            });";
        }
        else{
            if(Conexion::conect()->insert('cie',['codigo_de_cie'=>$this->codigo_de_cie,'nombre_de_cie'=>$this->nombre_de_cie,'codigo_de_grupo_de_cie_fk'=>$this->codigo_de_grupo])){
                Historial::nueva_actividad($this->id_de_usuario,'CIE 10','CREACION DE NUEVA CIE10 : '.$this->codigo_de_cie);
                echo "Swal.fire({
                    icon: 'success',
                    title: 'Codigo CIE agregado',
                    text: 'CIE10 agregado correctamente',
                    allowOutsideClick : false,
                    allowEscapeKey : false,
                    showConfirmButton : true
                });";
            }
        }
    }

    public function eliminar_cie($id_de_usuario,$codigo_de_cie)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->codigo_de_cie = $codigo_de_cie;
        if(Conexion::conect()->delete('cie',['codigo_de_cie'=>$this->codigo_de_cie]))
        {
            Historial::nueva_actividad($this->id_de_usuario,'CIE 10','USUARIO HA ELIMINADO EL CIE '.$this->codigo_de_cie);
            echo "Swal.fire({
                    icon: 'success',
                    title: 'Codigo CIE eliminado',
                    text: 'CIE10 eliminado correctamente',
                    allowOutsideClick : false,
                    allowEscapeKey : false,
                    showConfirmButton : true
                });";
        }
    }

    public function generar_formulario_de_edicion_de_cie($codigo_de_cie)
    {
        $this->codigo_de_cie = $codigo_de_cie;
        $this->cie = Conexion::conect()->get('cie','*',['codigo_de_cie'=>$this->codigo_de_cie]);
        $this->formulario_edicion.="
            <div class=\"container container-plus\">
                <div class=\"card acard card_main\">
                  <div class=\"card-header\">
                    <h3 class=\"card-title text-100 text-primary-d2\">
                      <i class=\"far fa-edit text-dark-l3 mr-1\"></i>
                      ".$this->codigo_de_cie."
                    </h3>
                  </div>
                  <div class=\"card-body\" id=\'main_div\'>
                    <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_descripcion_de_cie\" class=\"mb-0 text-info\">
                        Descripci&oacute;n
                      </label>
                    </div>

                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm text-uppercase\" id=\"act_descripcion_de_cie\" value=\"".utf8_decode($this->cie['nombre_de_cie'])."\">
                    </div>
                  </div>
                  
                  </div>
                  <div class=\'card-footer\'>
                    <button class=\"btn btn-success mb-1\" onclick='actualizar_cie(\"".$this->codigo_de_cie."\")'>
                        <i class=\"fa fa-check mr-1\"></i>
                        Actualizar
                      </button>
                  </div>
                </div>
            </div>";
        echo $this->formulario_edicion;
    }
    //ACTUALIZAR CIE
    public function actualizar_cie($id_de_usuario,$id_de_cie,$descripcion_cie)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->id_de_cie = $id_de_cie;
        $this->descripcion_de_cie = utf8_encode(strtoupper($descripcion_cie));
        if(Conexion::conect()->update('cie',['nombre_de_cie'=>$this->descripcion_de_cie],['codigo_de_cie'=>$this->id_de_cie]))
        {
            Historial::nueva_actividad($this->id_de_usuario,'CIE10','CIE ACTUALIZADO : '.$this->id_de_cie." cambio : ".$this->descripcion_de_cie);
            echo "$(\".card_main\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Registro actualizado</h3>CIE 10 actualizado correctamente.</div>\")";
        }
    }
}

