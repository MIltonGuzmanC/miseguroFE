<?php
    session_start();
    error_reporting(0);

    require_once 'vendor/autoload.php';
    use UAParser\Parser;
    $agenteDeUsuario = $_SERVER["HTTP_USER_AGENT"];
    $parseador = Parser::create();
    $resultado = $parseador->parse($agenteDeUsuario);
    $familiaNavegador = $resultado->ua->family; // Chrome, Firefox, Safari, Edge
    $navegador = $resultado->ua->toString();
    $dispositivo = $resultado->device->family;
    $familiaSistema = $resultado->os->family;
    $sistema = $resultado->os->toString();
    $completo = $resultado->toString();
    if($familiaNavegador!='Chrome')
    {
        die("<h1>Navegador no soportado</h1> <p>Este sistema fue dise&nacute;ado y funciona correctamente sobre la &uacute;ltima versi&oacute;n del Navegador de Google, Chrome</p><p>Usted puede descargarlo directamente <a href='https://www.google.com/intl/es/chrome/?brand=UUXU&gclid=Cj0KCQiA88X_BRDUARIsACVMYD8l36YxmXY_s6HETvneZ7boy9chJyuFzM5hUloADDo6qiwEbGbZAlAaAlnsEALw_wcB&gclsrc=aw.ds'>haciendo click en este enlace</a></p>");
    }
    if(isset($_SESSION['usuario']['indice_de_perfil_de_usuario']))
    {
        $opcion = $_SESSION['usuario']['indice_de_perfil_de_usuario'];
        switch ($opcion){
            case 1:
                header("Location: ./administrador.vw.php");
                break;
            case 2:
                header("Location: ./usuario.vw.phpr");
                break;
        }
    }

    ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <base href="../" />

    <title>MiSeguro</title>


    <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/regular.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/brands.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/solid.css">
    <link rel="stylesheet" type="text/css" href="dist/css/ace-font.css">
    <link rel="stylesheet" type="text/css" href="dist/css/ace.css">
    <link rel="stylesheet" href="fancybox/jquery.fancybox.css">
    <link rel="icon" type="image/png" href="assets/favico.ico" />

    <!-- "Login" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="views/pages/page-login/@page-style.css">
</head>

<body>
<div class="body-container">

    <div class="main-container container bgc-transparent">

        <div class="main-content minh-100 justify-content-center">
            <div class="p-2 p-md-4">
                <div class="row" id="row-1">
                    <div class="col-12 col-xl-10 offset-xl-1 bgc-white shadow radius-1 overflow-hidden">

                        <div class="row" id="row-2">
                                <div class="tab-content tab-sliding border-0 p-0" data-swipe="right">

                                    <div class="tab-pane active show mh-100 px-3 px-lg-0 pb-3" id="id-tab-login">
                                        <!-- show this in desktop -->
                                        <div class="d-none d-lg-block col-md-6 offset-md-3 mt-lg-4 px-0">
                                            <h4 class="text-dark-tp4 border-b-1 brc-secondary-l2 pb-1 text-130">
                                                <a href="#">
                                                    <img src="assets/image/logo.png" alt="MiSeguro" width="25%">
                                                </a>
                                            </h4>
                                        </div>

                                        <!-- show this in mobile device -->
                                        <div class="d-lg-none text-secondary-m1 my-4 text-center">
                                            <a href="#">
                                                <img src="assets/image/logo.png" alt="MiSeguro" width="25%">
                                            </a>
                                            <h1 class="text-170">
                            <span class="text-blue-d1">
                                Mi <span class="text-80 text-dark-tp3">SeguroFE</span>
                            </span>
                                            </h1>

                                            Bienvenid@
                                        </div>


                                        <form autocomplete="off" class="form-row mt-4" id="form_login">
                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <div class="d-flex align-items-center input-floating-label text-blue brc-blue-m2">
                                                    <input type="text" class="form-control form-control-lg pr-4 shadow-none" id="login_id_de_usuario" />
                                                    <i class="fa fa-user text-success ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 ml-n3" for="login_id_de_usuario">
                                                        ID de Usuario
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-2 mt-md-1">
                                                <div class="d-flex align-items-center input-floating-label text-blue brc-blue-m2">
                                                    <input type="password" class="form-control form-control-lg pr-4 shadow-none" id="login_password" />
                                                    <i class="fa fa-key text-grey-m2 ml-n4 text-success"></i>
                                                    <label class="floating-label text-grey-l1 ml-n3" for="login_password">
                                                        Clave de Usuario
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-right text-md-right mt-n2 mb-2">
                                                <a href="#" class="text-primary-m1 text-95" data-toggle="tab" data-target="#id-tab-forgot">
                                                    ¿Olvidaste tu clave?
                                                </a>
                                            </div>


                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <button type="button" class="btn btn-primary btn-block px-4 btn-bold mt-2 mb-4" id="btn_login">
                                                    Acceder
                                                </button>
                                            </div>
                                        </form>


                                        <div class="form-row">
                                            <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 d-flex flex-column align-items-center justify-content-center">

                                                <hr class="brc-default-l2 mt-0 mb-2 w-100" />

                                                <div class="p-0 px-md-2 text-dark-tp3 my-3">
                                                    ¿No eres Usuario?
                                                    <a class="text-success-m1 text-600 mx-1" data-toggle="tab" data-target="#id-tab-signup" href="#">
                                                        Darme de alta
                                                    </a>
                                                </div>

                                                <hr class="brc-default-l2 w-100 mb-2" />
                                             </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane mh-100 px-3 px-lg-0 pb-3" id="id-tab-signup" data-swipe-prev="#id-tab-login">
                                        <div class="position-tl ml-3 mt-3 mt-lg-0">
                                            <a href="#" class="btn btn-light-default btn-h-light-default btn-a-light-default btn-bgc-tp" data-toggle="tab" data-target="#id-tab-login">
                                                <i class="fa fa-arrow-left"></i>
                                            </a>
                                        </div>

                                        <!-- show this in desktop -->
                                        <div class="d-none d-lg-block col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-lg-4 px-0">
                                            <h4 class="text-dark-tp4 border-b-1 brc-grey-l1 pb-1 text-130">
                                                <i class="fa fa-user text-purple mr-1"></i>
                                                Crear Mi Cuenta
                                            </h4>
                                        </div>

                                        <!-- show this in mobile device -->
                                        <div class="d-lg-none text-secondary-m1 my-4 text-center">
                                            <a href="#">
                                                <img src="assets/image/logo.png" alt="MiSeguro" width="15%">
                                            </a>
                                            <h1 class="text-170">
                                                <span class="text-blue-d1">Mi <span class="text-80 text-dark-tp4">Seguro</span></span>
                                            </h1>

                                            Crear Mi Cuenta
                                        </div>


                                        <form autocomplete="off" class="form-row mt-4" id="frm_dar_de_alta" name="frm_dar_de_alta" action="#" method="post">
                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-1">
                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">
                                                    <input type="text" class="form-control form-control-lg pr-4 shadow-none" id="alta_id_de_usuario" name="alta_id_de_usuario" required />
                                                    <i class="fa fa-id-card text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 text-100 ml-n3" for="alta_id_de_usuario">
                                                        C&eacute;dula / Pasaporte
                                                    </label>
                                                </div>
                                                <div class="row small" id="msg_alta_id"></div>
                                            </div>
                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">
                                                    <input type="text" class="form-control form-control-lg pr-4 shadow-none text-uppercase" name="alta_apellidos" id="alta_apellidos" required />
                                                    <i class="fa fa-user text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 text-100 ml-n3" for="alta_apellidos">
                                                        Apellidos
                                                    </label>
                                                </div>
                                                <div class="row small" id="msg_alta_apellidos"></div>
                                            </div>
                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">
                                                    <input type="text" class="form-control form-control-lg pr-4 shadow-none text-uppercase" name="alta_nombres" id="alta_nombres" required />
                                                    <i class="fa fa-user text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 text-100 ml-n3" for="alta_nombres">
                                                        Nombres
                                                    </label>
                                                </div>
                                                <div class="row small" id="msg_alta_nombres"></div>
                                            </div>
                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">
                                                    <input type="email" class="form-control form-control-lg pr-4 shadow-none" id="alta_email" name="alta_email" required/>
                                                    <i class="fa fa-envelope text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 text-100 ml-n3" for="alta_email">
                                                        Email
                                                    </label>
                                                </div>
                                                <div class="row small" id="msg_alta_email"></div>
                                            </div>
                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-1">
                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">
                                                    <input type="text" class="form-control form-control-lg pr-4 shadow-none" id="alta_password" name="alta_password" required/>
                                                    <i class="fa fa-key text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 text-100 ml-n3" for="alta_password">
                                                        Clave
                                                    </label>
                                                </div>
                                                <div class="row small" id="msg_alta_clave"></div>
                                            </div>

                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-1">
                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">
                                                    <input type="text" class="form-control form-control-lg pr-4 shadow-none" id="alta_password_confirm" />
                                                    <i class="fas fa-sync-alt text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 text-100 ml-n3" for="alta_password_confirm">
                                                        Confirme su clave
                                                    </label>
                                                </div>
                                                <div class="row small" id="msg_alta_clave_com"></div>
                                            </div>
                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-2">
                                                <label class="d-inline-block mt-3 mb-0 text-secondary-d2">
                                                    <input type="checkbox" class="mr-1" id="chk_terminos" value="true" />
                                                    <span class="text-dark-m3">He le&iacute;do los  <a href="#" class="text-blue-d2">T&eacute;rminos de uso</a> y estoy de acuerdo con los mismos</span>
                                                </label>

                                                <button type="submit" class="btn btn-success btn-block px-4 btn-bold mt-2 mb-3" id="btn_dar_de_alta" disabled>
                                                    Darme de alta
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane mh-100 px-3 px-lg-0 pb-3" id="id-tab-forgot" data-swipe-prev="#id-tab-login">
                                        <div class="position-tl ml-3 mt-2">
                                            <a href="#" class="btn btn-light-default btn-h-light-default btn-a-light-default btn-bgc-tp" data-toggle="tab" data-target="#id-tab-login">
                                                <i class="fa fa-arrow-left"></i>
                                            </a>
                                        </div>


                                        <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-5 px-0 align-content-center">

                                            <h4 class="pt-4 pt-md-0 text-dark-tp4 border-b-1 brc-grey-l2 pb-1 text-130">
                                                <i class="fa fa-key text-brown-m1 mr-1"></i>
                                                Recuperar clave de Usuario
                                            </h4>
                                        </div>


                                        <form autocomplete="off" class="form-row mt-4" id="form_recuperar_clave">
                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <label class="text-secondary-d3 mb-3">
                                                    Ingrese su direcci&oacute;n de correo electr&oacute;nico y le enviaremos las instrucciones para recuperar su clave.
                                                </label>
                                                <div class="d-flex align-items-center">
                                                    <input type="email" class="form-control form-control-lg pr-4 shadow-none" id="id-recover-email" placeholder="Email" />
                                                    <i class="fa fa-envelope text-grey-m2 ml-n4"></i>
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-1">
                                                <button type="button" class="btn btn-orange btn-block px-4 btn-bold mt-2 mb-4" id="btn_recuperar_clave">
                                                    Recuperar clave
                                                </button>
                                            </div>
                                        </form>


                                        <div class="form-row w-100">
                                            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 d-flex flex-column align-items-center justify-content-center">

                                                <hr class="brc-default-l2 mt-0 mb-2 w-100" />

                                                <div class="p-0 px-md-2 text-dark-tp4 my-3">
                                                    <a class="text-blue-d1 text-600 btn-text-slide-x" data-toggle="tab" data-target="#id-tab-login" href="#">
                                                        <i class="btn-text-2 fa fa-arrow-left text-110 align-text-bottom mr-2"></i>Volver a Inicio
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div><!-- .tab-content -->
                            </div>

                        </div><!-- /.row -->

                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="my-3 text-white-tp1 text-center">
                    <i class="fa fa-leaf text-success-l3 mr-1 text-110"></i> Desarrollo y Soporte <a target="_blank" href="http://www.peefcorporation.com/" class="text-white-50">Peef Corp</a> &copy; 2020
                </div>
            </div>
        </div>
    </div>
</div>

<!-- include common vendor scripts used in demo pages -->
<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="node_modules/popper.js/dist/umd/popper.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/sweetalert2.all.js"></script>
<script src="fancybox/jquery.fancybox.js"></script>

<!-- include ace.js -->
<script src="dist/js/ace.js"></script>

<!-- "Login" page script to enable its demo functionality -->
<script src="views/pages/page-login/@page-script.js"></script>

<script src="js/dar_de_alta.js"></script>
<script src="js/login_de_usuario.js"></script>
</body>

</html>