<?php
    include_once '../cls/Beneficiarios.cls.php';
    $obj = new Beneficiarios();
    $obj->generar_lista_de_beneficiados_de_afiliado($_GET['numero_de_id_de_usuario']);