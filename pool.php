<?php
session_start();
if (!isset($_SESSION['usuario_info']) or empty($_SESSION['usuario_info'])) {
  // Redirigir a la página de inicio de sesión
  header("Location: index.php");
  exit(); // Asegurar que el script se detenga después de la redirección
}
require 'funciones.php';

// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tiendabillar";

$conn = new mysqli($servername, $username, $password, $dbname);
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

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/estilos.css">

  <style>
    #actualizarBtn,
    #agregarJugadorBtn {
      margin-top: 10px;
    }
  </style>
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
        <a href="tienda.php">
          <svg xmlns="http://www.w3.org/2000/svg" href="tienda.php" class="icon icon-tabler icon-tabler-sport-billard" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
            <path d="M12 12m-8 0a8 8 0 1 0 16 0a8 8 0 1 0 -16 0" />
          </svg>
        </a> 
        <a class="navbar-brand" href="tienda.php">BillarApp</a>
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
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>

  <!-- Contador de Puntos -->
  <div class="container mt-5">
    <h1 class="mb-4">Contador de Puntos</h1>

    <div class="row mb-3">
      <div class="col-md-6">
        <!-- Jugador 1 -->
        <table class="table table-bordered" id="jugador1">
          <thead>
            <tr>
              <th scope="col">Jugador 1</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Buenas: <span id="buenasJugador1">0</span></td>
              <td>Malas: <span id="malasJugador1">0</span></td>
            </tr>
            <tr>
              <td colspan="2" class="text-center">Total Puntos: <span id="totalJugador1">0</span></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-6">
        <!-- Jugador 2 -->
        <table class="table table-bordered" id="jugador2">
          <thead>
            <tr>
              <th scope="col">Jugador 2</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Buenas: <span id="buenasJugador2">0</span></td>
              <td>Malas: <span id="malasJugador2">0</span></td>
            </tr>
            <tr>
              <td colspan="2" class="text-center">Total Puntos: <span id="totalJugador2">0</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="d-flex justify-content-between mb-3">
          <div class="w-45">
            <label for="Jugador" class="form-label">Seleccionar Jugador:</label>
            <select class="form-select" id="Jugador" required>
              <option value="Jugador1">Jugador 1</option>
              <option value="Jugador2">Jugador 2</option>
            </select>
          </div>
          <div class="w-45">
            <label for="accion" class="form-label">Acción:</label>
            <select class="form-select" id="accion" required>
              <option value="sumar">Sumar Puntos</option>
              <option value="restar">Restar Puntos</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="cantidad" class="form-label">Cantidad:</label>
          <input type="number" class="form-control" id="cantidad" required>
        </div>
        <div class="mb-3 text-center">
          <button type="button" class="btn btn-primary" id="actualizarBtn">Actualizar Puntos</button>
        </div>
      </div>
    </div>
  </div>

  <script>
  document.addEventListener("DOMContentLoaded", function () {
    // Inicializar variables para llevar un seguimiento de las buenas y malas
    var buenasJugador1 = 0;
    var malasJugador1 = 0;
    var buenasJugador2 = 0;
    var malasJugador2 = 0;

    // Evento para actualizar los puntos al hacer clic en el botón
    document.getElementById("actualizarBtn").addEventListener("click", function () {
      var Jugador = document.getElementById("Jugador").value;
      var accion = document.getElementById("accion").value;
      var cantidadInput = document.getElementById("cantidad");
      var cantidad = parseInt(cantidadInput.value);

      // Asegurarse de que cantidad sea un número válido
      if (isNaN(cantidad)) {
        cantidad = 0;
      }

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

      // Actualizar la pantalla después de modificar las buenas o malas
      actualizarPantalla();
      
      // Agregar mensajes de depuración
      console.log("Jugador: " + Jugador);
      console.log("Acción: " + accion);
      console.log("Cantidad: " + cantidad);

      // Agregar la solicitud AJAX aquí
      $.ajax({
        type: 'POST',
        url: 'actualizar_puntos_pool.php',
        data: {
          'Jugador': Jugador,
          'accion': accion,
          'cantidad': cantidad
        },
        success: function (response) {
          console.log("Respuesta del servidor:", response);
          // Aquí puedes agregar más lógica si es necesario
        },
        error: function (xhr, status, error) {
      console.error("Error en la solicitud AJAX:", error);
      // Imprimir detalles adicionales del error
      console.log("XHR status:", status);
      console.log("XHR response text:", xhr.responseText);
      // Agrega alertas u otros mensajes de error según sea necesario
        }
      });

    });

    function actualizarPantalla() {
      document.getElementById("buenasJugador1").textContent = buenasJugador1;
      document.getElementById("malasJugador1").textContent = malasJugador1;
      document.getElementById("totalJugador1").textContent = buenasJugador1 - malasJugador1;
      document.getElementById("buenasJugador2").textContent = buenasJugador2;
      document.getElementById("malasJugador2").textContent = malasJugador2;
      document.getElementById("totalJugador2").textContent = buenasJugador2 - malasJugador2;
    }
  });
</script>

</body>

</html>
