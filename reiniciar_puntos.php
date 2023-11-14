<?php
session_start();
require 'funciones.php';

// Manejar la solicitud POST para reiniciar puntos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["equipo"])) {
        $equipo = $_POST["equipo"];
        try {
            reiniciarPuntosEnBaseDeDatos($equipo);
        } catch (Exception $e) {
            // Manejar errores de reinicio de puntos
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
