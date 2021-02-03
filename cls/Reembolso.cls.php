<?php
date_default_timezone_set('America/Lima');
include_once 'Conexion.cls.php';
include_once 'Historial.cls.php';
include_once 'Mailer.cls.php';
include_once '../config.ini.php';
class Reembolso
{
    private $formulario_nuevo_reembolso,$data_reembolso,$beneficiario,$encabezado_de_reembolso,$data_de_usuario,$num_reembolsos,$id_de_usuario,$digitador,$mail,$etq_estado,$informacion_de_encabezado;
    private $id_de_administrador,$numero_de_documento,$enfermedad_preexistente,$tipo_de_reembolso,$codigo_de_grupo_de_cie,$cie10,$estado_de_reembolso,$formulario_de_reembolso;
    private $filtro,$data,$lista_de_reembolsos,$formulario_de_detalle_de_reembolsos;
    private $item_formulario_1,$data_de_establecimientos,$establecimiento,$lista_de_establecimientos;
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

    static function retornar_saldo_de_usuario($id_de_usuario)
    {
        $total_debe  = 0;
        $total_haber = 0;
        $saldo_total = 0;
        $datos_de_usuario = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$id_de_usuario]);
        if($datos_de_usuario['es_titular_de_cuenta'] ==1)
        {
            $datos_de_titular_de_cuenta = $datos_de_usuario;
        }
        else
        {
            $datos_de_titular_de_cuenta = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$datos_de_usuario['id_de_dependiente']]);
        }
        $movimientos_de_usuario = Conexion::conect()->select('movimientos_de_usuario','*',['AND'=>['periodo'=>date('Y'),'numero_de_id_de_usuario_fk'=>$datos_de_titular_de_cuenta['numero_de_id_de_usuario']]]);
        foreach ($movimientos_de_usuario as $movimientos)
        {
            $total_debe = $total_debe+$movimientos['debe'];
            $total_haber = $total_haber+$movimientos['haber'];
        }
        $saldo_total = $total_debe - $total_haber;
        return $saldo_total;
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

    //ESTA FUNCION GENERA TODA LA FUNCIONALIDAD DEL FORMULARIO, ENCABEZADO Y DETALLE SY EL TIPO DE
    //FORMULARIO, ASI COMO SI ES POSIBLE EDITARLO O NO
    function generar_formulario_de_detalles_de_reembolso($numero_de_documento)
    {
        $this->numero_de_documento = $numero_de_documento;
        $this->data_reembolso = Conexion::conect()->get('encabezado_de_reembolso','*',['numero_de_documento'=>$this->numero_de_documento]);
        $this->data_de_usuario =Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$this->data_reembolso['numero_de_id_de_usuario_fk']]);
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
        $this->encabezado_de_reembolso .="<div class='row'>
            <div class=\"col-12 cards-container\" id=\"card-container-2\">
                  <div class=\"card border-0 shadow-sm radius-0\" id=\"card-2\" draggable=\"false\">
                    <div class=\"card-header bgc-primary-d1\">
                      <h5 class=\"card-title text-white\">
                        <i class=\"fa fa-table mr-2px\"></i>
                        N&uacute;mero de reembolso :  ".$this->numero_de_documento." 
                      </h5>
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
                            <td class=\"d-none d-lg-table-cell\">
                                    ".$this->etq_estado."
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div><!-- /.card-body -->
                    <div class='card-footer'>
                        <h4 class='text-orange'> Saldo a la fecha : $ ".self::retornar_saldo_de_usuario($this->data_de_usuario['numero_de_id_de_usuario'])."</h4>
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
                    <div class=\"card-body bgc-transparent p-0 border-1 brc-primary-m3 border-t-0\" id='cuerpo_de_reembolso'>
                    
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
            //SI EL PROCESO YA ESTÁ CERRADO
        }
        return $this->formulario_de_detalle_de_reembolsos;
    }

    //ESTA FUNCION GENERA LOS FORMULARIOS SEGUN EL TIPO DE REEMBOLSO
    function generador_de_formulario($numero_de_documento)
    {
        $this->informacion_de_encabezado=Conexion::conect()->get('encabezado_de_reembolso','*',['numero_de_documento'=>$numero_de_documento]);
        $this->tipo_de_reembolso = $this->informacion_de_encabezado['tipo_de_reembolso'];
        //FORMULARIO PARA REEMBOLSO TIPO NORMAL
        if($this->tipo_de_reembolso=='1')
        {
            $this->formulario_de_reembolso.="<a data-fancybox data-type=\"ajax\" href=\"#\" class=\"mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-success btn-h-lighter-success btn-a-lighter-primary\" data-src=\"controllers/formulario1_generar_nuevo_renglon_de_item.ctrl.php?numero_de_documento=".$numero_de_documento."\" href=\"javascript:;\">
        <i class=\"fa fa-plus text-primary-l1\"></i>Agregar item</a>";
        }
        return $this->formulario_de_reembolso;

    }
    //FUNCION QUE GENERA UN NUEVO RENGLON DE ITEM PARA AGREGAR AL FOMRULARIO DE TIPO NORMAL
    function agregar_item_formulario_1($numero_de_documento)
    {
        $this->numero_de_documento = $numero_de_documento;
        $this->item_formulario_1 = "<form class='form'>
                                       
                                        <div class='row form-group'>
                                           <div class='col-7'><label for='numero_de_factura' class='text-blue-d1'>N&uacute;mero de factura </label></div>
                                            <div class='col-4'>
                                                <input type='number' class='form-control text-90' id='numero_de_factura' placeholder='Factura'>
                                            </div>
                                        </div>    
                                            <div class='row form-group'>
                                                <div class='col-7'><label for='indice_de_establecimiento' class='text-blue-d1'>Cl&iacute;nica o Establecimiento </label></div>
                                                <div class='col-5'>
                                                    ".self::generar_lista_de_establecimientos()."
                                                </div>
                                            </div>
                                    </form>";
        echo $this->item_formulario_1;
    }

    //FUNCION QUE GENERA UNA LISTA DE CLINICAS Y ESTABLECIMIENTOS
    static function  generar_lista_de_establecimientos()
    {
        $data_de_establecimientos = Conexion::conect()->select('establecimiento_con_convenio','*',['ORDER'=>'convenio_vigente']);
        $lista_de_establecimientos='';
        $lista_de_establecimientos.="<select class='form-control text-90' id='indice_de_establecimiento' >";
        $lista_de_establecimientos.="<option value='0'>Seleccionar</option>";
            foreach ($data_de_establecimientos as $establecimiento)
            {
                $lista_de_establecimientos.="<option value=\"".$establecimiento['indice_de_establecimiento']."\">".utf8_decode($establecimiento['nombre_de_establecimiento'])."</option>";
            }
        $lista_de_establecimientos.="</select>";
        return $lista_de_establecimientos;
    }
}
