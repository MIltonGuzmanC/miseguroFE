<?php
error_reporting(0);
include_once 'Conexion.cls.php';
include_once 'Historial.cls.php';
include_once 'Encriptador.cls.php';
include_once '../config.ini.php';
class LoginDeUsuario
{
    private $id_de_usuario,$password,$usuario;
    function login($id_de_usuario,$password){
        $this->id_de_usuario = $id_de_usuario;
        $this->password = Encriptador::encriptar($password);
        if(Conexion::conect()->has('informacion_de_usuario',['AND'=>['numero_de_id_de_usuario'=>$this->id_de_usuario,'clave_de_usuario'=>$this->password]]))
        {

            $this->usuario = Conexion::conect()->get('informacion_de_usuario','*',['AND'=>['numero_de_id_de_usuario'=>$this->id_de_usuario,'clave_de_usuario'=>$this->password]]);

            if($this->usuario['tiene_acceso_al_sistema']!=1)
            {
                Historial::nueva_actividad($this->id_de_usuario,'LOGIN DE USUARIO','ESTE USUARIO INTENTA ACCEDER AL SISTEMA, SE LE NOTIFICA QUE SU ACCESO SE ENCUENTRA BLOQUEADO');
                echo "Swal.fire({
                    icon: 'error',
                    title: 'Usuario desactivado',
                    text: 'Su cuenta ha sido deactivada, consulte con el Administrador del sistema',
                    allowOutsideClick : false,
                    allowEscapeKey : false,
                    showConfirmButton : true,
                    willClose : function(){
                        window.close();
                    }
                });";
            }
            else{
                Historial::nueva_actividad($this->id_de_usuario,'LOGIN DE USUARIO','ACCESO AL SISTEMA CON EXITO');
                session_start();
                $_SESSION['usuario']['id_de_usuario'] = $this->id_de_usuario;
                $_SESSION['usuario']['indice_de_perfil_de_usuario'] = $this->usuario['indice_de_perfil_fk'];
                $_SESSION['usuario']['indice_de_organizacion'] = $this->usuario['indice_de_organizacion_fk'];
                $_SESSION['usuario']['nombres_de_usuario'] = $this->usuario['nombres'];
                echo "Swal.fire({
                    icon: 'success',
                    title: 'Enhorabuena',
                    text: 'Acceso concedido, presione OK para acceder al sistema',
                    allowOutsideClick : false,
                    allowEscapeKey : false,
                    showConfirmButton : true,
                    willClose : function(){
                        location.href =\" ".HOST."\"
                    }
                });";
            }

        }
        else
        {
            echo "Swal.fire({
                icon: 'error',
                title: 'Acceso no concedido',
                text: 'Existe un error, verifique su ID o clave, si no recuerda su clave de acceso, use el enlace para recuperar clave o intente nuevamente',
                allowOutsideClick : false,
                allowEscapeKey : false,
                showConfirmButton : true
            });";
        }
    }
}