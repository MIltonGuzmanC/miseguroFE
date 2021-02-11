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
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <base href="../" />

    <title>More Elements - Ace Admin</title>

    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/regular.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/brands.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/solid.css">



    <!-- include vendor stylesheets used in "More Elements" page. see "/views//pages/partials/form-more/@vendor-stylesheets.hbs" -->
    <link rel="stylesheet" type="text/css" href="node_modules/bootstrap-star-rating/css/star-rating.css">

    <link rel="stylesheet" type="text/css" href="node_modules/bootstrap-select/dist/css/bootstrap-select.css">

    <link rel="stylesheet" type="text/css" href="node_modules/bootstrap-duallistbox/dist/bootstrap-duallistbox.css">


    <link rel="stylesheet" type="text/css" href="node_modules/select2/dist/css/select2.css">
    <link rel="stylesheet" type="text/css" href="node_modules/chosen-js/chosen.css">


    <!-- include fonts -->
    <link rel="stylesheet" type="text/css" href="dist/css/ace-font.css">



    <!-- ace.css -->
    <link rel="stylesheet" type="text/css" href="dist/css/ace.css">


    <!-- "More Elements" page styles, specific to this page for demo only -->
</head>

<body>
<div class="container">
    <div class="d-flex justify-content-between flex-column flex-sm-row mb-3 px-2 px-sm-0">
        <h3 class="text-125 pl-1 mb-3 mb-sm-0 text-blue">
            <i class="px-1px fa fa-money-bill text-green-l3"></i>
            Reembolsos y cr&eacute;ditos.
        </h3>

        <div class="pos-rel ml-sm-auto mr-sm-2 order-last order-sm-0">
            <i class="fa fa-search position-lc ml-25 text-primary-m1"></i>
            <input type="text" class="form-control w-100 pl-45 radius-1 brc-primary-m4 text-80" placeholder="buscar por ID de Usuario" id="txt_filtro">
        </div>

        <div class="mb-2 mb-sm-0">
            <button type="button" class="btn btn-blue px-3 d-block w-100 text-95 radius-round border-2 brc-black-tp10" id="btn_nuevo_reembolso">
                <i class="fa fa-plus mr-1 text-white-50"></i>
                Nuevo reembolso
            </button>
        </div>
    </div>
    <div class="m-1px"></div>
    <div class="card" id="div_formulario_nuevo_reembolso">

</div>
</body>

<!-- include common vendor scripts used in demo pages -->
<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="node_modules/popper.js/dist/umd/popper.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>



<!-- include vendor scripts used in "More Elements" page. see "/views//pages/partials/form-more/@vendor-scripts.hbs" -->
<script src="node_modules/bootstrap-star-rating/js/star-rating.js"></script>

<script src="node_modules/typeahead.js/dist/typeahead.bundle.js"></script>

<script src="node_modules/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="node_modules/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.js"></script>


<script src="node_modules/select2/dist/js/select2.js"></script>
<script src="node_modules/chosen-js/chosen.jquery.js"></script>


<script src="node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.js"></script>
<script src="node_modules/bootstrap-maxlength/dist/bootstrap-maxlength.js"></script>
<script src="node_modules/inputmask/dist/jquery.inputmask.js"></script>


<!-- include ace.js -->
<script src="dist/js/ace.js"></script>


<!-- "More Elements" page script to enable its demo functionality -->
<script src="views/pages/form-more/@page-script.js"></script>

<script src="js/reembolsos_y_creditos.js"> </script>
</body>

</html>


