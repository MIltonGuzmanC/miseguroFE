<?php
    session_start();

    include_once '../cls/CategoriaCie10.cls.php';
    $cat = new CategoriaCie10();
    $cat->nueva_categoria($_SESSION['usuario']['id_de_usuario'],$_POST['codigo_de_categoria'],$_POST['nombre_de_categoria']);