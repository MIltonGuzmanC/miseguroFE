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
            <i class="fa fa-print text-blue-d1 px-2px"></i><span class="text-black-50">  Reporte de reembolsos generados por Per&iacute;odo</span>
        </h3>

        <div class="pos-rel ml-sm-auto mr-sm-2 order-last order-sm-0">
            <i class="fa fa-search position-lc ml-25 text-primary-m1"></i>
            <input type="number" min="1" class="form-control w-100 pl-45 radius-1 brc-primary-m4" placeholder="periodo ejem : 1981" id="txt_periodo">
        </div>

        <div class="mb-2 mb-sm-0">
            <a href="#" class="btn btn-green px-3 d-block w-100 text-95 radius-round border-2 brc-black-tp10" onclick="generar_reporte()">
                <i class="fa fa-file-download text-white"></i> Generar reporte
            </a>
        </div>
    </div>
    <div class="main-container" id="div_formulario_nuevo_reembolso">

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
<script src="js/reembolsos_por_periodo.rp.js"></script>
<script src="js/print.js"></script>
</html>


