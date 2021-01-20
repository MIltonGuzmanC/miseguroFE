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
                        <i class="fa fa-people-carry text-orange-d1"></i>
                        Beneficiarios y Empleados
                    </h5>

                    <div class="card-toolbar">
                        <div class="d-inline-flex align-items-center mb-1 px-3px">
                            <i class="fa fa-search text-success text-110 ml-25 pos-abs"></i>
                            <input type="text" class="form-control form-control-lg px-475" id="txt_buscar_beneficiario" placeholder="c&eacute;dula / pasaporte">
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class=" container container-plus">
                        <div class="form-group row">
                            <div class="col-12" id="div_lista_de_beneficiarios">

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
<script src="js/beneficiarios.js" ></script>

</html>


