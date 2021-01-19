<?php
    include_once '../cls/LoginDeUsuario.cls.php';
    $login = new LoginDeUsuario();
    $login->login($_POST['id_de_usuario'],$_POST['password']);
