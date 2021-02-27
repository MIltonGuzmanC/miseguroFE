<?php
session_start();
if(!isset($_SESSION['usuario']['id_de_usuario']))
{
    die("intento ilegal de acceder al sistema");
}
else{
    include_once '../cls/GeneradorDeReportes.cls.php';
    GeneradorDeReportes::generar_reporte_de_reembolso($_POST['numero_de_documento']);
}
