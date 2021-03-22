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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <title>MiSeguro - Admin</title>
    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css" media="all">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/regular.css" media="all">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/brands.css" media="all">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/solid.css">
    <link rel="stylesheet" type="text/css" href="dist/css/ace-font.css">
    <link rel="stylesheet" type="text/css" href="dist/css/ace.css">
    <link rel="stylesheet" href="fancybox/jquery.fancybox.css">
    <!-- favicon -->
    <link rel="icon" type="image/png" href="assets/favico.ico" />

</head>

<body>
<div class="body-container">
    <!-- Navbar -->
    <nav class="navbar navbar-sm navbar-expand-lg navbar-fixed navbar-blue">
        <div class="navbar-inner brc-grey-l2 shadow-md">
            <div class="navbar-inner brc-grey-l2 shadow-md">

                <!-- this button collapses/expands sidebar in desktop mode -->


                <div class="d-flex h-100 align-items-center justify-content-xl-between">

                    <a class="navbar-brand ml-2 text-white" href="#">
                        <img src="assets/image/logo.png" alt="MiSeguro" width="5%">
                        <span>MiSeguro</span> <span class="text-blue-l3">farma</span><span class="text-grey-l3">enlace</span>
                    </a>
                </div>

            <!-- .navbar-menu toggler -->
            <button class="navbar-toggler mx-1 p-25" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navbar menu">
                <i class="fa fa-user text-white"></i>
            </button>
            <div class="ml-auto mr-lg-5 navbar-menu collapse navbar-collapse navbar-backdrop" id="navbarMenu">
                <div class="navbar-nav">
                    <ul class="nav justify-content-center">
                        <li class="nav-item dropdown order-first order-lg-last">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="d-inline-block d-xl-inline-block">
                                    <span class="text-90" id="id-user-welcome">Bienvenid@</span>
                                </span>
                                <i class="caret fa fa-angle-down d-none d-xl-block"></i>
                                <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                            </a>

                            <div class="dropdown-menu dropdown-caret dropdown-menu-right dropdown-animated brc-primary-m3 py-1">
                                <div class="dropdown-divider brc-primary-l2"></div>

                                <a class="dropdown-item btn btn-outline-grey bgc-h-secondary-l3 btn-h-light-secondary btn-a-light-secondary" href="controllers/cerrar_sesion.ctrl.php">
                                    <i class="fa fa-power-off text-warning-d1 text-105 mr-1"></i>
                                    Salir
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div><!-- .navbar-menu -->


        </div><!-- .navbar-inner -->
    </nav>
    <div class="main-container bgc-white">

        <!-- Sidebar -->
        <div id="sidebar" class="sidebar sidebar-fixed expandable sidebar-light" data-backdrop="true" data-dismiss="true" data-swipe="true">
            <div class="sidebar-inner">

                <div class="ace-scroll flex-grow-1 mt-1px" data-ace-scroll="{}">

                    <!-- optional `nav` tag -->
                    <nav class="pt-3" aria-label="Main">
                        <div class="py-2 d-flex flex-column align-items-center">
                            <div>
                                <img alt="Administrador" src="assets/image/avatar/avatar2.png" class="p-2px border-2 brc-primary-tp2 radius-round">
                            </div>

                            <div class="text-center mt-1" id="id-user-info">
                                <a href="#id-user-menu" class="d-style pos-rel collapsed text-blue-d2 accordion-toggle no-underline bgc-h-primary-l2 px-1 py-2px" data-toggle="collapse" aria-expanded="false">
                                    <span class="text-70 font-bolder small"><?php echo $_SESSION['usuario']['nombres_de_usuario']?></span>
                                    <i class="fa fa-caret-down text-90 d-collapsed"></i>
                                    <i class="fa fa-caret-up text-90 d-n-collapsed"></i>
                                </a>
                                <div class="text-muted text-85">Administrador</div>
                            </div><!-- /#id-user-info -->

                            <div class="collapse" id="id-user-menu">
                                <div class="mt-3">
                                    <a href="controllers/cerrar_sesion.ctrl.php" class="btn btn-light-blue btn-brc-white btn-h-light-blue radius-round py-2 px-1 border-2 shadow-sm">
                                        <i class="fa fa-power-off w-4 text-110 text-red-d1"></i>
                                    </a>

                                    <a href="#" class="btn btn-light-blue btn-brc-white btn-h-light-blue radius-round py-2 px-1 border-2 shadow-sm">
                                        <i class="fa fa-mail-bulk w-4 text-110 text-blue-d1"></i>
                                    </a>

                                    <a href="#" class="btn btn-light-blue btn-brc-white btn-h-light-blue radius-round py-2 px-1 border-2 shadow-sm">
                                        <i class="fa fa-info w-4 text-110 text-blue-d1"></i>
                                    </a>
                                </div>
                            </div><!-- /.collapse -->
                        </div>

                    </nav>
                    <div class="btn-group btn-group-toggle btn-group-vertical d-flex" data-toggle="buttons">
                        <a href="#" class="d-style mb-1 active btn py-25 btn-outline-dark btn-h-outline-blue btn-a-outline-blue btn-a-bold w-100 btn-brc-tp border-none border-l-4 radius-l-0 radius-r-round text-left text-80" id="btn_servicios_medicos">
                            <i class="fa fa-medkit text-120 w-3 f-n-hover"></i>
                            SERVICIOS MEDICOS
                            <input type="radio" name="btn_servicios_medicos">
                        </a>

                        <a href="#" class="d-style mb-1 btn py-25 btn-outline-dark btn-h-outline-blue btn-a-outline-blue btn-a-bold w-100 btn-brc-tp border-none border-l-4 radius-0 text-left text-80 radius-l-0 radius-r-round" id="btn_servicios_medicos_especiales">
                            <i class="fa fa-plus-square text-120 text-orange-d1 w-3 f-n-hover"></i>
                            SERVICIOS MEDICOS ESPECIALES
                            <input type="radio" name="btn_servicios_medicos_especiales">
                        </a>

                        <a href="#" class="d-style mb-1 btn py-25 btn-outline-dark btn-h-outline-blue btn-a-outline-blue btn-a-bold w-100 btn-brc-tp border-none border-l-4 radius-0 text-left text-80 radius-l-0 radius-r-round" id="btn_cie10">
                            <i class="fa fa-heart-broken text-danger text-120 w-3 f-n-hover"></i>
                            CIE-10
                            <input type="radio" name="btn_cie10">
                        </a>

                        <a href="#" class="d-style mb-1 btn py-25 btn-outline-dark btn-h-outline-blue btn-a-outline-blue btn-a-bold w-100 btn-brc-tp border-none border-l-4 radius-0 text-left text-80 radius-l-0 radius-r-round" id="btn_establecimientos">
                            <i class="fa fa-hospital-symbol text-success-d1 text-120 w-3 f-n-hover"></i>
                            ESTABLECIMIENTOS AFILIADOS
                            <input type="radio" name="btn_establecimientos">
                        </a>

                        <a href="#" class="d-style mb-1 btn py-25 btn-outline-dark btn-h-outline-blue btn-a-outline-blue btn-a-bold w-100 btn-brc-tp border-none border-l-4 radius-0 text-left text-80 radius-l-0 radius-r-round" id="btn_empresas_afiliadas">
                            <i class="fa fa-layer-group text-info-d1 text-120 w-3 f-n-hover"></i>
                            GRUPOS FARMAENLACE
                            <input type="radio" name="btn_empresas_afiliadas">
                        </a>

                        <a href="#" class="d-style mb-1 btn py-25 btn-outline-dark btn-h-outline-blue btn-a-outline-blue btn-a-bold w-100 btn-brc-tp border-none border-l-4 radius-0 text-left text-80 radius-l-0 radius-r-round" id="btn_beneficiarios_y_afiliados">
                            <i class="fa fa-user-friends text-yellow-d4 text-120 w-3 f-n-hover"></i>
                            AFILIADOS Y BENEFICIARIOS
                            <input type="radio" name="btn_beneficiarios_y_afiliados">
                        </a>

                        <a href="#" class="d-style mb-1 btn py-25 btn-outline-dark btn-h-outline-blue btn-a-outline-blue btn-a-bold w-100 btn-brc-tp border-none border-l-4 radius-0 text-left text-80 radius-l-0 radius-r-round" id="btn_reembolsos_y_creditos">
                            <i class="fa fa-money-bill text-green-l2 text-120 w-3 f-n-hover"></i>
                            CREDITOS Y REEMBOLSOS
                            <input type="radio" name="btn_reembolsos_y_creditos">
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- Main Content -->
        <section class="main-content">
            <!-- Page Content -->
            <div class="page-content" id="contenedor_principal">
                
               <?php
                    include_once 'controllers/mostrar_parametros_de_configuracion.ctrl.php';
               ?>
            </div>        

        </section>

    </div>
</div>

<!-- include common vendor scripts used in demo pages -->
<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="node_modules/popper.js/dist/umd/popper.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="fancybox/jquery.fancybox.js"></script>
<script src="js/admin_buttons.js"></script>
<script src="js/sweetalert2.all.js"></script>
<!-- include ace.js -->
<script src="./dist/js/ace.js"></script>

</body>

</html>