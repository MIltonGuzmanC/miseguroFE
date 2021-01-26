<?php
include_once 'Conexion.cls.php';
include_once 'Mailer.cls.php';
include_once 'Historial.cls.php';

class ServiciosMedicosEspeciales
{
    private $id_de_usuario,$servicio_medico,$valor_de_servicio,$servicio,$tabla;
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

    function generar_lista_de_servicios_medicos_especiales($filtro)
    {
        $this->filtro = $filtro;
        if(($this->filtro == '*')||($this->filtro==' '))
        {
            $this->data = Conexion::conect()->select('servicios_medicos_especiales','*',["ORDER"=>'servicio_medico']);
        }
        else
        {
            $this->data = Conexion::conect()->select('servicios_medicos_especiales','*',['servicio_medico[~]'=>$this->filtro]);
        }


        $this->tabla.="<table id=\"simple-table\" class=\"table table-striped table-bordered table-hover brc-black-tp10 mb-0 text-grey\">
                        <thead class=\"text-dark-tp3 bgc-grey-l4 text-90 border-b-1 brc-transparent\">
                          <tr>
                           
                            <th>
                                Servicio M&eacute;dico
                            </th>

                            <th>
                                Valor del servicio
                            </th>
              
                           
                            <th></th>
                            
                          </tr>
                        </thead> 
                        <tbody class=\"mt-1\">";
        foreach($this->data as $this->servicio)
        {


            $this->tabla.="<tr class=\"bgc-h-yellow-l4 d-style text-blue-d1\">
                            <td>
                              ".utf8_decode($this->servicio['servicio_medico'])."
                            </td>
                            <td> $
                              ".$this->servicio['valor_de_servicio']."
                            </td>
                          
                            <td>
                                <div class=\"d-none d-lg-flex\">
                                <a data-fancybox data-type=\"ajax\" href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-success btn-a-lighter-success\" data-src=\"controllers/mostrar_formulario_de_edicion_de_servicio_medico_especial.ctrl.php?indice_de_servicio_medico=".$this->servicio['indice_de_servicio_medico']."\" href=\"javascript:;\">
        <i class=\"fa fa-pencil-alt text-secondary-d1\"></i>
                                </a>
                                </div>
                            </td>
                         </tr>";
        }
        $this->tabla.="</tbody></table>";
        echo $this->tabla;
    }
    function generar_formulario_de_nuevo_servicio_medico_especial()
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
                                    Nuevo servicio m&eacute;dico especial.
                                </h3>
                            </div>
                            <div class=\"card-body px-0\">
                                <form autocomplete=\"off\" id=\"form_nuevo_servicio_medico\">
                                    <div class=\"row\">
                                        <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                            <label for=\"servicio_medico\" class=\"mb-0\">
                                               Servicio m&eacute;dico
                                            </label>
                                        </div>
                                        <div class=\"col-9\">
                                            <div class=\"d-inline-flex align-items-center mb-1\">
                                                <i class=\"fa fa-medkit text-success text-110 ml-25 pos-abs\"></i>
                                                <input type=\"text\" class=\"form-control form-control-lg px-475\" id=\"servicio_medico\">
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                            <label for=\"valor_de_servicio\" class=\"mb-0\">
                                               Valor del servicio $
                                            </label>
                                        </div>
                                        <div class=\"col-9\">
                                            <div class=\"d-inline-flex align-items-center mb-1\">
                                                <i class=\"fa fa-money-bill text-success text-110 ml-25 pos-abs\"></i>
                                                <input type=\"number\" class=\"form-control form-control-lg px-475\" id=\"valor_de_servicio\">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.card-body -->
                            <div class=\"card-footer\">
                                        <div class=\"mt-1 border-t-1 bgc-secondary-l4 brc-secondary-l2 mx-n25\">
                                            <div class=\"offset-md-3 col-md-9 text-nowrap\">
                                                <button class=\"btn btn-info btn-bold px-4\" type=\"button\" onclick='guardar_nuevo_servicio_medico_especial()'>
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
        $this->servicio = Conexion::conect()->get('servicios_medicos_especiales','*',['indice_de_servicio_medico'=>$this->indice_de_servicio_medico]);
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
                                    Edici&oacute;n de servicio m&eacute;dico especial.
                                </h3>
                            </div>
                            <div class=\"card-body px-0\">
                                <form autocomplete=\"off\" id=\"form_nuevo_servicio_medico\">
                                    <input type='hidden' id='indice_de_servicio_medico' value='".$this->servicio['indice_de_servicio_medico']."'>
                                    <div class=\"row\">
                                        <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                            <label for=\"servicio_medico\" class=\"mb-0\">
                                               Servicio m&eacute;dico
                                            </label>
                                        </div>
                                        <div class=\"col-9\">
                                            <div class=\"d-inline-flex align-items-center mb-1\">
                                                <i class=\"fa fa-medkit text-success text-110 ml-25 pos-abs\"></i>
                                                <input type=\"text\" class=\"form-control form-control-lg px-475\" id=\"servicio_medico\" value='".utf8_decode($this->servicio['servicio_medico'])."'>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-3 col-form-label text-sm-right pr-0\">
                                            <label for=\"valor_de_servicio\" class=\"mb-0\">
                                               Valor del servicio
                                            </label>
                                        </div>
                                        <div class=\"col-9\">
                                            <div class=\"d-inline-flex align-items-center mb-1\">
                                                <i class=\"fa fa-calculator text-success text-110 ml-25 pos-abs\"></i>
                                                <input type=\"number\" class=\"form-control form-control-lg px-475\" id=\"valor_de_servicio\" value='".$this->servicio['valor_de_servicio']."'>
                                            </div>
                                        </div>
                                    </div>
                                 
                                </form>
                            </div><!-- /.card-body -->
                            <div class=\"card-footer\">
                                        <div class=\"mt-1 border-t-1 bgc-secondary-l4 brc-secondary-l2 mx-n25\">
                                            <div class=\"offset-md-3 col-md-9 text-nowrap\">
                                                <button class=\"btn btn-info btn-bold px-4\" type=\"button\" onclick='actualizar_servicio_medico_especial()'>
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
    function actualizar_servicio_medico_especial($id_de_usuario,$indice_de_servicio_medico,$servicio_medico,$valor_de_servicio)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->indice_de_servicio_medico = $indice_de_servicio_medico;
        $this->servicio_medico = utf8_encode(strtoupper($servicio_medico));
        $this->valor_de_servicio = $valor_de_servicio;
        if(Conexion::conect()->update('servicios_medicos_especiales',[
            'servicio_medico'=>$this->servicio_medico,
            'valor_de_servicio'=>$this->valor_de_servicio
        ],['indice_de_servicio_medico'=>$this->indice_de_servicio_medico]))
        {
            Historial::nueva_actividad($this->id_de_usuario,'SERVICIOS MEDICOS ESPECIALES','SERVICIO MEDICO ACTUALIZADO : '.$this->servicio_medico);
            echo "$(\".card_main\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Registro actualizado</h3>Servicio medico especial actualizado exitosamente.</div>\")";
        }


    }
}