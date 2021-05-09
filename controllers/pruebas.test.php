<?php
    include_once '../cls/Parametros.cls.php';
    $pam = new Parametros();
    $dedu = $pam->obtener_saldo();
    echo $dedu;