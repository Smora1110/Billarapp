<?php
session_start();
if (!isset($_SESSION['usuario_info']) or empty($_SESSION['usuario_info'])) {
  // Redirigir a la página de inicio de sesión
  header("Location: index.php");
  exit(); // Asegurar que el script se detenga después de la redirección
}
require 'funciones.php';

// Verificar si se están enviando datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtener datos del formulario
  $Jugador = $_POST['Jugador'];
  $accion = $_POST['accion'];
  $cantidad = (int)$_POST['cantidad'];

  // Construir la consulta SQL
  $query = "";

  if ($Jugador === "Jugador1") {
    if ($accion === "sumar") {
      $query = "UPDATE puntos_pool SET buenas = buenas + $cantidad WHERE id = 1";
    } elseif ($accion === "restar") {
      $query = "UPDATE puntos_pool SET malas = malas + $cantidad WHERE id = 1";
    }
  } elseif ($Jugador === "Jugador2") {
    if ($accion === "sumar") {
      $query = "UPDATE puntos_pool SET buenas = buenas + $cantidad WHERE id = 2";
    } elseif ($accion === "restar") {
      $query = "UPDATE puntos_pool SET malas = malas + $cantidad WHERE id = 2";
    }
  }

  // Realizar la conexión a la base de datos (ajusta los valores según tu configuración)
  $mysqli = new mysqli("localhost", "root", "", "tiendabillar");

  // Verificar la conexión
  if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
  }

  // Ejecutar la consulta
  $resultado = $mysqli->query($query);

  // Verificar si la consulta se ejecutó correctamente
  if ($resultado) {
    echo "Puntos actualizados correctamente";
  } else {
    echo "Error al actualizar los puntos: " . $mysqli->error;
  }

  // Cerrar la conexión
  $mysqli->close();
}
?>
