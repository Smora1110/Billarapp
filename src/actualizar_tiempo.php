<?php
session_start();

if (!isset($_SESSION['usuario_info']) or empty($_SESSION['usuario_info'])) {
    header('Location: ../../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../vendor/autoload.php';

    $nombre_usuario = isset($_POST['nombre_usuario']) ? $_POST['nombre_usuario'] : null;
    $accion = isset($_POST['accion']) ? $_POST['accion'] : null;

    if ($nombre_usuario && $accion) {
        $pedido = new billar\Pedido;

        switch ($accion) {
            case 'iniciar':
                $pedido->iniciarTiempo($nombre_usuario);
                break;
            case 'detener':
                $pedido->detenerTiempo($nombre_usuario);
                break;
            case 'reinicio':
                $pedido->reiniciarTiempo($nombre_usuario);
                break;
            default:
                // Manejar acciones desconocidas si es necesario
                break;
        }
    }
}

// Redirigir de nuevo a la página principal
header('Location: ../panel/productos/mesas.php');
exit;
?>
