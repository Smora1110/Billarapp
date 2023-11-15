<?php
// Archivo: tiempo.php

// Incluye los archivos necesarios y empieza la sesión
require 'vendor/autoload.php';
session_start();
require 'funciones.php';

// Obtiene el nombre de usuario de la sesión
$nombre_usuario = $_SESSION['nombre_usuario'];

// Crea una instancia de la clase Pedido
$tiempoBD = new billar\pedido;

// Obtiene el tiempo actual y de inicio desde la base de datos
$tiempoactual = $tiempoBD->actual($nombre_usuario);
$tiempoInicio = $tiempoBD->inicio($nombre_usuario);

// Validar que ambos tiempos no sean nulos y sean fechas válidas
if ($tiempoactual !== null && $tiempoInicio !== null) {
    // Convertir las cadenas de tiempo a objetos DateTime
    $fechaTiempoActual = new DateTime($tiempoactual);
    $fechaTiempoInicio = new DateTime($tiempoInicio);

    // Calcular la diferencia entre fechas
    $diferencia = $fechaTiempoInicio->diff($fechaTiempoActual);

    // Formatear la diferencia en formato horas:minutos:segundos
    $diferenciaFormateada = $diferencia->format('%H:%I:%S');
} else {
    $diferenciaFormateada = "No se pudo obtener la diferencia de tiempo.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BillarApp</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="tienda.php"><svg xmlns="http://www.w3.org/2000/svg" href="tienda.php" class="icon icon-tabler icon-tabler-sport-billard" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M12 12m-8 0a8 8 0 1 0 16 0a8 8 0 1 0 -16 0" />
                    </svg>
                </a>

                <a class="navbar-brand" href="tienda.php">BillarApp

                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="tienda.php">Tienda</a></li>

                    <li><a href="billar.php">Billar</a></li>
                    <li><a href="pool.php">Pool</a></li>
                    <li><a href="tiempo.php">Tiempo</a></li>
                </ul>

                <ul class="nav navbar-nav pull-right">
                    <li>
                        <a href="carrito.php" class="btn">CARRITO <span class="badge"><?php print cantidadproducto(); ?></span></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="panel/cerrar_session.php">Salir</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <!-- Contenedor principal -->
    <div class="container text-center" id="main">
        <div class="row">
            <!-- Muestra la diferencia de tiempo -->
            <h1><?php echo $diferenciaFormateada; ?></h1>
            <!-- Agrega este botón en la ubicación deseada de tu página actual -->
            <a href="tiempo.php" class="btn btn-primary">Recargar</a>

        </div>
    </div>

    <!-- jQuery y Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        // Evitar que el usuario retroceda en la página
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };
    </script>
</body>

</html>