<?php
    
    include_once '../cls/Parametros.cls.php';
    $obj = new Parametros();
    $obj->sobreescribir_parametros($_GET['valor_1'],$_GET['valor_2']);
