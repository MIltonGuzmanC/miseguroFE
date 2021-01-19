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
<div class="body-container">
   <div class="row justify-content-center">
       <div class="page-content container container-plus">
           <div class="row">
               <div class="col-6 cards-container" id="card-container-1">
                   <div class="card" id="card_categoria" draggable="false" style="">
                       <div class="card-header">
                           <i class="fa fa-book brc-brown-m2 text-orange p-1 radius-1"></i>
                           <h5 class="card-title">
                               Nueva categor&iacute;a de CIE 10
                           </h5>
                           <div class="card-toolbar">
                               <a href="#" data-action="expand" class="card-toolbar-btn text-orange-d3 d-style" draggable="false">
                                   <i class="fa fa-expand d-n-active"></i>
                                   <i class="fa fa-compress d-active"></i>
                               </a>

                               <a href="#" data-action="toggle" class="card-toolbar-btn text-grey-d1" draggable="false">
                                   <i class="fa fa-chevron-up"></i>
                               </a>

                               <a href="#" data-action="close" class="card-toolbar-btn text-danger" draggable="false">
                                   <i class="fa fa-times"></i>
                               </a>
                           </div>
                       </div><!-- /.card-header -->

                       <div class="card-body p-0 collapse show" style="">
                           <div class="card acard mt-2 mt-lg-3">
                               <div class="card-header">
                                   <h3 class="card-title text-125 text-primary-d2">
                                       <i class="far fa-edit text-danger mr-1"></i>
                                       Formulario
                                   </h3>
                               </div>
                               <div class="card-body px-3 pb-1">
                                   <form class="mt-lg-3" id="form_categoria" autocomplete="off">
                                       <div class="form-group row">
                                           <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                               <label for="codigo_de_categoria" class="mb-0">
                                                   C&oacute;d&iacute;go
                                               </label>
                                           </div>
                                           <div class="col-9">
                                               <div class="d-inline-flex align-items-center mb-1">
                                                   <i class="fa fa-key text-green text-125 ml-25 pos-abs"></i>
                                                   <input type="text" class="text-uppercase form-control form-control-lg px-475" id="codigo_de_categoria">
                                               </div>
                                           </div>
                                       </div>
                                       <div class="form-group row">
                                           <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                               <label for="nombre_de_categoria" class="mb-0">
                                                   Categor&iacute;a
                                               </label>
                                           </div>
                                           <div class="col-9">
                                               <div class="d-inline-flex align-items-center mb-1">
                                                   <i class="fa fa-book text-green text-125 ml-25 pos-abs"></i>
                                                   <input type="text" class="text-uppercase form-control form-control-lg px-475" id="nombre_de_categoria">
                                               </div>
                                           </div>
                                       </div>


                                       <div class="mt-5 border-t-1 bgc-secondary-l4 brc-secondary-l2 py-35 mx-n25">
                                           <div class="offset-md-3 col-md-9 text-nowrap">
                                               <button class="btn btn-info btn-bold px-4" type="button" onclick="guardar_categoria()">
                                                   <i class="fa fa-save mr-1"></i>
                                                   Guardar categor&iacute;a
                                               </button>
                                           </div>
                                       </div>
                                   </form>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-6 cards-container" id="card-container-1">
                   <div class="card" id="card-registroe10" draggable="false" style="">
                       <div class="card-header">
                           <i class="fa fa-pen-alt brc-brown-m2 text-purple-l1 p-1 radius-1"></i>
                           <h5 class="card-title">
                               Nuevo registro de CIE 10
                           </h5>

                           <div class="card-toolbar">

                               <a href="#" data-action="expand" class="card-toolbar-btn text-orange-d3 d-style" draggable="false">
                                   <i class="fa fa-expand d-n-active"></i>
                                   <i class="fa fa-compress d-active"></i>
                               </a>

                               <a href="#" data-action="toggle" class="card-toolbar-btn text-grey-d1" draggable="false">
                                   <i class="fa fa-chevron-up"></i>
                               </a>

                               <a href="#" data-action="close" class="card-toolbar-btn text-danger" draggable="false">
                                   <i class="fa fa-times"></i>
                               </a>
                           </div>
                       </div>

                       <div class="card-body p-0 collapse show" style="">
                           <div class="card-body p-0 collapse show" style="">
                               <div class="card acard mt-2 mt-lg-3">
                                   <div class="card-header">
                                       <h3 class="card-title text-125 text-primary-d2">
                                           <i class="fa fa-book-open text-danger-l1 mr-1"></i>
                                           Formulario
                                       </h3>
                                   </div>
                                   <div class="card-body px-3 pb-1">
                                       <form class="mt-lg-3" id="form_cie" autocomplete="off">
                                           <div class="form-group row">
                                               <div class="col-3 col-form-label text-sm-right pr-0">
                                                   <label  class="mb-0">
                                                       Categor&iacute;a
                                                   </label>
                                               </div>
                                               <div class="col-9" id="div_lista_de_categorias">

                                               </div>
                                           </div>

                                           <div class="form-group row">
                                               <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                                   <label for="codigo_de_cie" class="mb-0">
                                                       C&oacute;digo
                                                   </label>
                                               </div>
                                               <div class="col-9">
                                                   <div class="d-inline-flex align-items-center mb-1">
                                                       <i class="fa fa-shield-alt text-green text-125 ml-25 pos-abs"></i>
                                                       <input type="text" class="text-uppercase form-control form-control-lg px-475" id="codigo_de_cie">
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="form-group row">
                                               <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                                   <label for="nombre_de_cie" class="mb-0">
                                                       Nombre
                                                   </label>
                                               </div>
                                               <div class="col-9">
                                                   <div class="d-inline-flex align-items-center mb-1">
                                                       <i class="fa fa-info text-green text-125 ml-25 pos-abs"></i>
                                                       <input type="text" class="text-uppercase form-control form-control-lg px-475" id="nombre_de_cie">
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="mt-5 border-t-1 bgc-secondary-l4 brc-secondary-l2 py-35 mx-n25">
                                               <div class="offset-md-3 col-md-9 text-nowrap">
                                                   <button class="btn btn-info btn-bold px-4" type="button" onclick="guardar_cie()">
                                                       <i class="fa fa-save mr-1"></i>
                                                       Guardar CIE 10
                                                   </button>
                                               </div>
                                           </div>
                                       </form>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <div class="row">
               <div class="card acard mt-2 col-12">
                   <div class="card-header">
                       <h3 class="card-title text-125 text-primary-d2">
                           <i class="fa fa-database text-yellow-l3 mr-1"></i>
                           Lista de CIE 10
                       </h3>
                   </div>
                   <div class="card-body px-3 pb-1">
                       <div class="col-10 form-group" id="div_select_grupo">

                       </div>

                   </div>
                   <div class="card-footer">
                       <div class="row">
                            <div class="col-12 py-2" id="div_lista_de_cies">

                            </div>
                       </div>
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
<script src="js/cie10.js"></script>

</html>


