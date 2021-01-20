<?php
include_once 'Conexion.cls.php';
include_once 'Historial.cls.php';
include_once 'Mailer.cls.php';
class Beneficiarios{
    private $filtro,$data,$beneficiario,$tabla,$organizacion,$formulario_de_edicion;
    function generar_lista_de_beneficiarios($filtro)
    {
        $this->filtro = $filtro;
        if($this->filtro=='*')
        {
            $this->data = Conexion::conect()->select('informacion_de_usuario','*',["ORDER"=>'apellidos']);
        }
        else
        {
            $this->data = Conexion::conect()->select('informacion_de_usuario','*',['numero_de_id_de_usuario[~]'=>$this->filtro]);
        }

        $this->tabla .="<table class=\"table text-dark-m1 brc-black-tp10 mb-1\">
                      <thead>
                        <tr class=\"bgc-white text-secondary-d3 text-95\">
                          <th class=\"py-3 pl-35\">
                                N&uacute;mero de ID
                          </th>
                          <th>
                                Apellidos
                          </th>
                          <th>
                                Nombres
                          </th>
                          <th>
                                Organizaci&oacute;n
                          </th>  
                          <th>
                                Cargo / Ocupaci&oacute;n
                          </th>
                          <th>
                                Tel&eacute;fono de contacto
                          </th>
                          <th>
                                Correo electr&oacute;nico
                          </th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      ";
        foreach ($this->data as $this->beneficiario){
                $this->organizacion = Conexion::conect()->get('datos_de_organizacion','*',['indice_de_organizacion'=>$this->beneficiario['indice_de_organizacion_fk']]);
                $this->tabla.="<tr class=\"bgc-h-orange-l4 text-90\">
                          <td class=\"text-dark-m3\">
                                ".utf8_decode($this->beneficiario['numero_de_id_de_usuario'])."
                          </td>
                          <td class=\"pl-35\">
                            <span class=\"d-inline-block w-4 h-4 bgc-purple text-white  text-center pt-2 radius-round mr-2\">
                                ".utf8_decode(substr($this->beneficiario['apellidos'],0,1))."
							</span>
                            <a href=\"#\" class=\"text-secondary-d2 text-95 text-600\">
                                ".utf8_decode($this->beneficiario['apellidos'])."
                            </a>
                          </td>
                          <td class=\"text-dark-m3\">
                                ".utf8_decode($this->beneficiario['nombres'])."
                          </td>
                          <td class=\"text-dark-l1 text-95\">
                                ".utf8_decode($this->organizacion['nombre_de_organizacion'])."
                          </td>
                          <td class=\"text-dark-l1 text-95\">
                                ".utf8_decode($this->beneficiario['cargo_ocupacion'])."
                          </td>
                          <td class=\"text-dark-l1 text-95\">
                                ".$this->beneficiario['telefono_de_contacto']."
                          </td>
                          <td class=\"text-dark-l1 text-95\">
                                ".$this->beneficiario['email']."
                          </td>

                          <td class=\"text-right pr-35\">
                            <a data-fancybox data-type=\"ajax\" href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-success btn-a-lighter-success\" data-src=\"controllers/mostrar_formulario_de_edicion_de_beneficiario.ctrl.php?numero_de_id_de_usuario=".$this->beneficiario['numero_de_id_de_usuario']."\" href=\"javascript:;\">
        <i class=\"fa fa-pencil-alt\"></i>
                                </a>
                            <button type=\"button\" class=\"btn btn-sm btn-outline-default shadow-sm radius-2px px-1 py-1\">
                                <i class='fa fa-edit'></i>
                            </button>
                          </td>
                        </tr>";
        }
        $this->tabla.="</tbody>
                    </table>";
        echo $this->tabla;
    }
    function generar_formulario_de_edicion($id_de_usuario)
    {
        $this->beneficiario = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$id_de_usuario]);
        $this->formulario_de_edicion.="
            <div class=\"container container-plus\">
                <div class=\"card acard card_main\">
                  <div class=\"card-header\">
                    <h3 class=\"card-title text-100 text-primary-d2\">
                      <i class=\"far fa-edit text-dark-l3 mr-1\"></i> Editar Información de ".$this->beneficiario['apellidos']." ".$this->beneficiario['nombres']."
                    </h3>
                  </div>
                  <div class=\"card-body\" id=\'main_div\'>
                    <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_numero_de_id_de_usuario\" class=\"mb-0 text-info\">
                        C&eacute;dula / Pasaporte
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm \" id=\"act_numero_de_id_de_usuario\" value=\"".utf8_decode($this->beneficiario['numero_de_id_de_usuario'])."\" readonly>
                    </div>
                  </div>
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_nombres\" class=\"mb-0 text-info\">
                        Nombres
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm \" id=\"act_nombres\" value=\"".utf8_decode($this->beneficiario['nombres'])."\">
                    </div>
                  </div>
                  
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_apellidos\" class=\"mb-0 text-info\">
                        Apellidos
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control form-control-sm \" id=\"act_apellidos\" value=\"".utf8_decode($this->beneficiario['apellidos'])."\">
                    </div>
                  </div>
                  
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_fecha_de_nacimiento\" class=\"mb-0 text-info\">
                        Fecha de nacimiento (dd-mm-aaaa)
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"date\" class=\"form-control  form-control-sm \" id=\"act_fecha_de_nacimiento\" value=\"".utf8_decode($this->beneficiario['fecha_de_nacimiento'])."\">
                    </div>
                  </div>
                  
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_fecha_de_alta\" class=\"mb-0 text-info\">
                        Fecha de alta o ingreso (dd-mm-aaaa)
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"date\" class=\"form-control  form-control-sm \" id=\"act_fecha_de_alta\" value=\"".utf8_decode($this->beneficiario['fecha_de_alta'])."\">
                    </div>
                  </div>
                  
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_cargo_ocupacion\" class=\"mb-0 text-info\">
                        Cargo / Ocupaci&oacute;n
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control  form-control-sm \" id=\"act_cargo_ocupacion\" value=\"".utf8_decode($this->beneficiario['cargo_ocupacion'])."\">
                    </div>
                  </div>
                  
                  
                  
                  
                  </div>
                  <div class=\'card-footer\'>
                    <button class=\"btn btn-success mb-1\" onclick='actualizar_beneficiario(".$id_de_usuario.")'>
                        <i class=\"fa fa-check mr-1\"></i>
                        Actualizar
                      </button>
                  </div>
                </div>
            </div>";
        echo $this->formulario_de_edicion;
    }
}




                      


                        
