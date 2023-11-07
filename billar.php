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
        <a class="navbar-brand" href="index.php">BillarApp</a>
      </div>
    </div>
  </nav>

  <!-- Contador de Puntos -->
  <div class="container mt-5">
    <h1 class="mb-4">Contador de Puntos</h1>

    <div class="row mb-3">
      <div class="col-md-4">
        <h2>Persona 1</h2>
        <p>Puntos: <span id="puntosPersona1">0</span></p>
        <button type="button" class="btn btn-danger" id="resetPersona1Btn">Resetear Persona 1</button>
      </div>
      <div class="col-md-4">
        <h2>Persona 2</h2>
        <p>Puntos: <span id="puntosPersona2">0</span></p>
        <button type="button" class="btn btn-danger" id="resetPersona2Btn">Resetear Persona 2</button>
      </div>
      <div class="col-md-4">
        <h2>Persona 3</h2>
        <p>Puntos: <span id="puntosPersona3">0</span></p>
        <button type="button" class="btn btn-danger" id="resetPersona3Btn">Resetear Persona 3</button>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <br><br><br>
        <select class="form-select mb-2" id="persona" required>
          <option value="persona1">Persona 1</option>
          <option value="persona2">Persona 2</option>
          <option value="persona3">Persona 3</option>
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

  <!-- Incluye el script de Bootstrap 5 y el script personalizado -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Script para manejar la actualización y el reseteo de puntos
    document.getElementById("actualizarBtn").addEventListener("click", function() {
      var persona = document.getElementById("persona").value;
      var accion = document.getElementById("accion").value;
      var cantidad = parseInt(document.getElementById("cantidad").value);

      if (accion === "sumar") {
        if (persona === "persona1") {
          var puntosPersona1 = parseInt(document.getElementById("puntosPersona1").textContent);
          document.getElementById("puntosPersona1").textContent = puntosPersona1 + cantidad;
        } else if (persona === "persona2") {
          var puntosPersona2 = parseInt(document.getElementById("puntosPersona2").textContent);
          document.getElementById("puntosPersona2").textContent = puntosPersona2 + cantidad;
        } else if (persona === "persona3") {
          var puntosPersona3 = parseInt(document.getElementById("puntosPersona3").textContent);
          document.getElementById("puntosPersona3").textContent = puntosPersona3 + cantidad;
        }
      } else if (accion === "restar") {
        if (persona === "persona1") {
          var puntosPersona1 = parseInt(document.getElementById("puntosPersona1").textContent);
          document.getElementById("puntosPersona1").textContent = puntosPersona1 - cantidad;
        } else if (persona === "persona2") {
          var puntosPersona2 = parseInt(document.getElementById("puntosPersona2").textContent);
          document.getElementById("puntosPersona2").textContent = puntosPersona2 - cantidad;
        } else if (persona === "persona3") {
          var puntosPersona3 = parseInt(document.getElementById("puntosPersona3").textContent);
          document.getElementById("puntosPersona3").textContent = puntosPersona3 - cantidad;
        }
      }
    });

    // Script para resetear los puntos de las personas
    document.getElementById("resetPersona1Btn").addEventListener("click", function() {
      document.getElementById("puntosPersona1").textContent = "0";
    });

    document.getElementById("resetPersona2Btn").addEventListener("click", function() {
      document.getElementById("puntosPersona2").textContent = "0";
    });

    document.getElementById("resetPersona3Btn").addEventListener("click", function() {
      document.getElementById("puntosPersona3").textContent = "0";
    });
  </script>
</body>
</html>
