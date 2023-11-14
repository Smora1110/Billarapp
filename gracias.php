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
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">

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

    <div class="container" id="main">
        <div class="row">
            <div class="jumbotron">
                <p>Gracias por su compra</p>
                <p>
                    <a href="tienda.php">Regresar</a>
                </p>
            </div>



        </div>
      

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

  </body>
</html>
