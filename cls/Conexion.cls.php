<?php
require '../vendor/autoload.php';
use Medoo\Medoo;

class Conexion{
    //METODO ESTATICO
    public static function conect()
    {
        if($_SERVER['SERVER_NAME']=='miseguro.local')
        {
            $conector = new Medoo([
                // required
                'database_type' => 'mysql',
                'database_name' => 'miseguro',
                'server' => 'localhost',
                'username' => 'root',
                'password' => 'adminroot',

            ]);
        }

        elseif ($_SERVER['SERVER_NAME']=='smartsara.co') {
            $conector = new Medoo([
                // required
                'database_type' => 'mysql',
                'database_name' => 'smart-sara',
                'server' => 'localhost',
                'username' => 'smart-admin',
                'password' => 'adminroot',

            ]);
        }

        return $conector;
    }
}

//Ejemplo de uso de la clase conectar :$conectar = Conexion::conect();

