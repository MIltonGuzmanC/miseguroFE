<?php
  //CLASE QUE ENCRIPTA / DESENCRIPTA LAS CLAVES DE USUARIO
class Encriptador{
    public static function encriptar($clave)
    {
        return openssl_encrypt ($clave,'aes-256-cbc' , 'enhorabuena', false, "dsafdslñkfskdsjfskdnckjds");
    }
    public static function desencriptar($clave)
    {
        return openssl_decrypt($clave, 'aes-256-cbc', 'enhorabuena', false, "dsafdslñkfskdsjfskdnckjds");
    }
}
/*$clave = "Milton";
echo Encriptador::encriptar($clave);
echo Encriptador::desencriptar('o/Fa25O51O0idEtrmYQ2iw==');*/