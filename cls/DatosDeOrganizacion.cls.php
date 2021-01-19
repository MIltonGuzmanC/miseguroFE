<?php
include_once 'Conexion.cls.php';
include_once 'Historial.cls.php';
class DatosDeOrganizacion
{
    private $data_de_organizaciones,$option,$organizacion,$id_de_usuario,$id_de_organizacion,$nombre_de_organizacion,$provincia,$ciudad,$direccion,$telefono,$tabla,$info,$indice_de_organizacion,$formulario_edicion;
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

    function guardar_nueva_organizacion($id_de_usuario,$id_de_organizacion,$nombre_de_organizacion,$provincia,$ciudad,$direccion,$telefono)
    {
        $this->id_de_organizacion = $id_de_organizacion;

        if(Conexion::conect()->has('datos_de_organizacion',['id_de_organizacion'=>$this->id_de_organizacion]))
        {
            echo "Swal.fire({
                icon: 'error',
                title: 'Empresa Afilidada ya registrada',
                text: 'Este registro ya existe en la base de datos',
                allowOutsideClick : false,
                allowEscapeKey : false,
                showConfirmButton : true
            });";
        }
        else
        {
            $this->id_de_usuario = $id_de_usuario;
            $this->nombre_de_organizacion = utf8_encode($nombre_de_organizacion);
            $this->provincia = utf8_encode(ucfirst($provincia));
            $this->ciudad = utf8_encode(ucfirst($ciudad));
            $this->direccion = utf8_encode($direccion);
            $this->telefono = $telefono;

            if(Conexion::conect()->insert('datos_de_organizacion',[
                'id_de_organizacion'=>$this->id_de_organizacion,
                'nombre_de_organizacion'=>$this->nombre_de_organizacion,
                'provincia' =>$this->provincia,
                'ciudad' =>$this->ciudad,
                'direccion' =>$this->direccion,
                'telefono' =>$this->telefono
            ])){
                Historial::nueva_actividad($this->id_de_usuario,'EMPRESA AFILIADA','NUEVA EMPRESA AFILIADA AGREGADA : '.$this->id_de_organizacion);
                echo "Swal.fire({
                icon: 'success',
                title: 'Registro agregado',
                text: 'Nueva Empresa agregada',
                allowOutsideClick : false,
                allowEscapeKey : false,
                showConfirmButton : true
            });
            $(\"#form_empresa_afiliada\")[0].reset();";
            }
        }
    }

    function generar_tabla_de_organizaciones($filtro)
    {
        $this->filtro = $filtro;
        if($filtro=='*')
        {
            $this->data = Conexion::conect()->select('datos_de_organizacion','*',['ORDER'=>'nombre_de_organizacion']);
        }
        else
        {
            $this->data = Conexion::conect()->select('datos_de_organizacion','*',['nombre_de_organizacion[~]'=>$this->filtro]);
        }
        $this->tabla.="<table class='mb-0 table table-borderless table-bordered-x brc-secondary-l3 text-dark-m2 radius-1 overflow-hidden'>";
        $this->tabla.="<thead class=\"text-dark-tp3 bgc-grey-l4 text-90 border-b-1 brc-transparent\">
                          <tr>
                            <th class=\"d-none d-sm-table-cell\">
                              RUC
                            </th>
                            <th class=\"d-none d-lg-table-cell\">
                              NOMBRE
                            </th>
                            <th class=\"d-none d-sm-table-cell\">
                              CIUDAD
                            </th>
                             <th class=\"d-none d-sm-table-cell\">
                              DIRECCI&Oacute;N
                            </th>
                            
                            <th class=\"d-none d-sm-table-cell\">
                              TELEFONO
                            </th>
                          
                            <th></th>
                          </tr>
                        </thead><tbody class='mt-1'>";
        foreach ($this->data as $this->info)
        {
            $this->tabla.="<tr class=\"bgc-h-yellow-l4 d-style\">
                            <td class=\"text-600 text-orange-d2\">
                                ".$this->info['id_de_organizacion']."
                            </td>
                            <td class=\"d-none d-lg-table-cell text-purple-d2\">
                                ".utf8_decode($this->info['nombre_de_organizacion'])."
                            </td>
                            <td class=\"d-none d-sm-table-cell text-grey text-95\">
                                ".$this->info['ciudad']."
                            </td>
                            <td class=\"d-none d-sm-table-cell text-grey text-95\">
                                ".utf8_decode($this->info['direccion'])."
                            </td>
                            <td class=\"d-none d-sm-table-cell text-grey text-95\">
                                ".$this->info['telefono']."
                            </td>
                           
                            <td>
                              <!-- action buttons -->
                              <div class=\"d-none d-lg-flex\">
                                <a data-fancybox data-type=\"ajax\" href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-success btn-a-lighter-success\" data-src=\"controllers/mostrar_formulario_de_edicion_de_organizacion.ctrl.php?indice_de_organizacion=".$this->info['indice_de_organizacion']."\" href=\"javascript:;\">
        <i class=\"fa fa-pencil-alt\"></i>
                                </a>
                                <a href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-danger btn-a-lighter-danger\" onclick='eliminar_organizacion(".$this->info['indice_de_organizacion'].")'>
                                  <i class=\"fa text-danger-l1 fa-trash-alt\"></i>
                                </a>
                              </div>
                            </td>
                          </tr>";
        }
        $this->tabla.="</tbody></table>";
        echo $this->tabla;
    }
    //======================================================================================================

    //GENERAR FOMRULARIO DE EDICION
    function generar_formulario_de_edicion($id_de_usuario,$indice_de_organizacion)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->indice_de_organizacion = $indice_de_organizacion;
        $this->info = Conexion::conect()->get('datos_de_organizacion','*',['indice_de_organizacion'=>$this->indice_de_organizacion]);
        $this->formulario_edicion.="
            <div class=\"container container-plus\">
                <div class=\"card acard card_main\">
                  <div class=\"card-header\">
                    <h3 class=\"card-title text-100 text-primary-d2\">
                      <i class=\"far fa-edit text-dark-l3 mr-1\"></i> Editar Empresa Afiliada : 
                      ".$this->indice_de_organizacion."
                    </h3>
                  </div>
                  <div class=\"card-body\" id=\'main_div\'>
                    <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_id_de_organizacion\" class=\"mb-0 text-info\">
                        RUC / ID 
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm \" id=\"act_id_de_organizacion\" value=\"".utf8_decode($this->info['id_de_organizacion'])."\">
                    </div>
                  </div>
                    <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_nombre_de_organizacion\" class=\"mb-0 text-info\">
                        Nombre 
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm \" id=\"act_nombre_de_organizacion\" value=\"".utf8_decode($this->info['nombre_de_organizacion'])."\">
                    </div>
                  </div>
                  
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_ciudad\" class=\"mb-0 text-info\">
                        Ciudad 
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm \" id=\"act_ciudad\" value=\"".utf8_decode($this->info['ciudad'])."\">
                    </div>
                  </div>
                  
                   <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_direccion\" class=\"mb-0 text-info\">
                        Direcci&oacute;n 
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm \" id=\"act_direccion\" value=\"".utf8_decode($this->info['direccion'])."\">
                    </div>
                  </div>
                  
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_fono\" class=\"mb-0 text-info\">
                        Tel&eacute;fono 
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm \" id=\"act_fono\" value=\"".utf8_decode($this->info['telefono'])."\">
                    </div>
                  </div>

                     
                  </div>
                  <div class=\'card-footer\'>
                    <button class=\"btn btn-success mb-1\" onclick='actualizar_organizacion(".$this->indice_de_organizacion.")'>
                        <i class=\"fa fa-check mr-1\"></i>
                        Actualizar
                      </button>
                  </div>
                </div>
            </div>";
        echo $this->formulario_edicion;
    }
    function actualizar_organizacion($id_de_usuario,$indice_de_organizacion,$id_de_organizacion,$nombre_de_organizacion,$ciudad,$direccion,$telefono)
    {
        $this->indice_de_organizacion = $indice_de_organizacion;
        $this->id_de_organizacion = $id_de_organizacion;

        if(Conexion::conect()->count('datos_de_organizacion',['id_de_organizacion'=>$this->id_de_organizacion])>1)
        {
            echo "$(\".card_main\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>No se actualiz&oacute; el establecimiento </h3>Ya existe una Empresa Afiliada con el mismo RUC.</div>\")";
        }
        else
        {
            $this->id_de_usuario = $id_de_usuario;
            $this->nombre_de_organizacion = utf8_encode($nombre_de_organizacion);
            $this->ciudad = utf8_encode($ciudad);
            $this->direccion = utf8_encode($direccion);
            $this->telefono = $telefono;
            if(Conexion::conect()->update('datos_de_organizacion',[
                'id_de_organizacion' => $this->id_de_organizacion,
                'nombre_de_organizacion' => $this->nombre_de_organizacion,
                'ciudad' => $this->ciudad,
                'direccion' => $this->direccion,
                'telefono' => $this->telefono
            ],['indice_de_organizacion'=>$this->indice_de_organizacion])){
                Historial::nueva_actividad($this->id_de_usuario,'EMPRESAS AFILIADAS',$this->indice_de_organizacion.' EMPRESA ACTUALIZADA POR ESTE USUARIO');
                echo "$(\".card_main\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Registro actualizado</h3>Empresa afiliada actualizada correctamente.</div>\")";
            }
        }
    }
}



