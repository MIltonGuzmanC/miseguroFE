<?php

include_once 'Conexion.cls.php';
class TablaDeParametros
{
    private $data;
    function mostrar_tabla_de_valores(){
        $this->data = Conexion::conect()->get('parametros_del_sistema','*');
        echo "<div role=\"main\" class=\"main-content\">
            <div class=\"page-content container\">
                <!-- stat boxes -->
                <div class=\"row px-1\">

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                                <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-orange-l3 p-3 radius-round\">
                                        <i class=\"fa fa-money-bill-alt text-orange-d4 text-180 w-4\"></i>
                                    </span>
                                </div>
                                <div class=\"mt-1\">
                                    <div class=\"text-secondary-d3 text-180 \">
                                        $ ".$this->data['valor_maximo_de_cobertura_dc']."
                                    </div>
                                    <div class=\"text-dark-tp4 text-110\">
                                        <span class=\"text-80 text-black-50\">Valor m&aacute;ximo  de cobertura dentro de convenio</span>
                                    </div>
                                </div>
                                <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                    <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
        <i class=\"fa fa-pen text-orange\"></i>
                                    </a>
                                </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-success-l2 p-3 radius-round\">
                                        <i class=\"fa fa-money-bill-alt text-success-m1 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                $ ".$this->data['valor_maximo_de_cobertura_fc']."
        </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor m&aacute;ximo de cobertura fuera de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-red-m1 p-3 radius-round\">
                                        <i class=\"fa fa-book-medical text-white-tp1 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['consulta_medica_dc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por consulta m&eacute;dica dentro de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-primary-l3 p-3 radius-round\">
                                        <i class=\"fa fa-book-medical text-primary text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['consulta_medica_fc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por consulta m&eacute;dica fuera de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>


                </div>
                <div class=\"py-2px\"></div>
                <div class=\"row px-1\">

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-yellow-d1 p-3 radius-round\">
                                        <i class=\"fa fa-ambulance text-yellow-d3 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180 \">
                                    $ ".$this->data['consulta_medica_emergencia_dc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por consulta m&eacute;dica de emergencias dentro de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-warning-l2 p-3 radius-round\">
                                        <i class=\"fa fa-ambulance text-warning text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['consulta_medica_emergenca_fc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por consulta m&eacute;dica de emergencias fuera de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-success-d1 p-3 radius-round\">
                                        <i class=\"fa fa-heart text-white-tp1 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['cuarto_y_alimento_diario_dc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de hosperdaje y alimentaci&oacute;n dentro de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-info-d1 p-3 radius-round\">
                                        <i class=\"fa fa-heart text-white-tp1 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['cuarto_y_alimento_diario_fc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de hospedaje y alimentaci&oacute;n fuera de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class=\"py-2px\"></div>
                <div class=\"row px-1\">
                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-info-d1 p-3 radius-round\">
                                        <i class=\"fa fa-wheelchair text-white-tp1 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['deducible_por_incapacidad_dc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Deducible por incapacidad dentro de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-red-l4 p-3 radius-round\">
                                        <i class=\"fa fa-wheelchair text-black-50 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['deducible_por_incapacidad_fc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Deducible por incapacidad fuera de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-blue-l1 p-3 radius-round\">
                                        <i class=\"fa fa-medkit text-blue text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    % ".$this->data['terapia_intensiva_dc']."
        </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Cobertura por terapia intensiva dentro de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-yellow-l2 p-3 radius-round\">
                                        <i class=\"fa fa-medkit text-warning text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    % ".$this->data['terapia_intensiva_fc']."
        </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Cobertura por terapia intensiva fuera de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class=\"py-2px\"></div>
                <div class=\"row px-1px\">
                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-danger-m1 p-3 radius-round\">
                                        <i class=\"fa fa-percent text-white-tp1 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    % ".$this->data['porcentaje_de_reembolso_dc']."
        </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Porcentaje de reembolso dentro de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-danger-l3 p-3 radius-round\">
                                        <i class=\"fa fa-percent text-black-50 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    % ".$this->data['porcentaje_de_reembolso_fc']."
        </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Porcentaje de reembolso fuera de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-info-d3 p-3 radius-round\">
                                        <i class=\"fa fa-bed text-black-50 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    ".$this->data['periodo_de_incapacidad_dc']." d&iacute;as
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Periodo de incapacidad dentro de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-info-l2 p-3 radius-round\">
                                        <i class=\"fa fa-bed text-black-50 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    ".$this->data['periodo_de_incapacidad_fc']." d&iacute;as
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Periodo de incapacidad fuera de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class=\"py-2px\"></div>
                <div class=\"row px-1px\">
                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-danger-l1 p-3 radius-round\">
                                        <i class=\"fa fa-ambulance text-white-tp1 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    % ".$this->data['emergencia_por_accidente_dc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Porcentaje de cobertura por emergencia provocada por accidente dentro de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-yellow-d1 p-3 radius-round\">
                                        <i class=\"fa fa-ambulance text-blue text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    % ".$this->data['emergencia_por_accidente_fc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Porcentaje de cobertura por emergencia provocada por accidente fuera de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-green-d1 p-3 radius-round\">
                                        <i class=\"fa fa-ambulance text-white-tp1 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['ambulancia_terrestre_dc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de ambulancia terrestre dentro de cobertura</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-black-tp2 p-3 radius-round\">
                                        <i class=\"fa fa-ambulance text-yellow text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['ambulancia_terrestre_fc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de ambulancia terrestre fuera de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class=\"py-2px\"></div>
                <div class=\"row px-1px\">
                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-blue-d1 p-3 radius-round\">
                                        <i class=\"fa fa-book text-white-tp2 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    ".$this->data['tiempo_entrega_de_documentacion_dc']." d&iacute;as
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Tiempo de entega de documentaci&oacute;n dentro de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-danger-m1 p-3 radius-round\">
                                        <i class=\"fa fa-book text-white-tp2 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    ".$this->data['tiempo_entrega_de_documentacion_fc']." d&iacute;as
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Tiempo de entega de documentaci&oacute;n fuera de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-purple-d1 p-3 radius-round\">
                                        <i class=\"fa fa-hospital-symbol text-white-tp2 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    % ".$this->data['cobertura_hospitalaria_dc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Porcentaje de cobertura hospitalaria dentro de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-green-l2 p-3 radius-round\">
                                        <i class=\"fa fa-hospital-symbol text-green-d1 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    % ".$this->data['cobertura_hospitalaria_fc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Porcentaje de cobertura hospitalaria fuera de convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>


                </div>
                <div class=\"py-2px\"></div>
                <div class=\"row px-1px\">
                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-black p-3 radius-round\">
                                        <i class=\"fa fa-cross text-white-tp2 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                $ ".$this->data['sepelio_de_dependientes_dc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de sepelio de dependientes dentro del convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-grey-d1 p-3 radius-round\">
                                        <i class=\"fa fa-cross text-white-tp2 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                $ ".$this->data['sepelio_de_dependientes_fc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de sepelio de dependientes fuera del convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-red-l2 p-3 radius-round\">
                                        <i class=\"fa fa-baby text-purple text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['parto_normal_dc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de parto normal dentro del convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-yellow-l3 p-3 radius-round\">
                                        <i class=\"fa fa-baby text-purple text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['parto_normal_fc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de parto normal fuera del convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>


                </div>
                <div class=\"py-2px\"></div>
                <div class=\"row py-2px\">

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-blue-l1 p-3 radius-round\">
                                        <i class=\"fa fa-baby-carriage text-white text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['cesarea_dc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de ces&aacute;rea dentro del convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-purple-l1 p-3 radius-round\">
                                        <i class=\"fa fa-baby-carriage text-white text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['cesarea_fc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de ces&aacute;rea fuera del convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-green-l2 p-3 radius-round\">
                                        <i class=\"fa fa-bars text-white text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['aborto_no_inducido_dc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de aborto no inducido dentro del convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-blue p-3 radius-round\">
                                        <i class=\"fa fa-bars text-white text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['aborto_no_inducido_fc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de aborto no inducido fuera del convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class=\"py-2px\"></div>
                <div class=\"row py-2px\">

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-purple-d1 p-3 radius-round\">
                                        <i class=\"fa fa-user-md text-white text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    % ".$this->data['reembolso_por_cirugia_dc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Porcentaje de reembolso por concepto de cirug&iacute;a dentro del convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-yellow-d3 p-3 radius-round\">
                                        <i class=\"fa fa-user-md text-white text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    % ".$this->data['reembolso_por_cirugia_fc']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Porcentaje de reembolso por concepto de cirug&iacute;a fuera del convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-yellow-l2 p-3 radius-round\">
                                        <i class=\"fa fa-crop-alt text-warning text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['ligadura']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de ligadura dentro del convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-purple p-3 radius-round\">
                                        <i class=\"fa fa-hand-scissors text-white-50 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['vasectomia']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de vasectom&iacute;a dentro del convenio</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class=\"py-2px\"></div>
                <div class=\"row py-2px\">
                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-purple-l1 p-3 radius-round\">
                                        <i class=\"fa fa-venus text-black-50 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                $ ".$this->data['colocacion_t_de_cobre']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de colocac&oacute;n de T de cobre</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-12 col-sm-6 col-md-3 px-2 mb-1 mb-md-0\">
                        <div class=\"bcard d-flex flex-column text-center px-2 py-3 h-100\">
                            <div class=\"mb-1\">
                                    <span class=\"d-inline-block bgc-purple-d2 p-3 radius-round\">
                                        <i class=\"fa fa-bars text-black-50 text-180 w-4\"></i>
                                    </span>
                            </div>
                            <div class=\"mt-1\">
                                <div class=\"text-secondary-d3 text-180\">
                                    $ ".$this->data['colocacion_de_implanon']."
                                </div>
                                <div class=\"text-dark-tp4 text-110\">
                                    <span class=\"text-80 text-black-50\">Valor de cobertura por concepto de colocac&oacute;n de implan&oacute;n</span>
                                </div>
                            </div>
                            <div class=\"text-blue-m1 font-bolder position-tr m-2\">
                                <a class=\"btn bgc-white btn-light-secondary mx-0\" href=\"#\" data-toggle=\"tooltip\" title=\"\" data-original-title=\"Print\">
                                    <i class=\"fa fa-pen text-orange\"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
    }
}