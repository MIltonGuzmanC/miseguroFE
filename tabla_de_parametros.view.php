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
        <div class="main-container" id="main">

        </div>
    </div>
</body>
<script>
    $(function(){
        Swal.close();
        $.ajax({
            method : 'GET',
            url : './controllers/mostrar_tabla_de_parametros.ctrl.php'
        }).done(function(response){
            $("#main").html(response);
        })
    })
</script>
<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="node_modules/popper.js/dist/umd/popper.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="fancybox/jquery.fancybox.js"></script>
<script src="dist/js/ace.js"></script>
<script src="views/pages/form-basic/@page-script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.13.0/dist/sweetalert2.all.min.js" integrity="sha256-J9avsZWTdcAPp1YASuhlEH42nySYLmm0Jw1txwkuqQw=" crossorigin="anonymous"></script>
</html>


