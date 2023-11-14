<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre_usuario = $_POST['nombre_usuario'];
    $clave = $_POST['clave'];
    require 'vendor/autoload.php';
    $usuario = new billar\usuario;
    $resultado = $usuario->login($nombre_usuario, $clave);

    if ($resultado) {

        session_start();

        $_SESSION['usuario_info'] = array(
            'nombre_usuario' => $resultado['$nombre_usuario'],
            
        );

        if ($nombre_usuario=='admin') {
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            $_SESSION['estado'] = 1;
            $_SESSION['logueado'] = true;
            header('Location: panel/dashboard.php');
        } elseif ($nombre_usuario!=='admin'){
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            $_SESSION['estado'] = 0;
            $_SESSION['logueado'] = true;
            header('Location: tienda.php');
        }


    } else {
        header('Location: usuario_incorrecto.php');
    }

    
}
