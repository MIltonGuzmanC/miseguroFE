<?php
    session_start();
    if(!isset($_SESSION['usuario']))
    {
        header("Location: ./index.php");
    }
    elseif($_SESSION['usuario']['indice_de_perfil_de_usuario']!=1)
    {
        die("Intento ilegal de acceder al sistema");
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/regular.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/brands.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/solid.css">
    <link rel="stylesheet" href="fancybox/jquery.fancybox.css">


    <link rel="stylesheet" type="text/css" href="dist/css/ace-font.css">
    <link rel="stylesheet" type="text/css" href="dist/css/ace.css">
    <link rel="icon" type="image/png" href="assets/favico.ico" />
</head>
<body>
    <div class="body-container">
        <div class="d-flex justify-content-between flex-column flex-sm-row mb-3 px-3px px-sm-0">
            <h3 class="text-125 pl-1 mb-3 mb-sm-0 text-primary-d1">
                <i class="fa fa-book-medical text-orange-d1 px-1px"></i>Lista de servicios m&eacute;dicos especiales
            </h3>

            <div class="pos-rel ml-sm-auto mr-sm-2 order-last order-sm-0">
                <i class="fa fa-search position-lc ml-25 text-primary-m1"></i>
                <input type="text" class="form-control w-100 pl-45 radius-1 brc-primary-m4" placeholder="Buscar servicio" id="filtro">
            </div>

            <div class="mb-2 mb-sm-0">
                <a data-fancybox data-type="ajax" href="#" class="btn btn-blue px-3 d-block w-100 text-95 radius-round border-2 brc-black-tp10" data-src="controllers/mostrar_formulario_de_nuevo_servicio_medico_especial.ctrl.php" href="javascript:;">
                <i class="fa fa-plus text-white"></i> Nuevo servicio m&eacute;dico
                </a>
            </div>
        </div>
        <div class="main-container" id="main_servicios_medicos">

        </div>
    </div>
</body>
<script>

</script>
<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="node_modules/popper.js/dist/umd/popper.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="fancybox/jquery.fancybox.js"></script>
<script src="dist/js/ace.js"></script>
<script src="views/pages/form-basic/@page-script.js"></script>
<script src="js/servicios_medicos_especiales.js"></script>

</html>


