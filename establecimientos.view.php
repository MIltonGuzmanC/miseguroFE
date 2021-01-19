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
</head>
<body>
<div class="container container-plus">
    <div class="row">
        <div class="col-12  cards-container" id="card-container-1">
            <div class="card" id="card-1">
                <div class="card-header">
                    <h5 class="card-title">
                        Agregar Nuevo Establecimiento
                    </h5>

                    <div class="card-toolbar">

                        <a href="#" data-action="expand" class="card-toolbar-btn text-orange-d3 d-style">
                            <i class="fa fa-expand d-n-active"></i>
                            <i class="fa fa-compress d-active"></i>
                        </a>

                        <a href="#" data-action="toggle" class="card-toolbar-btn text-grey-d1">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                        <a href="#" data-action="close" class="card-toolbar-btn text-danger">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div><!-- /.card-header -->

                <div class="card-body p-0">
                    <div class=" container container-plus">
                        <div class="card acard mt-2 mt-lg-3">
                            <div class="card-header">
                                <h3 class="card-title text-125 text-primary-d2">
                                    <i class="far fa-edit text-orange-l1 mr-1"></i>
                                    Datos de Cl&iacute;nica / Establecimiento, todos los campos marcados con * son obligatorios
                                </h3>
                            </div>

                            <div class="card-body px-3 pb-1">
                                <form class="mt-lg-3" autocomplete="off" id="form_establecimiento">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group row">
                                                <div class="col-3 col-form-label text-sm-right pr-0">
                                                    <label for="id_de_establecimiento" class="mb-0">
                                                       * RUC / ID
                                                    </label>
                                                </div>
                                                <div class="col-9">
                                                    <div class="d-inline-flex align-items-center mb-1">
                                                        <i class="fa fa-id-card text-success text-110 ml-25 pos-abs"></i>
                                                        <input type="text" class="form-control form-control-lg px-475" id="id_de_establecimiento">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-3 col-form-label text-sm-right pr-0">
                                                    <label for="nombre_de_establecimiento" class="mb-0">
                                                        * Nombre Comercial
                                                    </label>
                                                </div>
                                                <div class="col-9">
                                                    <div class="d-inline-flex align-items-center mb-1">
                                                        <i class="fa fa-book-reader text-success text-110 ml-25 pos-abs"></i>
                                                        <input type="text" class="form-control form-control-lg px-475" id="nombre_de_establecimiento">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-3 col-form-label text-sm-right pr-0">
                                                    <label for="provincia" class="mb-0">
                                                        * Provincia
                                                    </label>
                                                </div>
                                                <div class="col-8" id="div_lista_de_provincias">

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-3 col-form-label text-sm-right pr-0">
                                                    <label for="ciudad" class="mb-0">
                                                       * Ciudad
                                                    </label>
                                                </div>
                                                <div class="col-9">
                                                    <div class="d-inline-flex align-items-center mb-1">
                                                        <i class="fa fa-map-marker-alt text-success text-110 ml-25 pos-abs"></i>
                                                        <input type="text" class="text-uppercase form-control form-control-lg px-475" id="ciudad">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-3 col-form-label text-sm-right pr-0">
                                                    <label for="direccion" class="mb-0">
                                                        * Direcci&oacute;n
                                                    </label>
                                                </div>
                                                <div class="col-9">
                                                    <div class="d-inline-flex align-items-center mb-1">
                                                        <i class="fa fa-map-marked text-success text-110 ml-25 pos-abs"></i>
                                                        <input type="text" class="text-uppercase form-control form-control-lg px-475" id="direccion">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group row">
                                                <div class="col-3 col-form-label text-sm-right pr-0">
                                                    <label for="telefono1" class="mb-0">
                                                        * Tel&eacute;fono principal
                                                    </label>
                                                </div>
                                                <div class="col-9">
                                                    <div class="d-inline-flex align-items-center mb-1">
                                                        <i class="fa fa-phone text-success text-110 ml-25 pos-abs"></i>
                                                        <input type="number" class="text-uppercase form-control form-control-lg px-475" id="telefono1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-3 col-form-label text-sm-right pr-0">
                                                    <label for="telefono2" class="mb-0">
                                                        Celular o PBX
                                                    </label>
                                                </div>
                                                <div class="col-9">
                                                    <div class="d-inline-flex align-items-center mb-1">
                                                        <i class="fa fa-mobile-alt text-success text-110 ml-25 pos-abs"></i>
                                                        <input type="number" class="text-uppercase form-control form-control-lg px-475" id="telefono2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-3 col-form-label text-sm-right pr-0">
                                                    <label for="correo" class="mb-0">
                                                        Email
                                                    </label>
                                                </div>
                                                <div class="col-9">
                                                    <div class="d-inline-flex align-items-center mb-1">
                                                        <i class="fa fa-envelope text-success text-110 ml-25 pos-abs"></i>
                                                        <input type="email" class="form-control form-control-lg px-475" id="correo">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4 col-form-label text-sm-right pr-0">
                                                    <label for="porcentaje" class="mb-0">
                                                        Porcentaje de cobertura (si aplica)
                                                    </label>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-inline-flex align-items-center mb-1">
                                                        <i class="fa fa-percent text-success text-110 ml-25 pos-abs"></i>
                                                        <input type="number" class="form-control form-control-lg px-475" id="porcentaje" value="0.0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-3 col-form-label text-sm-right pr-0">
                                                    <label for="convenio" class="mb-0">
                                                        ¿Tiene convenio?
                                                    </label>
                                                </div>
                                                <div class="col-4">
                                                    <input type="checkbox" id="convenio" class="ace-switch input-lg ace-switch-yesno bgc-purple-d1 text-grey-m2">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="mt-1 border-t-1 bgc-secondary-l4 brc-secondary-l2 mx-n25">
                                            <div class="offset-md-3 col-md-9 text-nowrap">
                                                <button class="btn btn-info btn-bold px-4" type="button" id="btn_guardar_establecimiento">
                                                    <i class="fa fa-check mr-1"></i>
                                                    Guardar
                                                </button>

                                                <button class="btn btn-outline-lightgrey btn-bgc-white btn-bold ml-2 px-4" type="reset">
                                                    <i class="fa fa-undo mr-1"></i>
                                                    Reset
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.card-body -->
                        </div><!-- /.card -->

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card acard mt-2 col-12">
                <div class="card-header">
                    <h3 class="card-title text-125 text-primary-d2">
                        <i class="fa fa-hospital text-orange-d1 mr-1"></i>
                        Lista de Cl&iacute;nicas y Establecimientos
                    </h3>

                    <div class="form-group row">
                        <div class="col-12">
                            <div class="d-inline-flex align-items-center mb-1">
                                <i class="fa fa-search text-success text-110 ml-25 pos-abs"></i>
                                <input type="text" class="form-control form-control-lg px-475" id="txt_buscador" placeholder="Buscar por nombre">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body px-3 pb-1">
                    <div class="col-12 form-group" id="div_lista_de_establecimientos">

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="node_modules/popper.js/dist/umd/popper.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="dist/js/ace.js"></script>
<script src="views/pages/form-basic/@page-script.js"></script>

<script src="js/establecimientos.js"></script>

</html>


