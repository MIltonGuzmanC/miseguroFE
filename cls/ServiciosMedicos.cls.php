<?php
include_once 'Conexion.cls.php';
include_once 'Mailer.cls.php';
include_once 'Historial.cls.php';
class ServiciosMedicos
{
 private $id_de_usuario,$servicio_medico,$valor_dentro_de_cobertura,$valor_fuera_de_cobertura,$tipo_de_valor;
 private $valor_de_servicio,$data,$tabla,$servicio,$formulario,$etq_tipo_valor,$op,$indice_de_servicio_medico;
    function agregar_nuevo_servicio_medico($id_de_usuario,$servicio_medico,$valor_dentro_de_cobertura,$valor_fuera_de_cobertura,$tipo_de_valor)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->servicio_medico = utf8_encode(strtoupper($servicio_medico));
        $this->valor_dentro_de_cobertura = $valor_dentro_de_cobertura;
        $this->valor_fuera_de_cobertura = $valor_fuera_de_cobertura;
        $this->tipo_de_valor = $tipo_de_valor;
        if(Conexion::conect()->insert('servicios_medicos',[
            'servicio_medico'=>$this->servicio_medico,
            'valor_dentro_de_cobertura'=>$this->valor_dentro_de_cobertura,
            'valor_fuera_de_cobertura'=>$this->valor_fuera_de_cobertura,
            'tipo_de_valor'=>$this->tipo_de_valor,
            'periodo'=>date('Y')
        ])){
            Historial::nueva_actividad($this->id_de_usuario,'SERVICIOS MEDICOS','NUEVO SERVICIO MEDICO AGREGADO : '.$this->servicio_medico);
            echo "$(\".card_main\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Registro agregado</h3>Servicio medico agregado exitosamente.</div>\")";

        }

    }

    function agregar_nuevo_servicio_medico_especial($id_de_usuario,$servicio_medico,$valor_de_servicio)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->servicio_medico = utf8_encode(strtoupper($servicio_medico));
        $this->valor_de_servicio = $valor_de_servicio;
        if(Conexion::conect()->insert('servicios_medicos_especiales',[
            'servicio_medico'=>$this->servicio_medico,
            'valor_de_servicio'=>$this->valor_de_servicio,
            'periodo'=>date('Y')
        ]))
        {
            Historial::nueva_actividad($this->id_de_usuario,'SERVICIOS MEDICOS ESPECIALES','NUEVO SERVICIO MEDICO AGREGADO : '.$this->servicio_medico);
            echo "$(\".card_main\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Registro agregado</h3>Servicio medico especial agregado exitosamente.</div>\")";
        }

    }

    function generar_lista_de_servicios_medicos()
    {
        $this->data = Conexion::conect()->select('servicios_medicos','*',["ORDER"=>'servicio_medico']);

        $this->tabla.="<table id=\"simple-table\" class=\"table table-striped table-bordered table-hover brc-black-tp10 mb-0 text-grey\">
                        <thead class=\"text-dark-tp3 bgc-grey-l4 text-90 border-b-1 brc-transparent\">
                          <tr>
                           
                            <th>
                                Servicio M&eacute;dico
                            </th>

                            <th>
                                Valor dentro de cobertura
                            </th>

                            <th class=\"d-none d-sm-table-cell\">
                                Valor fuera de cobertura
                            </th>

                            <th class=\"d-none d-sm-table-cell\">
                                Tipo de par&aacute;metro
                            </th>  
                            <th></th>
                            
                          </tr>
                        </thead> 
                        <tbody class=\"mt-1\">";
        foreach($this->data as $this->servicio)
        {
                $this->op = $this->servicio['tipo_de_valor'];
                if($this->op==2)
                {
                    $this->etq_tipo_valor = 'Porcentaje';
                }
                elseif ($this->op==1)
                {
                    $this->etq_tipo_valor = 'D&oacute;lares';

                }
                else
                {
                    $this->etq_tipo_valor = 'D&iacute;a / s';
                }

                $this->tabla.="<tr class=\"bgc-h-yellow-l4 d-style text-blue-d1\">
                            <td>
                              ".utf8_decode($this->servicio['servicio_medico'])."
                            </td>
                            <td>
                              ".$this->servicio['valor_dentro_de_cobertura']."
                            </td>
                            <td>
                              ".$this->servicio['valor_fuera_de_cobertura']."
                            </td>
                            <td>
                              ".$this->etq_tipo_valor."
                            </td>
                            <td>
                                <div class=\"d-none d-lg-flex\">
                                <a data-fancybox data-type=\"ajax\" href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-success btn-a-lighter-success\" data-src=\"controllers/mostrar_formulario_de_edicion_de_servicio_medico.ctrl.php?indice_de_servicio_medico=".$this->servicio['indice_de_servicio_medico']."\" href=\"javascript:;\">
        <i class=\"fa fa-pencil-alt text-secondary-d1\"></i>
                                </a>
                                </div>
                            </td>
                         </tr>";
        }
        $this->tabla.="</tbody></table>";
        echo $this->tabla;
    }

    function generar_formulario_de_nuevo_servicio_medico()
    {
        $this->formulario="<div class=\"col-10  cards-container card_main\" id=\"card-container-1\">
            <div class=\"card\" id=\"card-1\">
                <div class=\"card-header\">
                    <h5 class=\"card-title\">
                        Formulario de ingreso
                    </h5>
                </div><!-- /.card-header -->
                <div class=\"card-body p-1\">
                    <div class=\"container\">
                        <div class=\"card acard\">
                            <div class=\"card-header\">
                                <h3 class=\"card-title text-125 text-primary-d2\">
                                    <i class=\"far fa-edit text-orange-l1 mr-1\"></i>
                                    Nuevo servicio m&eacute;dico.
                                </h3>
                            </div>
                            <div class=\"card-body px-0\">
                                <form autocomplete=\"off\" id=\"form_nuevo_servicio_medico\">
                                    <div class=\"row\">
                                        <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                            <label for=\"servico_medico\" class=\"mb-0\">
                                               Servicio m&eacute;dico
                                            </label>
                                        </div>
                                        <div class=\"col-9\">
                                            <div class=\"d-inline-flex align-items-center mb-1\">
                                                <i class=\"fa fa-medkit text-success text-110 ml-25 pos-abs\"></i>
                                                <input type=\"text\" class=\"form-control form-control-lg px-475\" id=\"servico_medico\">
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                            <label for=\"valor_dentro_de_cobertura\" class=\"mb-0\">
                                               Valor dentro de cobertura
                                            </label>
                                        </div>
                                        <div class=\"col-9\">
                                            <div class=\"d-inline-flex align-items-center mb-1\">
                                                <i class=\"fa fa-calculator text-success text-110 ml-25 pos-abs\"></i>
                                                <input type=\"number\" class=\"form-control form-control-lg px-475\" id=\"valor_dentro_de_cobertura\">
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                            <label for=\"valor_fuera_de_cobertura\" class=\"mb-0\">
                                               Valor fuera de cobertura
                                            </label>
                                        </div>
                                        <div class=\"col-9\">
                                            <div class=\"d-inline-flex align-items-center mb-1\">
                                                <i class=\"fa fa-calculator text-success text-110 ml-25 pos-abs\"></i>
                                                <input type=\"number\" class=\"form-control form-control-lg px-475\" id=\"valor_fuera_de_cobertura\">
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-3\">
                                          <select class=\"mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down\" id=\"tipo_de_valor\">
                                            <option value=\"0\">Tipo de par&aacute;metro</option>
                                            <option value=\"1\">Moneda <b>$</b></option>
                                            <option value=\"2\">Porcentaje  <b>%</b></option>
                                            <option value=\"3\">D&iacute;a <b>D</b></option>
                                          </select>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.card-body -->
                            <div class=\"card-footer\">
                                        <div class=\"mt-1 border-t-1 bgc-secondary-l4 brc-secondary-l2 mx-n25\">
                                            <div class=\"offset-md-3 col-md-9 text-nowrap\">
                                                <button class=\"btn btn-info btn-bold px-4\" type=\"button\" onclick='guardar_nuevo_servicio_medico()'>
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
    function generar_formulario_de_edicion_de_servicio_medico($indice_de_servicio_medico)
    {
        $this->indice_de_servicio_medico = $indice_de_servicio_medico;
        $this->servicio = Conexion::conect()->get('servicios_medicos','*',['indice_de_servicio_medico'=>$this->indice_de_servicio_medico]);
        $this->formulario="<div class=\"col-10  cards-container card_main\" id=\"card-container-1\">
            <div class=\"card\" id=\"card-1\">
                <div class=\"card-header\">
                    <h5 class=\"card-title\">
                        Formulario
                    </h5>
                </div><!-- /.card-header -->

                <div class=\"card-body p-1\">
                    <div class=\"container\">
                        <div class=\"card acard\">
                            <div class=\"card-header\">
                                <h3 class=\"card-title text-125 text-primary-d2\">
                                    <i class=\"far fa-edit text-orange-l1 mr-1\"></i>
                                    Edici&oacute;n de servicio m&eacute;dico.
                                </h3>
                            </div>
                            <div class=\"card-body px-0\">
                                <form autocomplete=\"off\" id=\"form_nuevo_servicio_medico\">
                                    <input type='hidden' id='indice_de_servicio_medico' value='".$this->servicio['indice_de_servicio_medico']."'>
                                    <div class=\"row\">
                                        <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                            <label for=\"servico_medico\" class=\"mb-0\">
                                               Servicio m&eacute;dico
                                            </label>
                                        </div>
                                        <div class=\"col-9\">
                                            <div class=\"d-inline-flex align-items-center mb-1\">
                                                <i class=\"fa fa-medkit text-success text-110 ml-25 pos-abs\"></i>
                                                <input type=\"text\" class=\"form-control form-control-lg px-475\" id=\"servico_medico\" value='".utf8_decode($this->servicio['servicio_medico'])."'>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                            <label for=\"valor_dentro_de_cobertura\" class=\"mb-0\">
                                               Valor dentro de cobertura
                                            </label>
                                        </div>
                                        <div class=\"col-9\">
                                            <div class=\"d-inline-flex align-items-center mb-1\">
                                                <i class=\"fa fa-calculator text-success text-110 ml-25 pos-abs\"></i>
                                                <input type=\"number\" class=\"form-control form-control-lg px-475\" id=\"valor_dentro_de_cobertura\" value='".$this->servicio['valor_dentro_de_cobertura']."'>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                            <label for=\"valor_fuera_de_cobertura\" class=\"mb-0\">
                                               Valor fuera de cobertura
                                            </label>
                                        </div>
                                        <div class=\"col-9\">
                                            <div class=\"d-inline-flex align-items-center mb-1\">
                                                <i class=\"fa fa-calculator text-success text-110 ml-25 pos-abs\"></i>
                                                <input type=\"number\" class=\"form-control form-control-lg px-475\" id=\"valor_fuera_de_cobertura\" value='".$this->servicio['valor_fuera_de_cobertura']."'>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-3\">
                                          <select class=\"mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down\" id=\"tipo_de_valor\">
                                            <option value='".$this->servicio['tipo_de_valor']."'>Conservar y no cambiar</option>
                                            <option value=\"1\">Moneda <b>$</b></option>
                                            <option value=\"2\">Porcentaje  <b>%</b></option>
                                            <option value=\"3\">D&iacute;a <b>D</b></option>
                                          </select>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.card-body -->
                            <div class=\"card-footer\">
                                        <div class=\"mt-1 border-t-1 bgc-secondary-l4 brc-secondary-l2 mx-n25\">
                                            <div class=\"offset-md-3 col-md-9 text-nowrap\">
                                                <button class=\"btn btn-info btn-bold px-4\" type=\"button\" onclick='actualizar_servicio_medico()'>
                                                    <i class=\"fa fa-check mr-1\"></i>
                                                    Actualizar
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
    function actualizar_servicio_medico($id_de_usuario,$indice_de_servicio_medico,$servicio_medico,$valor_dentro_de_cobertura,$valor_fuera_de_cobertura,$tipo_de_valor)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->indice_de_servicio_medico = $indice_de_servicio_medico;
        $this->servicio_medico = utf8_encode(strtoupper($servicio_medico));
        $this->valor_dentro_de_cobertura = $valor_dentro_de_cobertura;
        $this->valor_fuera_de_cobertura = $valor_fuera_de_cobertura;
        $this->tipo_de_valor = $tipo_de_valor;
        if(Conexion::conect()->update('servicios_medicos',[
            'servicio_medico'=>$this->servicio_medico,
            'valor_dentro_de_cobertura'=>$this->valor_dentro_de_cobertura,
            'valor_fuera_de_cobertura'=>$this->valor_fuera_de_cobertura,
            'tipo_de_valor'=>$this->tipo_de_valor
        ],['indice_de_servicio_medico'=>$this->indice_de_servicio_medico]))
        {
            Historial::nueva_actividad($this->id_de_usuario,'SERVICIOS MEDICOS ESPECIALES','SERVICIO MEDICO ACTUALIZADO : '.$this->servicio_medico);
            echo "$(\".card_main\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Registro actualizado</h3>Servicio medico actualizado exitosamente.</div>\")";
        }


    }
}


