<?php

include_once 'Conexion.cls.php';
include_once 'Historial.cls.php';

class Establecimiento
{
    private $id_de_usuario,$id_de_establecimiento,$nombre_de_establecimiento,$provincia,$ciudad,$direccion,$telefono1,$telefono2,$email,$porcentaje,$convenio;
    private $filtro,$data,$tabla,$info,$formulario_edicion,$indice_de_establecimiento;
    private $correo_electronico,$porcentaje_de_cobertura,$convenio_vigente;
    function guardar_nuevo_establecimiento($id_de_usuario,$id_de_establecimiento,$nombre_de_establecimiento,$provincia,$ciudad,$direccion,$telefono1,$telefono2,$email,$porcentaje,$convenio)
    {
        $this->id_de_establecimiento = $id_de_establecimiento;

        if(Conexion::conect()->has('establecimiento_con_convenio',['id_de_establecimiento'=>$this->id_de_establecimiento]))
        {
            echo "Swal.fire({
                icon: 'error',
                title: 'Establecimiento ya registrado',
                text: 'Este establecimiento ya existe en la base de datos',
                allowOutsideClick : false,
                allowEscapeKey : false,
                showConfirmButton : true
            });";
        }
        else
        {
            $this->id_de_usuario = $id_de_usuario;
            $this->nombre_de_establecimiento = utf8_encode($nombre_de_establecimiento);
            $this->provincia = utf8_encode(ucfirst($provincia));
            $this->ciudad = utf8_encode(ucfirst($ciudad));
            $this->direccion = utf8_encode($direccion);
            $this->nombre_de_establecimiento = utf8_encode($nombre_de_establecimiento);
            $this->telefono1 = $telefono1;
            $this->telefono2 = $telefono2;
            $this->email = $email;
            $this->porcentaje = $porcentaje;
            $this->convenio = $convenio;
            

            if(Conexion::conect()->insert('establecimiento_con_convenio',[
                'id_de_establecimiento'=>$this->id_de_establecimiento,
                'nombre_de_establecimiento'=>$this->nombre_de_establecimiento,
                'provincia' =>$this->provincia,
                'ciudad' =>$this->ciudad,
                'direccion' =>$this->direccion,
                'telefono1' =>$this->telefono1,
                'telefono2' =>$this->telefono2,
                'correo_electronico' =>$this->email,
                'porcentaje_de_cobertura' =>$this->porcentaje,
                'convenio_vigente' =>$this->convenio
            ])){
                Historial::nueva_actividad($this->id_de_usuario,'CLINICAS / ESTABLECIMIENTOS','NUEVO ESTABLECIMIENTO AGREGADO : '.$this->id_de_establecimiento);
                echo "Swal.fire({
                icon: 'success',
                title: 'Registro agregado',
                text: 'Nuevo establecimiento agregado',
                allowOutsideClick : false,
                allowEscapeKey : false,
                showConfirmButton : true
            });
            $(\"#form_establecimiento\")[0].reset();";
            }
        }
    }

    function generar_tabla_de_establecimientos($filtro)
    {
        $this->filtro = $filtro;
        if($filtro=='*')
        {
            $this->data = Conexion::conect()->select('establecimiento_con_convenio','*',['ORDER'=>'nombre_de_establecimiento']);
        }
        else
        {
            $this->data = Conexion::conect()->select('establecimiento_con_convenio','*',['nombre_de_establecimiento[~]'=>$this->filtro]);
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
                              TELEFONO PRINCIPAL
                            </th>
                            <th class=\"d-none d-sm-table-cell\">
                              CELULAR / PBX
                            </th>
                            <th class=\"d-none d-sm-table-cell\">
                              CORREO ELECTRONICO
                            </th>
                            <th class=\"d-none d-sm-table-cell\">
                              CIUDAD
                            </th>
                            <th></th>
                          </tr>
                        </thead><tbody class='mt-1'>";
        foreach ($this->data as $this->info)
        {
            $this->tabla.="<tr class=\"bgc-h-yellow-l4 d-style\">
                            <td class=\"text-600 text-orange-d2\">
                                ".$this->info['id_de_establecimiento']."
                            </td>
                            <td class=\"d-none d-lg-table-cell text-purple-d2\">
                                ".utf8_decode($this->info['nombre_de_establecimiento'])."
                            </td>
                            <td class=\"d-none d-sm-table-cell text-grey text-95\">
                                ".$this->info['telefono1']."
                            </td>
                            <td class=\"d-none d-sm-table-cell text-grey text-95\">
                                ".$this->info['telefono2']."
                            </td>
                            <td class=\"d-none d-sm-table-cell text-grey text-95\">
                                ".$this->info['correo_electronico']."
                            </td>
                            <td class=\"d-none d-sm-table-cell text-grey text-95\">
                                ".utf8_decode($this->info['ciudad'])."
                            </td>
                            <td>
                              <!-- action buttons -->
                              <div class=\"d-none d-lg-flex\">
                                <a data-fancybox data-type=\"ajax\" href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-success btn-a-lighter-success\" data-src=\"controllers/mostrar_formulario_de_edicion_de_establecimiento.ctrl.php?indice_de_establecimiento=".$this->info['indice_de_establecimiento']."\" href=\"javascript:;\">
        <i class=\"fa fa-pencil-alt\"></i>
                                </a>
                                <a href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-danger btn-a-lighter-danger\" onclick='eliminar_establecimiento(".$this->info['indice_de_establecimiento'].")'>
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
    function generar_formulario_de_edicion($id_de_usuario,$indice_de_establecimiento)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->indice_de_establecimiento = $indice_de_establecimiento;
        $this->info = Conexion::conect()->get('establecimiento_con_convenio','*',['indice_de_establecimiento'=>$this->indice_de_establecimiento]);
        $this->formulario_edicion.="
            <div class=\"container container-plus\">
                <div class=\"card acard card_main\">
                  <div class=\"card-header\">
                    <h3 class=\"card-title text-100 text-primary-d2\">
                      <i class=\"far fa-edit text-dark-l3 mr-1\"></i> Editar Cl&iacute;nica / Establecimiento : 
                      ".$this->indice_de_establecimiento."
                    </h3>
                  </div>
                  <div class=\"card-body\" id=\'main_div\'>
                    <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_id_de_establecimiento\" class=\"mb-0 text-info\">
                        RUC / ID 
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm \" id=\"act_id_de_establecimiento\" value=\"".utf8_decode($this->info['id_de_establecimiento'])."\">
                    </div>
                  </div>
                    <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_nombre_de_establecimiento\" class=\"mb-0 text-info\">
                        Nombre 
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm \" id=\"act_nombre_de_establecimiento\" value=\"".utf8_decode($this->info['nombre_de_establecimiento'])."\">
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
                      <label for=\"act_fono1\" class=\"mb-0 text-info\">
                        Tel&eacute;fono principal 
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm \" id=\"act_fono1\" value=\"".utf8_decode($this->info['telefono1'])."\">
                    </div>
                  </div>
                  
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_fono2\" class=\"mb-0 text-info\">
                        Tel&eacute;fono celular / PBX 
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm \" id=\"act_fono2\" value=\"".utf8_decode($this->info['telefono2'])."\">
                    </div>
                  </div>
                  
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_correo_electronico\" class=\"mb-0 text-info\">
                        Correo electr&oacute;nico
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm \" id=\"act_correo_electronico\" value=\"".utf8_decode($this->info['correo_electronico'])."\">
                    </div>
                  </div>
                  
                    <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_porcentaje_de_cobertura\" class=\"mb-0 text-info\">
                        Porcentaje de cobertura
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"number\" class=\"form-control form-control-sm \" id=\"act_porcentaje_de_cobertura\" value=\"".utf8_decode($this->info['porcentaje_de_cobertura'])."\">
                    </div>
                  </div>
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_convenio_vigente\" class=\"mb-0 text-info\">
                        ¿Tiene convenio?
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <select id=\"act_convenio_vigente\" class=\"form-control\">
                            <option value='".$this->info['convenio_vigente']."'>Conservar estado</option>
                            <option value='1'>Cambiar a SI</option>
                            <option value='0'>Cambiar a NO</option>
                      </select>
                    </div>
                  </div>
                     
                  </div>
                  <div class=\'card-footer\'>
                    <button class=\"btn btn-success mb-1\" onclick='actualizar_establecimiento(".$this->indice_de_establecimiento.")'>
                        <i class=\"fa fa-check mr-1\"></i>
                        Actualizar
                      </button>
                  </div>
                </div>
            </div>";
        echo $this->formulario_edicion;
    }

    function actualizar_establecimiento($id_de_usuario,$indice_de_establecimiento,$id_de_establecimiento,$nombre_de_establecimiento,$ciudad,$direccion,$telefono1,$telefono2,$correo_electronico,$porcentaje_de_cobertura,$convenio_vigente)
    {
        $this->indice_de_establecimiento = $indice_de_establecimiento;
        $this->id_de_establecimiento = $id_de_establecimiento;

        if(Conexion::conect()->count('establecimiento_con_convenio',['id_de_establecimiento'=>$this->id_de_establecimiento])>1)
        {
            echo "$(\".card_main\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>No se actualiz&oacute; el establecimiento </h3>Ya existe un establecimiento con el mismo RUC.</div>\")";
        }
        else
        {
            $this->id_de_usuario = $id_de_usuario;
            $this->nombre_de_establecimiento = utf8_encode($nombre_de_establecimiento);
            $this->ciudad = utf8_encode($ciudad);
            $this->direccion = utf8_encode($direccion);
            $this->telefono1 = $telefono1;
            $this->telefono2 = $telefono2;
            $this->correo_electronico = $correo_electronico;
            $this->porcentaje_de_cobertura = $porcentaje_de_cobertura;
            $this->convenio_vigente = $convenio_vigente;
            if(Conexion::conect()->update('establecimiento_con_convenio',[
                'id_de_establecimiento' => $this->id_de_establecimiento,
                'nombre_de_establecimiento' => utf8_encode($this->nombre_de_establecimiento),
                'ciudad' => utf8_encode($this->ciudad),
                'direccion' => utf8_encode($this->direccion),
                'telefono1' => $this->telefono1,
                'telefono2' => $this->telefono2,
                'correo_electronico' => $this->correo_electronico,
                'porcentaje_de_cobertura' => $this->porcentaje_de_cobertura,
                'convenio_vigente' => $this->convenio_vigente
            ],['indice_de_establecimiento'=>$this->indice_de_establecimiento])){
                    Historial::nueva_actividad($this->id_de_usuario,'CLINICAS / ESTABLECIMIENTOS',$this->id_de_establecimiento.' ESTABLECIMIENTO ACTUALIZADO POR ESTE USUARIO');
                echo "$(\".card_main\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Registro actualizado</h3>Establecimiento actualizado correctamente.</div>\")";
            }
        }
    }
    function eliminar_establecimiento($id_de_usuario,$indice_de_establecimiento){
        $this->indice_de_establecimiento = $indice_de_establecimiento;
        $this->id_de_usuario = $id_de_usuario;
        if(Conexion::conect()->count('encabezadp_de_reclamo',['indice_de_establecimiento_fk'=>$this->indice_de_establecimiento]))
        {
            echo "Swal.fire({
                    icon: 'error',
                    title: 'No se puede eliminar el registro',
                    text: 'existen reclamos ligados a este Establecimiento.',
                    allowOutsideClick : false,
                    allowEscapeKey : false,
                    showConfirmButton : true
                });";
        }
        else
        {
            if(Conexion::conect()->delete('establecimiento_con_convenio',['indice_de_establecimiento'=>$this->indice_de_establecimiento]))
            {
                Historial::nueva_actividad($this->id_de_usuario,'ESTABLECIMIENTO','ESTABLECIMIENTO ELIMINADO POR ESTE USUARIO = '.$this->indice_de_establecimiento);
                echo "Swal.fire({
                    icon: 'success',
                    title: 'Registro eliminado',
                    text: 'Establecimiento eliminado correctamente',
                    allowOutsideClick : false,
                    allowEscapeKey : false,
                    showConfirmButton : true
                });";
            }
        }
    }
}