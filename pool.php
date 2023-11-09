<?php
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
          
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>

  <!-- Contador de Puntos -->
  <div class="container mt-5">
    <h1 class="mb-4">Contador de Puntos</h1>

    <div class="row mb-3">
      <div class="col-md-4">
        <h2>Jugador 1</h2>
        <p>Buenas: <span id="buenasJugador1">0</span></p>
        <p>Malas: <span id="malasJugador1">0</span></p>
        <p>Total Puntos: <span id="totalJugador1">0</span></p>
      </div>
      <div class="col-md-4">
        <h2>Jugador 2</h2>
        <p>Buenas: <span id="buenasJugador2">0</span></p>
        <p>Malas: <span id="malasJugador2">0</span></p>
        <p>Total Puntos: <span id="totalJugador2">0</span></p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <br><br><br>
        <select class="form-select mb-2" id="Jugador" required>
          <option value="Jugador1">Jugador 1</option>
          <option value="Jugador2">Jugador 2</option>
        </select>

        <select class="form-select mb-2" id="accion" required>
          <option value="sumar">Sumar Puntos</option>
          <option value="restar">Restar Puntos</option>
        </select>
        <div class="mb-3">
          <br>
          <label for="cantidad" class="form-label">Cantidad:</label>
          <input type="number" class="form-control" id="cantidad" required>
        </div>
        <br>
        <button type="button" class="btn btn-primary" id="actualizarBtn">Actualizar Puntos</button>
      </div>
    </div>
  </div>

  <!-- Incluye el script de Bootstrap y el script para el contador de puntos -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    // Inicializar variables para llevar un seguimiento de las buenas y malas
    var buenasJugador1 = 0;
    var malasJugador1 = 0;
    var buenasJugador2 = 0;
    var malasJugador2 = 0;

    // Actualizar la pantalla con las buenas, malas y total de puntos actuales
    function actualizarPantalla() {
      document.getElementById("buenasJugador1").textContent = buenasJugador1;
      document.getElementById("malasJugador1").textContent = malasJugador1;
      document.getElementById("totalJugador1").textContent = buenasJugador1 - malasJugador1;
      document.getElementById("buenasJugador2").textContent = buenasJugador2;
      document.getElementById("malasJugador2").textContent = malasJugador2;
      document.getElementById("totalJugador2").textContent = buenasJugador2 - malasJugador2;
    }

    // Script para manejar la actualización de puntos
    document.getElementById("actualizarBtn").addEventListener("click", function() {
      var Jugador = document.getElementById("Jugador").value;
      var accion = document.getElementById("accion").value;
      var cantidad = parseInt(document.getElementById("cantidad").value);

      if (accion === "sumar") {
        if (Jugador === "Jugador1") {
          buenasJugador1 += cantidad;
        } else if (Jugador === "Jugador2") {
          buenasJugador2 += cantidad;
        }
      } else if (accion === "restar") {
        if (Jugador === "Jugador1") {
          malasJugador1 += cantidad;
        } else if (Jugador === "Jugador2") {
          malasJugador2 += cantidad;
        }
      }

      actualizarPantalla();
    });

    // Script para resetear los puntos de los jugadores
    document.getElementById("resetJugador1Btn").addEventListener("click", function() {
      buenasJugador1 = 0;
      malasJugador1 = 0;
      actualizarPantalla();
    });

    document.getElementById("resetJugador2Btn").addEventListener("click", function() {
      buenasJugador2 = 0;
      malasJugador2 = 0;
      actualizarPantalla();
    });
  </script>
</body>

</html>