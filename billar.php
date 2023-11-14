<?php
session_start();
if (!isset($_SESSION['usuario_info']) or empty($_SESSION['usuario_info'])) {
  // Redirigir a la página de inicio de sesión
  header("Location: index.php");
  exit(); // Asegurar que el script se detenga después de la redirección
}
session_start();
require 'funciones.php';

// Manejar la solicitud POST para reiniciar puntos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["resetEquipoBtn"])) {
    // Asegúrate de obtener el nombre del equipo correctamente desde tu formulario
    $equipo = $_POST["nombre_del_equipo"]; // Reemplaza esto con el valor correcto
    reiniciarPuntosEnBaseDeDatos($equipo);
  }
}

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
    .equipo-container {
      margin-top: 20px;
    }

    .equipo-column {
      text-align: center;
      margin-bottom: 20px;
    }

    .equipo-buttons {
      margin-top: 10px;
    }

    .btn-reiniciar {
      background-color: #d9534f;
      border-color: #d9534f;
    }

    .equipos-row {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
    }

    .seleccionar-equipo,
    .seleccionar-accion {
      margin-bottom: 10px;
    }

    .cantidad-input {
      width: 100%;
      margin-bottom: 10px;
    }

    .actualizar-btn {
      width: 100%;
    }

    #actualizarBtnRow {
      margin-top: 20px;
      display: flex;
      justify-content: center;
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

  <div class="container mt-5">
    <h1 class="mb-4">Contador de Puntos</h1>

    <div class="equipos-row equipo-container">
      <!-- Equipo 1 -->
<div class="col-md-4 equipo-column">
  <h2>Equipo 1</h2>
  <p>Puntos: <span id="puntosEquipo1">0</span></p>
  <button type="button" class="btn btn-danger btn-reiniciar" data-equipo="Equipo1" id="resetEquipo1Btn">Reiniciar Puntos</button>
</div>

<!-- Equipo 2 -->
<div class="col-md-4 equipo-column">
  <h2>Equipo 2</h2>
  <p>Puntos: <span id="puntosEquipo2">0</span></p>
  <button type="button" class="btn btn-danger btn-reiniciar" data-equipo="Equipo2" id="resetEquipo2Btn">Reiniciar Puntos</button>
</div>

<!-- Equipo 3 -->
<div class="col-md-4 equipo-column">
  <h2>Equipo 3</h2>
  <p>Puntos: <span id="puntosEquipo3">0</span></p>
  <button type="button" class="btn btn-danger btn-reiniciar" data-equipo="Equipo3" id="resetEquipo3Btn">Reiniciar Puntos</button>
</div>

    </div>

    <div class="row">
      <!-- Seleccionar equipo y acción -->
      <div class="col-md-4 seleccionar-equipo">
        <label for="Equipo" class="form-label">Seleccionar equipo:</label>
        <select class="form-select mb-2" id="Equipo" required>
          <option value="Equipo1">Equipo 1</option>
          <option value="Equipo2">Equipo 2</option>
          <option value="Equipo3">Equipo 3</option>
        </select>
      </div>

      <div class="col-md-4 seleccionar-accion">
        <label for="accion" class="form-label">Acción:</label>
        <select class="form-select mb-2" id="accion" required>
          <option value="sumar">Sumar Puntos</option>
          <option value="restar">Restar Puntos</option>
        </select>
      </div>

      <!-- Nueva fila para cantidad y botón de actualizar -->
      <div class="row">
        <div class="col-md-12 cantidad-input">
          <label for="cantidad" class="form-label">Cantidad:</label>
          <input type="number" class="form-control" id="cantidad" required>
        </div>
      </div>
      <div class="row" id="actualizarBtnRow">
        <div class="col-md-12 d-flex justify-content-center">
          <button type="button" class="btn btn-primary" id="actualizarBtn">Actualizar Puntos</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  // Función para realizar solicitudes AJAX
  function hacerSolicitudAJAX(url, datos, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          callback(xhr.responseText);
        } else {
          console.error("Error en la solicitud AJAX. Estado:", xhr.status);
        }
      }
    };
    xhr.send(datos);
  }

  // Función para actualizar puntos
  function actualizarPuntos(equipo, accion, cantidad) {
    var datos = "equipo=" + encodeURIComponent(equipo) + "&accion=" + encodeURIComponent(accion) + "&cantidad=" + encodeURIComponent(cantidad);

    hacerSolicitudAJAX("actualizar_puntos.php", datos, function(respuesta) {
      console.log("Respuesta del servidor:", respuesta);
      // Actualizar los puntos en la interfaz de usuario (ajusta según tu estructura HTML)
      document.getElementById("puntos" + equipo).textContent = respuesta;
    });
  }

  // Función para reiniciar puntos
  function reiniciarPuntos(equipo) {
    var datos = "equipo=" + encodeURIComponent(equipo) + "&accion=reiniciar&cantidad=0";

    hacerSolicitudAJAX("reiniciar_puntos.php", datos, function(respuesta) {
      console.log("Respuesta del servidor:", respuesta);
      // Reiniciar los puntos en la interfaz de usuario (ajusta según tu estructura HTML)
      document.getElementById("puntos" + equipo).textContent = respuesta;
    });
  }

  // Evento de clic para el botón de actualizar
  document.getElementById("actualizarBtn").addEventListener("click", function() {
    var equipo = document.getElementById("Equipo").value;
    var accion = document.getElementById("accion").value;
    var cantidad = parseInt(document.getElementById("cantidad").value);

    // Llama a la función para actualizar puntos
    actualizarPuntos(equipo, accion, cantidad);
  });

  // Evento de clic para los botones de reinicio
  document.querySelectorAll(".btn-reiniciar").forEach(function(btn) {
    btn.addEventListener("click", function() {
      var equipo = this.getAttribute("data-equipo");

      // Llama a la función para reiniciar puntos
      reiniciarPuntos(equipo);
    });
  });
</script>
  </script>


</body>
</html>