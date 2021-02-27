<?php
date_default_timezone_set('America/Lima');
include_once 'Conexion.cls.php';
include_once 'Historial.cls.php';
include_once 'Mailer.cls.php';
include_once 'MovimientoDeUsuario.cls.php';
include_once '../config.ini.php';
class Reembolso
{
    private $formulario_nuevo_reembolso,$data_reembolso,$beneficiario,$encabezado_de_reembolso,$data_de_usuario,$num_reembolsos,$id_de_usuario,$digitador,$mail,$etq_estado,$informacion_de_encabezado;
    private $id_de_administrador,$numero_de_documento,$enfermedad_preexistente,$tipo_de_reembolso,$codigo_de_grupo_de_cie,$cie10,$estado_de_reembolso,$formulario_de_reembolso;
    private $filtro,$data,$lista_de_reembolsos,$formulario_de_detalle_de_reembolsos;
    private $item_formulario_1,$encabezado,$saldo_de_usuario,$boton_imprimir,$data_de_cie;
    static function  generar_datalist_de_usuarios()
    {
        $data = Conexion::conect()->select('informacion_de_usuario','*',['activar_usuario'=>1]);
        $datalist="";
        $datalist.="<datalist id='lista_de_usuarios'>";
        foreach ($data as $beneficiario)
        {
            $datalist.="<option value='".$beneficiario['numero_de_id_de_usuario']."'>".utf8_decode($beneficiario['apellidos'])." ".utf8_decode($beneficiario['nombres'])."</option>";
        }
        $datalist.="</datalist>";

        return $datalist;
    }

    static function generar_lista_de_cie10($codigo_grupo_de_cie)
    {

        $data = Conexion::conect()->select('cie','*',['codigo_de_grupo_de_cie_fk'=>$codigo_grupo_de_cie]);
        $lista='';
        if($codigo_grupo_de_cie=="0")
        {
            $lista ="<span class='text-info text-75'>Esperando grupo de CIE...</span>";
        }
        else
        {
            $lista.="<select id='cie10' class='form-control form-control-lg px-475 border-info text-75'>";
            foreach ($data as $cie10)
            {

                $lista.="<option value='".$cie10['codigo_de_cie']."'>".$cie10['codigo_de_cie']." : ".utf8_decode($cie10['nombre_de_cie'])."</option>";
            }
            $lista.="</select>";
        }


        return $lista;
    }



    static function generar_lista_de_grupos_de_cie10()
    {
        $data = Conexion::conect()->select('grupo_de_cie','*',['ORDER'=>'nombre_del_grupo']);
        $lista_encabezado_cie='';
        $lista_encabezado_cie.="<select id='codigo_de_grupo_de_cie' class='form-control form-control-lg px-475 border-info text-75' onchange='generar_lista_de_cie10()'>";
        $lista_encabezado_cie.="<option value='0'>SELECCIONE UN GRUPO</option>";
        foreach ($data as $enc_cie)
        {

                $lista_encabezado_cie.="<option value='".$enc_cie['codigo_de_grupo_de_cie']."'>".utf8_decode($enc_cie['nombre_del_grupo'])."</option>";
            }
        $lista_encabezado_cie.="</select>";

        return $lista_encabezado_cie;
    }

    function generar_formulario_de_nuevo_reembolso($id_de_usuario)
    {
        $this->digitador = $id_de_usuario;
        $this->num_reembolsos.=date('YmdGis');
        $this->num_reembolsos.=$this->digitador;
        $this->num_reembolsos.=Conexion::conect()->count('encabezado_de_reembolso');
        $this->formulario_nuevo_reembolso.="
            <div class='card-header'>
                <h5 class='card-title'>Formulario para nuevo reembolso # ".$this->num_reembolsos."</h5>
            </div>
            <div class='card-body'>
                <input type='hidden' id='numero_de_documento' value='".$this->num_reembolsos."'>
                
                <div class='form-group form-row'>
                    <div class='form-inline col-4'>
                        <label for='id_de_usuario' class='label'>
                        Seleccione Beneficiario
                    </label>
                    </div>
                    <div class='form-inline col-8'>
                        <i class='fa fa-id-card position-absolute text-blue-d1 px-3'></i>
                        <input type='text' id='id_de_usuario' class='form-control form-control-lg px-475 border-info' placeholder='digite la c&eacute;dula o ID' list='lista_de_usuarios'>
                    </div>
                    ".self::generar_datalist_de_usuarios()."
                </div>
                <div class='form-group form-row'>
                    <div class='form-inline col-4'>
                        <label for='enfermedad_preexistente' class='label'>
                        ¿Existe una enfermedad pre existente?
                    </label>
                    </div>
                    <div class='form-inline col-8'>
                        <textarea class=\"form-control border-info\" maxlength=\"50\" placeholder=\"50 caracteres m&aacute;ximo\" id='enfermedad_preexistente' rows='4' cols='30'></textarea>
                    </div>
                </div>       
                
                <div class='form-group form-row'>
                    <div class='form-inline col-4'>
                        <label for='tipo_de_reembolso' class='label'>
                        Tipo de reembolso
                    </label>
                    </div>
                    <div class='form-inline col-8'>
                        <i class='fa fa-money-check position-absolute text-blue-d1 px-3'></i>
                        <select id='tipo_de_reembolso' class='form-control form-control-lg px-475 border-info text-75'>
                            <option value='0'>SELECCIONE TIPO DE REEMBOLSO</option>
                            <option value='1'>NORMAL</option>
                            <option value='2'>CR&Eacute;DITO HOSPITALARIO</option>
                            <option value='3'>COORDINACI&Oacute;N DE BENEFICIO</option>
                        </select>
                    </div> 
                </div>
                
                <div class='form-group form-row'>
                    <div class='form-inline col-4'>
                        <label for='grupo_de_cie' class='label'>
                            Grupo de CIE 10
                        </label>
                    </div>
                    <div class='form-inline col-8'>
                        <i class='fa fa-list-alt position-absolute text-blue-d1 px-3'></i>
                        ".self::generar_lista_de_grupos_de_cie10()."
                    </div> 
                </div>
                <div class='form-group form-row' >
                    <div class='form-inline col-4'>
                        <label for='cie10' class='label'>
                            Enfermedad / CIE 10
                        </label>
                    </div>
                    <div class='form-inline col-8' id='div_lista_de_cie10'></div>
                </div>
        </div>
        <div class='card-footer justify-content-center'>
            <input type='button' class='btn btn-outline-info btn-a-b2' value='Generar reembolso' onclick='generar_nuevo_reembolso()'>
        </div>
                 
        ";
        echo $this->formulario_nuevo_reembolso;
    }

    function generar_nuevo_reembolso($id_de_administrador,$numero_de_documento,$id_de_usuario,$enfermedad_preexistente,$tipo_de_reembolso,$codigo_de_grupo_de_cie,$cie10)
    {
        $this->id_de_administrador = $id_de_administrador;
        $this->numero_de_documento = $numero_de_documento;
        $this->id_de_usuario = $id_de_usuario;
        $this->enfermedad_preexistente = utf8_encode($enfermedad_preexistente);
        $this->tipo_de_reembolso = $tipo_de_reembolso;
        $this->codigo_de_grupo_de_cie = $codigo_de_grupo_de_cie;
        $this->cie10 = $cie10;
        $this->beneficiario = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$this->id_de_usuario]);

        if(Conexion::conect()->insert('encabezado_de_reembolso',[
            'numero_de_documento'=>$this->numero_de_documento,
            'enfermedad_preexistente'=>$this->enfermedad_preexistente,
            'fecha_de_ingreso'=>date('Y-m-d'),
            'tipo_de_reembolso'=>$this->tipo_de_reembolso,
            'numero_de_id_de_usuario_fk'=>$this->id_de_usuario,
            'codigo_de_cie'=>$this->cie10,
            'estado_de_reclamo'=>1,
            'periodo'=>date('Y')
        ])){
                Historial::nueva_actividad($this->id_de_administrador,'REEMBOLSOS Y RECLAMOS','NUEVO REEMBOLSO GENERADO POR ESTE ADMINISTRADOR :'.$this->numero_de_documento);
                $this->mail = new Mailer();
                $this->mail->enviar_correo(ADMIN_MAIL,ADMIN_NAME,$this->beneficiario['email'],utf8_decode($this->beneficiario['nombres']),'NUEVO REEMBOLSO O RECLAMO INGRESADO',"<p>Se ha generado un nuevo reclamo o reembolso, para referencia del mismo, guarde el siguiente codigo</p>
<p><h4>".$this->numero_de_documento."</h4></p>
<p><b>Beneficiario : </b> ".utf8_decode($this->beneficiario['apellidos'])." ".utf8_decode($this->beneficiario['nombres'])."</p>
<p>Cualquer inquietud o novedad, responda a este correo.</p>");
                echo "Swal.fire({
                icon: 'success',
                title: 'Reembolso ingresado',
                text: 'Reembolso generado con exito',
                allowOutsideClick : false,
                allowEscapeKey : false,
                showConfirmButton : true
            });
            generar_formulario_de_detalles_de_reembolso('".$this->numero_de_documento."')";
        }
        else{
            echo "Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Se ha generado un error, comuniquese con Soporte.',
                allowOutsideClick : false,
                allowEscapeKey : false,
                showConfirmButton : true
            });";
        }
    }

    //ESTA FUNCION GENERA TODA LA FUNCIONALIDAD DEL FORMULARIO, ENCABEZADO Y DETALLES Y EL TIPO DE
    //FORMULARIO, ASI COMO SI ES POSIBLE EDITARLO O NO
    function generar_formulario_de_detalles_de_reembolso($numero_de_documento)
    {
        $this->numero_de_documento = $numero_de_documento;
        $this->data_reembolso = Conexion::conect()->get('encabezado_de_reembolso','*',['numero_de_documento'=>$this->numero_de_documento]);
        $this->data_de_usuario =Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$this->data_reembolso['numero_de_id_de_usuario_fk']]);
        $this->estado_de_reembolso = $this->data_reembolso['estado_de_reclamo'];
        $this->data_de_cie = Conexion::conect()->get('cie','*',['codigo_de_cie'=>$this->data_reembolso['codigo_de_cie']]);

        if($this->estado_de_reembolso == 1)
        {
            $this->etq_estado = "<span class=\"badge badge-warning\">Reembolso generado</span>
                                 <select id='operaciones_de_reembolso' class='ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3 brc-default-m3 brc-h-warning-m1 text-80' onchange='generar_nuevo_estado_de_reembolso(this.value,\"".$this->numero_de_documento."\")'>
                                        <option value='0'>Seleccione una acci&oacute;n</option>            
                                        <option value='2'>Procesar reembolso</option>
                                        <option value='3'>Rechazar reembolso</option>
                                 </select>   
                                ";
        }
        elseif ($this->estado_de_reembolso == 2)
        {
            $this->etq_estado = "<span class=\"badge badge-success\">Reembolso procesado</span>
                                <select id='operaciones_de_reembolso' class='ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3 brc-default-m3 brc-h-warning-m1 text-80' onchange='generar_nuevo_estado_de_reembolso(this.value,\"".$this->numero_de_documento."\")'>
                                        <option value='0'>Seleccione una acci&oacute;n</option>     
                                        <option value='4'>Entregar reembolso</option>
                                 </select>   ";
        }
        elseif($this->estado_de_reembolso == 3)
        {
            $this->etq_estado = "<span class=\"badge badge-danger\">Reembolso rechazado</span>";
        }
        elseif ($this->estado_de_reembolso == 4)
        {
            $this->etq_estado = "<span class=\"badge badge-primary\">Reembolso entregado </span>";
        }
        $this->encabezado_de_reembolso .="<div class='row'>
            <div class=\"col-12 cards-container text-90\" id=\"card-container-2\">
                  <div class=\"card border-0 shadow-sm radius-0\" id=\"card-2\" draggable=\"false\">
                    <div class=\"card-header bgc-primary-d1\">
                      <h5 class=\"card-title text-white\">
                        <i class=\"fa fa-table mr-2px\"></i>
                        N&uacute;mero de reembolso :  ".$this->numero_de_documento." 
                      </h5>
                      <span><a class='btn btn-orange rounded-circle' onclick='generar_reporte_de_reembolso(\"".$this->numero_de_documento."\")'><i class='text-white fa fa-print'></i></a></span>
                    </div>

                    <div class=\"card-body bgc-transparent p-0 border-1 brc-primary-m3 border-t-0\">
                      <table class=\"table table-striped table-hover mb-0 text-danger\">
                        <thead class=\"text-dark-l2 text-95\">
                          <tr>
                            <th>
                              <i class=\"far fa-calendar text-blue mr-1px\"></i>
                              Fecha
                            </th>

                            <th>
                              <i class=\"fa fa-user text-orange-d1 mr-1px\"></i>
                              Beneficiario
                            </th>
                            <th class=\"d-none d-lg-table-cell mr-1px\">
                            <i class=\"fa fa-hospital text-blue-d1 mr-1px\"></i>
                              Enfermedad / CIE10
                            </th>
                            
                            <th class=\"d-none d-lg-table-cell mr-1px\">
                            <i class=\"fa fa-user text-orange-d1 mr-1px\"></i>
                              Estado de reembolso
                            </th>
                            
                          </tr>
                          
                        </thead>

                        <tbody>
                          <tr>
                            <td class=\"text-dark-m2\">".$this->data_reembolso['fecha_de_ingreso']."</td>
                            <td>
                              <a href=\"#\" class=\"text-primary-d2\" draggable=\"false\">".utf8_decode($this->data_de_usuario['apellidos'])." ".utf8_decode($this->data_de_usuario['nombres'])."</a>
    </td>
                            <td>
                                ".$this->data_reembolso['codigo_de_cie']." " .utf8_decode($this->data_de_cie['nombre_de_cie'])."
                            </td>
                            <td class=\"d-none d-lg-table-cell\">
                                    ".$this->etq_estado."
                            </td>
                            
                          </tr>
                          
                        </tbody>
                      </table>
                    </div><!-- /.card-body -->
                    <div class='card-footer'>
                        <h4 class='text-orange'> Saldo a la fecha : $ ".MovimientoDeUsuario::retornar_saldo_de_usuario($this->data_de_usuario['numero_de_id_de_usuario'])."</h4>
                    </div>
                  </div><!-- /.card -->
                </div>
                
        </div>";

        //AQUI VA LOS DETALLES DE EL REEMBOLSO ASI COMO INFORMACION DEL ESTADO

        $this->encabezado_de_reembolso.="<div class=\"col-12 cards-container\" id=\"card-container-2\">";
            $this->encabezado_de_reembolso.="<div class=\"card-header bgc-secondary-l3 justify-content-center text-center\">
                      <h5 class=\"card-title text-blue-d1\">
                        <i class=\"fa fa-list mr-2px\"></i>
                        Detalles de reclamo
                      </h5>
                      ".$this->verificar_estado_de_reembolso_y_si_es_posible_editarlo($this->numero_de_documento,$this->estado_de_reembolso)."
                    </div>
                    <div class=\"card-body bgc-transparent p-0 border-1 brc-primary-m3 border-t-0\" id='div_detalles_de_reembolso'>
                    
                    </div>";
        $this->encabezado_de_reembolso.="</div>";
        //FINAL DEL DETALLE DE LOS REEMBOLSOS

        echo $this->encabezado_de_reembolso;
    }
    //FUNCION QUE GENERA LA LISTA DE REEMBOLOS EN LA PAGINA PRINCIPAL
    function generar_lista_de_reembolsos($filtro)
    {
        $this->filtro = $filtro;
        if(($this->filtro == '*')||($this->filtro == '')||($this->filtro == ' '))
        {
            $this->data = Conexion::conect()->select('encabezado_de_reembolso','*',['periodo'=>date('Y')],['ORDER'=>'numero_de_id_de_usuario_fk']);
        }
        else
        {
            $this->data = Conexion::conect()->select('encabezado_de_reembolso','*',['numero_de_id_de_usuario_fk[~]'=>$this->filtro]);
        }
        $this->lista_de_reembolsos.="<div class=\"card acard text-80\">
                                              <div class=\"card-header border-0\">
                                                <h5 class=\"text-info-d2 mb-0\">
                                                    Lista de cr&eacute;ditos y reembolsos
                                                </h5>
                                              </div>
                                              <div class=\"card-body p-0\">
                                                <div class=\"table-responsive-md\">
                                                  <table class=\"table table-bordered border-0	table-striped-secondary text-dark-m1 mb-0\">
                                                    <thead>
                                                      <tr class=\"bgc-info text-white brc-black-tp10\">
                                                        <th>N&uacute;mero de documento</th>
                                                        <th>Fecha de ingreso</th>
                                                        <th>Beneficiario</th>
                                                        <th>Apellidos y Nombres</th>
                                                        <th>Estado</th>
                                                        <th></th>
                                                      </tr>
                                                    
                                                    </thead>
                                                        
                                                    <tbody>";
        foreach ($this->data as $this->data_reembolso)
        {
            $this->estado_de_reembolso = $this->data_reembolso['estado_de_reclamo'];
            if($this->estado_de_reembolso == 1)
            {
                $this->etq_estado = "<span class=\"badge badge-warning\">Reembolso generado</span>";
            }
            elseif ($this->estado_de_reembolso == 2)
            {
                $this->etq_estado = "<span class=\"badge badge-success\">Reembolso procesado</span>";
            }
            elseif($this->estado_de_reembolso == 3)
            {
                $this->etq_estado = "<span class=\"badge badge-danger\">Reembolso rechazado</span>";
            }
            elseif ($this->estado_de_reembolso == 4)
            {
                $this->etq_estado = "<span class=\"badge badge-primary\">Reembolso entregado </span>";
            }
            $this->data_de_usuario = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$this->data_reembolso['numero_de_id_de_usuario_fk']]);
            $this->lista_de_reembolsos.="<tr>
                            <td>".$this->data_reembolso['numero_de_documento']."</td>
                            <td>".$this->data_reembolso['fecha_de_ingreso']."</td>
                            <td>".$this->data_reembolso['numero_de_id_de_usuario_fk']."</td>
                            <td>".utf8_decode($this->data_de_usuario['apellidos'])." ".utf8_decode($this->data_de_usuario['nombres'])."</td>
                            <td>".$this->etq_estado."</td>
                            <td><a  class='btn btn-lighter-info btn-sm' onclick=\"generar_formulario_de_detalles_de_reembolso('".$this->data_reembolso['numero_de_documento']."')\"><i class='fa fa-folder-open'></i></a></td>
                          </tr>";
        }
        $this->lista_de_reembolsos.="</tbody>
                      </table>
                    </div>
                  </div>
                </div>";

        echo $this->lista_de_reembolsos;
    }
    //ESTA FUNCION VERIFICA EL ESTADO DE UN REEMBOLSO, SI ES EDITABLE, REDIRECCIONA AL FORMULARIO CORRESPONDIENTE
    function verificar_estado_de_reembolso_y_si_es_posible_editarlo($numero_de_documento,$estado_de_reembolso)
    {
        /*
         * ESTADOS DE RECLAMO :
         * 1. RECLAMO GENERADO
         * 2. RECLAMO PROCESADO
         * 3. RECLAMO RECHAZADO
         * 4. RECLAMO ENTREGADO AL SOLICITANTE
         * */
        $this->numero_de_documento = $numero_de_documento;
        $this->estado_de_reembolso = $estado_de_reembolso;

        if($this->estado_de_reembolso=='1')
        {
            //SI EL PROCESO ESTÁ ABIERTO GENERAR EL RESPECTIVO FORMULARIO
            $this->formulario_de_detalle_de_reembolsos = $this->generador_de_formulario($this->numero_de_documento);
        }
        else
        {
            //SI EL PROCESO YA ESTÁ CERRADO, PROGRAMAR AQUI!!! LOS OTROS ESTADOS

        }
        return $this->formulario_de_detalle_de_reembolsos;
    }

    //ESTA FUNCION GENERA LOS FORMULARIOS SEGUN EL TIPO DE REEMBOLSO, PLASMAR AQUI LA IMPLEMENTACION DE LOS OTROS FORMULARIOS
    function generador_de_formulario($numero_de_documento)
    {
        $this->informacion_de_encabezado=Conexion::conect()->get('encabezado_de_reembolso','*',['numero_de_documento'=>$numero_de_documento]);
        $this->tipo_de_reembolso = $this->informacion_de_encabezado['tipo_de_reembolso'];
        //VERIFICAR SI EL SALDO NO ES CERO PARA PROSEGUIR CON EL REEMBOLSO
        $this->saldo_de_usuario = MovimientoDeUsuario::retornar_saldo_de_usuario($this->informacion_de_encabezado['numero_de_id_de_usuario_fk']);
        if($this->saldo_de_usuario>0)
        {
            //AQUI PROGRAMAR L LA FUNCIONALIDAD DE LOS ESTADOS Y  FORMULARIOS

            //1. FORMULARIO PARA REEMBOLSO TIPO NORMAL
            if($this->tipo_de_reembolso=='1')
            {
                $this->formulario_de_reembolso.="<a data-fancybox data-type=\"ajax\" href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-success btn-h-lighter-success btn-a-lighter-primary\" data-src=\"controllers/formulario1_generar_nuevo_renglon_de_item.ctrl.php?numero_de_documento=".$numero_de_documento."\" href=\"javascript:;\">
        <i class=\"fa fa-plus text-primary-l1\"></i>Agregar item</a>";
            }
            //3. FORMULARIO PARA REEMBOLSO COORDINACION DE BENEFICIOS
            if($this->tipo_de_reembolso=='3')
            {
                $this->formulario_de_reembolso.="<a data-fancybox data-type=\"ajax\" href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-success btn-h-lighter-success btn-a-lighter-primary\" data-src=\"controllers/formulario3_generar_formulario_de_beneficio.ctrl.php?numero_de_documento=".$numero_de_documento."\" href=\"javascript:;\">
        <i class=\"fa fa-paperclip text-primary-l1\"></i> Agregar detalle de beneficio</a>";

            }



        }
        else
        {
            $this->formulario_de_reembolso.="<div role=\"alert\" class=\"alert alert-warning bgc-warning-l4 brc-warning-m3 border-2 d-flex align-items-center text-80\">
                      <i class=\"fas fa-exclamation-circle mr-3 fa-2x text-orange\"></i>

                      <div class=\"text-dark-tp2\">
                        Saldo no disponible para realizar peticiones de reembolo
                        
                    </div>";
        }

        return $this->formulario_de_reembolso;

    }
    //FUNCION QUE GENERA UN NUEVO RENGLON DE ITEM PARA AGREGAR AL FORMULARIO 1  DE TIPO NORMAL
    function agregar_item_formulario_1($numero_de_documento)
    {
        $this->numero_de_documento = $numero_de_documento;
        $this->encabezado = Conexion::conect()->get('encabezado_de_reembolso','*',['numero_de_documento'=>$this->numero_de_documento]);
        $this->item_formulario_1 = "<div class='card-main'>
                                    <form class='form'>
                                       <input type='hidden' id='numero_de_documento' value=\"".$this->numero_de_documento."\">
                                       <input type='hidden' id='indice_de_reembolso' value=\"".$this->encabezado['indice_de_reembolso']."\">
                                        <div class='row form-group'>
                                           <div class='col-7'><label for='numero_de_factura' class='text-blue-d1'>N&uacute;mero de factura </label></div>
                                            <div class='col-4'>
                                                <input type='number' class='form-control text-90' id='numero_de_factura' min='1'>
                                            </div>
                                        </div>    
                                        <div class='row form-group'>
                                           <div class='col-7'><label for='fecha_de_factura' class='text-blue-d1'>Fecha de factura </label></div>
                                            <div class='col-4'>
                                                <input type='date' class='form-control text-90' id='fecha_de_factura'>
                                            </div>
                                        </div> 
                                        <div class='row form-group'>
                                            <div class='col-7'><label for='indice_de_establecimiento' class='text-blue-d1'>Cl&iacute;nica o Establecimiento </label></div>
                                            <div class='col-5'>
                                                ".self::generar_lista_de_establecimientos()."
                                            </div>
                                        </div>
                                        <div class='row form-group'>
                                            <div class='col-5'><label for='porcentaje' class='text-blue-d1'>Servicio</label></div>
                                            <div class='col-7'>
                                                ".self::generar_lista_de_servicios_medicos()."
                                            </div>
                                        </div>   
                                        <section id='seccion_de_valores'>
                                        
                                        </section>
                                        
                                    </form></div>";
        echo $this->item_formulario_1;
    }
    //FUNCION QUE GENERA EL FORMULARIO DE REEMBOLSO PARA COORDINACION DE BENEFICIOS TIPO 3
    function agregar_reembolso_formulario_3($numero_de_documento)
    {
        $this->numero_de_documento = $numero_de_documento;
        $this->encabezado = Conexion::conect()->get('encabezado_de_reembolso','*',['numero_de_documento'=>$this->numero_de_documento]);
        $this->item_formulario_1 = "<div class='card-main'>
                                    <form class='form'>
                                       <input type='hidden' id='numero_de_documento' value=\"".$this->numero_de_documento."\">
                                       <input type='hidden' id='indice_de_reembolso' value=\"".$this->encabezado['indice_de_reembolso']."\">
                                        <div class='row form-group'>
                                           <div class='col-5'><label for='numero_de_factura' class='text-blue-d1'>N&uacute;mero de factura </label></div>
                                            <div class='col-7'>
                                                <input type='number' class='form-control text-90' id='numero_de_factura' min='1'>
                                            </div>
                                        </div>    
                                        <div class='row form-group'>
                                           <div class='col-5'><label for='fecha_de_factura' class='text-blue-d1'>Fecha de factura </label></div>
                                            <div class='col-7'>
                                                <input type='date' class='form-control text-90' id='fecha_de_factura'>
                                            </div>
                                        </div> 
                                        <div class='row form-group'>
                                            <div class='col-5'><label for='indice_de_servicio_medico' class='text-blue-d1'>Servicio </label></div>
                                            <div class='col-7'>
                                               ".self::generar_lista_de_servicios_especiales()."
                                            </div>
                                        </div>
                                        <div class='row form-group'>
                                            <div class='col-5'><label for='valor_de_cobertura' class='text-blue-d1'>Valor de cobertura $</label></div>
                                            <div class='col-7'>
                                               <input type='number' min='1' id='valor_de_cobertura' class='form-control text-90'>
                                            </div>
                                        </div>   
                                        <div class='row form-group'>
                                            <div class='col-12'>
                                                <input type='button' class='btn btn-block btn-light-blue' value='Guardar' onclick=\"form3_guardar_reembolso()\"></div>
                                            </div>
                                        </div>
                                      
                                    </form></div>";
        echo $this->item_formulario_1;
    }

    //FUNCION QUE GENERA UNA LISTA DE CLINICAS Y ESTABLECIMIENTOS
    static function  generar_lista_de_establecimientos()
    {
        $data_de_establecimientos = Conexion::conect()->select('establecimiento_con_convenio','*',['ORDER'=>'convenio_vigente']);
        $lista_de_establecimientos='';
        $lista_de_establecimientos.="<select class='form-control text-80' id='indice_de_establecimiento' onchange='f1_generar_campo_de_descuento()'>";
        $lista_de_establecimientos.="<option value='0'>Seleccionar</option>";
            foreach ($data_de_establecimientos as $establecimiento)
            {
                if($establecimiento['convenio_vigente']=='1')
                {
                    $etq_convenio = 'SI';
                }
                else
                {
                    $etq_convenio = 'NO';
                }
                $lista_de_establecimientos.="<option value=\"".$establecimiento['indice_de_establecimiento']."\">".utf8_decode($establecimiento['nombre_de_establecimiento'])." ¿ Tiene Convenio ? :".$etq_convenio."</option>";
            }
        $lista_de_establecimientos.="</select>";
        return $lista_de_establecimientos;
    }

    //FUNCION QUE GENERA UNA LISTA DE SERVICIOS MEDICOS
    static function generar_lista_de_servicios_medicos()
    {
        $data_servicio_medico = Conexion::conect()->select('servicios_medicos','*',['ORDER'=>'servicio_medico']);
        $lista_de_servicios_medicos="";
        $lista_de_servicios_medicos.="<select class='form-control text-90' id='indice_de_servicio_medico' onchange='f1_generar_campo_de_descuento()'>";
            $lista_de_servicios_medicos.="<option value='0'>Seleccionar</option>";
            foreach ($data_servicio_medico as $servicio_medico)
            {
                $lista_de_servicios_medicos.="<option value=\"".$servicio_medico['indice_de_servicio_medico']."\">".utf8_decode($servicio_medico['servicio_medico'])."</option>";
            }
        $lista_de_servicios_medicos.="</select>";
        return $lista_de_servicios_medicos;
    }

    //FUNCION QUE GENERA EL INPUT DE DESCUENTO SEGUN ESTABLECIMIENTO Y SERVICIO

    static function generar_input_de_descuento($id_de_establecimiento,$id_de_servicio_medico)
    {
        $establecimiento = Conexion::conect()->get('establecimiento_con_convenio','*',['indice_de_establecimiento'=>$id_de_establecimiento]);
        $input='';
        $servicio_medico = Conexion::conect()->get('servicios_medicos','*',["AND"=>['indice_de_servicio_medico'=>$id_de_servicio_medico,'periodo'=>date('Y')]]);
        $op=$servicio_medico['tipo_de_valor'];
        if($op==2)
        {
            $etq_tipo_valor = 'Porcentaje %';
        }
        elseif ($op==1)
        {
            $etq_tipo_valor = 'D&oacute;lares $';

        }
        else
        {
            $etq_tipo_valor = 'D&iacute;a / s';
        }
        $input.= "    <input type='hidden' id='tipo_de_operacion' value=\"".$op."\">
                    <div class='row form-group'><div class='col-5'><label for='valor_de_calculo' class='text-blue-d1'>".utf8_decode($etq_tipo_valor)."</label></div>";
        if($establecimiento['convenio_vigente']==1)
        {
            $valor = $servicio_medico['valor_dentro_de_cobertura'];
        }
        else
        {
            $valor = $servicio_medico['valor_fuera_de_cobertura'];
        }
        $input.="<div class='col-7'><input type='number' class='form-control text-90' id='valor_de_calculo' value=\"".$valor."\"></div></div>";
        $input.="<div class='row form-group'>
                    <div class='col-7'><label for='subtotal' class='text-blue-d1'>Subtotal $</label></div>
                    <div class='col-5'><input type='number' min='1' class='form-control text-90' id='subtotal'></div>
                </div>";
        $input.="<div class='row form-group'>
                    <div class='col-7'><label for='valor_no_cubierto' class='text-blue-d1'>Valor no cubierto $</label></div>
                    <div class='col-5'><input type='number' min='1' class='form-control text-90' id='valor_no_cubierto'></div>
                </div>";
        $input.="<div class='row form-group'>
                    <div class='col-7'>
                    <input type='button' class='btn btn-block btn-light-blue' value='Guardar' onclick=\"form1_guardar_nuevo_detalle_de_reembolso()\"></div>
                    
                </div>";

        echo $input;
    }
    //FUNCION QUE AGREGA UN DETALLE DE REEMBOLSO PARA REEMBOLSOS NORMALES
    static function formulario1_agregar_nuevo_detalle_de_reembolso($id_de_usuario,$numero_de_documento,$indice_de_reembolso,$numero_de_factura,$fecha_de_factura,$indice_de_establecimiento,$indice_de_servicio_medico,$valor_de_calculo,$subtotal,$valor_no_cubierto,$tipo_de_operacion)
    {
        $saldo_a_cubrir = $subtotal - $valor_no_cubierto;

        //OPERACION PARA PORCENTAJES
        if($tipo_de_operacion==2)
        {
            $valor_copago = round(($saldo_a_cubrir - ($saldo_a_cubrir*($valor_de_calculo/100))),2);
        }
        //OPERACON PARA VALOR EN DOLARES
        elseif($tipo_de_operacion==1)
        {
            $valor_copago = $saldo_a_cubrir - $valor_de_calculo;
        }
        else
        {
            $valor_copago = 0;
        }

        //EVALUAR SI EL SALDO ES SUFICIENTE PARA LA OPERACION DE REEMBOLSO
        $datos_de_encabezado_de_reembolso= Conexion::conect()->get('encabezado_de_reembolso','*',['indice_de_reembolso'=>$indice_de_reembolso]);
        $saldo_de_usuario = MovimientoDeUsuario::retornar_saldo_de_usuario($datos_de_encabezado_de_reembolso['numero_de_id_de_usuario_fk']);
        if($saldo_de_usuario>=$saldo_a_cubrir)
        {
            if(Conexion::conect()->insert('detalles_de_reembolso',[
                'indice_de_reembolso_fk'=>$indice_de_reembolso,
                'numero_de_factura' =>$numero_de_factura,
                'indice_de_establecimiento_fk'=>$indice_de_establecimiento,
                'indice_de_servicio_medico_fk'=>$indice_de_servicio_medico,
                'fecha_de_factura'=>$fecha_de_factura,
                'subtotal'=>$subtotal,
                'valor_no_cubierto'=>$valor_no_cubierto,
                'valor_cubierto'=>$subtotal-$valor_no_cubierto,
                'valor_copago'=>$valor_copago
            ])){
                Historial::nueva_actividad($id_de_usuario,'REEMBOLSOS','registro de nuevo detalle al reembolso '.$numero_de_documento);
                MovimientoDeUsuario::nuevo_movimiento($datos_de_encabezado_de_reembolso['numero_de_id_de_usuario_fk'],'NUEVA FACTURA AGREGADA A REEMBOLSO',$numero_de_factura,0,$saldo_a_cubrir);

                echo "$(\"form\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Detalle registrado</h3>Factura o detalle registrado exitosamente .</div>\")";
            }
            else
            {
                echo "$(\"form\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Detalle no registrado</h3>Error al registrar detalle</div>\")";
            }
        }
        else
        {
            echo "$(\"form\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Detalle no registrado</h3>saldo insuficiente para realizar esta operacion </div>\")";
        }
    }

    //FUNCION QUE AGREGA UN DETALLE DE REEMBOLSO PARA REEMBOLSOS POR COORDINACION
    static function formulario3_agregar_nuevo_detalle_de_reembolso($id_de_usuario,$numero_de_documento,$indice_de_reembolso,$numero_de_factura,$fecha_de_factura,$indice_de_servicio_medico,$valor_de_cobertura)
    {
        $saldo_a_cubrir = $valor_de_cobertura;
        $valor_copago = 0;

        //EVALUAR SI EL SALDO ES SUFICIENTE PARA LA OPERACION DE REEMBOLSO
        $datos_de_encabezado_de_reembolso= Conexion::conect()->get('encabezado_de_reembolso','*',['indice_de_reembolso'=>$indice_de_reembolso]);
        $saldo_de_usuario = MovimientoDeUsuario::retornar_saldo_de_usuario($datos_de_encabezado_de_reembolso['numero_de_id_de_usuario_fk']);
        if($saldo_de_usuario>=$saldo_a_cubrir)
        {
            if(Conexion::conect()->insert('detalles_de_reembolso',[
                'indice_de_reembolso_fk'=>$indice_de_reembolso,
                'numero_de_factura' =>$numero_de_factura,
                'indice_de_establecimiento_fk'=>1,
                'indice_de_servicio_medico_fk'=>$indice_de_servicio_medico,
                'fecha_de_factura'=>$fecha_de_factura,
                'subtotal'=>0,
                'valor_no_cubierto'=>0,
                'valor_cubierto'=>$saldo_a_cubrir,
                'valor_copago'=>$valor_copago,

            ])){
                Historial::nueva_actividad($id_de_usuario,'REEMBOLSOS','registro de nuevo detalle al reembolso '.$numero_de_documento);
                MovimientoDeUsuario::nuevo_movimiento($datos_de_encabezado_de_reembolso['numero_de_id_de_usuario_fk'],'NUEVO REEMBOLSO POR COORDINACION ',$numero_de_factura,0,$saldo_a_cubrir);

                echo "$(\"form\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Detalle registrado</h3>Factura o detalle registrado exitosamente .</div>\")";
            }
            else
            {
                echo "$(\"form\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Detalle no registrado</h3>Error al registrar detalle</div>\")";
            }
        }
        else
        {
            echo "$(\"form\").html(\"<div class=\'text-dark-tp3\'><h3 class=\'text-success-d1 text-130\'>Detalle no registrado</h3>saldo insuficiente para realizar esta operacion </div>\")";
        }
    }

    static function generar_lista_de_detalles_de_reembolso($numero_de_documento)
    {
        $encabezado=Conexion::conect()->get('encabezado_de_reembolso','*',['numero_de_documento'=>$numero_de_documento]);
        $tabla_de_detalles='';
        $indice_de_reembolso = $encabezado['indice_de_reembolso'];
        $data_detalle_de_reembolso=Conexion::conect()->select('detalles_de_reembolso','*',['indice_de_reembolso_fk'=>$indice_de_reembolso]);
        $tabla_de_detalles.="<table class=\"table table-striped table-bordered table-hover brc-black-tp10 mb-0 text-grey text-90\">
                        <thead class=\"brc-transparent\">
                          <tr class=\"bgc-green-d2 text-white\">
                            <th>
                                    N&uacute;mero de Factura
                            </th>
                            <th>
                                    Fecha de factura
                            </th>
                            <th>        
                                    Subtotal
                            </th>
                             <th>        
                                    Valor no cubierto
                            </th>
                            <th>
                                <b>Valor cubierto</b>
                            </th>
                             <th>        
                                    Copago
                            </th>
                            <th></th>
                          </tr>
                        </thead>

                        <tbody>";
                        foreach ($data_detalle_de_reembolso as $reembolso)
                        {
                            $tabla_de_detalles.="<tr class=\"bgc-h-yellow-l3\">
                            <td class=\"text-600 text-dark\">
                                ".$reembolso['numero_de_factura']."
                            </td>
                            <td class=\"text-info-m1\">
                                ".$reembolso['fecha_de_factura']."
                            </td>
                            <td class='text-success-d2'>
                                $ ".$reembolso['subtotal']."   
                            </td>
                            <td class='text-success-d2'>
                                $ ".$reembolso['valor_no_cubierto']."   
                            </td>
                            <td class='text-primary-d2'>
                                $ ".$reembolso['valor_cubierto']."   
                            </td>
                            <td class='text-success-d2'>
                                $ ".$reembolso['valor_copago']."   
                            </td>
                            <td class=\"text-center\">
                              <a  class=\"btn btn-sm btn-red radius-round border-0 px-4\" onclick='eliminar_detalle_de_reembolso(".$reembolso['indice_de_detalle'].")'>
                                <i class='fa fa-trash text-white'></i>
                                </a>
                            </td>
                          </tr>
                            ";
                        }
        $tabla_de_detalles.="</tbody>
                      </table>";
        echo $tabla_de_detalles;
    }

    //FUNCION QUE ELIMINA UN DETALLE DE REEMBOLSO
    static function eliminar_detalle_de_reembolso($usuario,$indice_de_detalle)
    {
        $detalle = Conexion::conect()->get('detalles_de_reembolso','*',['indice_de_detalle'=>$indice_de_detalle]);

        $reembolso = Conexion::conect()->get('encabezado_de_reembolso','*',['indice_de_reembolso'=>$detalle['indice_de_reembolso_fk']]);
        $valor_de_retorno = $detalle['subtotal']-$detalle['valor_no_cubierto'];
        if($reembolso['estado_de_reclamo']==1)
        {
            if(Conexion::conect()->delete('detalles_de_reembolso',['indice_de_detalle'=>$indice_de_detalle]))
            {
                Historial::nueva_actividad($usuario,'DETALLES DE REEMBOLSO','SE ELIMINA UN ITEM AL REEMBOLSO :'.$reembolso['numero_de_documento']);
                MovimientoDeUsuario::nuevo_movimiento($reembolso['numero_de_id_de_usuario_fk'],'SALDO REVERTIDO POR ELIMINACION DE FACTURA',$detalle['numero_de_factura'],$valor_de_retorno,0);

                echo "generar_formulario_de_detalles_de_reembolso('".$reembolso['numero_de_documento']."')";
            }
        }
        else
        {
            echo "Swal.fire({
                            icon: 'error',
                            title: 'Error al borrar',
                            text: 'No se puede eliminar una factura de un reembolso ya procesado',
                            allowOutsideClick : false,
                            allowEscapeKey : false,
                            showConfirmButton : true
                        });";
        }

    }

    //FUNCION QUE PROCESA UN REEMBOLSO
    static function generar_nuevo_estado_de_reembolso($opcion,$numero_de_documento)
    {
        //RECUPERAR DATOS DE ENCABEZADO
        $encabezado=Conexion::conect()->get('encabezado_de_reembolso','*',['numero_de_documento'=>$numero_de_documento]);

        //RECUPERAR DETALLES DE REEMBOLSO
        $detalles_de_reembolso = Conexion::conect()->select('detalles_de_reembolso','*',['indice_de_reembolso_fk'=>$encabezado['indice_de_reembolso']]);
        $sumatoria_subtotal = 0;
        $sumatoria_valor_no_cubierto = 0;
        $sumatoria_valor_cubierto = 0;
        $sumatoria_valor_copago = 0;
        $numero_de_documento=$encabezado['numero_de_documento'];
        
        switch ($opcion){
            case 2:
                $recurrencia=Conexion::conect()->count('encabezado_de_reembolso',['AND'=>['periodo'=>date('Y'),'numero_de_id_de_usuario_fk'=>$encabezado['numero_de_id_de_usuario_fk'],'codigo_de_cie'=>$encabezado['codigo_de_cie']]]);
               
                if($recurrencia==1)
                {
                    if($encabezado['tipo_de_reembolso']=='1')
                    {
                        $deducible = 20;
                    }
                    else
                    {
                        $deducible =0;
                    }

                }
                else{
                    $deducible = 0;
                }
                foreach ($detalles_de_reembolso as $item)
                {
                    $sumatoria_subtotal = $sumatoria_subtotal + $item['subtotal'];
                    $sumatoria_valor_no_cubierto = $sumatoria_valor_no_cubierto + $item['valor_no_cubierto'];
                    $sumatoria_valor_cubierto = $sumatoria_valor_cubierto + $item['valor_cubierto'];
                    $sumatoria_valor_copago = $sumatoria_valor_copago + $item['valor_copago'];
                }
                if(Conexion::conect()->update('encabezado_de_reembolso',[
                    'estado_de_reclamo'=>$opcion,
                    'valor_del_reclamo'=>$sumatoria_subtotal,
                    'deducible'=>$deducible,
                    'copago_1'=>$sumatoria_valor_copago,
                    'copago_2'=>0,
                    'valor_cubierto'=>$sumatoria_valor_cubierto,
                    'valor_no_cubierto'=>$sumatoria_valor_no_cubierto,
                    'total_de_reembolso'=>$sumatoria_valor_cubierto

                ],['indice_de_reembolso'=>$encabezado['indice_de_reembolso']])){
                    echo "Swal.fire({
                            icon: 'success',
                            title: 'Reembolso procesado',
                            text: 'Reembolso cerrado y procesado correctamente',
                            allowOutsideClick : false,
                            allowEscapeKey : false,
                            showConfirmButton : true
                        });
                        generar_reporte_de_reembolso(\"".$numero_de_documento."\");";
                }
                break;
        }
    }

    //FUNCION QUE GENERA UNA LISTA DE SERVICIOS ESPECIALES
    static function  generar_lista_de_servicios_especiales()
    {
        $data_servicios_especiales = Conexion::conect()->select('servicios_medicos_especiales','*',['ORDER'=>'servicio_medico']);
        $lista_de_servicios='';
        $lista_de_servicios.="<select class='form-control text-80' id='indice_de_servicio_medico'>";
        $lista_de_servicios.="<option value='0'>Seleccione</option>";
        foreach ($data_servicios_especiales as $servicio)
        {
            $lista_de_servicios.="<option value=\"".$servicio['indice_de_servicio_medico']."\">".utf8_decode($servicio['servicio_medico'])."</option>";
        }
        $lista_de_servicios.="</select>";
        return $lista_de_servicios;
    }
}
