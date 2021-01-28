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
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/regular.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/brands.css">
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
                        <span>MiSeguroFE</span>
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

                                <a class="dropdown-item btn btn-outline-grey bgc-h-secondary-l3 btn-h-light-secondary btn-a-light-secondary" href="cerrar_sesion.php">
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
                                    <a href="#" class="btn btn-light-blue btn-brc-white btn-h-light-blue radius-round py-2 px-1 border-2 shadow-sm">
                                        <i class="fa fa-power-off w-4 text-110 text-blue-d1"></i>
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
                        <ul class="nav flex-column has-active-border">
                            <li class="nav-item">
                                <a class="nav-link" href="#" id="btn_servicios_medicos">
                                    <i class="nav-icon fa fa-comment-medical text-purple-d1"></i>
                                    <span class="nav-text fadeable text-blue text-90">Servicios m&eacute;dicos</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" id="btn_servicios_medicos_especiales">
                                    <i class="nav-icon fa fa-file-medical text-purple-d2"></i>
                                    <span class="nav-text fadeable text-blue text-85">Servicios m&eacute;dicos especiales</span>
                                </a>
                            </li>



                            <li class="nav-item">
                                <a class="nav-link" href="#" id="btn_cie10">
                                    <i class="nav-icon fa fa-book-medical text-purple-d3"></i>
                                    <span class="nav-text fadeable text-blue text-90">CIE-10</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" id="btn_establecimientos">
                                    <i class="nav-icon fa fa-hospital-alt text-purple-d4"></i>
                                    <span class="nav-text fadeable text-blue text-90">Cl&iacute;nicas / Establecimientos</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" id="btn_empresas_afiliadas">
                                    <i class="nav-icon fa fa-building text-purple-l1"></i>
                                    <span class="nav-text fadeable text-blue text-90">Empresas Afiliadas</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" id="btn_beneficiarios_y_afiliados">
                                    <i class="nav-icon fa fa-people-arrows text-purple-l2"></i>
                                    <span class="nav-text fadeable text-blue text-90">Beneficiarios y Afiliados</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" id="btn_reembolsos_y_creditos">
                                    <i class="nav-icon fa fa-paperclip text-purple-l3"></i>
                                    <span class="nav-text fadeable text-blue text-90">Reembolsos y cr&eacute;ditos</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <section class="main-content">
            <!-- Page Content -->
            <div class="page-content" id="contenedor_principal">

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
<script>
    $(function(){
        $("#contenedor_principal").load('servicios_medicos.view.php',function(status,response,xhr){
            if(xhr.status===404)
            {
                $("#contenedor_principal").html("<h1 class='h-1'>Error 404, p&aacute;gina no encontrada</h1>");
            }
        })
    })
</script>
</body>

</html>