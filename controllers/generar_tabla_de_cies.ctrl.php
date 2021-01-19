<?php
    include_once '../cls/CategoriaCie10.cls.php';
    $cat = new CategoriaCie10();
    $cat->generar_tabla_de_cies($_POST['codigo_de_grupo_de_cie']);