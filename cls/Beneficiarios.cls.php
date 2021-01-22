<?php
date_default_timezone_set('America/Lima');
include_once 'Conexion.cls.php';
include_once 'Historial.cls.php';
include_once 'Mailer.cls.php';
include_once '../config.ini.php';
class Beneficiarios{
    private $filtro,$data,$beneficiario,$tabla,$organizacion,$formulario_de_edicion,$provincia,$ciudad,$btn_beneficiario,$etq_benefactor;
    private $id_de_usuario,$numero_de_id_de_usuario,$nombres,$apellidos,$fecha_de_nacimiento,$fecha_de_alta,$cargo_ocupacion,$tipo_de_cuenta,$telefono_de_contacto,$email,$direccion,$es_titular_de_cuenta,$rol_familiar,$tiene_acceso_al_sistema,$correo,$id_de_dependiente,$formulario;
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
                         
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      ";
        foreach ($this->data as $this->beneficiario){
                $this->organizacion = Conexion::conect()->get('datos_de_organizacion','*',['indice_de_organizacion'=>$this->beneficiario['indice_de_organizacion_fk']]);
                if($this->beneficiario['es_titular_de_cuenta']==1)
                {
                    $this->btn_beneficiario="<a data-fancybox data-type=\"ajax\" href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-success btn-a-lighter-success\" data-src=\"controllers/mostrar_formulario_nuevo_beneficiario.ctrl.php?numero_de_id_de_usuario=".$this->beneficiario['numero_de_id_de_usuario']."\" href=\"javascript:;\">
        <i class=\"fa fa-user-friends text-primary-l1\"></i></a>";

                }
                else
                {
                    $this->btn_beneficiario="<i class=\"fa fa-user-alt text-success-d1\"></i>";
                }
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
                         

                          <td class=\"text-right pr-35\">
                            <a data-fancybox data-type=\"ajax\" href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-success btn-a-lighter-success\" data-src=\"controllers/mostrar_formulario_de_edicion_de_beneficiario.ctrl.php?numero_de_id_de_usuario=".$this->beneficiario['numero_de_id_de_usuario']."\" href=\"javascript:;\">
        <i class=\"fa fa-pencil-alt text-secondary-d1\"></i>
                                </a>
                                ".$this->btn_beneficiario."
                            <button type=\"button\" class=\"btn btn-sm btn-outline-default shadow-sm radius-2px px-1 py-1\">
                                <i class='fa fa-trash text-danger-l2'></i>
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
                  
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_telefono_de_contacto\" class=\"mb-0 text-info\">
                        Tel&eacute;fono principal
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control  form-control-sm \" id=\"act_telefono_de_contacto\" value=\"".$this->beneficiario['telefono_de_contacto']."\">
                    </div>
                  </div>
                  
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_direccion\" class=\"mb-0 text-info\">
                        Direcci&oacute;n
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control  form-control-sm \" id=\"act_direccion\" value=\"".utf8_decode($this->beneficiario['direccion'])."\">
                    </div>
                  </div>
                  
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_email\" class=\"mb-0 text-info\">
                        Correo electr&oacute;nico
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control  form-control-sm \" id=\"act_email\" value=\"".$this->beneficiario['email']."\">
                    </div>
                  </div>
                  
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_es_titular_de_cuenta\" class=\"mb-0 text-info\">
                        ¿Es titular de cuenta?
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <select  id='act_es_titular_de_cuenta' class='form-control form-control-sm'>
                        <option value='".$this->beneficiario['es_titular_de_cuenta']."'>Conservar estado</option>
                        <option value='1'>Es titular de cuenta</option>
                        <option value='0'>Es cuenta dependiente</option>
                      </select>
                    </div>
                  </div>
                  
                  <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_rol_familiar\" class=\"mb-0 text-info\">
                        Rol Familiar
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <input type=\"text\" class=\"form-control  form-control-sm \" id=\"act_rol_familiar\" value=\"".utf8_decode($this->beneficiario['rol_familiar'])."\">
                    </div>
                  </div>
                  
                   <div class=\"form-group row\">
                    <div class=\"col-sm-3 col-form-label text-sm-right pr-0\">
                      <label for=\"act_tiene_acceso_al_sistema\" class=\"mb-0 text-info\">
                        ¿Tiene acceso de administradci&oacute;n al sistema?
                      </label>
                    </div>
                    <div class=\"col-sm-9\">
                      <select  id='act_tiene_acceso_al_sistema' class='form-control form-control-sm'>
                        <option value='".$this->beneficiario['tiene_acceso_al_sistema']."'>Conservar acceso actual</option>
                        <option value='1'>Dar acceso de administraci&oacute;n</option>
                        <option value='0'>Denegar acceso de administraci&oacute;n</option>
                      </select>
                    </div>
                  </div>
                  
                  </div>
                  <div class=\'card-footer\'>
                    <button class=\"btn btn-success mb-1\" onclick='actualizar_beneficiario(".$id_de_usuario.")'>
                        <i class=\"fa fa-check mr-1\"></i>
                        Actualizar datos
                      </button>
                  </div>
                </div>
            </div>";
        echo $this->formulario_de_edicion;
    }

    function actualizar_datos_de_beneficiario($id_de_usuario,$numero_de_id_de_usuario,$nombres,$apellidos,$fecha_de_nacimiento,$fecha_de_alta,$cargo_ocupacion,$telefono_de_contacto,$email,$direccion,$es_titular_de_cuenta,$rol_familiar,$tiene_acceso_al_sistema)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->numero_de_id_de_usuario = $numero_de_id_de_usuario;
        $this->nombres = utf8_encode(strtoupper($nombres));
        $this->apellidos = utf8_encode(strtoupper($apellidos));
        $this->fecha_de_nacimiento = $fecha_de_nacimiento;
        $this->fecha_de_alta = $fecha_de_alta;
        $this->cargo_ocupacion = utf8_encode($cargo_ocupacion);
        $this->telefono_de_contacto = $telefono_de_contacto;
        $this->email = $email;
        $this->direccion = utf8_encode($direccion);
        $this->es_titular_de_cuenta = $es_titular_de_cuenta;
        $this->rol_familiar = utf8_encode(strtoupper($rol_familiar));
        $this->tiene_acceso_al_sistema = $tiene_acceso_al_sistema;
        if(Conexion::conect()->update('informacion_de_usuario',[
            'nombres'=>$this->nombres,
            'apellidos' =>$this->apellidos,
            'fecha_de_nacimiento'=>$this->fecha_de_nacimiento,
            'fecha_de_alta'=>$this->fecha_de_alta,
            'cargo_ocupacion'=>$this->cargo_ocupacion,
            'telefono_de_contacto'=>$this->telefono_de_contacto,
            'email'=>$this->email,
            'direccion'=>$this->direccion,
            'es_titular_de_cuenta'=>$this->es_titular_de_cuenta,
            'rol_familiar'=>$this->rol_familiar,
            'tiene_acceso_al_sistema'=>$this->tiene_acceso_al_sistema

        ],['numero_de_id_de_usuario'=>$this->numero_de_id_de_usuario]))
        {
            $this->correo = new Mailer();
            $this->correo->enviar_correo(ADMIN_MAIL,ADMIN_NAME,$this->email,$this->nombres,'ACTUALIZACION DE INFORMACION PERSONAL',"<p class=\"text-primary\">Se ha realizado una actualizacion de informacion en su servicio de MiSeguroFE</p>.<br><p class=\"text-secondary\">Si Usted no ha solicitao este cambio, por favor comuniquese con nosotros respondiendo este correo</p>");
            Historial::nueva_actividad($this->id_de_usuario,'AFILIADOS Y BENEFICIARIOS','CAMBIO DE INFORMACION EN EL USUARIO : '.$this->numero_de_id_de_usuario);
            echo "$(\".card_main\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Registro actualizado</h3>Datos de Usuario actualizados correctamente.</div>\")";
        }
    }
    function generar_formulario_para_agregar_beneficiario($id_de_dependiente)
    {
        $this->id_de_dependiente = $id_de_dependiente;
        $this->beneficiario = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$this->id_de_dependiente]);
        if($this->id_de_dependiente=='1')
        {
            $this->etq_benefactor="Es afiliado directo.";
        }
        else
        {
            $this->etq_benefactor=$this->beneficiario['apellidos']." ".$this->beneficiario['nombres'];
        }

        $this->id_de_dependiente = $id_de_dependiente;
        $this->beneficiario = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$this->id_de_dependiente]);
        $this->formulario="<div class=\"col-12  cards-container card_main\" id=\"card-container-1\">
            <div class=\"card\" id=\"card-1\">
                <div class=\"card-header\">
                    <h5 class=\"card-title\">
                        Agregar Nuevo Usuario
                    </h5>
                </div><!-- /.card-header -->

                <div class=\"card-body p-0\">
                    <div class=\" container container-plus\">
                        <div class=\"card acard mt-2 mt-lg-3\">
                            <div class=\"card-header\">
                                <h3 class=\"card-title text-125 text-primary-d2\">
                                    <i class=\"far fa-edit text-orange-l1 mr-1\"></i>
                                    Patrocinador o Benefactor : ".$this->etq_benefactor."
                                </h3>
                            </div>
                            <div class=\"card-body px-3 pb-1\">
                                <form class=\"mt-lg-3\" autocomplete=\"off\" id=\"form_empresa_afiliada\">
                                <input type='hidden' id='id_de_dependiente' value='".$this->id_de_dependiente."'>
                                
                                    <div class=\"row\">
                                        <div class=\"col-6\">
                                            <div class=\"form-group row\">
                                                <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                                    <label for=\"id_usuario\" class=\"mb-0\">
                                                       C&eacute;dula o Pasaporte
                                                    </label>
                                                </div>
                                                <div class=\"col-9\">
                                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                                        <i class=\"fa fa-id-card text-success text-110 ml-25 pos-abs\"></i>
                                                        <input type=\"text\" class=\"form-control form-control-lg px-475\" id=\"id_usuario\">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=\"form-group row\">
                                                <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                                    <label for=\"nombres\" class=\"mb-0\">
                                                        Nombres
                                                    </label>
                                                </div>
                                                <div class=\"col-9\">
                                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                                        <i class=\"fa fa-book-reader text-success text-110 ml-25 pos-abs\"></i>
                                                        <input type=\"text\" class=\"form-control form-control-lg px-475\" id=\"nombres\">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=\"form-group row\">
                                                <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                                    <label for=\"apellidos\" class=\"mb-0\">
                                                        Apellidos
                                                    </label>
                                                </div>
                                                <div class=\"col-9\">
                                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                                        <i class=\"fa fa-book-reader text-success text-110 ml-25 pos-abs\"></i>
                                                        <input type=\"text\" class=\"form-control form-control-lg px-475\" id=\"apellidos\">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=\"form-group row\">
                                                <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                                    <label for=\"correo\" class=\"mb-0\">
                                                        Email
                                                    </label>
                                                </div>
                                                <div class=\"col-9\">
                                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                                        <i class=\"fa fa-envelope text-success text-110 ml-25 pos-abs\"></i>
                                                        <input type=\"email\" class=\"form-control form-control-lg px-475 text-80\" id=\"correo\" value='".$this->beneficiario['email']."'>
                                                    </div>
                                                </div>
                                            </div>                                              
                                            <div class=\"form-group row\">
                                                <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                                    <label for=\"ciudad\" class=\"mb-0\">
                                                        Provincia
                                                    </label>
                                                </div>
                                                <div class=\"col-9\">
                                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                                        <i class=\"fa fa-map text-success text-110 ml-25 pos-abs\"></i>
                                                        <input type=\"text\" class=\"text-uppercase form-control form-control-lg px-475\" id=\"provincia\" value='".utf8_decode($this->beneficiario['provincia'])."'>
                                                    </div>
                                                </div>
                                            </div>   
                                            <div class=\"form-group row\">
                                                <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                                    <label for=\"ciudad\" class=\"mb-0\">
                                                        Ciudad
                                                    </label>
                                                </div>
                                                <div class=\"col-9\">
                                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                                        <i class=\"fa fa-map-marker-alt text-success text-110 ml-25 pos-abs\"></i>
                                                        <input type=\"text\" class=\"text-uppercase form-control form-control-lg px-475\" id=\"ciudad\" value='".utf8_decode($this->beneficiario['ciudad'])."'>
                                                    </div>
                                                </div>
                                            </div>                                                                                     
                                        </div>
                                        <div class=\"col-6\">
                                       
                                            <div class=\"form-group row\">
                                                <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                                    <label for=\"telefono1\" class=\"mb-0\">
                                                        Tel&eacute;fono principal
                                                    </label>
                                                </div>
                                                <div class=\"col-9\">
                                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                                        <i class=\"fa fa-phone text-success text-110 ml-25 pos-abs\"></i>
                                                        <input type=\"number\" class=\"text-uppercase form-control form-control-lg px-475\" id=\"telefono\" value='".$this->beneficiario['telefono_de_contacto']."'>
                                                    </div>
                                                </div>
                                            </div>                                             
                                            <div class=\"form-group row\">
                                                <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                                    <label for=\"direccion\" class=\"mb-0\">
                                                        Direcci&oacute;n
                                                    </label>
                                                </div>
                                                <div class=\"col-9\">
                                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                                        <i class=\"fa fa-map-marked text-success text-110 ml-25 pos-abs\"></i>
                                                        <input type=\"text\" class=\"text-uppercase form-control form-control-lg px-475\" id=\"direccion\" value='".utf8_decode($this->beneficiario['direccion'])."'>
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class=\"form-group row\">
                                                <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                                    <label for=\"cargo_ocupacion\" class=\"mb-0\">
                                                        Cargo ocupaci&oacute;n
                                                    </label>
                                                </div>
                                                <div class=\"col-9\">
                                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                                        <i class=\"fas fa-briefcase text-success text-110 ml-25 pos-abs\"></i>
                                                        <input type=\"text\" class=\"form-control form-control-lg px-475\" id=\"cargo_ocupacion\">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=\"form-group row\">
                                                <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                                    <label for=\"rol_familiar\" class=\"mb-0\">
                                                        Rol familiar
                                                    </label>
                                                </div>
                                                <div class=\"col-9\">
                                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                                        <i class=\"fas fa-user-tag text-success text-110 ml-25 pos-abs\"></i>
                                                        <input type=\"text\" class=\"form-control form-control-lg px-475\" id=\"rol_familiar\">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=\"form-group row\">
                                                <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                                    <label for=\"fecha_nacimiento\" class=\"mb-0\">
                                                        Fecha de nacimiento
                                                    </label>
                                                </div>
                                                <div class=\"col-9\">
                                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                                        <i class=\"fas fa-birthday-cake text-success text-110 ml-25 pos-abs\"></i>
                                                        <input type=\"date\" class=\"form-control form-control-lg px-475\" id=\"fecha_nacimiento\">
                                                    </div>
                                                </div>
                                            </div>                                                                                                                  
                                        </div>                                        
                                    </div>
                                    
                                </form>
                            </div><!-- /.card-body -->
                            <div class=\"card-footer\">
                                        <div class=\"mt-1 border-t-1 bgc-secondary-l4 brc-secondary-l2 mx-n25\">
                                            <div class=\"offset-md-3 col-md-9 text-nowrap\">
                                                <button class=\"btn btn-info btn-bold px-4\" type=\"button\" onclick='guardar_nuevo_beneficiario()'>
                                                    <i class=\"fa fa-check mr-1\"></i>
                                                    Guardar
                                                </button>
                                                <button class=\"btn btn-outline-lightgrey btn-bgc-white btn-bold ml-2 px-4\" type=\"reset\">
                                                    <i class=\"fa fa-undo mr-1\"></i>
                                                    Reset
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                        </div><!-- /.card -->
                    </div>
                </div>                
            </div>
        </div>";
        echo $this->formulario;
    }
    function guardar_nuevo_usuario($id_de_usuario,$numero_de_id_de_usuario,$nombres,$apellidos,$fecha_de_nacimiento,$cargo_ocupacion,$telefono_de_contacto,$email,$provincia,$ciudad,$direccion,$id_de_dependiente,$rol_familiar)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->numero_de_id_de_usuario = $numero_de_id_de_usuario;
        $this->nombres = utf8_encode(strtoupper($nombres));
        $this->apellidos = utf8_encode(strtoupper($apellidos));
        $this->fecha_de_nacimiento = $fecha_de_nacimiento;
        $this->cargo_ocupacion = utf8_encode($cargo_ocupacion);
        $this->telefono_de_contacto = $telefono_de_contacto;
        $this->email = $email;
        $this->provincia = utf8_encode(strtoupper($provincia));
        $this->ciudad = utf8_encode(strtoupper($ciudad));
        $this->direccion = utf8_encode($direccion);
        $this->id_de_dependiente = $id_de_dependiente;
        $this->rol_familiar = utf8_encode(strtoupper($rol_familiar));


        if(Conexion::conect()->has('informacion_de_usuario',['numero_de_id_de_usuario'=>$this->numero_de_id_de_usuario]))
        {
            echo "$(\".card_main\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Usuario ya existente</h3>Este Usuario ya se encuentra en el sistema .</div>\")";
        }
        else
        {
            if($this->id_de_dependiente==1)
            {
                $this->tipo_de_cuenta=1;
            }
            else
            {
                $this->tipo_de_cuenta=0;
            }

            if(Conexion::conect()->insert('informacion_de_usuario',[
                'numero_de_id_de_usuario'=>$this->numero_de_id_de_usuario,
                'nombres'=>$this->nombres,
                'apellidos'=>$this->apellidos,
                'fecha_de_nacimiento'=>$this->fecha_de_nacimiento,
                'fecha_de_alta'=>date('Y-m-d'),
                'cargo_ocupacion'=>$this->cargo_ocupacion,
                'telefono_de_contacto'=>$this->telefono_de_contacto,
                'email'=>$this->email,
                'provincia'=>$this->provincia,
                'ciudad'=>$this->ciudad,
                'direccion'=>$this->direccion,
                'indice_de_perfil_fk'=>2,
                'id_de_dependiente'=>$this->id_de_dependiente,
                'es_titular_de_cuenta'=>$this->tipo_de_cuenta,
                'rol_familiar'=>$this->rol_familiar,
                'tiene_acceso_al_sistema'=>0,
                'activar_usuario'=>1
            ])){
                Historial::nueva_actividad($this->id_de_usuario,'USUARIOS','NUEVO USUARIO REGISTRADO :'.$this->numero_de_id_de_usuario);
                echo "$(\".card_main\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Usuario registrado</h3>Usuario egistrado en el sistema correctamente .</div>\")";
                /*if($this->id_de_dependiente==1)
                {
                    $this->email = new Mailer();
                    $this->email->enviar_correo(ADMIN_MAIL,ADMIN_NAME,$this->email,$this->nombres,'REGISTRO EXITOSO A MISEGURO','<h3 class="text-purple-d1">Bienvenido a MiSeguroFE</h3><p>Su cuenta ha sido registrada exitosamente.</p>');
                }
                else
                {
                    $this->email = new Mailer();
                    $this->email->enviar_correo(ADMIN_MAIL,ADMIN_NAME,$this->email,$this->nombres,'NUEVO BENEFICIARIO REGISTRADO','<h3 class="text-purple-d1">Bienvenido a MiSeguroFE</h3><p>Hay un nuevo dependiente de seguro registrado a su cuenta, si cree que es un error, por favor responda a este correo con el respectivo reclamo.</p>');
                }*/
            }
        }
    }
}




                      


                        
