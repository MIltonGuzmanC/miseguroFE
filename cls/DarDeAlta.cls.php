<?php
error_reporting(0);
include_once 'Conexion.cls.php';
include_once 'Encriptador.cls.php';
include_once 'Mailer.cls.php';
include_once 'DatosDeOrganizacion.cls.php';
include_once 'ListaDeProvincias.cls.php';
include_once 'Historial.cls.php';
include_once '../config.ini.php';
class DarDeAlta
{
    private $mail,$id_de_usuario,$apellidos,$nombres,$email,$password,$subject,$id_encriptado;
    private $data_de_usuario,$formulario_de_registro,$organizacion,$provincia;
    private $fecha_de_nacimiento,$indice_de_organizacion,$cargo_ocupacion,$telefono_de_contacto,$ciudad,$direccion;
    //FUNCION QUE VALIDA QUE UN USUARIO ESTÉ EN LISTA DE USUARIOS PERMITIDOS
    function verificar_en_lista($id_de_usuario,$email)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->email = $email;
        if(Conexion::conect()->has('lista_de_usuarios_permitidos',['AND'=>['id_de_usuario'=>$this->id_de_usuario,'mail_de_usuario'=>$this->email]]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //========================================

    //FUNCION QUE DA DE ALTA A UN USUARIO
    function dar_de_alta($id_de_usuario,$apellidos,$nombres,$email,$password)
    {
        $this->id_de_usuario = $id_de_usuario;
        $this->apellidos = utf8_encode(strtoupper($apellidos));
        $this->nombres = utf8_encode(strtoupper($nombres));
        $this->email = $email;
        $this->password = Encriptador::encriptar($password);
        $this->id_encriptado = Encriptador::encriptar($this->id_de_usuario);
        if($this->verificar_en_lista($this->id_de_usuario,$this->email))
        {
            if(Conexion::conect()->has('informacion_de_usuario',['numero_de_id_de_usuario'=>$this->id_de_usuario]))
            {
                echo "Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Este Usuario ya tiene una cuenta registrada',
              footer: 'Si Usted no recuerda su clave, recurra a la seccion ¿olvido su clave? para recuperarla.</a>'
            })";
            }
            else{
                if(Conexion::conect()->insert('informacion_de_usuario',[
                    'numero_de_id_de_usuario'=>$this->id_de_usuario,
                    'nombres'=>$this->nombres,
                    'apellidos'=>$this->apellidos,
                    'fecha_de_alta'=>date('Y-m-d'),
                    'email'=>$this->email,
                    'clave_de_usuario'=>$this->password,
                    'tiene_acceso_al_sistema'=>0
                ])){
                    $this->subject.="<p class='h5 text-lg-center'> Estimad@ ".$this->apellidos." ".$this->nombres."</p>";
                    $this->subject.="<p class='text-primary'>Para seguir con el proceso de validaci&oacute;n de su cuenta, es necesario que llene el <b>formulario de Datos</b> haciendo click en el boton de activar cuenta.</p>";
                    $this->subject.="<p class='footer'> Atentamente, el Administrador</p>";
                    $this->subject.="<p><a class='ntn btn-primary' href='".HOST."/register.vw.php?id_de_usuario=".$this->id_encriptado."'>activar mi cuenta</a></p>";
                    $this->mail = new Mailer();
                    $this->mail->enviar_correo(ADMIN_MAIL,ADMIN_NAME,$this->email,$this->apellidos.' '.$this->nombres,'ACTIVACION DE SU CUENTA',$this->subject);
                    echo "Swal.fire({
                          icon: 'success',
                          title: 'Enhorabuena',
                          text: 'El sistema ha validado sus datos y ha dado de alta su cuenta',
                          footer: 'Solo necesitamos activar su cuenta, le hemos enviado las instrucciones al correo ".$this->email.".</a>'
                        });
                        ";

                }
            }

        }
        else{
            echo "Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'No hemos encontrado su registro en el sistema',
              footer: 'Esto suele suceder por varias razones:  No es un Usuario autorizado, No coincide el correo electr&oacute;nico o; Su ID de Usuario es incorrecto , Si Usted cree que esto existe un error, por favor contacte al Administrador.</a>'
            })";
        }

    }
    //==================================================================================================================

    //FUNCION QUE GENERA EL FOMRULARIO DE DATOS PARA USUARIO
     function generar_formulario_de_inscripcion($token){
        $this->id_de_usuario = Encriptador::desencriptar($token);
        if(Conexion::conect()->has('informacion_de_usuario',['numero_de_id_de_usuario'=>$this->id_de_usuario]))
        {
            $this->data_de_usuario = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$this->id_de_usuario]);
            if($this->data_de_usuario['activar_usuario']==1)
            {
                die ("<h3 class='text-danger'>Acceso denegado , Usuario ya activado</h3>");
            }
            else {

                $this->formulario_de_registro="
                 <section id=\"cabecera\" class=\"page-content container container-plus\">
                        <div class=\"card acard mt-2 mt-lg-3\">
                            <div class=\"card-header\">
                                <h3 class=\"card-title text-125 text-primary-d2 py-1 px-2\">
                                    <i class=\"far fa-user text-dark-l3 mr-1\"></i>
                                    Bienvenid@ ".$this->data_de_usuario['apellidos']." ".$this->data_de_usuario['nombres']."
                                </h3>
                            </div>
                            <div class='card-body'>
                                <h6 class='text-success-d1 px-3 py-3'>Por favor complete el siguiente formulario para activar su cuenta.</h6>
                            </div>
                        </div>
                    </section>
                    <section id=\"formulario\">
                        <form autocomplete=\"off\">
                            <input type='hidden' id='id_de_usuario' value='".$this->id_de_usuario."' readonly>
                            <div class=\"form-group row\">
                                <div class=\"col-2 col-form-label text-sm-right pr-0 text-secondary\">
                                    <label for=\"fecha_de_nacimiento\" class=\"mb-0\">
                                        Fecha de Nacimiento
                                    </label>
                                </div>
                                <div class=\"col-10\">
                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                        <i class=\"fa fa-calendar text-blue text-125 ml-25 pos-abs\"></i>
                                        <input type=\"date\" class=\"form-control form-control-sm px-475\"  id=\"fecha_de_nacimiento\">
                                    </div>
                                </div>
                            </div>
                
                            <div class=\"form-group row\">
                                <div class=\"col-2 col-form-label text-sm-right pr-0 text-secondary\">
                                    <label for=\"indice_de_organizacion\" class=\"mb-0\">
                                        Etablecimiento Afiliado
                                    </label>
                                </div>
                                <div class=\"col-10\">
                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                        <i class=\"fa fa-hospital text-blue text-125 ml-25 px-1 pos-rel\"></i>
                                       ";
                                    $this->organizacion = new DatosDeOrganizacion();
                                    $this->formulario_de_registro.=$this->organizacion->generar_option_de_organizaciones();
                $this->formulario_de_registro.="
                                    </div>
                                </div>
                            </div>
                            
                            <div class=\"form-group row\">
                                <div class=\"col-2 col-form-label text-sm-right pr-0 text-secondary\">
                                    <label for=\"telefono_de_contacto\" class=\"mb-0\">
                                        Tel&eacute;fono celular
                                    </label>
                                </div>
                                <div class=\"col-10\">
                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                        <i class=\"fa fa-phone text-blue text-125 ml-25 pos-abs\"></i>
                                        <input type=\"text\" class=\"text-uppercase form-control form-control-sm px-475\"  id=\"telefono_de_contacto\">
                                    </div>
                                </div>
                            </div>
                            
                            <div class=\"form-group row\">
                                <div class=\"col-2 col-form-label text-sm-right pr-0 text-secondary\">
                                    <label for=\"cargo_ocupacional\" class=\"mb-0\">
                                        Cargo / Profesi&oacute;n
                                    </label>
                                </div>
                                <div class=\"col-10\">
                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                        <i class=\"fa fa-toolbox text-blue text-125 ml-25 pos-abs\"></i>
                                        <input type=\"text\" class=\"text-uppercase form-control form-control-sm px-475\"  id=\"cargo_ocupacional\">
                                    </div>
                                </div>
                            </div>
                            
                            <div class=\"form-group row\">
                                <div class=\"col-2 col-form-label text-sm-right pr-0 text-secondary\">
                                    <label for=\"provincia\" class=\"mb-0\">
                                        Provincia
                                    </label>
                                </div>
                                <div class=\"col-10\">
                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                        <i class=\"fa fa-map text-blue text-125 ml-25 px-1 pos-rel\"></i>
                                       ";
                                    $this->provincia = new ListaDeProvincias();
                                    $this->formulario_de_registro.=$this->provincia->generar_lista_de_provincias();
                                    $this->formulario_de_registro.="
                                    </div>
                                </div>
                            </div>
                            
                            <div class=\"form-group row\">
                                <div class=\"col-2 col-form-label text-sm-right pr-0 text-secondary\">
                                    <label for=\"ciudad\" class=\"mb-0\">
                                        Ciudad
                                    </label>
                                </div>
                                <div class=\"col-10\">
                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                        <i class=\"fa fa-map-marked text-blue text-125 ml-25 pos-abs\"></i>
                                        <input type=\"text\" class=\"text-uppercase form-control form-control-sm px-475\"  id=\"ciudad\">
                                    </div>
                                </div>
                            </div>
                            
                            <div class=\"form-group row\">
                                <div class=\"col-2 col-form-label text-sm-right pr-0 text-secondary\">
                                    <label for=\"direccion\" class=\"mb-0\">
                                        Direcci&oacute;n
                                    </label>
                                </div>
                                <div class=\"col-10\">
                                    <div class=\"d-inline-flex align-items-center mb-1\">
                                        <i class=\"fa fa-map-marked-alt text-blue text-125 ml-25 pos-abs\"></i>
                                        <input type=\"text\" class=\"text-uppercase form-control form-control-sm px-475\"  id=\"direccion\">
                                    </div>
                                </div>
                            </div>
                            
                            <div class=\"mt-5 border-t-1  brc-secondary-l2 py-35 mx-n25\">
                                <div class=\"offset-md-3 col-md-9 text-nowrap\">
                                    <button class=\"btn btn-success btn-bold btn-sm px-4\" type=\"button\" id='btn_enviar_formulario' onclick='enviar_formulario()'>
                                        <i class=\"fa fa-check mr-1\"></i>
                                        Guardar formulario
                                    </button>
                                    <button class=\"btn btn-outline-lightgrey btn-bgc-white btn-bold ml-2 px-4\" type=\"reset\">
                                        <i class=\"fa fa-undo mr-1\"></i>
                                        Reset
                                    </button>
                                </div>
                            </div>
                            
                        </form>
                    </section>
            ";
                return $this->formulario_de_registro;
            }


        }
        else
        {
            die("acceso Denegado");
        }
    }

    //FUNCION QUE COMPLETA LA ACTIVACION DE UN USUARIO
    function completar_registro_de_usuario($id_de_usuario,$fecha_de_nacimiento,$indice_de_organizacion,$cargo_ocupacion,$telefono_de_contacto,$provincia,$ciudad,$direccion)
    {
        $this->id_de_usuario = $id_de_usuario;
        if(Conexion::conect()->has('informacion_de_usuario',['numero_de_id_de_usuario'=>$this->id_de_usuario]))
        {
            $this->fecha_de_nacimiento = $fecha_de_nacimiento;
            $this->indice_de_organizacion = $indice_de_organizacion;
            $this->cargo_ocupacion = utf8_encode(strtoupper($cargo_ocupacion));
            $this->telefono_de_contacto = $telefono_de_contacto;
            $this->provincia = utf8_encode($provincia);
            $this->ciudad = utf8_encode($ciudad);
            $this->direccion = utf8_encode($direccion);

            if(Conexion::conect()->update('informacion_de_usuario',[
                'fecha_de_nacimiento'=>$this->fecha_de_nacimiento,
                'indice_de_organizacion_fk'=>$this->indice_de_organizacion,
                'cargo_ocupacion'=>$this->cargo_ocupacion,
                'telefono_de_contacto'=>$this->telefono_de_contacto,
                'provincia'=>$this->provincia,
                'ciudad'=>$this->ciudad,
                'direccion'=>$this->direccion,
                'indice_de_perfil_fk'=>2,
                'es_titular_de_cuenta'=>1,
                'tiene_acceso_al_sistema'=>1,
                'activar_usuario'=>1
            ],['numero_de_id_de_usuario'=>$this->id_de_usuario]))
            {
                Historial::nueva_actividad($this->id_de_usuario,'DAR DE ALTA','USUARIO COMPLETA EL FORMULARIO PARA PODERSE DAR DE ALTA EN ELS SISTEMA');
                echo "Swal.fire({
                    icon: 'success',
                    title: 'Usuario activado',
                    text: 'Su cuenta ha sido activada de manera exitosa',
                    allowOutsideClick : false,
                    allowEscapeKey : false,
                    showConfirmButton : true,
                    willClose : function(){
                        window.close();
                    }
                });";
            }

        }
        else
        {
            echo "Swal.fire({
                icon: 'error',
                title: 'Usuario no encontrado',
                text: 'Existe un error, consulte con un Administrador',
                allowOutsideClick : false,
                allowEscapeKey : false,
                showConfirmButton : true,
                willClose : function(){
                    window.close();
                }
            });";
        }
    }
}