<?php
session_start();

// Establece la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "tiendabillar";

try {
    $conexion = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

// Verifica si se recibieron los datos del formulario
if (isset($_POST['equipo']) && isset($_POST['accion']) && isset($_POST['cantidad'])) {
    $equipo = $_POST['equipo'];
    $accion = $_POST['accion'];
    $cantidad = (int)$_POST['cantidad'];

    // Actualiza los puntos del equipo en la base de datos
    try {
        // Verifica si el equipo existe en la base de datos
        $stmt = $conexion->prepare("SELECT * FROM puntos WHERE equipo = :equipo");
        $stmt->bindParam(':equipo', $equipo);
        $stmt->execute();
        $equipoExistente = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$equipoExistente) {
            die("Error: El equipo no existe en la base de datos.");
        }

        // Actualiza los puntos del equipo
        if ($accion == "sumar") {
            $stmt = $conexion->prepare("UPDATE puntos SET puntos = puntos + :cantidad WHERE equipo = :equipo");
        } elseif ($accion == "restar") {
            $stmt = $conexion->prepare("UPDATE puntos SET puntos = puntos - :cantidad WHERE equipo = :equipo");
        } else {
            die("Error: Acción no válida.");
        }

        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':equipo', $equipo);
        $stmt->execute();

        // Obtiene los puntos actualizados del equipo
        $stmt = $conexion->prepare("SELECT puntos FROM puntos WHERE equipo = :equipo");
        $stmt->bindParam(':equipo', $equipo);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devuelve los puntos actualizados como respuesta
        echo $result['puntos'];
    } catch (PDOException $e) {
        die("Error al actualizar puntos: " . $e->getMessage());
    }
} else {
    die("Error: Datos no recibidos.");
}
?>