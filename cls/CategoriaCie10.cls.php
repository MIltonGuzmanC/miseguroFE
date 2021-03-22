<?php
include_once 'Conexion.cls.php';
include_once 'Historial.cls.php';

class CategoriaCie10
{
    private $id_de_usuario,$codigo_de_categoria,$nombre_de_categoria;
    private $filtro,$data,$cie,$tabla_de_cies;
       //FUNCION QUE GENERA UNA LISTA DE CATEGORIAS
        static function generar_lista_de_categorias()
        {
            $lista_de_categorias="";
            $data = Conexion::conect()->select('grupo_de_cie','*',["ORDER"=>'codigo_de_grupo_de_cie']);
            /*$lista_de_categorias.="<div class=\"d-inline-flex align-items-center mb-1\">
                                            <i class=\"fa fa-book text-green text-100 ml-25 pos-abs\"></i>
                                            <select class=\"form-control px-5 \" id=\"codigo_de_grupo\" data-place-holder='seleccione categoria'>
                                                <option value=\"0\">Seleccione categor&iacute;a</option>";
                    foreach ($data as $categoria)
                    {
                        $lista_de_categorias.="<option value='".$categoria['codigo_de_grupo_de_cie']."'>".utf8_decode($categoria['nombre_del_grupo'])."</option>";
                    }
            $lista_de_categorias.="</select></div>";*/
            $lista_de_categorias.="<input id='codigo_de_grupo' list='id_de_grupo' class='d-inline-flex align-items-center form-control'>";
            $lista_de_categorias.="<datalist id='id_de_grupo'>";
                    foreach($data as $categoria)
                    {
                        $lista_de_categorias.="<option value='".$categoria['codigo_de_grupo_de_cie']."'>".utf8_decode($categoria['nombre_del_grupo'])."</option>";
                    }
            $lista_de_categorias.="</datalist>";        
            
            echo $lista_de_categorias;
        }
    //=========================================================================

    //FUNCION QUE AGREGA UNA NUEVA CATEGORIA
    function nueva_categoria($id_de_usuario,$codigo_de_categoria,$nombre_de_categoria)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->codigo_de_categoria = $codigo_de_categoria;
        $this->nombre_de_categoria = utf8_encode(strtoupper($nombre_de_categoria));
        if(Conexion::conect()->has('grupo_de_cie',['codigo_de_grupo_de_cie'=>$this->codigo_de_categoria]))
        {
            echo "Swal.fire({
                icon: 'error',
                title: 'Codigo ya existente',
                text: 'Este codigo ya existe en la base de datos',
                allowOutsideClick : false,
                allowEscapeKey : false,
                showConfirmButton : true
            });";
        }
        else
        {
            if(Conexion::conect()->insert('grupo_de_cie',['codigo_de_grupo_de_cie'=>$this->codigo_de_categoria,'nombre_del_grupo'=>$this->nombre_de_categoria])){
                Historial::nueva_actividad($this->id_de_usuario,'CODIGOS CIE10',"nueva categoria agregada por este Usuario :".$this->codigo_de_categoria);
                echo "Swal.fire({
                    icon: 'success',
                    title: 'Codigo agregado',
                    text: 'Nueva categoria agregada exitosamente',
                    allowOutsideClick : false,
                    allowEscapeKey : false,
                    showConfirmButton : true
                });";
            }
        }
    }
    //========================================================

    //FUNCION QUE GENERA UNA LISTA DE CATEGORIAS DE CIE PARA FILTRAR
    public function generar_tabla_de_cies($filtro)
    {
        $this->filtro = $filtro;
        if($filtro=='*')
        {
            $this->data = Conexion::conect()->select('cie','*',['ORDER'=>'codigo_de_grupo_de_cie_fk']);
        }
        else
        {
            $this->data = Conexion::conect()->select('cie','*',['codigo_de_grupo_de_cie_fk'=>$this->filtro]);
        }
        $this->tabla_de_cies.="<table class='mb-0 table table-borderless table-bordered-x brc-secondary-l3 text-dark-m2 radius-1 overflow-hidden'>";
        $this->tabla_de_cies.="<thead class=\"text-dark-tp3 bgc-grey-l4 text-90 border-b-1 brc-transparent\">
                          <tr>
                            <th class=\"d-none d-sm-table-cell\">
                              GRUPO CIE
                            </th>
                            <th class=\"d-none d-sm-table-cell\">
                              CODIGO
                            </th>
                            <th class=\"d-none d-sm-table-cell\">
                              DESCRIPCION
                            </th>
                            <th></th>
                          </tr>
                        </thead><tbody class='mt-1'>";
        foreach ($this->data as $this->cie)
        {
            $this->tabla_de_cies.="<tr class=\"bgc-h-yellow-l4 d-style\">
                            <td class=\"text-600 text-orange-d2\">
                                ".$this->cie['codigo_de_grupo_de_cie_fk']."
                            </td>
                            <td class=\"d-none d-sm-table-cell text-purple-d2\">
                                ".$this->cie['codigo_de_cie']."
                            </td>
                            <td class=\"d-none d-sm-table-cell text-grey text-95\">
                                ".utf8_decode($this->cie['nombre_de_cie'])."
                            </td>
                            <td>
                              <!-- action buttons -->
                              <div class=\"d-none d-lg-flex\">
                                <a data-fancybox data-type=\"ajax\" href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-success btn-a-lighter-success\" data-src=\"controllers/mostrar_formulario_de_edicion_de_cie.ctrl.php?codigo_de_cie=".$this->cie['codigo_de_cie']."\" href=\"javascript:;\">
        <i class=\"fa fa-pencil-alt\"></i>
                                </a>
                                <a href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-danger btn-a-lighter-danger\" onclick='eliminar_cie(\"".$this->cie['codigo_de_cie']."\")'>
                                  <i class=\"fa text-danger-l1 fa-trash-alt\"></i>
                                </a>
                              </div>
                            </td>
                          </tr>";
        }
        $this->tabla_de_cies.="</tbody></table>";
        echo $this->tabla_de_cies;

    }
    //================================================================

    static function generar_select_de_busqueda(){
        $lista = '';
        $data = Conexion::conect()->select('grupo_de_cie','*',["ORDER"=>'codigo_de_grupo_de_cie']);
        $lista.="<select class=\"px-5 mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down\" id=\"codigo_de_grupo_cie\" onchange='generar_tabla_de_cies()'>
                               <option value=\"-\">SELECCIONA UN GRUPO</option>
                               <option value=\"*\">MOSTRAR TODO</option>";
        foreach ($data as $categoria)
        {
            $lista.="<option value='".$categoria['codigo_de_grupo_de_cie']."'>CODIGO : ".$categoria['codigo_de_grupo_de_cie']." - ".utf8_decode($categoria['nombre_del_grupo'])."</option>";
        }
        $lista.="</select>";
        
        echo $lista;
    }

}