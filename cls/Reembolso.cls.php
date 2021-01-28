<?php
date_default_timezone_set('America/Lima');
include_once 'Conexion.cls.php';
include_once 'Historial.cls.php';
include_once 'Mailer.cls.php';
include_once '../config.ini.php';
class Reembolso
{
    private $formulario_nuevo_reembolso,$data,$beneficiario,$datalist,$enc_cie,$num_reembolsos,$id_de_usuario,$digitador,$mail;
    private $id_de_administrador,$numero_de_documento,$enfermedad_preexistente,$tipo_de_reembolso,$codigo_de_grupo_de_cie,$cie10;

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
        $this->num_reembolsos=Conexion::conect()->count('encabezado_de_reembolso');
        $this->num_reembolsos.="-".date('YmdGis-');
        $this->num_reembolsos.=$this->digitador;
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
            'estado_de_reclamo'=>1
        ])){
                Historial::nueva_actividad($this->id_de_administrador,'REEMBOLSOS Y RECLAMOS','NUEVO REEMBOLSO GENERADO POR ESTE ADMINISTRADOR :'.$this->numero_de_documento);
                $this->mail = new Mailer();
                $this->mail->enviar_correo(ADMIN_MAIL,ADMIN_NAME,$this->beneficiario['email'],utf8_decode($this->beneficiario['nombres']),'NUEVO REEMBOLSO O RECLAMO INGRESADO',"<p>Se ha generado un nuevo reclamo o reembolso, para referencia del mismo, guarde el siguiente codigo</p>
<p><h4>".$this->numero_de_documento."</h4></p>
<p>Cualquer inquietud o novedad, responda a este correo.</p>");
                echo "Swal.fire({
                icon: 'success',
                title: 'Reembolso ingresado',
                text: 'Reembolso generado con exito',
                allowOutsideClick : false,
                allowEscapeKey : false,
                showConfirmButton : true
            });
            $(\"#div_formulario_nuevo_reembolso\").html('procesando...');";
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
}