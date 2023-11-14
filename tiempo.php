<?php
session_start();
if (!isset($_SESSION['usuario_info']) or empty($_SESSION['usuario_info'])) {
    // Redirigir a la página de inicio de sesión
    header("Location: index.php");
    exit(); // Asegurar que el script se detenga después de la redirección
}

session_start();
require 'funciones.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BillarApp</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">

    <style>
        /* ... (otros estilos) */

        .tiempo-container {
            margin-top: 70px;
            font-size: 24px;
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

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
          <li><a href="">Tiempo</a></li>
        </ul>

        <ul class="nav navbar-nav pull-right">
          <li>
            <a href="carrito.php" class="btn">CARRITO <span class="badge"><?php print cantidadproducto(); ?></span></a>
          </li>
          
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>

    <div class="container">
        <?php
        // En tiempo.php
        require 'vendor/autoload.php'; // Ajusta esto según tu estructura

        if (!isset($_SESSION['usuario_info']) or empty($_SESSION['usuario_info'])) {
            // Manejar el caso cuando no hay una sesión iniciada
            echo "No hay una sesión iniciada.";
            exit;
        }

        $nombreUsuario = $_SESSION['nombre_usuario'];

        $pedido = new billar\Pedido;
        $tiempoTranscurrido = $pedido->obtenerTiempoTranscurridoActual($nombreUsuario);

        if ($tiempoTranscurrido !== null) {
            // Calcular minutos y segundos
            $minutos = floor($tiempoTranscurrido / 60);
            $segundos = $tiempoTranscurrido % 60;

            echo "<div id='tiempoTranscurrido' class='tiempo-container'>Tiempo transcurrido: $minutos minutos y $segundos segundos.</div>";
        } else {
            echo "No se pudo obtener el tiempo transcurrido.";
        }
        ?>

        <script>
            function actualizarTiempo() {
                // Obtener el contenedor del tiempo
                var contenedorTiempo = document.getElementById('tiempoTranscurrido');

                // Obtener el tiempo actual del servidor usando una petición AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'obtener_tiempo_actual.php', true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        try {
                            var tiempoActual = JSON.parse(xhr.responseText);

                            // Restar 20 minutos al tiempo actual
                            tiempoActual.minutos -= 20;

                            // Formatear el tiempo en formato de reloj (HH:MM:SS)
                            var tiempoFormateado = formatarTiempo(tiempoActual.minutos, tiempoActual.segundos);

                            // Actualizar el contenido del contenedor con el nuevo tiempo
                            contenedorTiempo.innerHTML = "Tiempo transcurrido: " + tiempoFormateado;
                        } catch (e) {
                            console.error("Error al parsear JSON:", e);
                        }
                    }
                };
                xhr.send();
            }

            function formatarTiempo(minutos, segundos) {
                // Agregar ceros a la izquierda si es necesario
                var minutosStr = minutos < 10 ? '0' + minutos : minutos;
                var segundosStr = segundos < 10 ? '0' + segundos : segundos;

                return minutosStr + ':' + segundosStr;
            }

            // Actualizar el tiempo cada segundo
            setInterval(actualizarTiempo, 1000);

            // Llamar a la función para la primera actualización
            actualizarTiempo();
        </script>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body>

</html>
